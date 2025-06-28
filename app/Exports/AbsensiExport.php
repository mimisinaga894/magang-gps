<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsensiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Absensi::with('karyawan')->latest()->get();
    }

    public function map($absensi): array
    {
        return [
            $absensi->tanggal,
            $absensi->karyawan->nik ?? '-',
            $absensi->karyawan->nama_lengkap ?? '-',
            $absensi->jam_masuk ?? '-',
            $absensi->jam_pulang ?? '-',
            $absensi->status,
            $absensi->keterangan ?? '-',
        ];
    }

    public function headings(): array
    {
        return ['Tanggal', 'NIK', 'Nama', 'Jam Masuk', 'Jam Pulang', 'Status', 'Keterangan'];
    }
}
