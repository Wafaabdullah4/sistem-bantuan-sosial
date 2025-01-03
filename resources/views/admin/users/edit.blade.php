{{-- Gunakan layout yang sesuai --}}
@extends('../../layouts.app')

@section('content')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit User</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="wilayah_id">Wilayah</label>
                            <select id="wilayah_id" name="wilayah_id" class="form-control">
                                <option value="">Pilih Wilayah</option>
                                @foreach($wilayahs as $wilayah)
                                    <option value="{{ $wilayah->id }}" {{ $user->wilayah_id == $wilayah->id ? 'selected' : '' }}>
                                        {{ $wilayah->nama_wilayah }} ({{ ucfirst($wilayah->level) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('wilayah_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>

@endsection
