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
                    <h1 style="text-align: center;">LAPORAN STOK BARANG</h1>
                </td>
            </tr>
        </table>
        <br>
        <table style="width: 100%; border: 1px solid black;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; width: 5px;">No</th>
                    <th style="border: 1px solid black; text-align: start;">Gambar</th>
                    <th style="border: 1px solid black; text-align: start;">Barang</th>
                    <th style="border: 1px solid black; width: 200px;">Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stok as $k => $item)
                    <tr>
                        <td style="border: 1px solid black;">{{ $k+1 }}</td>
                        <td style="border: 1px solid black;">
                            @if ($item->foto_barang)
                                <img src="{{ asset('foto_barang') }}/{{ $item->foto_barang }}" width="50px" height="50px">
                            @else
                                <img src="{{ asset('no_image.jpg') }}" width="50px" height="50px">
                            @endif
                        </td>
                        <td style="border: 1px solid black;">{{ $item->nama_barang }}</td>
                        <td style="border: 1px solid black;">{{ $item->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
