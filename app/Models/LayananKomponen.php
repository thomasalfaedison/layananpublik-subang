<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_layanan
 * @property int $id_ref_layanan_komponen
 * @property string $uraian
 * @property int|null $urutan
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property Layanan $layanan
 * @property RefLayananKomponen $refLayananKomponen
 */
class LayananKomponen extends Model
{
    protected $table = 'layanan_komponen';

    protected $fillable = [
        'id_layanan',
        'id_ref_layanan_komponen',
        'uraian',
        'urutan',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id');
    }

    public function refLayananKomponen()
    {
        return $this->belongsTo(RefLayananKomponen::class, 'id_ref_layanan_komponen', 'id');
    }
}

