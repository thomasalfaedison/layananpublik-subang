<?php

namespace App\Services;

use App\Components\Session;
use App\Models\Layanan;
use App\Models\LayananKomponen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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

        $data = $this->applyAudit($data, true);

        return LayananKomponen::create($data);
    }

    public function update(LayananKomponen $model, array $data): LayananKomponen
    {
        $data['id_layanan'] = $model->id_layanan;
        $data['id_ref_layanan_komponen'] = $model->id_ref_layanan_komponen;


        $this->validate($data);

        $this->guardLayananAccess((int) $data['id_layanan']);

        $data = $this->applyAudit($data);

        $model->update($data);

        return $model;
    }

    public function delete(LayananKomponen $model): bool
    {
        $this->guardLayananAccess($model->id_layanan);

        return $model->delete();
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
}

