<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penggajian</title>
</head>
<style>
    table {
        width: 100%;
        margin: 20px auto;
        table-layout: auto;
    }

    table,
    td,
    th {
        border-collapse: collapse;
    }

    th,
    td {
        padding: 6px;
        border: solid 1px;
        text-align: center;
    }

    .w {
        width: 400px;
    }
</style>

<body>
    <h1 style="text-align: center;">Laporan Penggajian</h1>
    <table>
        <tr>
            <th>NO</th>
            <th>Tanggal</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Tunjangan</th>
            <th>Potongan</th>
            <th>Gaji</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d M Y', strtotime($item->tgl_penggajian)) }}</td>
                <td>{{ $item->karyawan->nama }}</td>
                <td>{{ $item->karyawan->jabatan->nama }}</td>
                <td>{{ $item->total_tunjangan }}</td>
                <td>{{ $item->total_pengurangan }}</td>
                <td>{{ $item->total_gaji }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
