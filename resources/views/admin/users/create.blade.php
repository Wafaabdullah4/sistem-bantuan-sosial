@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <p class="mb-0">Formulir Pendaftaran Pengguna</p>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <p class="text-uppercase text-sm">User Information</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Password Information</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="form-control-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-control-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Role & Wilayah</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="form-control-label">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="wilayah" class="form-control-label">Wilayah</label>
                            <select name="wilayah_id" id="wilayah" class="form-control">
                                <option value="">Pilih Wilayah</option>
                                @foreach($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}">
                                        {{ $wilayah->nama_wilayah }} ({{ ucfirst($wilayah->level) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('wilayah_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

@endsection
