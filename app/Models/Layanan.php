<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_instansi
 * @property string $nama
 * @property string|null $deskripsi
 * @property int|null $id_ref_layanan_pemicu
 * @property int|null $id_ref_layanan_teknis
 * @property int|null $id_ref_layanan_penerima_manfaat
 * @property int|null $id_ref_layanan_produk
 * @property int $status_atribut_persyaratan
 * @property int $status_atribut_prosedur
 * @property int|null $id_ref_atribut_biaya
 * @property string|null $atribut_kategori
 * @property int|null $id_ref_atribut_sop
 * @property int|null $id_ref_atribut_siklus_layanan
 * @property int|null $id_ref_atribut_skm
 * @property string|null $persen_komponen
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property Layanan|null $induk
 * @property Instansi $instansi
 * @property RefLayananPemicu|null $layananPemicu
 * @property RefLayananTeknis|null $layananTeknis
 * @property RefLayananPenerimaManfaat|null $layananPenerimaManfaat
 * @property RefLayananProduk|null $layananProduk
 * @property RefAtributBiaya|null $atributBiaya
 * @property RefAtributSop|null $atributSop
 * @property RefAtributSiklusLayanan|null $atributSiklusLayanan
 * @property RefAtributSkm|null $atributSkm
 * @property \Illuminate\Database\Eloquent\Collection<LayananKomponen> $komponen
 */
class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = [
        'id_induk',
        'id_instansi',
        'nama',
        'deskripsi',
        'id_ref_layanan_pemicu',
        'id_ref_layanan_teknis',
        'id_ref_layanan_penerima_manfaat',
        'id_ref_layanan_produk',
        'status_atribut_persyaratan',
        'status_atribut_prosedur',
        'id_ref_atribut_biaya',
        'atribut_kategori',
        'id_ref_atribut_sop',
        'id_ref_atribut_siklus_layanan',
        'id_ref_atribut_skm',
        'jumlah_pengguna',
        'status_skm',
        'nilai_skm',
        'status_digitalisasi',
        'nama_aplikasi',
        'link_aplikasi',
        'status_inovasi',
        'deskripsi_inovasi',
        'persen_komponen',
    ];

    public function induk()
    {
        return $this->belongsTo(Layanan::class, 'id_induk', 'id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi', 'id');
    }

    public function layananPemicu()
    {
        return $this->belongsTo(RefLayananPemicu::class, 'id_ref_layanan_pemicu', 'id');
    }

    public function layananTeknis()
    {
        return $this->belongsTo(RefLayananTeknis::class, 'id_ref_layanan_teknis', 'id');
    }

    public function layananPenerimaManfaat()
    {
        return $this->belongsTo(RefLayananPenerimaManfaat::class, 'id_ref_layanan_penerima_manfaat', 'id');
    }

    public function layananProduk()
    {
        return $this->belongsTo(RefLayananProduk::class, 'id_ref_layanan_produk', 'id');
    }

    public function atributBiaya()
    {
        return $this->belongsTo(RefAtributBiaya::class, 'id_ref_atribut_biaya', 'id');
    }

    public function atributSop()
    {
        return $this->belongsTo(RefAtributSop::class, 'id_ref_atribut_sop', 'id');
    }

    public function atributSiklusLayanan()
    {
        return $this->belongsTo(RefAtributSiklusLayanan::class, 'id_ref_atribut_siklus_layanan', 'id');
    }

    public function atributSkm()
    {
        return $this->belongsTo(RefAtributSkm::class, 'id_ref_atribut_skm', 'id');
    }

    public function komponen()
    {
        return $this->hasMany(LayananKomponen::class, 'id_layanan', 'id');
    }
}
