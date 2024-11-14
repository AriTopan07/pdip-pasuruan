<?php

namespace App\Exports;

use App\Models\DataDiri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataDiriExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Ambil data DataDiri beserta user yang terkait
        return DataDiri::with('user')->get();
    }

    public function headings(): array
    {
        // Header kolom
        return [
            'Kecamatan',
            'Desa',
            'TPS',
            'Foto Diri',
        ];
    }

    public function map($dataDiri): array
    {
        // Mapping data agar sesuai dengan urutan kolom yang diinginkan
        return [
            $dataDiri->user->nama,  // Kolom nama dari tabel users
            $dataDiri->kecamatan,
            $dataDiri->desa,
            $dataDiri->foto_diri,
        ];
    }
}
