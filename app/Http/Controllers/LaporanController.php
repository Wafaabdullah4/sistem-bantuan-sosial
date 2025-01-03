<?php

namespace App\Http\Controllers;

use App\Models\laporan_bantuan;
use App\Models\program_bantuan;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    public function create()
    {
        $user = auth()->user();
        $wilayah = $user->wilayah;

        // Ambil semua program bantuan
        $programs = program_bantuan::all();

        // Ambil wilayah yang tidak memiliki parent_id (Provinsi)
        $wilayahs = Wilayah::whereNull('parent_id')->get();

        // Default koleksi untuk provinsi, kabupaten, dan kecamatan
        $provinsi = collect();
        $kabupatens = collect();
        $kecamatans = collect();

        if ($wilayah && $wilayah->level == 'kecamatan') {
            $kabupaten = $wilayah->parent;
            $provinsi = $kabupaten->parent ? collect([$kabupaten->parent]) : collect();
            $kabupatens = collect([$kabupaten]);
            $kecamatans = collect([$wilayah]);
        }

        if ($wilayah && $wilayah->level == 'kabupaten') {
            $provinsi = $wilayah->parent ? collect([$wilayah->parent]) : collect();
            $kabupatens = collect([$wilayah]);
            $kecamatans = $wilayah->children;
        }

        if ($wilayah && $wilayah->level == 'provinsi') {
            $provinsi = collect([$wilayah]);
            $kabupatens = $wilayah->children;
        }

        // Ambil data laporan yang terkait dengan user
        $laporans = laporan_bantuan::where('user_id', $user->id)->get();

        // dd(compact('wilayah', 'provinsi', 'kabupatens', 'kecamatans'));
        return view('laporan.create', compact('programs', 'wilayahs', 'user', 'laporans', 'provinsi', 'kabupatens', 'kecamatans'));
    }



    // Menyimpan laporan baru
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:program_bantuans,id',
            'jumlah_penerima' => 'required|numeric|min:1',
            'wilayah_id' => 'required|exists:wilayahs,id',
            'tanggal_penyaluran' => 'required|date',
            'bukti_penyaluran' => 'required|mimes:jpg,png,pdf|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // $buktiPenyaluran = $request->file('bukti_penyaluran')->store('bukti_penyaluran');
        $buktiPenyaluran = $request->file('bukti_penyaluran')->storePublicly('bukti_penyaluran', 'public');
        $wilayahId = $request->kecamatan_id ?: $request->kabupaten_id ?: $request->wilayah_id;


        // Membuat laporan baru
        laporan_bantuan::create([
            'program_id' => $request->program_id,
            'jumlah_penerima' => $request->jumlah_penerima,
            'wilayah_id' => $wilayahId,
            'tanggal_penyaluran' => $request->tanggal_penyaluran,
            'bukti_penyaluran' => $buktiPenyaluran,
            'catatan' => $request->catatan,
            'status' => 'Pending',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dikirim');
    }


    public function index(Request $request)
    {
        $user = auth()->user();

        $programs = program_bantuan::all();

        $query = laporan_bantuan::with(['wilayah', 'wilayah.parent', 'wilayah.parent.parent'])
            ->where('user_id', $user->id);

        if ($request->has('nama_program') && $request->nama_program != '') {
            $query->whereHas('program', function ($q) use ($request) {
                $q->where('nama_program', 'like', '%' . $request->nama_program . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $laporans = $query->get();

        return view('laporan.index', compact('laporans', 'user', 'programs'));
    }

    public function edit($id)
    {
        $laporan = laporan_bantuan::findOrFail($id);
        $programs = program_bantuan::all();
        $wilayahs = Wilayah::whereNull('parent_id')->get();
        $selectedWilayah = Wilayah::find($laporan->wilayah_id);
        $kabupatens = $selectedWilayah->parent_id ? Wilayah::where('parent_id', $selectedWilayah->parent_id)->get() : [];
        return view('laporan.edit', compact('laporan', 'programs', 'wilayahs', 'kabupatens'));
    }

    // Memperbarui laporan yang sudah ada
    public function update(Request $request, $id)
    {
        $laporan = laporan_bantuan::findOrFail($id);

        $request->validate([
            'program_id' => 'required|exists:program_bantuans,id',
            'jumlah_penerima' => 'required|numeric|min:1',
            'tanggal_penyaluran' => 'required|date',
            'bukti_penyaluran' => 'nullable|mimes:jpg,png,pdf|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // Mengupdate bukti penyaluran jika ada file baru
        if ($request->hasFile('bukti_penyaluran')) {

            Storage::delete($laporan->bukti_penyaluran);

            $buktiPenyaluran = $request->file('bukti_penyaluran')->storePublicly('bukti_penyaluran', 'public');

            // $buktiPenyaluran = $request->file('bukti_penyaluran')->store('bukti_penyaluran');
            $laporan->bukti_penyaluran = $buktiPenyaluran;
        }

        $laporan->update([
            'program_id' => $request->program_id,
            'jumlah_penerima' => $request->jumlah_penerima,
            'tanggal_penyaluran' => $request->tanggal_penyaluran,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui');
    }

    // Menghapus laporan
    public function destroy($id)
    {
        $laporan = laporan_bantuan::findOrFail($id);

        Storage::delete($laporan->bukti_penyaluran);

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus');
    }

    // Menampilkan detail laporan untuk admin
    public function show($id)
    {
        $laporan = laporan_bantuan::with(['program', 'wilayah'])->findOrFail($id);
        return view('laporan.show', compact('laporan'));
    }
}
