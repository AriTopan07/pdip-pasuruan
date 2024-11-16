<?php

if (!function_exists('extractKecamatanKelurahan')) {
    function extractKecamatanKelurahan($username)
    {
        $kecamatan = null;
        $kelurahan = null;

        if (str_starts_with($username, 'tps-')) {
            // Pisahkan bagian username menjadi elemen-elemen
            $parts = explode('-', $username);
            if (count($parts) >= 4) {
                $kecamatan = strtoupper(array_pop($parts)); // Ambil kecamatan
                $kelurahan = strtoupper(implode(' ', array_slice($parts, 2))); // Gabung kelurahan
            }
        }

        return [
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
        ];
    }
}
