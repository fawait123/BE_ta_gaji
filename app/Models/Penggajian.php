<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'penggajians';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id',);
    }
}
