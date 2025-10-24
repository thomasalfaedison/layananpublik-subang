<?php

namespace App\Services;

use App\Models\Instansi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InstansiService
{
    public function validate(array $data)
    {
        $rules = [
            'tahun_awal' => 'required|integer|digits:4',
            'tahun_akhir' => 'required|integer|digits:4',
            'nama' => 'required|string',
            'id_instansi_jenis' => 'required|string',
        ];
        
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []) : Builder
    {
        $query = Instansi::query();

        if(@$params['id'] !== null)
        {
            $query->where('id',$params['id']);
        }

        if(@$params['nama'] !== null)
        {
            $query->where('nama','like', '%'.$params['nama'].'%');
        }

        if(@$params['singkatan'] !== null)
        {
            $query->whereRaw('LOWER(singkatan) = ?', [strtolower($params['singkatan'])]);
        }

        if(@$params['id_instansi_jenis'] !== null)
        {
            $query->where('id_instansi_jenis',$params['id_instansi_jenis']);
        }

        if (@$params['tahun'] !== null) {
            $query->where('tahun_awal', '<=', $params['tahun']);
            $query->where('tahun_akhir', '>=', $params['tahun']);
        }

        return $query;
    }

    public function findOne(array $params=[]) : ?Instansi
    {
        return $this->query($params)->first();
    }

    /**
     * @return Collection<Instansi>
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

    public function findById(int $id): ?Instansi
    {
        return Instansi::find($id);
    }

    public function create(array $data): Instansi
    {
        $this->validate($data);

        return Instansi::create($data);
    }

    public function update(Instansi $model, array $data): ?Instansi
    {
        $this->validate($data);

        $model->update($data);

        return $model;
    }

    public function delete(Instansi $model): bool
    {
        return $model->delete();
    }

    public function count(array $params = [])
    {
        $query = $this->query($params);

        return $query->count();
    }
}
