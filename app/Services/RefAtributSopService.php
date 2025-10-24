<?php

namespace App\Services;

use App\Models\RefAtributSop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RefAtributSopService
{
    public function validate(array $data): void
    {
        $rules = [
            'nama' => 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []): Builder
    {
        $query = RefAtributSop::query();

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['nama'] !== null) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        return $query;
    }

    public function findOne(array $params = []): ?RefAtributSop
    {
        return $this->query($params)->first();
    }

    public function findOrFail(array $params = []): RefAtributSop
    {
        $model = $this->query($params)->first();

        if ($model === null) {
            abort(404, 'Atribut SOP tidak ditemukan');
        }

        return $model;
    }

    /**
     * @return Collection<RefAtributSop>
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

    public function findById(int $id): ?RefAtributSop
    {
        return RefAtributSop::find($id);
    }

    public function create(array $data): RefAtributSop
    {
        $this->validate($data);

        return RefAtributSop::create($data);
    }

    public function update(RefAtributSop $model, array $data): RefAtributSop
    {
        $this->validate($data);

        $model->update($data);

        return $model;
    }

    public function delete(RefAtributSop $model): bool
    {
        return $model->delete();
    }
}
