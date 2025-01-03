<?php

namespace App\Http\Controllers;

use App\Models\laporan_bantuan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanBantuanExport;
use App\Models\program_bantuan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade as PDF;
use PDF;

class AdminController extends Controller
{

    public function dashboard()
    {
        // Data laporan bantuan, hanya yang disetujui
        $laporanBantuans = laporan_bantuan::with('program', 'wilayah')
            ->where('status', 'disetujui') 
            ->get()
            ->map(function ($laporan) {
                $laporan->tanggal_penyaluran = Carbon::parse($laporan->tanggal_penyaluran);
                return $laporan;
            });

        // Total laporan dan penerima
        $totalLaporan = $laporanBantuans->count();
        $totalPenerima = $laporanBantuans->sum('jumlah_penerima');

        // Data wilayah
        $wilayahData = laporan_bantuan::selectRaw('wilayah_id, SUM(jumlah_penerima) as total_penerima')
            ->where('status', 'disetujui') 
            ->groupBy('wilayah_id')
            ->pluck('total_penerima', 'wilayah_id')
            ->toArray();

        // Ambil semua provinsi
        $provinsi = Wilayah::where('level', 'provinsi')->with('children.children.laporanBantuan')->get();

        // Hitung total penerima untuk setiap provinsi
        $dataProvinsi = $provinsi->map(function ($prov) {
            return [
                'nama_wilayah' => $prov->nama_wilayah,
                'total_penerima' => $prov->total_penerima, 
            ];
        });

        // Data untuk Chart.js
        $provinsiLabels = $dataProvinsi->pluck('nama_wilayah');
        $provinsiValues = $dataProvinsi->pluck('total_penerima');

        $kabupatenData = Wilayah::where('level', 'kabupaten')
            ->with('children') 
            ->get()
            ->map(function ($kabupaten) {
                // Menghitung jumlah penerima untuk kabupaten ini
                $totalPenerimaKabupaten = $kabupaten->laporanBantuan->where('status', 'disetujui')->sum('jumlah_penerima'); 
                foreach ($kabupaten->children as $kecamatan) {
                    $totalPenerimaKabupaten += $kecamatan->laporanBantuan->where('status', 'disetujui')->sum('jumlah_penerima'); 
                }
                return [
                    'nama_wilayah' => $kabupaten->nama_wilayah,
                    'total_penerima' => $totalPenerimaKabupaten,
                ];
            })
            ->sortByDesc('total_penerima')
            ->take(5);


        $kecamatanData = Wilayah::where('level', 'kecamatan')
            ->with('children') 
            ->get()
            ->map(function ($kecamatan) {
                // Menghitung jumlah penerima untuk kabupaten ini
                $totalPenerimakecamatan = $kecamatan->laporanBantuan->where('status', 'disetujui')->sum('jumlah_penerima'); 
                foreach ($kecamatan->children as $kecamatan) {
                    $totalPenerimakecamatan += $kecamatan->laporanBantuan->where('status', 'disetujui')->sum('jumlah_penerima'); 
                }
                return [
                    'nama_wilayah' => $kecamatan->nama_wilayah,
                    'total_penerima' => $totalPenerimakecamatan,
                ];
            })
            ->sortByDesc('total_penerima')
            ->take(5);

        // Hitung jumlah provinsi, kabupaten, kecamatan
        $totalProvinsi = Wilayah::where('level', 'provinsi')->count();
        $totalKabupaten = Wilayah::where('level', 'kabupaten')->count();
        $totalKecamatan = Wilayah::where('level', 'kecamatan')->count();

        // Ambil data wilayah
        $provinsiList = Wilayah::where('level', 'provinsi')->get();
        $kabupatenList = Wilayah::where('level', 'kabupaten')->get();
        $kecamatanList = Wilayah::where('level', 'kecamatan')->get();

        return view('admin.dashboard', compact(
            'laporanBantuans',
            'totalLaporan',
            'totalPenerima',
            'wilayahData',
            'totalProvinsi',
            'totalKabupaten',
            'totalKecamatan',
            'provinsiLabels',
            'provinsiValues',
            'provinsiList',
            'kabupatenList',
            'kecamatanList',
            'kabupatenData',
            'kecamatanData'
        ));
    }

    public function index(Request $request)
    {
        $wilayah = $request->input('wilayah');
        $program = $request->input('program');
        $status = $request->input('status');

        $laporanBantuans = laporan_bantuan::query();

        if ($wilayah && $wilayah != 'all') {
            $wilayahData = Wilayah::where('nama_wilayah', 'like', '%' . $wilayah . '%')->first();
        
            if ($wilayahData) {
                if ($wilayahData->level == 'provinsi') {
                    $laporanBantuans->whereHas('wilayah', function ($query) use ($wilayahData) {
                        $query->where('parent_id', $wilayahData->id)
                              ->orWhere('id', $wilayahData->id);
                    });
        
                    $laporanBantuans->orWhereHas('wilayah', function ($query) use ($wilayahData) {
                        $query->whereIn('parent_id', function ($subQuery) use ($wilayahData) {
                            $subQuery->select('id')->from('wilayahs')
                                     ->where('parent_id', $wilayahData->id);
                        });
                    });
                } elseif ($wilayahData->level == 'kabupaten') {
                    $laporanBantuans->whereHas('wilayah', function ($query) use ($wilayahData) {
                        $query->where('parent_id', $wilayahData->id)
                              ->orWhere('id', $wilayahData->id);
                    });
                } elseif ($wilayahData->level == 'kecamatan') {
                    $laporanBantuans->whereHas('wilayah', function ($query) use ($wilayahData) {
                        $query->where('id', $wilayahData->id);
                    });
                }
            }
        }

        // Filter berdasarkan program jika ada input dari user
        if ($program && $program != 'all') {
            $laporanBantuans->where('program_id', $program);
        }

        // Filter status
        if ($status && $status != 'all') {
            $laporanBantuans->where('status', $status);
        }

        // Ambil data
        $laporanBantuans = $laporanBantuans->get();

        // Kirim data ke view
        return view('admin.laporan.index', [
            'laporanBantuans' => $laporanBantuans,
            'wilayahList' => Wilayah::all(),
            'programList' => program_bantuan::all(),
        ]);
    }

    public function exportLaporan(Request $request)
    {
        // Dapatkan data laporan yang sudah difilter
        $laporanBantuans = laporan_bantuan::query();

        if ($request->has('wilayah') && $request->wilayah != 'all') {
            $laporanBantuans->where('wilayah_id', $request->wilayah);
        }
        if ($request->has('program') && $request->program != 'all') {
            $laporanBantuans->where('program_id', $request->program);
        }
        if ($request->has('status') && $request->status != 'all') {
            $laporanBantuans->where('status', $request->status);
        }

        $laporanBantuans = $laporanBantuans->with(['wilayah', 'program'])->get();

        return Excel::download(new LaporanBantuanExport($laporanBantuans), 'laporan_bantuan.xlsx');
    }

    public function exportPdf(Request $request)
    {
        // dd($request->all());      
        $laporanBantuans = laporan_bantuan::query();

        if ($request->has('wilayah') && $request->wilayah != 'all') {
            $laporanBantuans->where('wilayah_id', $request->wilayah);
        }
        if ($request->has('program') && $request->program != 'all') {
            $laporanBantuans->where('program_id', $request->program);
        }
        if ($request->has('status') && $request->status != 'all') {
            $laporanBantuans->where('status', $request->status);
        }

        $laporanBantuans = $laporanBantuans->get();

        $pdf = PDF::loadView('admin.laporan.pdf', compact('laporanBantuans'));

        return $pdf->download('laporan_bantuan.pdf');
    }

    /**
     * Verifikasi status laporan bantuan.
     */
    public function verify(Request $request, $id)
    {
        $laporan = laporan_bantuan::findOrFail($id);

        $laporan->status = $request->status;
        $laporan->alasan_penolakan = $request->status == 'ditolak' ? $request->alasan_penolakan : null;
        $laporan->save();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diverifikasi');
    }
    public function show($id)
    {
        $laporan = laporan_bantuan::with(['program', 'wilayah'])->findOrFail($id);
        return view('admin.laporan.show', compact('laporan'));
    }
}
