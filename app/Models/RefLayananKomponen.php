<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $grup
 * @property int $urutan
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class RefLayananKomponen extends Model
{
    protected $table = 'ref_layanan_komponen';

    protected $fillable = [
        'grup',
        'urutan',
        'nama',
    ];

    public static function getListGrup()
    {
        return [
            1 => 'Komponen Standar Pelayanan yang terkait dengan proses penyampaian pelayanan (service delivery)',
            2 => 'Komponen Standar Pelayanan yang terkait dengan proses pengelolaan pelayanan di internal organisasi (manufacturing)',
        ];
    }
}

