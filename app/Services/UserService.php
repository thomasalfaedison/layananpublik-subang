<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function validate(array $data, $id = null)
    {
        $rules = [
            'username' => [
                'required',
                'string',
                Rule::unique('user', 'username')->ignore($id),
            ],
            'password' => [
                'string',
                'min:3',
                Rule::requiredIf(is_null($id)),
            ],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function query(array $params=[]) : Builder
    {
        $query = User::query();

        if(@$params['id'] !== null)
        {
            $query->where('id',$params['id']);
        }
        
        if(@$params['id_role'] !== null)
        {
            $query->where('id_role',$params['id_role']);
        }
        
        if(@$params['nama'] !== null)
        {
            $query->where('nama','like','%'.$params['nama'].'%');
        }

        if(@$params['username'] !== null)
        {
            $query->where('username','like','%'.$params['username'].'%');
        }

        return $query;
    }

    public function findOne(array $params=[]) : ?User
    {
        return $this->query($params)->first();
    }

    /**
     * @return Collection<User>
     */
    public function findAll(array $params=[]) : Collection
    {
        $query = $this->query($params);

        if (@$params['limit'] !== null) {
            return $query->get()->take($params['limit']);
        }

        return $query->get();
    }

    public function paginate(array $params = []): LengthAwarePaginator
    {
        $perPage = $params['perPage'] ?? 10;

        $query = $this->query($params);

        return $query->paginate($perPage)->appends($params);
    }

    public function findById(int $id): ?User
    {
        return $this->query(['id' => $id])->first();
    }

    public function create(array $data): User
    {
        $this->validate($data);

        return User::create($data);
    }

    public function update(User $model, array $data): ?User
    {
        $this->validate($data, $model->id);

        $model->update($data);

        return $model;
    }

    public function delete(User $model): bool
    {
        return $model->delete();
    }

    public function resetPasswordDefault(array $params = [], string $default = 'subangkab2025'): int
    {
        $query = $this->query($params);

        $payload = ['password' => Hash::make($default)];

        return $query->update($payload);
    }

    public function setPassword(User $model, array $attributes = [])
    {
        $validator = Validator::make($attributes, [
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model->password = $attributes['password'];
        $model->save();

        return $model;
    }

    public function changePassword(User $model, array $attributes = [])
    {
        $validator = Validator::make($attributes, [
           'password_lama' => ['required', function ($attr, $value, $fail) use ($model) {
                if (!Hash::check($value, $model->password)) {
                    $fail('Password lama tidak sesuai.');
                }
            }],
            'password_baru' => [
                'required',
                'confirmed',
                'different:password_lama',
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $model->password = $attributes['password_baru'];
        $model->save();

        return $model;
    }
}