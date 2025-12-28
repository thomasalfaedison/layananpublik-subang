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
            'id_induk' => 'nullable|integer',
            'id_instansi' => 'required|integer',
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

        if (@$params['id_induk'] !== null) {
            $query->where('id_induk', $params['id_induk']);
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
            if(@$params['id_ref_layanan_penerima_manfaat'] == 'null') {
                $query->whereNull('id_ref_layanan_penerima_manfaat');
            } else {
                $query->where('id_ref_layanan_penerima_manfaat', $params['id_ref_layanan_penerima_manfaat']);
            }
        }

        if (@$params['id_ref_layanan_produk'] !== null) {
            if(@$params['id_ref_layanan_produk'] == 'null') {
                $query->whereNull('id_ref_layanan_produk');
            } else {
                $query->where('id_ref_layanan_produk', $params['id_ref_layanan_produk']);
            }
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

        if (@$params['urutan_persen_kelengkapan'] !== null) {
            $direction = strtolower($params['urutan_persen_kelengkapan']) === 'asc' ? 'asc' : 'desc';
            $query->orderBy('persen_komponen', $direction);
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

    public function count(array $params = [])
    {
        $query = $this->query($params);

        return $query->count();
    }

    public function summarizeByInstansi(array $params = []): Collection
    {
        $query = Layanan::query()
            ->selectRaw('id_instansi, COUNT(*) as jumlah_layanan')
            ->selectRaw('AVG(COALESCE(persen_komponen, 0)) as persen_kelengkapan')
            ->groupBy('id_instansi');

        if (@$params['array_id_instansi'] !== null) {
            $query->whereIn('id_instansi', $params['array_id_instansi']);
        }

        return $query->get()->keyBy('id_instansi');
    }

    public function summarizeByProduk(array $params = []): Collection
    {
        $query = Layanan::query()
            ->leftJoin('ref_layanan_produk as rp', 'rp.id', '=', 'layanan.id_ref_layanan_produk')
            ->selectRaw("layanan.id_ref_layanan_produk, COALESCE(rp.nama, 'Tidak Ditentukan') as produk_nama")
            ->selectRaw('COUNT(*) as jumlah_layanan')
            ->groupBy('layanan.id_ref_layanan_produk', 'rp.nama')
            ->orderByDesc('jumlah_layanan');

        if (Session::isInstansi()) {
            $query->where('layanan.id_instansi', Session::getIdInstansi());
        }

        return $query->get();
    }

    public function summarizeByPenerimaManfaat(array $params = []): Collection
    {
        $query = Layanan::query()
            ->leftJoin('ref_layanan_penerima_manfaat as rm', 'rm.id', '=', 'layanan.id_ref_layanan_penerima_manfaat')
            ->selectRaw("layanan.id_ref_layanan_penerima_manfaat, COALESCE(rm.nama, 'Tidak Ditentukan') as penerima_nama")
            ->selectRaw('COUNT(*) as jumlah_layanan')
            ->groupBy('layanan.id_ref_layanan_penerima_manfaat', 'rm.nama')
            ->orderByDesc('jumlah_layanan');

        if (Session::isInstansi()) {
            $query->where('layanan.id_instansi', Session::getIdInstansi());
        }

        return $query->get();
    }
}
