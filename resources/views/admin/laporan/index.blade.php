@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-3">
                <div class="row">

                    <div class="col-12 col-md-3">
                        <label for="wilayah" class="form-label">Wilayah</label>
                        <select name="wilayah" class="form-select" id="wilayah">
                            <option value="">Pilih Wilayah</option>
                            <option value="all">Semua Wilayah</option>
                            @foreach ($wilayahList as $wilayah)
                                <option value="{{ $wilayah->nama_wilayah }}"
                                    {{ request('wilayah') == $wilayah->nama_wilayah ? 'selected' : '' }}>
                                    {{ $wilayah->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                <div class="col-12 col-md-3">
                    <label for="program" class="form-label">Program</label>
                    <select name="program" class="form-select" id="program">
                        <option value="">Pilih Program</option>
                        <option value="all">Semua Program</option>
                        @foreach ($programList as $program)
                            <option value="{{ $program->id }}" {{ request('program') == $program->id ? 'selected' : '' }}>
                                {{ $program->nama_program }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" id="status">
                        <option value="">Pilih Status</option>
                        <option value="all">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
        </div>
        <div class="col-12 col-md-3 d-flex align-items-end mt-2">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('laporan.export', ['wilayah' => request('wilayah'), 'program' => request('program'), 'status' => request('status')]) }}"
                class="btn btn-success">Export Excel</a>
            <a href="{{ route('laporan.exportPdf', ['wilayah' => request('wilayah'), 'program' => request('program'), 'status' => request('status')]) }}"
                class="btn btn-danger">Export PDF</a>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Nama Program</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Jumlah Penerima</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Wilayah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Status</th>
                                <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanBantuans as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->program->nama_program }}</td>
                                    <td>{{ $laporan->jumlah_penerima }}</td>
                                    <td>
                                        @if ($laporan->wilayah->parent && $laporan->wilayah->parent->parent)
                                            {{ $laporan->wilayah->parent->parent->nama_wilayah }} >
                                        @endif
                                        @if ($laporan->wilayah->parent)
                                            {{ $laporan->wilayah->parent->nama_wilayah }} >
                                        @endif
                                        {{ $laporan->wilayah->nama_wilayah }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $laporan->status == 'pending' ? 'bg-warning' : ($laporan->status == 'disetujui' ? 'bg-success' : 'bg-danger') }}">
                                            {{ ucfirst($laporan->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#verifyModal{{ $laporan->id }}">Verifikasi</button>
                                        <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                                            class="btn btn-info btn-sm">Lihat</a>
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

    <!-- Modal Verifikasi -->
    @foreach ($laporanBantuans as $laporanItem)
        <div class="modal fade" id="verifyModal{{ $laporanItem->id }}" tabindex="-1" aria-labelledby="verifyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalLabel">Verifikasi Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.laporan.verify', $laporanItem->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alasan_penolakan">Alasan Penolakan (Jika ditolak)</label>
                                <textarea name="alasan_penolakan" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success mt-2">Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
