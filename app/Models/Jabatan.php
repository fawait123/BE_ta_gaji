<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function potongans()
    {
        return $this->hasMany(Potongan::class,'jabatan_id');
    }

    public function tunjangans()
    {
        return $this->hasMany(Tunjangan::class,'jabatan_id');
    }
}
