<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WilayahController extends Controller
{
    public function semuaKecamatan()
    {
        $filePath = public_path('wilayah.json');
        $wilayahData = json_decode(File::get($filePath), true);

        // Ambil data kecamatan unik
        $kecamatan = collect($wilayahData)->pluck('KECAMATAN')->unique()->values();

        return response()->json($kecamatan);
    }

    public function desaByKecamatan($kecamatan)
    {
        $filePath = public_path('wilayah.json');
        $wilayahData = json_decode(File::get($filePath), true);

        // Filter desa berdasarkan kecamatan
        $desa = collect($wilayahData)->where('KECAMATAN', strtoupper($kecamatan))->values();

        return response()->json($desa);
    }
}
