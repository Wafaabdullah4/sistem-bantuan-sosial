@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('admin.wilayah.create') }}" class="btn btn-primary mb-3">Tambah Wilayah</a>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">

                <div class="card-header pb-0">
                    <h6>Manage Wilayah</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Wilayah</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Induk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Level</th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wilayahs as $wilayah)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $wilayah->nama_wilayah }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $wilayah->parent->nama_wilayah ?? '-' }}</td>
                                        <td>{{ ucfirst($wilayah->level) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="{{ route('admin.wilayah.edit', $wilayah->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.wilayah.destroy', $wilayah->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                                </form>
                                            </div>
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
