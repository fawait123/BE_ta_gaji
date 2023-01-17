<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Potongan;
use App\Models\Tunjangan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // tes
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
        $data = [];
        $karyawan = Karyawan::with('jabatan')->get();
        foreach($karyawan as $kary)
        {
            $absen = Absensi::query();
            if($request->filled('start_date') && $request->filled('end_date')){
                $absen = $absen->whereBetween('tgl_absen',[$request->start_date,$request->end_date]);
            }

            $sakit = $absen->where('status_kehadiran','like','%sakit%')->where('karyawan_id',$kary->id)->count();
            $hadir = $absen->where('status_kehadiran','like','%hadir%')->where('karyawan_id',$kary->id)->count();
            $alpha = $absen->where('status_kehadiran','like','%alpha%')->where('karyawan_id',$kary->id)->count();
            $ijin = $absen->where('status_kehadiran','like','%ijin%')->where('karyawan_id',$kary->id)->count();

            array_push($data,[
                'nama'=>$kary->nama ?? '',
                'jabatan'=>$kary->jabatan->nama ?? '',
                'sakit'=>$sakit ?? '',
                'hadir'=>$hadir ?? '',
                'alpha'=>$alpha ?? '',
                'ijin'=>$ijin ?? '',
            ]);

        }
        // $data = Absensi::query();
        // $data = $data->with(['karyawan.jabatan']);
        // if($request->filled('start_date') && $request->filled('end_date')){
        //     $data = $data->whereBetween('tgl_absen',[$request->start_date,$request->end_date]);
        // }

        // $data = $data->get();
        $pdf = Pdf::loadView('pdf.absen',[
            'data'=>$data,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date
        ]);
        return $pdf->download('laporan-absensi.pdf');
    }

    public function slip(Request $request)
    {
        $data = Penggajian::with(['karyawan.jabatan','detail.komponen'])->where('id',$request->penggajian_id)->first();
        $pdf = Pdf::loadView('pdf.slip',[
            'penggajian'=>$data
        ]);
        return $pdf->download('laporan-slip.pdf');
    }
}
