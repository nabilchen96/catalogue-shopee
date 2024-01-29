<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Hash; //membuat text menjadi terenkripsi
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        ini_set('max_execution_time', 300);

        // Check if the row is empty, and stop the import process if it is.
        if (empty(array_filter($row))) {
            // Returning null will stop the import process for the current row.
            return null;
        }

        $data = $row['harga'];

        // Menghilangkan "Rp" dan titik
        $data = str_replace(array("Rp", "."), "", $data);

        // Memecah data menjadi dua bagian menggunakan "-" sebagai delimiter
        $parts = explode("-", $data);

        // Menghapus spasi pada kedua bagian
        $min_price = trim($parts[0]);
        if (isset($parts[1])) {
            $max_price = trim($parts[1]);
        } else {
            $max_price = 0;
        }

        // Menghapus karakter khusus
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', $row['judul']);

        // Mengganti spasi dengan tanda hubung
        $text = str_replace(' ', '-', $text);

        // Mengonversi ke huruf kecil
        $text = strtolower($text);

        return Barang::create([
            'nama_barang' => $row['judul'],
            'kategori' => $row['kategori'],

            'harga_start' => $min_price,
            'harga_end' => $max_price,
            'rating' => $row['rating'],
            'terjual' => $row['terjual'],
            'spesifikasi' => $row['spesifikasi'],
            'deskripsi' => $row['deskripsi'],
            'slug'  => $text,

            'id_user' => Auth::id()
        ]);
    }

}
