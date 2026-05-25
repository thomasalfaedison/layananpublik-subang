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
        $validator = Validator::make($data, [
            'id_instansi' => [
                'required',
                'integer',
                'exists:instansi,id',
                Rule::unique('dokumen')->where(function ($query) use ($data) {
                    return $query->where('jenis', $data['jenis'] ?? null);
                })->ignore($model?->id),
            ],
            'jenis' => [
                'required',
                Rule::in([
                    Dokumen::JENIS_SP,
                    Dokumen::JENIS_BA,
                    Dokumen::JENIS_MP,
                ]),
            ],
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file' => [
                $model?->file ? 'nullable' : 'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:5120',
            ],
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

        $model = $this->findOne([
            'id_instansi' => $data['id_instansi'] ?? null,
            'jenis' => $data['jenis'] ?? null,
        ]);

        $this->validate($data, $model);

        static::handleFileUploads($data, ['file'], Dokumen::FOLDER_FILE, $model);

        if ($model) {
            $model->update($data);

            return $model;
        }

        return Dokumen::create($data);
    }
}
