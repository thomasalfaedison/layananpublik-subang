<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_instansi
 * @property string|null $nomor
 * @property string|null $alamat
 * @property string|null $jabatan_ttd
 * @property string|null $nama_ttd
 * @property string|null $nip_ttd
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property Instansi $instansi
 */
class StandarPelayanan extends Model
{
    protected $table = 'standar_pelayanan';

    protected $fillable = [
        'id_instansi',
        'nomor',
        'alamat',
        'jabatan_ttd',
        'nama_ttd',
        'nip_ttd',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi', 'id');
    }
}
