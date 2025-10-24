<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Summary of InstansiJenis
 * @property int $id
 * @property string $nama
 */
class InstansiJenis extends Model
{
    protected $table = 'instansi_jenis';

    protected $fillable = ['nama'];

    public function manyInstansi()
    {
        return $this->hasMany(Instansi::class, 'id_instansi_jenis');
    }
}