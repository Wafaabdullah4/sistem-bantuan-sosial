@extends('layouts.app')

@section('content')
<div class="col-md-8">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <p class="mb-0">Edit Laporan Bantuan</p>
            </div>
        </div>
        <div class="card-body">
            <!-- Menampilkan pesan sukses jika ada -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program_id" class="form-control-label">Program Bantuan</label>
                            <select class="form-select" name="program_id" id="program_id" required>
                                <option value="">Pilih Program Bantuan</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ $program->id == $laporan->program_id ? 'selected' : '' }}>
                                        {{ $program->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_penerima" class="form-control-label">Jumlah Penerima</label>
                            <input type="number" name="jumlah_penerima" id="jumlah_penerima" class="form-control" value="{{ old('jumlah_penerima', $laporan->jumlah_penerima) }}" required>
                            @error('jumlah_penerima')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark">

                <p class="text-uppercase text-sm">Information</p>
                <div class="mb-3">
                    <label for="tanggal_penyaluran" class="form-label">Tanggal Penyaluran</label>
                    <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran" class="form-control" value="{{ old('tanggal_penyaluran', $laporan->tanggal_penyaluran) }}" required>
                    @error('tanggal_penyaluran')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bukti_penyaluran" class="form-label">Bukti Penyaluran (JPG/PNG/PDF)</label>
                    <input type="file" name="bukti_penyaluran" id="bukti_penyaluran" class="form-control">
                    <small class="form-text text-muted">File yang telah diupload sebelumnya: <a href="{{ Storage::url($laporan->bukti_penyaluran) }}" target="_blank">Lihat Bukti Penyaluran</a></small>
                    @error('bukti_penyaluran')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan Tambahan</label>
                    <textarea name="catatan" id="catatan" class="form-control">{{ old('catatan', $laporan->catatan) }}</textarea>
                    @error('catatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Laporan</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
