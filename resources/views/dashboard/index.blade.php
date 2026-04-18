@extends('layouts.dashboard')

@section('content')
<header class="mb-4">
    <h2 class="fw-bold text-dark">Ringkasan Koperasi</h2>
    <p class="text-muted">Statistik Koperasi Merah Putih hari ini.</p>
</header>

<div class="row g-4">

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 border-start border-danger border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Total Cicilan</h6>
                <h3 class="fw-bold text-dark mb-0">Rp0</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Pinjaman Aktif</h6>
                <h3 class="fw-bold text-dark mb-0">0 Anggota</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 border-start border-warning border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Total Penarikan</h6>
                <h3 class="fw-bold text-dark mb-0">Rp0</h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0 border-start border-success border-4">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small fw-bold">Modal Koperasi</h6>
                <h3 class="fw-bold text-dark mb-0">Rp0</h3>
            </div>
        </div>
    </div>

</div>
@endsection