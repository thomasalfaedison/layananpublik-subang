<?php

namespace App\Services;

use App\Components\Session;
use App\Models\Instansi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Request;

class InstansiService
{
    protected function getKuesionerRespondenService(): KuesionerRespondenService
    {
        return app()->make(KuesionerRespondenService::class);
    }

    protected function getBeritaAcaraService(): BeritaAcaraService
    {
        return app()->make(BeritaAcaraService::class);
    }

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

    public function findAllWithKuesionerResponden(string $kodeKuesioner, array $params = [])
    {
        $kuesionerRespondenService = $this->getKuesionerRespondenService();
        $tahun = $params['tahun'] ?? Session::getTahun();

        $allData = $this->findAll($params);

        foreach ($allData as $data) {
            $kuesioenrResponden = $kuesionerRespondenService->findOne([
                'kode_kuesioner' => $kodeKuesioner,
                'tahun' => $tahun,
                'id_instansi' => $data->id,
            ]);

            $data->kuesionerResponden = $kuesioenrResponden;
        }

        $sortParam = $params['sort'] ?? null;
        if (!empty($sortParam)) {
            $descending = str_starts_with($sortParam, '-');
            $column = ltrim($sortParam, '-');

            $allData = $allData
                ->sortBy(
                    fn ($item) => data_get($item, $column),
                    SORT_NATURAL,
                    $descending
                )
                ->values();
        }

        return $allData;
    }

    public function paginateWithKuesionerResponden(string $kodeKuesioner, array $params = [])
    {
        $perPage = $params['perPage'] ?? 10;
        
        $data = collect($this->findAllWithKuesionerResponden($kodeKuesioner, $params));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $pagedData,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => Request::url(), 'query' => Request::query()]
        );
    }

    public function findAllWithBeritaAcara(array $params = [])
    {
        $beritaAcaraService = $this->getBeritaAcaraService();
        $tahun = $params['tahun'] ?? Session::getTahun();

        $allData = $this->findAll($params);

        foreach ($allData as $data) {
            $beritaAcara = $beritaAcaraService->firstOrCreate([
                'tahun' => $tahun,
                'id_instansi' => $data->id,
            ]);

            $data->beritaAcara = $beritaAcara;
        }

        return $allData;
    }

    public function paginateWithBeritaAcara(array $params = [])
    {
        $perPage = $params['perPage'] ?? 10;
        
        $data = collect($this->findAllWithBeritaAcara($params));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $pagedData,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => Request::url(), 'query' => Request::query()]
        );
    }
}
