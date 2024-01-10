<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="Description" content="Enter your description here" />
    </head>
    <body>
        <table style="width: 100%;">
            <tr>
                <td>
                    <h1 style="text-align: center;">DAFTAR HADIR RAPAT</h1>
                </td>
            </tr>
        </table>
        <table style="width: 100%; border: 1px solid black;">
            <tr>
                <td style="border: 1px solid black; width: 100px;">
                    Hari, Tanggal
                </td>
                <td style="border: 1px solid black; width: 5px;">
                    :
                </td>
                <td style="border: 1px solid black;">
                <?php use Carbon\Carbon; ?>
                 {{ Carbon::parse(date('d-m-Y', strtotime($q)))->dayName }}, {{ date('d-m-Y', strtotime($q)) }}
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; width: 5px;">No</th>
                    <th style="border: 1px solid black; text-align: start;">Nama Anggota</th>
                    <th style="border: 1px solid black; text-align: start;">Jabatan</th>
                    <th style="border: 1px solid black; width: 200px;">Jenis Rapat</th>
                    <th style="border: 1px solid black; width: 200px;">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $k => $item)
                    <tr>
                        <td style="border: 1px solid black;">{{ $k+1 }}</td>
                        <td style="border: 1px solid black;">{{ $item->nama_lengkap }}</td>
                        <td style="border: 1px solid black;">{{ $item->jabatan }}</td>
                        <td style="border: 1px solid black;">{{ $item->jenis_rapat }}</td>
                        <td style="border: 1px solid black;">
                            <img width="200px" src="{{ asset('signature') }}/{{ @$item->signature }}" alt="">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
