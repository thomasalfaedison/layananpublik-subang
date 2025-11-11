<?php

namespace App\Services;

use App\Components\Session;
use App\Models\StandarPelayanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StandarPelayananService
{
    /**
     * @throws ValidationException
     */
    public function validate(array $data, ?StandarPelayanan $model = null): void
    {
        $rules = [
            'id_instansi' => [
                'required',
                'integer',
                'exists:instansi,id',
                Rule::unique('standar_pelayanan', 'id_instansi')
                    ->ignore($model?->id),
            ],
            'nomor' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'jabatan_ttd' => 'nullable|string|max:255',
            'nama_ttd' => 'nullable|string|max:255',
            'nip_ttd' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []): Builder
    {
        $query = StandarPelayanan::query()
            ->with(['instansi']);

        if (Session::isInstansi()) {
            $query->where('id_instansi', Session::getIdInstansi());
        }

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['id_instansi'] !== null) {
            $query->where('id_instansi', $params['id_instansi']);
        }

        if (@$params['keyword'] !== null) {
            $keyword = '%' . $params['keyword'] . '%';
            $query->where(function (Builder $builder) use ($keyword) {
                $builder->where('nomor', 'like', $keyword)
                    ->orWhere('jabatan_ttd', 'like', $keyword)
                    ->orWhere('nama_ttd', 'like', $keyword)
                    ->orWhere('nip_ttd', 'like', $keyword);
            });
        }

        $query->orderBy('id', 'desc');

        return $query;
    }

    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = $params['perPage'] ?? 10;

        return $this->query($params)->paginate($perPage)->appends($params);
    }

    /**
     * @return Collection<StandarPelayanan>
     */
    public function findAll(array $params = []): Collection
    {
        return $this->query($params)->get();
    }

    public function findById(int $id): ?StandarPelayanan
    {
        $query = StandarPelayanan::query()
            ->with('instansi')
            ->where('id', $id);

        if (Session::isInstansi()) {
            $query->where('id_instansi', Session::getIdInstansi());
        }

        return $query->first();
    }

    public function findByInstansi(int $idInstansi): ?StandarPelayanan
    {
        return StandarPelayanan::query()
            ->where('id_instansi', $idInstansi)
            ->first();
    }

    /**
     * @throws ValidationException
     */
    public function create(array $data): StandarPelayanan
    {
        if (Session::isInstansi()) {
            $data['id_instansi'] = Session::getIdInstansi();
        }

        $this->validate($data);

        return StandarPelayanan::create($data);
    }

    /**
     * @throws ValidationException
     */
    public function update(StandarPelayanan $model, array $data): StandarPelayanan
    {
        if (Session::isInstansi()) {
            $data['id_instansi'] = Session::getIdInstansi();
        }

        $this->validate($data, $model);

        $model->update($data);

        return $model;
    }

    public function delete(StandarPelayanan $model): bool
    {
        if (Session::isInstansi() && $model->id_instansi !== Session::getIdInstansi()) {
            abort(403, 'Anda tidak memiliki akses ke data ini');
        }

        return $model->delete();
    }

    public function firstOrCreate(array $attributes, array $values = [])
    {
        return StandarPelayanan::firstOrCreate($attributes, $values);
    }
}
