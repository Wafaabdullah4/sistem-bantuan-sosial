@extends('layouts.app')

@section('content')
    <div class="col-md-8 ">
        <div class="card">
            <div class="card-header">
                <h2>Tambah Wilayah</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.wilayah.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama_wilayah">Nama Wilayah</label>
                        <input type="text" id="nama_wilayah" name="nama_wilayah" class="form-control" required>
                        @error('nama_wilayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Induk Wilayah (Opsional)</label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="">-- Tidak Ada Induk --</option>
                            @foreach ($wilayahInduk as $induk)
                                <option value="{{ $induk->id }}">{{ $induk->nama_wilayah }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select id="level" name="level" class="form-control" required>
                            <option value="provinsi">Provinsi</option>
                            <option value="kabupaten">Kabupaten</option>
                            <option value="kecamatan">Kecamatan</option>
                        </select>
                        @error('level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.wilayah.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
