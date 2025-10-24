<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class RefLayananPenerimaManfaat extends Model
{
    protected $table = 'ref_layanan_penerima_manfaat';

    protected $fillable = [
        'nama',
    ];
}
