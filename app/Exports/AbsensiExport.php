<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function view(): View
    {
        $absensis = Absensi::where('user_id', $this->user_id)->get();
        return view('karyawan.laporan_excel', compact('absensis'));
    }
}
