<?php

namespace App\Services;

use App\Models\RefLayananProduk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RefLayananProdukService
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
        $query = RefLayananProduk::query();

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['nama'] !== null) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        return $query;
    }

    public function findOne(array $params = []): ?RefLayananProduk
    {
        return $this->query($params)->first();
    }

    public function findOrFail(array $params = []): RefLayananProduk
    {
        $model = $this->query($params)->first();

        if ($model === null) {
            abort(404, 'Layanan produk tidak ditemukan');
        }

        return $model;
    }

    /**
     * @return Collection<RefLayananProduk>
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

    public function findById(int $id): ?RefLayananProduk
    {
        return RefLayananProduk::find($id);
    }

    public function create(array $data): RefLayananProduk
    {
        $this->validate($data);

        return RefLayananProduk::create($data);
    }

    public function update(RefLayananProduk $model, array $data): RefLayananProduk
    {
        $this->validate($data);

        $model->update($data);

        return $model;
    }

    public function delete(RefLayananProduk $model): bool
    {
        return $model->delete();
    }
}
