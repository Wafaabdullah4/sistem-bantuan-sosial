@extends('layouts.app')

@section('title', 'Detail Laporan Bantuan')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header  text-white">
            <h4>Detail Laporan Bantuan</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Program Bantuan</th>
                        <td>{{ $laporan->program->nama_program }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Penerima</th>
                        <td>{{ $laporan->jumlah_penerima }}</td>
                    </tr>
                    <tr>
                        <th>Wilayah</th>
                        <td>{{ $laporan->wilayah->nama_wilayah }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Penyaluran</th>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_penyaluran)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Bukti Penyaluran</th>
                        <td>
                            @if ($laporan->bukti_penyaluran)
                                <a href="{{ asset('storage/' . $laporan->bukti_penyaluran) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Bukti</a>
                            @else
                                <span class="text-danger">Tidak ada bukti penyaluran</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $laporan->catatan ?? 'Tidak ada catatan' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $laporan->status == 'pending' ? 'bg-warning' : ($laporan->status == 'disetujui' ? 'bg-success' : 'bg-danger') }}">
                                {{ $laporan->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ \Carbon\Carbon::parse($laporan->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ \Carbon\Carbon::parse($laporan->updated_at)->format('d M Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
                
                {{-- Hanya tampilkan tombol Edit dan Hapus jika status Pending --}}
                @if ($laporan->status == 'pending')
                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
