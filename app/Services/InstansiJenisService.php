<?php

namespace App\Services;

use App\Models\InstansiJenis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InstansiJenisService
{
    public function validate(array $data)
    {
        $rules = [
            'nama' => 'required|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []) : Builder
    {
        $query = InstansiJenis::query();

        if(@$params['id'] !== null)
        {
            $query->where('id',$params['id']);
        }

        if(@$params['nama'] !== null)
        {
            $query->where('nama','like', '%'.$params['nama'].'%');
        }
        
        if(@$params['username'] !== null)
        {
            $query->where('username','like', '%'.$params['username'].'%');
        }

        return $query;
    }

    public function findOne(array $params=[]) : ?InstansiJenis
    {
        return $this->query($params)->first();
    }

    /**
     * @return Collection<InstansiJenis>
     */
    public function findAll(array $params = []): Collection
    {
        $query = $this->query($params);

        if (@$params['limit'] !== null) {
            return $query->get()->take($params['limit']);
        }

        return $query->get();
    }

    public function getList(array $params = [])
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

    public function findById(int $id): ?InstansiJenis
    {
        return InstansiJenis::find($id);
    }

    public function create(array $data): InstansiJenis
    {
        $this->validate($data);

        return InstansiJenis::create($data);
    }

    public function update(int $id, array $data): ?InstansiJenis
    {
        $this->validate($data);
        
        $model = $this->findById($id);

        if (!$model) {
            return null;
        }

        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        $model = $this->findById($id);

        if (!$model) {
            return false;
        }

        return $model->delete();
    }
}