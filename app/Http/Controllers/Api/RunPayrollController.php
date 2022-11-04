<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\PenggajianDetail;
use App\Models\Potongan;
use App\Models\Tunjangan;
use Illuminate\Http\Request;

class RunPayrollController extends Controller
{
    public function run(Request $request)
    {
        $karyawan = Karyawan::all();
        $total_allowance = 0;
        $total_deduction = 0;
        foreach ($karyawan as $key) {
            $queryAllowance = Tunjangan::where('jabatan_id',$key->jabatan_id)->get();
            foreach($queryAllowance as $allowance){
                $total_allowance += $allowance->jumlah;
            }

            $queryDeduction = Potongan::where('jabatan_id',$key->jabatan_id)->get();
            foreach($queryDeduction as $deduction){
                $total_allowance += $deduction->jumlah;
            }


            $gaji = Penggajian::create([
                'tgl_penggajian'=>$request->tgl_penggajian,
                'karyawan_id'=>$key->id,
                'total_tunjangan'=>$total_allowance,
                'total_potongan'=>$total_deduction,
                'total_gaji'=>$total_allowance-$total_deduction
            ]);
            foreach($queryAllowance as $allowance){
                PenggajianDetail::create([
                    'penggajian_id'=>$gaji->id,
                    'komponen_id'=>$allowance->id,
                    'tipe'=>'tunjangan',
                    'jumlah'=>$allowance->jumlah
                ]);
            }
            foreach($queryDeduction as $deduction){
                PenggajianDetail::create([
                    'penggajian_id'=>$gaji->id,
                    'komponen_id'=>$deduction->id,
                    'tipe'=>'potongan',
                    'jumlah'=>$deduction->jumlah
                ]);
            }

        }
        return Response::send(200,['message'=>'oke','data'=>$karyawan]);
    }
}
