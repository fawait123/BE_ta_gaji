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
    <h1 style="text-align: center;">Laporan Absensi Tanggal {{ date('d M Y', strtotime($start_date)) }} -
        {{ date('d M Y', strtotime($end_date)) }}</h1>
    <table>
        <tr>
            <th>NO</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Sakit</th>
            <th>Ijin</th>
            <th>Alpha</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item['nama'] ?? '' }}</td>
                <td>{{ $item['jabatan'] ?? '' }}</td>
                <td>{{ $item['sakit'] }}</td>
                <td>{{ $item['ijin'] }}</td>
                <td>{{ $item['alpha'] }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
