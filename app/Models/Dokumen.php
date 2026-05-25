<?php

namespace App\Models;

use App\Traits\FileAccessModelTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_instansi
 * @property string $jenis
 * @property string $nomor
 * @property string $tanggal
 * @property string|null $file
 * @property Instansi $instansi
 */
class Dokumen extends Model
{
    use FileAccessModelTrait;

    public const JENIS_SP = 'SP';
    public const JENIS_BA = 'BA';
    public const JENIS_MP = 'MP';
    public const FOLDER_FILE = 'dokumen';
    public const SLUG_STANDAR_PELAYANAN = 'standar-pelayanan';
    public const SLUG_BERITA_ACARA = 'berita-acara';
    public const SLUG_MAKLUMAT_PELAYANAN = 'maklumat-pelayanan';

    protected $table = 'dokumen';

    protected $fillable = [
        'id_instansi',
        'jenis',
        'nomor',
        'tanggal',
        'file',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'id_instansi', 'id');
    }

    public static function getJenisBySlug(string $slug): ?string
    {
        return [
            self::SLUG_STANDAR_PELAYANAN => self::JENIS_SP,
            self::SLUG_BERITA_ACARA => self::JENIS_BA,
            self::SLUG_MAKLUMAT_PELAYANAN => self::JENIS_MP,
        ][$slug] ?? null;
    }

    public static function getSlugByJenis(string $jenis): ?string
    {
        return [
            self::JENIS_SP => self::SLUG_STANDAR_PELAYANAN,
            self::JENIS_BA => self::SLUG_BERITA_ACARA,
            self::JENIS_MP => self::SLUG_MAKLUMAT_PELAYANAN,
        ][$jenis] ?? null;
    }

    public static function getLabelByJenis(string $jenis): string
    {
        return [
            self::JENIS_SP => 'Standar Pelayanan',
            self::JENIS_BA => 'Berita Acara',
            self::JENIS_MP => 'Maklumat Pelayanan',
        ][$jenis] ?? 'Dokumen';
    }
}
