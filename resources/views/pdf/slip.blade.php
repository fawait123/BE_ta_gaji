<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Slip Gaji</title>
</head>

<body>
    <div style="width: 100%; border:1px solid black;padding:5px;">
        <span style="font-size: 15px; font-weight:bold;display:block;text-align:center;">RINCIAN PENERIMAAN SILTAP.
            TUNJANGAN DAN
            TAMSIL</span>
        <span style="font-size: 15px; font-weight:bold;display:block;text-align:center;">PAMONG KELURAHAN DAN DUKUH
            SINDUADI</span>
        <span style="font-size: 15px; font-weight:bold;display:block;text-align:center; margin-bottom:5px;">BULAN
            <span style="text-transform: uppercase">{{ date('F', strtotime($penggajian->tgl_penggajian)) }}</span>
            {{ date('Y', strtotime($penggajian->tgl_penggajian)) }}</span>
        <div style="border-bottom: 1px solid black"></div>
        <div style="position: relative;">
            <div style="margin-top:10px;">
                <div style="width: 120px;display:inline-block;font-weight:bold;">NAMA : </div>
                <div style="display: inline-block;font-weight:bold;">{{ strtoupper($penggajian->karyawan->nama ?? '') }}
                </div>
            </div>
            <div style="margin-top:10px;">
                <div style="width: 120px;display:inline-block;font-weight:bold;">NAMA BANK : </div>
                <div style="display: inline-block;font-weight:bold;">
                    {{ strtoupper($penggajian->karyawan->nama_bank ?? '') }}
                </div>
            </div>
            <div style="position: absolute; right: 0;top:0;">
                <div style="width: 120px;display:inline-block;font-weight:bold;">JABATAN : </div>
                <div style="display: inline-block;font-weight:bold;">
                    {{ strtoupper($penggajian->karyawan->jabatan->nama ?? '') }}</div>
            </div>
            <div style="position: absolute; right: 0;top:20;">
                <div style="width: 120px;display:inline-block;font-weight:bold;">NO REK : </div>
                <div style="display: inline-block;font-weight:bold;">
                    {{ strtoupper($penggajian->karyawan->no_rek ?? '') }}</div>
            </div>
        </div>
        <ol type="A">
            <li>TUNJANGAN
                <div style="position: relative">
                    <ol type="1">
                        @foreach ($penggajian->detail as $item)
                            @if ($item->tipe == 'Penambahan')
                                <li>{{ $item->komponen->nama ?? '' }}</li>
                            @endif
                        @endforeach
                    </ol>
                    <div style="position: absolute;top:0;right:0;">
                        @foreach ($penggajian->detail as $item)
                            @if ($item->tipe == 'Penambahan')
                                <div>
                                    <div style="width:160px;display: inline-block;">Rp.</div>
                                    {{ number_format($item->jumlah, 2, ',', '.') }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
            <li style="margin-top: 40px;">PENGURANGAN
                <div style="position: relative">
                    <ol type="1">
                        @foreach ($penggajian->detail as $item)
                            @if ($item->tipe == 'Pengurangan')
                                <li>{{ $item->komponen->nama }}</li>
                            @endif
                        @endforeach
                    </ol>
                    <div style="position: absolute;top:0;right:0;">
                        @foreach ($penggajian->detail as $item)
                            @if ($item->tipe == 'Pengurangan')
                                <div>
                                    <div style="width:160px;display: inline-block;">Rp.</div>
                                    {{ number_format($item->jumlah, 2, ',', '.') }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </li>
            <li style="margin-top: 40px; margin-bottom:20px;">TERIMA BERSIH / TRANSFER
                <div style="position: relative">
                    <div style="position: absolute;top:0;right:0;">
                        <div>
                            <div style="width:160px;display: inline-block;">Rp.</div>
                            {{ number_format($penggajian->total_gaji, 2, ',', '.') }}
                        </div>
                    </div>
                </div>
            </li>
        </ol>
        <div style="border-bottom: 1px solid black; margin-top:40px;margin-bottom:20px;"></div>
        <div style="position: relative;">
            <div>
                <span>Yang Menerima</span>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <span>{{ strtoupper($penggajian->karyawan->nama ?? '') }}</span>
            </div>
            <div style="position: absolute;top:0;right:0;">
                <span style="display:block">Sinduadi, {{ date('d M Y') }}</span>
                <span>Kaum Danarta</span>
                <br>
                <br>
                <br>
                <br>
                <span>Agus Sudarmana</span>
            </div>
        </div>
    </div>
</body>

</html>
