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
class RefAtributBiaya extends Model
{
    protected $table = 'ref_atribut_biaya';

    protected $fillable = [
        'nama',
    ];
}
