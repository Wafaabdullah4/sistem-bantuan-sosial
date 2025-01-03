@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="text-primary text-center fw-bold">Selamat Datang di Sistem Monitoring dan Evaluasi</h1>
                    <p class="text-center text-muted fs-5">
                        Sistem ini dirancang untuk mendukung Kementerian Sosial dalam memastikan penyaluran bantuan sosial yang lebih 
                        transparan, akurat, dan efisien. Kami berkomitmen untuk meningkatkan layanan masyarakat melalui pengelolaan data 
                        yang lebih baik dan komunikasi yang terintegrasi antara pemerintah pusat dan daerah.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Transparansi Data</h5>
                    <p class="text-muted">Pantau progres penyaluran bantuan dengan data yang terintegrasi dan real-time.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Kolaborasi Pemerintah</h5>
                    <p class="text-muted">Mempermudah koordinasi antara pemerintah pusat dan daerah untuk layanan yang lebih baik.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fa fa-envelope fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Respon Cepat</h5>
                    <p class="text-muted">Tangani keluhan masyarakat secara efisien melalui sistem pelaporan yang terintegrasi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer pt-5 mt-5">
        <div class="container-fluid text-center">
            <p class="text-muted mb-0">© <script>document.write(new Date().getFullYear())</script>, Sistem Monitoring dan Evaluasi Kementerian Sosial</p>
            <p class="text-muted">Dibangun untuk mendukung program bantuan sosial di seluruh Indonesia.</p>
        </div>
    </footer>
</div>
@endsection
