<?php

namespace App\Services;

use App\Components\Session;
use App\Models\Layanan;
use App\Models\LayananKomponen;
use App\Models\RefLayananKomponen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LayananKomponenService
{
    public function validate(array $data): void
    {
        $rules = [
            'id_layanan' => 'required|integer',
            'id_ref_layanan_komponen' => 'required|integer',
            'uraian' => 'required|string',
            'urutan' => 'nullable|integer',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []): Builder
    {
        $query = LayananKomponen::query()
            ->with([
                'layanan.instansi',
                'refLayananKomponen',
            ]);

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['id_layanan'] !== null) {
            $query->where('id_layanan', $params['id_layanan']);
        }

        if (@$params['id_ref_layanan_komponen'] !== null) {
            $query->where('id_ref_layanan_komponen', $params['id_ref_layanan_komponen']);
        }

        if (@$params['keyword'] !== null) {
            $query->where('uraian', 'like', '%' . $params['keyword'] . '%');
        }

        if (@$params['id_instansi'] !== null) {
            $query->whereHas('layanan', function (Builder $builder) use ($params) {
                $builder->where('id_instansi', $params['id_instansi']);
            });
        }

        $query->orderBy('urutan')->orderBy('id');

        return $query;
    }

    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = $params['perPage'] ?? 10;

        $query = $this->query($params);

        return $query->paginate($perPage)->appends($params);
    }

    /**
     * @return Collection<LayananKomponen>
     */
    public function findAll(array $params = []): Collection
    {
        $query = $this->query($params);

        if (@$params['limit'] !== null) {
            return $query->get()->take($params['limit']);
        }

        return $query->get();
    }

    public function findById(int $id): ?LayananKomponen
    {
        $params = ['id' => $id];

        if (Session::isInstansi()) {
            $params['id_instansi'] = Session::getIdInstansi();
        }

        return $this->query($params)->first();
    }

    public function create(array $data): LayananKomponen
    {
        $this->validate($data);

        $this->guardLayananAccess((int) $data['id_layanan']);

        $uraianList = $this->extractMultipleUraian($data['uraian']);

        $lastUrutan = $this->getLastUrutan([
            'id_layanan' => $data['id_layanan'],
            'id_ref_layanan_komponen' => $data['id_ref_layanan_komponen'],
        ]);
        $currentUrutan = $lastUrutan + 1;

        if (count($uraianList) <= 1) {
            $data = $this->applyAudit($data, true);

            if (@$data['urutan'] == null) {
                $data['urutan'] = $currentUrutan;
            }

            $model = LayananKomponen::create($data);
        } else {
            $model = DB::transaction(function () use ($data, $uraianList, $currentUrutan) {
                $lastModel = null;

                foreach ($uraianList as $uraian) {
                    $payload = $data;
                    $payload['uraian'] = $uraian;
                    $payload['urutan'] = $currentUrutan++;
                    $payload = $this->applyAudit($payload, true);

                    $lastModel = LayananKomponen::create($payload);
                }

                return $lastModel;
            });
        }

        $this->updatePersenKomponen($data['id_layanan']);

        return $model;
    }

    public function update(LayananKomponen $model, array $data): LayananKomponen
    {
        $data['id_layanan'] = $model->id_layanan;
        $data['id_ref_layanan_komponen'] = $model->id_ref_layanan_komponen;


        $this->validate($data);

        $this->guardLayananAccess($data['id_layanan']);

        $data = $this->applyAudit($data);

        $model->update($data);

        $this->updatePersenKomponen($model->id_layanan);

        return $model;
    }

    public function delete(LayananKomponen $model): bool
    {
        $this->guardLayananAccess($model->id_layanan);

        $deleted = $model->delete();

        $this->updatePersenKomponen($model->id_layanan);

        return $deleted;
    }

    protected function guardLayananAccess(int $idLayanan): void
    {
        if (!Session::isInstansi()) {
            return;
        }

        $exists = Layanan::query()
            ->where('id', $idLayanan)
            ->where('id_instansi', Session::getIdInstansi())
            ->exists();

        if (!$exists) {
            abort(403, 'Anda tidak memiliki akses ke layanan yang dipilih');
        }
    }

    protected function applyAudit(array $data, bool $isCreate = false): array
    {
        $userId = Session::getIdUser();

        if ($isCreate) {
            $data['created_by'] = $userId;
        }

        $data['updated_by'] = $userId;

        return $data;
    }

    protected function extractMultipleUraian(string $uraian): array
    {
        $segments = preg_split('/;\s*(?:\r?\n|$)/', $uraian);

        $segments = array_map(static fn ($value) => trim($value), $segments ?? []);
        $segments = array_values(array_filter($segments, static fn ($value) => $value !== ''));

        return $segments;
    }

    protected function updatePersenKomponen(?int $id_layanan): void
    {
        $totalKomponen = RefLayananKomponen::query()->count();

        if ($totalKomponen === 0) {
            Layanan::query()
                ->where('id', $id_layanan)
                ->update(['persen_komponen' => 0]);

            return;
        }

        $terisi = LayananKomponen::query()
            ->where('id_layanan', $id_layanan)
            ->select('id_ref_layanan_komponen')
            ->distinct()
            ->count('id_ref_layanan_komponen');

        $persen = ($terisi / $totalKomponen) * 100;
        $persen = max(0, min(100, $persen));

        Layanan::query()
            ->where('id', $id_layanan)
            ->update(['persen_komponen' => $persen]);
    }

    public function getLastUrutan(array $params = []): int
    {
        $query = $this->query($params);

        $max = $query->max('urutan');

        return $max === null ? 0 : (int) $max;
    }
}
