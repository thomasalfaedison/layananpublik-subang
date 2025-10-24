<?php

namespace App\Services;

use App\Models\RefLayananTeknis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RefLayananTeknisService
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
        $query = RefLayananTeknis::query();

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['nama'] !== null) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        return $query;
    }

    public function findOne(array $params = []): ?RefLayananTeknis
    {
        return $this->query($params)->first();
    }

    public function findOrFail(array $params = []): RefLayananTeknis
    {
        $model = $this->query($params)->first();

        if ($model === null) {
            abort(404, 'Layanan teknis tidak ditemukan');
        }

        return $model;
    }

    /**
     * @return Collection<RefLayananTeknis>
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

    public function findById(int $id): ?RefLayananTeknis
    {
        return RefLayananTeknis::find($id);
    }

    public function create(array $data): RefLayananTeknis
    {
        $this->validate($data);

        return RefLayananTeknis::create($data);
    }

    public function update(RefLayananTeknis $model, array $data): RefLayananTeknis
    {
        $this->validate($data);

        $model->update($data);

        return $model;
    }

    public function delete(RefLayananTeknis $model): bool
    {
        return $model->delete();
    }
}
