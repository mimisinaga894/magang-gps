<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\LokasiKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;


class PresensiController extends Controller
{
    public function index()
    {
        $title = 'Presensi';
        $presensiKaryawan = DB::table('presensi')
            ->where('nik', auth()->guard('karyawan')->user()->nik)
            ->where('tanggal_presensi', date('Y-m-d'))
            ->first();
        $lokasiKantor = LokasiKantor::where('is_used', true)->first();
        return view('dashboard.presensi.index', compact('title', 'presensiKaryawan', 'lokasiKantor'));
    }

    public function store(Request $request)
    {
        $jenisPresensi = $request->jenis;
        $nik = auth()->guard('karyawan')->user()->nik;
        $tglPresensi = date('Y-m-d');
        $jam = date('H:i:s');

        $lokasi = $request->lokasi;

        $lokasiKantor = LokasiKantor::where('is_used', true)->first();
        $langtitudeKantor = $lokasiKantor->latitude;
        $longtitudeKantor = $lokasiKantor->longitude;

        $lokasiUser = explode(",", $lokasi);
        $langtitudeUser = $lokasiUser[0];
        $longtitudeUser = $lokasiUser[1];

        $jarak = round($this->validation_radius_presensi($langtitudeKantor, $longtitudeKantor, $langtitudeUser, $longtitudeUser), 2);

        if ($jarak > 33) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => "Anda berada di luar radius kantor. Jarak Anda " . $jarak . " meter dari kantor",
                'jenis_error' => "radius",
            ]);
        }

        if ($jenisPresensi == "masuk") {
            $data = [
                "nik" => $nik,
                "tanggal_presensi" => $tglPresensi,
                "jam_masuk" => $jam,
                "lokasi_masuk" => $lokasi,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            $store = DB::table('presensi')->insert($data);
        } elseif ($jenisPresensi == "keluar") {
            $data = [
                "jam_keluar" => $jam,
                "lokasi_keluar" => $lokasi,
                "updated_at" => Carbon::now(),
            ];
            $store = DB::table('presensi')
                ->where('nik', $nik)
                ->where('tanggal_presensi', $tglPresensi)
                ->update($data);
        }

        if (!$store) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => "Gagal presensi",
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $data,
            'success' => true,
            'message' => "Berhasil presensi",
            'jenis_presensi' => $jenisPresensi,
        ]);
    }
    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:karyawan,nik',
            'keterangan' => 'required|in:Hadir,Sakit,Izin',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $karyawan = Karyawan::with('departemen')->where('nik', $request->nik)->first();

        DB::table('presensi')->insert([
            'nik' => $karyawan->nik,
            'tanggal_presensi' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'lokasi_masuk' => $request->latitude . ',' . $request->longitude,
            'keterangan' => $request->keterangan,
            'jabatan' => $karyawan->jabatan,
            'departemen' => $karyawan->departemen->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function formManualAbsensi()
    {
        $karyawans = Karyawan::with('departemen')->get();
        return view('admin.absensi.manual-form', compact('karyawans'));
    }
    public function storeManualAbsensi(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'departemen' => 'required',
            'keterangan' => 'required|in:Hadir,Sakit,Izin',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        DB::table('presensi')->insert([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'keterangan' => $request->keterangan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tanggal_presensi' => now()->format('Y-m-d'),
            'jam_masuk' => now()->format('H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Absensi manual berhasil disimpan.');
    }



    public function validation_radius_presensi($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2))
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $km = $miles * 1.609344;
        $meters = $km * 1000;
        return $meters;
    }

    public function history()
    {
        $title = 'Riwayat Presensi';
        $riwayatPresensi = DB::table("presensi")
            ->where('nik', auth()->guard('karyawan')->user()->nik)
            ->orderBy("tanggal_presensi", "asc")
            ->paginate(10);
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('dashboard.presensi.history', compact('title', 'riwayatPresensi', 'bulan'));
    }

    public function searchHistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $data = DB::table('presensi')
            ->where('nik', auth()->guard('karyawan')->user()->nik)
            ->whereMonth('tanggal_presensi', $bulan)
            ->whereYear('tanggal_presensi', $tahun)
            ->orderBy("tanggal_presensi", "asc")
            ->get();
        return view('dashboard.presensi.search-history', compact('data'));
    }

    public function monitoringPresensi(Request $request)
    {
        $query = DB::table('presensi as p')
            ->join('karyawan as k', 'p.nik', '=', 'k.nik')
            ->join('departemen as d', 'k.departemen_id', '=', 'd.id')
            ->orderBy('k.nama_lengkap', 'asc')
            ->orderBy('d.kode', 'asc')
            ->select('p.*', 'k.nama_lengkap as nama_karyawan', 'd.nama as nama_departemen');

        if ($request->tanggal_presensi) {
            $query->whereDate('p.tanggal_presensi', $request->tanggal_presensi);
        } else {
            $query->whereDate('p.tanggal_presensi', Carbon::now());
        }

        $monitoring = $query->paginate(10);
        $lokasiKantor = LokasiKantor::where('is_used', true)->first();

        return view('admin.monitoring-presensi.index', compact('monitoring', 'lokasiKantor'));
    }


    public function absensiTrackerAdmin(Request $request)
    {
        $karyawans = Karyawan::orderBy('nama_lengkap')->get();

        $query = DB::table('presensi as p')
            ->join('karyawan as k', 'p.nik', '=', 'k.nik')
            ->select('p.*', 'k.nama_lengkap', 'k.jabatan');

        if ($request->filled('karyawan_id')) {
            $karyawan = Karyawan::find($request->karyawan_id);
            if ($karyawan) {
                $query->where('k.nik', $karyawan->nik);
            }
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('p.tanggal_presensi', $request->tanggal);
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('p.tanggal_presensi', $request->bulan)
                ->whereYear('p.tanggal_presensi', $request->tahun);
        } else {
            $query->whereDate('p.tanggal_presensi', now()->toDateString());
        }

        $absensiHariIni = $query->get();


        $statistikQuery = DB::table('presensi as p')
            ->join('karyawan as k', 'p.nik', '=', 'k.nik');

        if ($request->filled('karyawan_id')) {
            $karyawan = Karyawan::find($request->karyawan_id);
            if ($karyawan) {
                $statistikQuery->where('k.nik', $karyawan->nik);
            }
        }

        if ($request->filled('tanggal')) {
            $statistikQuery->whereDate('p.tanggal_presensi', $request->tanggal);
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $statistikQuery->whereMonth('p.tanggal_presensi', $request->bulan)
                ->whereYear('p.tanggal_presensi', $request->tahun);
        } else {
            $statistikQuery->whereDate('p.tanggal_presensi', now()->toDateString());
        }

        $statistik = [
            'hadir' => (clone $statistikQuery)->where('keterangan', 'Hadir')->count(),
            'sakit' => (clone $statistikQuery)->where('keterangan', 'Sakit')->count(),
            'izin'  => (clone $statistikQuery)->where('keterangan', 'Izin')->count(),
        ];

        return view('admin.absensi.absensi-tracker', compact('karyawans', 'absensiHariIni', 'statistik'));
    }

    public function exportExcel()
    {
        return Excel::download(new AbsensiExport, 'rekap-absensi.xlsx');
    }

    public function exportPDF()
    {

        $absensi = Absensi::with('karyawan')->latest()->get();

        return Pdf::loadView('admin.absensi.pdf', compact('absensi'))
            ->setPaper('a4', 'landscape')
            ->download('rekap-absensi.pdf');
    }


    public function viewLokasi(Request $request)
    {
        if ($request->tipe == "lokasi_masuk") {
            return DB::table('presensi')->where('nik', $request->nik)->first('lokasi_masuk');
        } elseif ($request->tipe == "lokasi_keluar") {
            return DB::table('presensi')->where('nik', $request->nik)->first('lokasi_keluar');
        }
    }
}
