<?php

namespace App\Services;

use App\Models\RefLayananKomponen;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RefLayananKomponenService
{
    public function validate(array $data): void
    {
        $rules = [
            'grup' => 'required|string',
            'urutan' => 'required|integer',
            'nama' => 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []): Builder
    {
        $query = RefLayananKomponen::query();

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['grup'] !== null) {
            $query->where('grup', 'like', '%' . $params['grup'] . '%');
        }

        if (@$params['urutan'] !== null) {
            $query->where('urutan', $params['urutan']);
        }

        if (@$params['nama'] !== null) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        return $query;
    }

    public function findOne(array $params = []): ?RefLayananKomponen
    {
        return $this->query($params)->first();
    }

    public function findOrFail(array $params = []): RefLayananKomponen
    {
        $model = $this->query($params)->first();

        if ($model === null) {
            abort(404, 'Komponen layanan tidak ditemukan');
        }

        return $model;
    }

    /**
     * @return Collection<RefLayananKomponen>
     */
    public function findAll(array $params = []): Collection
    {
        $query = $this->query($params);

        if (@$params['limit'] !== null) {
            return $query->get()->take($params['limit']);
        }

        return $query->get();
    }

    public function getList(array $params = []): array
    {
        $query = $this->query($params);

        return $query->pluck('nama', 'id')->toArray();
    }

    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = $params['perPage'] ?? 10;

        $query = $this->query($params);

        return $query->paginate($perPage)->appends($params);
    }

    public function findById(int $id): ?RefLayananKomponen
    {
        return RefLayananKomponen::find($id);
    }

    public function create(array $data): RefLayananKomponen
    {
        $this->validate($data);

        return RefLayananKomponen::create($data);
    }

    public function update(RefLayananKomponen $model, array $data): RefLayananKomponen
    {
        $this->validate($data);

        $model->update($data);

        return $model;
    }

    public function delete(RefLayananKomponen $model): bool
    {
        return $model->delete();
    }
}

