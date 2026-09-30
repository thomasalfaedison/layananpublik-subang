<?php

namespace App\Services;

use App\Components\Session;
use App\Models\Dokumen;
use App\Traits\HandleFileUploadsTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DokumenService
{
    use HandleFileUploadsTrait;

    /**
     * @throws ValidationException
     */
    public function validate(array $data, ?Dokumen $model = null): void
    {
        $isAnnualDocument = in_array($data['jenis'] ?? null, [
            Dokumen::JENIS_SP,
            Dokumen::JENIS_BA,
            Dokumen::JENIS_MP,
        ], true);
        $idInstansiRules = ['required', 'integer', 'exists:instansi,id'];
        $tahunRules = ['required', 'integer', 'between:1901,2155'];

        if ($isAnnualDocument) {
            $tahunRules[] = Rule::unique('dokumen', 'tahun')
                ->where('id_instansi', $data['id_instansi'] ?? null)
                ->where('jenis', $data['jenis'])
                ->withoutTrashed()
                ->ignore($model?->id);
        }

        $validator = Validator::make($data, [
            'id_instansi' => $idInstansiRules,
            'jenis' => [
                'required',
                Rule::in([
                    Dokumen::JENIS_SP,
                    Dokumen::JENIS_BA,
                    Dokumen::JENIS_MP,
                ]),
            ],
            'nomor' => 'required|string|max:255',
            'tahun' => $tahunRules,
            'tanggal' => 'required|date',
            'file' => [
                $model?->file ? 'nullable' : 'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
        ], [
            'tahun.unique' => 'Dokumen untuk perangkat daerah, jenis, dan tahun ini sudah ada. Gunakan aksi Ubah untuk memperbaruinya.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @return Collection<Dokumen>
     */
    public function findAll(array $params = []): Collection
    {
        $query = Dokumen::query()->with('instansi');

        if (Session::isInstansi()) {
            $query->where('id_instansi', Session::getIdInstansi());
        }

        if (@$params['id_instansi'] !== null) {
            if (is_array($params['id_instansi'])) {
                $query->whereIn('id_instansi', $params['id_instansi']);
            } else {
                $query->where('id_instansi', $params['id_instansi']);
            }
        }

        if (@$params['jenis'] !== null) {
            $query->where('jenis', $params['jenis']);
        }

        if (@$params['tahun'] !== null) {
            $query->where('tahun', $params['tahun']);
        }

        return $query->get();
    }

    public function findOne(array $params = []): ?Dokumen
    {
        return $this->findAll($params)->first();
    }

    /**
     * @throws ValidationException
     */
    public function upsert(array $data): Dokumen
    {
        if (Session::isInstansi()) {
            $data['id_instansi'] = Session::getIdInstansi();
        }

        $this->validate($data);

        static::handleFileUploads($data, ['file'], Dokumen::FOLDER_FILE);

        return Dokumen::create($data);
    }

    /**
     * @throws ValidationException
     */
    public function update(Dokumen $model, array $data): Dokumen
    {
        $data['id_instansi'] = $model->id_instansi;
        $data['jenis'] = $model->jenis;
        $data['tahun'] = $model->tahun ?? ($model->jenis === Dokumen::JENIS_SP ? ($data['tahun'] ?? null) : null);

        $this->validate($data, $model);
        static::handleFileUploads($data, ['file'], Dokumen::FOLDER_FILE, $model);
        $model->update($data);

        return $model;
    }

    public function delete(Dokumen $model): bool
    {
        return (bool) $model->delete();
    }
}
