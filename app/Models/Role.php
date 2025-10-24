<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Summary of Role
 * @property int $id
 * @property string $nama
 */
class Role extends Model
{
    protected $table = 'role';

    protected $fillable = ['nama'];
}
