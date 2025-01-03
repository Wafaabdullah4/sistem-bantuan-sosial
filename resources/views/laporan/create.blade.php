@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <p class="mb-0">Formulir Laporan Penyaluran Bantuan</p>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <p class="text-uppercase text-sm">User Information : {{ $user ->name }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="program" class="form-control-label">Nama Program</label>
                            <select class="form-select" name="program_id" id="program" required>
                                <option value="">Pilih Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
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
                            <input type="number" name="jumlah_penerima" id="jumlah_penerima" class="form-control" required>
                            @error('jumlah_penerima')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm"> Information</p>
                @if ($user->wilayah)
                @if ($user->wilayah->parent)
                    <!-- Jika user memiliki parent wilayah, tampilkan Provinsi -->
                    <div class="mb-3">
                        <label for="wilayah" class="form-label">Provinsi</label>
                        <select class="form-select" name="wilayah_id" id="wilayah" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($wilayahs as $wilayah)
                                <option value="{{ $wilayah->id }}" 
                                    @if ($user->wilayah->parent->id == $wilayah->id || 
                                         ($user->wilayah->level == 'kecamatan' && $user->wilayah->parent->parent->id == $wilayah->id))
                                        selected
                                    @endif
                                >
                                    {{ $wilayah->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                        @error('wilayah_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            
                @if ($user->wilayah->level == 'kabupaten' || $user->wilayah->level == 'kecamatan')
                    <!-- Jika user level kabupaten atau kecamatan, tampilkan Kabupaten -->
                    <div class="mb-3">
                        <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                        <select class="form-select" name="kabupaten_id" id="kabupaten" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                            @foreach ($kabupatens as $kabupaten)
                                <option value="{{ $kabupaten->id }}" 
                                    @if ($user->wilayah->id == $kabupaten->id || 
                                         ($user->wilayah->level == 'kecamatan' && $user->wilayah->parent->id == $kabupaten->id))
                                    selected
                                    @endif
                                >
                                    {{ $kabupaten->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                        @error('kabupaten_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            
                @if ($user->wilayah->level == 'kecamatan')
                    <!-- Jika user level kecamatan, tampilkan Kecamatan -->
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select class="form-select" name="kecamatan_id" id="kecamatan" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" 
                                    @if ($user->wilayah->id == $kecamatan->id)
                                        selected
                                    @endif
                                >
                                    {{ $kecamatan->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            @endif
            
            

                <div class="mb-3">
                    <label for="tanggal_penyaluran" class="form-label">Tanggal Penyaluran</label>
                    <input type="date" name="tanggal_penyaluran" id="tanggal_penyaluran" class="form-control" required>
                    @error('tanggal_penyaluran')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bukti_penyaluran" class="form-label">Bukti Penyaluran (JPG/PNG/PDF)</label>
                    <input type="file" name="bukti_penyaluran" id="bukti_penyaluran" class="form-control" required>
                    @error('bukti_penyaluran')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan Tambahan</label>
                    <textarea name="catatan" id="catatan" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
            </form>
        </div>
    </div>
</div>


@endsection
