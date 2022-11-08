<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\PenggajianDetail;
use App\Models\Potongan;
use App\Models\Tunjangan;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class RunPayrollController extends Controller
{
    public function run(Request $request)
    {
        $karyawan = Karyawan::get();
        foreach ($karyawan as $key) {
            $total_allowance = 0;
            $total_deduction = 0;
            $data = [];
            // grouping tunjangan karyawan
            // cari tunjangan
            $queryAllowance = Tunjangan::where('jabatan_id',$key->jabatan_id)->whereHas('komponen',function($q){
                $q->where('nama','not like','%istri%')->where('nama','not like','%anak%');
            })->get();
            foreach($queryAllowance as $allowance){
                $total_allowance += $allowance->jumlah;
                array_push($data,[
                    "komponen_id"=>$allowance->komponen_id,
                    "tipe"=>"Penambahan",
                    "jumlah"=>$allowance->jumlah,
                ]);
            }

            // cari keluarga istri
            $queryIstri = Keluarga::where('karyawan_id',$key->jabatan_id)->where('jenis','like','%istri%')->get();
            foreach($queryIstri as $allowance){
                $komponenIstri = Tunjangan::whereHas('komponen',function($q){
                    $q->where('nama','like','%istri%');
                })->first();
                $tunjanganIstri = $komponenIstri ? $komponenIstri->jumlah : 0;
                $total_allowance += $tunjanganIstri;
                if($komponenIstri){
                    array_push($data,[
                        "komponen_id"=>$komponenIstri->komponen_id,
                        "tipe"=>"Penambahan",
                        "jumlah"=>$komponenIstri->jumlah,
                    ]);
                }
            }

            // cari keluarga anak
            $queryAnak = Keluarga::where('karyawan_id',$key->jabatan_id)->where('jenis','like','%anak%')->get();
            foreach($queryIstri as $allowance){
                $komponenAnak = Tunjangan::whereHas('komponen',function($q){
                    $q->where('nama','like','%anak%');
                })->first();
                $tunjanganAnak = $komponenAnak ? $komponenAnak->jumlah :0;
                $total_allowance += $tunjanganAnak;
                if($komponenAnak){
                    array_push($data,[
                        "komponen_id"=>$komponenAnak->komponen_id,
                        "tipe"=>"Penambahan",
                        "jumlah"=>$komponenAnak->jumlah,
                    ]);
                }
            }

            // grouping pengurangan karyawan
            // cari pengurangan
            $queryDeduction = Potongan::where('jabatan_id',$key->jabatan_id)->get();
            foreach($queryDeduction as $deduction){
                $total_deduction += $deduction->jumlah;
                array_push($data,[
                    "komponen_id"=>$komponenIstri->komponen_id,
                    "tipe"=>"Pengurangan",
                    "jumlah"=>$komponenIstri->jumlah,
                ]);
            }

            $gaji = Penggajian::create([
                'tgl_penggajian'=>$request->tgl_penggajian,
                'karyawan_id'=>$key->id,
                'total_tunjangan'=>$total_allowance,
                'total_pengurangan'=>$total_deduction,
                'total_gaji'=>$total_allowance-$total_deduction
            ]);
            foreach($data as $item){
                PenggajianDetail::create([
                    'penggajian_id'=>$gaji->id,
                    'komponen_id'=>$item['komponen_id'],
                    'tipe'=>$item['tipe'],
                    'jumlah'=>$item['jumlah']
                ]);
            }
        }
        return Response::send(200,['message'=>'Run Payroll Berhasil','data'=>$karyawan]);
    }
}
