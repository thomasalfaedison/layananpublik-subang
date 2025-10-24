<?php

namespace App\Services;

use App\Components\Session;
use App\Models\Layanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LayananService
{
    public function validate(array $data): void
    {
        $rules = [
            'id_instansi' => 'required|integer|exists:instansi,id',
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'id_ref_layanan_pemicu' => 'nullable|integer|exists:ref_layanan_pemicu,id',
            'id_ref_layanan_teknis' => 'nullable|integer|exists:ref_layanan_teknis,id',
            'id_ref_layanan_penerima_manfaat' => 'nullable|integer|exists:ref_layanan_penerima_manfaat,id',
            'id_ref_layanan_produk' => 'nullable|integer|exists:ref_layanan_produk,id',
            'status_atribut_persyaratan' => 'nullable|boolean',
            'status_atribut_prosedur' => 'nullable|boolean',
            'id_ref_atribut_biaya' => 'nullable|integer|exists:ref_atribut_biaya,id',
            'atribut_kategori' => 'nullable|string',
            'id_ref_atribut_sop' => 'nullable|integer|exists:ref_atribut_sop,id',
            'id_ref_atribut_siklus_layanan' => 'nullable|integer|exists:ref_atribut_siklus_layanan,id',
            'id_ref_atribut_skm' => 'nullable|integer|exists:ref_atribut_skm,id',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function query(array $params = []): Builder
    {
        $query = Layanan::query()
            ->with([
                'instansi',
                'layananPemicu',
                'layananTeknis',
                'layananPenerimaManfaat',
                'layananProduk',
                'atributBiaya',
                'atributSop',
                'atributSiklusLayanan',
                'atributSkm',
            ]);

        if (@$params['id'] !== null) {
            $query->where('id', $params['id']);
        }

        if (@$params['id_instansi'] !== null) {
            $query->where('id_instansi', $params['id_instansi']);
        }

        if (@$params['nama'] !== null) {
            $query->where('nama', 'like', '%' . $params['nama'] . '%');
        }

        if (@$params['id_ref_layanan_pemicu'] !== null) {
            $query->where('id_ref_layanan_pemicu', $params['id_ref_layanan_pemicu']);
        }

        if (@$params['id_ref_layanan_teknis'] !== null) {
            $query->where('id_ref_layanan_teknis', $params['id_ref_layanan_teknis']);
        }

        if (@$params['id_ref_layanan_penerima_manfaat'] !== null) {
            $query->where('id_ref_layanan_penerima_manfaat', $params['id_ref_layanan_penerima_manfaat']);
        }

        if (@$params['id_ref_layanan_produk'] !== null) {
            $query->where('id_ref_layanan_produk', $params['id_ref_layanan_produk']);
        }

        if (@$params['status_atribut_persyaratan'] !== null) {
            $query->where('status_atribut_persyaratan', $params['status_atribut_persyaratan']);
        }

        if (@$params['status_atribut_prosedur'] !== null) {
            $query->where('status_atribut_prosedur', $params['status_atribut_prosedur']);
        }

        if (@$params['atribut_kategori'] !== null) {
            $query->where('atribut_kategori', 'like', '%' . $params['atribut_kategori'] . '%');
        }

        return $query;
    }

    public function findOne(array $params = []): ?Layanan
    {
        return $this->query($params)->first();
    }

    /**
     * @return Collection<Layanan>
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

    public function findById(int $id): ?Layanan
    {
        return Layanan::with([
            'instansi',
            'layananPemicu',
            'layananTeknis',
            'layananPenerimaManfaat',
            'layananProduk',
            'atributBiaya',
            'atributSop',
            'atributSiklusLayanan',
            'atributSkm',
        ])->find($id);
    }

    public function create(array $data): Layanan
    {
        if (Session::isInstansi()) {
            $data['id_instansi'] = Session::getIdInstansi();
        }

        $this->validate($data);

        $data['status_atribut_persyaratan'] = $data['status_atribut_persyaratan'] ?? 0;
        $data['status_atribut_prosedur'] = $data['status_atribut_prosedur'] ?? 0;

        return Layanan::create($data);
    }

    public function update(Layanan $model, array $data): Layanan
    {
        $this->validate($data);

        $data['status_atribut_persyaratan'] = $data['status_atribut_persyaratan'] ?? 0;
        $data['status_atribut_prosedur'] = $data['status_atribut_prosedur'] ?? 0;

        $model->update($data);

        return $model;
    }

    public function delete(Layanan $model): bool
    {
        return $model->delete();
    }
}

