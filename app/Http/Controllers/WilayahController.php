<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::with('parent')->get(); 
        return view('admin.wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        $wilayahInduk = Wilayah::all();
        return view('admin.wilayah.create', compact('wilayahInduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'level' => 'required|in:provinsi,kabupaten,kecamatan',
        ]);

        Wilayah::create($request->all());
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        $wilayahInduk = Wilayah::all(); 
        return view('admin.wilayah.edit', compact('wilayah', 'wilayahInduk'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'level' => 'required|in:provinsi,kabupaten,kecamatan',
        ]);

        $wilayah->update($request->all());
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();
        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
