@extends('layouts.dashboard')

@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi MP - Dashboard Simpanan</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --primary: #e63946;
        --primary-dark: #d62839;
        --bg: #f8fafc;
        --sidebar-width: 280px;
    }

    body {
        background: var(--bg);
        font-family: 'Inter', sans-serif;
        color: #1e293b;
    }

    /* Sidebar Styling */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        background: #fff;
        border-right: 1px solid #e2e8f0;
        padding: 1.5rem;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.02);
        z-index: 1000;
    }

    .sidebar-brand {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 2rem;
        padding-left: 10px;
    }

    /* Profile Section Otomatis */
    .profile-card {
        text-align: center;
        padding: 1.5rem 1rem;
        background: #fff;
        border-radius: 20px;
        margin-bottom: 2rem;
        border: 1px solid #f1f5f9;
    }

    .profile-img {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
        margin-bottom: 12px;
    }

    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #64748b;
        text-decoration: none;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: 0.3s;
        font-weight: 500;
    }

    .nav-link-custom:hover,
    .nav-link-custom.active {
        background: #fff1f2;
        color: var(--primary);
    }

    /* Main Content */
    .content {
        margin-left: var(--sidebar-width);
        padding: 2.5rem;
    }

    .card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
    }

    .simpanan-card {
        border-left: 6px solid var(--primary);
    }

    .simpanan-pokok {
        border-left-color: #e63946;
    }

    .simpanan-wajib {
        border-left-color: #10b981;
    }

    .simpanan-sementara {
        border-left-color: #3b82f6;
    }

    .btn-add {
        background: var(--primary);
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        color: white;
    }

    .btn-add:hover {
        background: var(--primary-dark);
        color: white;
    }
    </style>
</head>

<body>

    <div class="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="bi bi-building-fill"></i> KOPERASI MP
        </a>

        <div class="profile-card">
            @if(Auth::check())
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e63946&color=fff"
                class="profile-img" alt="User">
            <h6 class="mb-0 fw-bold">{{ Auth::user()->name }}</h6>
            <small class="text-muted">{{ Auth::user()->email }}</small>
            @else
            <img src="https://ui-avatars.com/api/?name=Guest&background=64748b&color=fff" class="profile-img"
                alt="Guest">
            <h6 class="mb-0 fw-bold">Guest User</h6>
            <small class="text-muted">Please login</small>
            @endif
        </div>

        <nav>
            <a href="#" class="nav-link-custom active">
                <i class="bi bi-house-door me-3"></i> Beranda
            </a>
            <hr class="text-muted opacity-25">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link-custom text-danger border-0 bg-transparent w-100">
                    <i class="bi bi-box-arrow-right me-3"></i> Keluar
                </button>
            </form>
        </nav>
    </div>

    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">Dashboard Simpanan</h2>
                <p class="text-muted">Total akumulasi dana simpanan Anda.</p>
            </div>
            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Simpanan
            </button>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card p-4 simpanan-card simpanan-pokok">
                    <h6>Simpanan Pokok</h6>
                    <h4>Rp {{ number_format($data->sum('simpanan_pokok'), 0, ',', '.') }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 simpanan-card simpanan-wajib">
                    <h6>Simpanan Wajib</h6>
                    <h4>Rp {{ number_format($data->sum('simpanan_wajib'), 0, ',', '.') }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 simpanan-card simpanan-sementara">
                    <h6>Simpanan Sementara</h6>
                    <h4>Rp {{ number_format($data->sum('simpanan_sementara'), 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Pokok</th>
                            <th>Wajib</th>
                            <th>Sementara</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-bold text-danger">Rp {{ number_format($item->simpanan_pokok,0,',','.') }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($item->simpanan_wajib,0,',','.') }}
                            </td>
                            <td class="fw-bold text-primary">Rp {{ number_format($item->simpanan_sementara,0,',','.') }}
                            </td>
                            <td>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ url('/dashboard/modal/'.$item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0">
                                    <form action="{{ url('/dashboard/modal/'.$item->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="fw-bold">Update Simpanan</h5>
                                        </div>
                                        <div class="modal-body">
                                            <input type="number" name="simpanan_pokok" class="form-control mb-3"
                                                value="{{ $item->simpanan_pokok }}" placeholder="Pokok">
                                            <input type="number" name="simpanan_wajib" class="form-control mb-3"
                                                value="{{ $item->simpanan_wajib }}" placeholder="Wajib">
                                            <input type="number" name="simpanan_sementara" class="form-control"
                                                value="{{ $item->simpanan_sementara }}" placeholder="Sementara">
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Data Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <form action="{{ url('/dashboard/modal') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="fw-bold">Tambah Data Baru</h5>
                    </div>
                    <div class="modal-body">
                        <input type="number" name="simpanan_pokok" class="form-control mb-3"
                            placeholder="Masukkan Simpanan Pokok" required>
                        <input type="number" name="simpanan_wajib" class="form-control mb-3"
                            placeholder="Masukkan Simpanan Wajib" required>
                        <input type="number" name="simpanan_sementara" class="form-control"
                            placeholder="Masukkan Simpanan Sementara" required>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-danger px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection