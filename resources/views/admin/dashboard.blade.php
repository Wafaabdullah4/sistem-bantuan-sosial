@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Total Laporan Masuk -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Laporan Masuk</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalLaporan }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-folder-17 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penerima Bantuan -->
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Penerima Bantuan</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalPenerima }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Provinsi -->
        <div class="col-md-2 col-sm-6 mb-4">
            <div class="card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#provinsiModal">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Provinsi</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalProvinsi }} Provinsi
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-map-big text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kabupaten -->
        <div class="col-md-2 col-sm-6 mb-4">
            <div class="card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#kabupatenModal">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Kabupaten</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalKabupaten }} Kabupaten
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-building text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kecamatan -->
        <div class="col-md-2 col-sm-6 mb-4">
            <div class="card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#kecamatanModal">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Kecamatan</p>
                                <h5 class="font-weight-bolder">
                                    {{ $totalKecamatan }} Kecamatan
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                <i class="ni ni-square-pin text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Provinsi -->
    <div class="modal fade" id="provinsiModal" tabindex="-1" aria-labelledby="provinsiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="provinsiModalLabel">Informasi Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($provinsiList as $prov)
                            <li>{{ $prov->nama_wilayah }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kabupaten -->
    <div class="modal fade" id="kabupatenModal" tabindex="-1" aria-labelledby="kabupatenModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kabupatenModalLabel">Informasi Kabupaten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($kabupatenList as $kab)
                            <li>{{ $kab->nama_wilayah }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Kecamatan -->
    <div class="modal fade" id="kecamatanModal" tabindex="-1" aria-labelledby="kecamatanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kecamatanModalLabel">Informasi Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($kecamatanList as $kec)
                            <li>{{ $kec->nama_wilayah }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>




    <div class="row mt-4">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header  text-white text-center py-4">
                    <h6 class="mb-0 text-uppercase">Total Penerima per Provinsi</h6>
                </div>
                <div class="card-body  p-4">
                    <div class="chart-container" style="position: relative; height:50vh; width:100%">
                        <canvas id="chart-bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("chart-bar").getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(75, 192, 192, 0.4)');
            gradient.addColorStop(1, 'rgba(75, 192, 192, 0.1)');

            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($provinsiLabels) !!},
                    datasets: [{
                        label: 'Jumlah Penerima',
                        data: {!! json_encode($provinsiValues) !!},
                        backgroundColor: gradient,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(75, 192, 192, 0.6)',
                        hoverBorderColor: 'rgba(75, 192, 192, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#333',
                                font: {
                                    size: 14,
                                    family: "'Roboto', sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleFont: {
                                size: 16
                            },
                            bodyFont: {
                                size: 14
                            },
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 12,
                                    family: "'Roboto', sans-serif"
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 12,
                                    family: "'Roboto', sans-serif"
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Top 5 Penerimaan Terbanyak (Kabupaten)</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>Kabupaten</th>
                                <th class="text-center">Jumlah Penerima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kabupatenData as $kabupaten)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div>
                                            </div>
                                            <div class="ms-4">
                                                <h6 class="text-sm mb-0">{{ $kabupaten['nama_wilayah'] }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-sm mb-0">{{ number_format($kabupaten['total_penerima']) }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Top 5 Penerimaan Terbanyak (Kecamatan)</h6>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        @foreach ($kecamatanData as $kecamatan)
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-map-pin text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">{{ $kecamatan['nama_wilayah'] }}</h6>
                                        <span class="text-xs">Total Penerima: <span
                                                class="font-weight-bold">{{ $kecamatan['total_penerima'] }}</span></span>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button
                                        class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                        <i class="ni ni-bold-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <footer class="footer pt-3  ">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative
                                Tim</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                target="_blank">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                target="_blank">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                target="_blank">License</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
@endsection
