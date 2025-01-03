@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('laporan.create') }}" class="btn btn-primary mb-3">Add Laporan</a>
            
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('laporan.index') }}" method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="nama_program" class="form-control">
                            <option value="">Pilih Nama Program (Semua)</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->nama_program }}" {{ request()->get('nama_program') == $program->nama_program ? 'selected' : '' }}>
                                    {{ $program->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Pilih Status (Semua)</option>
                            <option value="Pending" {{ request()->get('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ request()->get('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request()->get('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-secondary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Daftar Laporan Penyaluran Bantuan</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Program</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Penerima</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wilayah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $laporan->program->nama_program }}</td>
                                        <td>{{ $laporan->jumlah_penerima }}</td>
                                        <td>
                                            {{-- Menampilkan hierarki wilayah --}}
                                            @if ($laporan->wilayah->parent && $laporan->wilayah->parent->parent)
                                                {{ $laporan->wilayah->parent->parent->nama_wilayah }} > 
                                            @endif
                                            @if ($laporan->wilayah->parent)
                                                {{ $laporan->wilayah->parent->nama_wilayah }} > 
                                            @endif
                                            {{ $laporan->wilayah->nama_wilayah }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $laporan->status == 'pending' ? 'bg-warning' : ($laporan->status == 'disetujui' ? 'bg-success' : 'bg-danger') }}">
                                                {{ $laporan->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($laporan->status == 'Pending')
                                                <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @else
                                                <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
