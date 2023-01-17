<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggajianDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'penggajian_details';

    public function komponen()
    {
        return $this->belongsTo(Komponen::class,'komponen_id');
    }
}
