<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\PenggajianDetail;
use App\Models\Potongan;
use App\Models\Tunjangan;
use App\Models\Jabatan;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use App\Http\Resources\Jabatan as JabatanResources;

class RunPayrollController extends Controller
{
    public function run(Request $request)
    {
        try {
            $karyawan = Karyawan::get();
            foreach ($karyawan as $key) {
                $total_allowance = 0;
                $total_deduction = 0;
                $data = collect([]);
                // grouping tunjangan karyawan
                // cari tunjangan
                $queryAllowance = Tunjangan::with('komponen')->where('jabatan_id',$key->jabatan_id)->whereHas('komponen',function($q){
                    $q->where('nama','not like','%istri%')->where('nama','not like','%anak%')->where('nama','not like','%suami%');
                })->get();
                // $queryAllowance = Jabatan::with(['tunjangans.komponen','potongans.komponen'])->where('id',$key->jabatan_id)->first();
                // $dataTunjangan = new JabatanResources($queryAllowance);
                foreach($queryAllowance as $allowance){
                    $check = $data->where('nama',$allowance->komponen->nama)->all();
                    if(count($check) == 0){
                        $total_allowance += $allowance->jumlah;
                        $data->push([
                            "komponen_id"=>$allowance->komponen_id,
                            "tipe"=>"Penambahan",
                            "jumlah"=>$allowance->jumlah,
                            'nama'=>$allowance->komponen->nama,
                        ]);
                    }
                }
                // cari keluarga istri
                $queryIstri = Keluarga::where('karyawan_id',$key->id)->where('jenis','not like','%anak%')->get();
                foreach($queryIstri as $allowance){
                    $komponenIstri = Tunjangan::whereHas('komponen',function($q){
                        $q->where('nama','like','%istri%')->orWhere('nama','like','%suami%');
                    })->first();
                    $tunjanganIstri = $komponenIstri ? $komponenIstri->jumlah : 0;
                    $total_allowance += $tunjanganIstri;
                    if($komponenIstri){
                       $data->push([
                        "komponen_id"=>$komponenIstri->komponen_id,
                        "tipe"=>"Penambahan",
                        "jumlah"=>$komponenIstri->jumlah,
                       ]);
                    }
                }

                // cari keluarga anak
                $queryAnak = Keluarga::where('karyawan_id',$key->id)->where('jenis','like','%anak%')->get();
                foreach($queryAnak as $allowance){
                    $umur = $this->getRange($allowance->tgl_lahir,date('Y-m-d'));
                    if(count($umur)<=8760){
                        $komponenAnak = Tunjangan::whereHas('komponen',function($q){
                            $q->where('nama','like','%anak%');
                        })->first();
                        $tunjanganAnak = $komponenAnak ? $komponenAnak->jumlah :0;
                        $total_allowance += $tunjanganAnak;
                        if($komponenAnak){
                            $data->push([
                                "komponen_id"=>$komponenAnak->komponen_id,
                                "tipe"=>"Penambahan",
                                "jumlah"=>$komponenAnak->jumlah,
                            ]);
                        }
                    }
                }

                // grouping pengurangan karyawan
                // cari pengurangan
                $queryDeduction = Potongan::with('komponen')->where('jabatan_id',$key->jabatan_id)->get();
                foreach($queryDeduction as $deduction){
                    $check = $data->where('nama',$deduction->komponen->nama)->all();
                    if(count($check)==0){
                        $total_deduction += $deduction->jumlah;
                        $data->push([
                            "komponen_id"=>$deduction->komponen_id,
                            "tipe"=>"Pengurangan",
                            "jumlah"=>$deduction->jumlah,
                            'nama'=>$deduction->komponen->nama,
                        ]);
                    }
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

            return Response::send(200,['message'=>'Run Payroll Berhasil','data'=>[]]);
        } catch (Exception $th) {
            return Response::send(500,['message'=>$th->getMessage(),'data'=>[]]);
        }
    }

    // public function run(Request $request)
    // {
    //     try {
    //         $jabatan = Jabatan::with(['tunjangans.komponen','potongans.komponen'])->where('id',6)->first();
    //         // $jabatan = new JabatanResources($jabatan);
    //         return $jabatan;
    //     } catch (Exception $th) {
    //         return Response::send(500,['message'=>$th->getMessage(),'data'=>[]]);
    //     }
    // }

    public function getRange($start,$end)
    {
        return CarbonPeriod::create($start,$end);
    }
}
