<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Penggajian;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function gaji(Request $request)
    {
        $data = Penggajian::query();
        $data = $data->with(['karyawan.jabatan']);
        if($request->filled('start_date') && $request->filled('end_date')){
            $data = $data->whereBetween('tgl_penggajian',[$request->start_date,$request->end_date]);
        }

        $data = $data->get();
        $pdf = Pdf::loadView('pdf.penggajian',[
            'data'=>$data
        ]);
        return $pdf->download('laporan-penggajian.pdf');
    }

    public function absen(Request $request)
    {
        $data = Absensi::query();
        $data = $data->with(['karyawan.jabatan']);
        if($request->filled('start_date') && $request->filled('end_date')){
            $data = $data->whereBetween('tgl_absen',[$request->start_date,$request->end_date]);
        }

        $data = $data->get();
        $pdf = Pdf::loadView('pdf.absen',[
            'data'=>$data
        ]);
        return $pdf->download('laporan-absen.pdf');
    }

    public function slip(Request $request)
    {
        $data = Penggajian::with(['karyawan.jabatan.tunjangans.komponen','karyawan.jabatan.potongans.komponen'])->where('id',$request->penggajian_id)->first();
        $pdf = Pdf::loadView('pdf.slip',[
            'penggajian'=>$data
        ]);
        return $pdf->download('laporan-slip.pdf');
    }
}
