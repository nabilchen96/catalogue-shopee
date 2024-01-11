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
                    <h1 style="text-align: center;">LAPORAN KEUNGAN BAG. {{ strtoupper($bidang) }}</h1>
                    <h1 style="text-align: center;">
                       {{ date('d-m-Y', strtotime($tgl_awal)) }} s/d {{ date('d-m-Y', strtotime($tgl_akhir)) }}
                    </h1>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; width: 5px;">No</th>
                    <th style="border: 1px solid black; text-align: start;">Tanggal</th>
                    <th style="border: 1px solid black; text-align: start;">Keterangan</th>
                    <th style="border: 1px solid black; width: 200px;">Penerimaan</th>
                    <th style="border: 1px solid black; width: 200px;">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jurnal as $k => $item)
                    <tr>
                        <td style="border: 1px solid black;">{{ $k+1 }}</td>
                        <td style="border: 1px solid black;">
                            {{ date('d-m-Y H:i', strtotime($item->waktu_transaksi)) }}
                        </td>
                        <td style="border: 1px solid black;">{{ $item->keterangan }}</td>
                        <td style="border: 1px solid black;">Rp. {{ number_format($item->debet) }}</td>
                        <td style="border: 1px solid black;">Rp. {{ number_format($item->kredit) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
