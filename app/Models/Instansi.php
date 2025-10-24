<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Summary of Instansi
 * @property int $id
 * @property string $nama
 * @property string $id_instansi_jenis
 * @property int $tahun_awal
 * @property int $tahun_akhir
 * @property InstansiJenis $instansiJenis
 * @property Instansi $induk
 */
class Instansi extends Model
{
    protected $table = 'instansi';
    protected $fillable = [
        'nama',
        'singkatan',
        'username',
        'password',
        'alamat',
        'kota',
        'id_kabkota',
        'id_provinsi',
        'telepon',
        'kode_pos',
        'aktif',
        'nama_pj',
        'nip_pj',
        'telepon_pj',
        'email_pj',
        'login_terakhir',
        'status_aktif',
        'status_kunci',
        'status_hapus',
        'waktu_dihapus',
        'id_instansi_jenis',
        'id_induk',
        'id_instansi_referensi',
        'tanggal_pengesahan',
        'kepala_nama_jabatan',
        'kepala_nama',
        'kepala_nip',
        'pembuat_pengesahan_nama_jabatan',
        'pembuat_pengesahan_nama',
        'pembuat_pengesahan_nip',
        'fax',
        'tahun_awal',
        'tahun_akhir',
    ];

    public function instansiJenis()
    {
        return $this->belongsTo(InstansiJenis::class, 'id_instansi_jenis', 'id');
    }

    public function induk()
    {
        return $this->belongsTo(Instansi::class, 'id_induk', 'id');
    }
}
