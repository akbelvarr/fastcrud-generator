@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-primary">Dashboard Overview</h2>
            <p class="text-muted">Selamat datang kembali, Akbel! Berikut adalah ringkasan sistem Anda hari ini.</p>
        </div>
    </div>

    <div class="row">
        @forelse($stats as $stat)
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #0d6efd !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total {{ $stat['label'] }}
                            </div>
                            <div class="h3 mb-0 fw-bold text-dark">{{ $stat['count'] }}</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi {{ $stat['icon'] }} text-primary h4 mb-0"></i>
                        </div>
                    </div>

                    {{-- PERBAIKAN: Cek apakah link tersedia sebelum membuat route --}}
                    @if($stat['link'])
                        <a href="{{ route($stat['link']) }}" class="btn btn-link btn-sm p-0 mt-3 text-decoration-none">
                            Lihat Detail <i class="bi bi-arrow-right shadow-sm"></i>
                        </a>

                        <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-2">
                        <a href="{{ route($stat['link']) }}" class="btn btn-link btn-sm p-0 text-decoration-none text-primary">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ url('/export-zip/'.$stat['label']) }}" class="btn btn-outline-success btn-sm py-0 px-2" style="font-size: 0.7rem;">
                            <i class="bi bi-file-earmark-zip"></i> ZIP
                        </a>
                    </div>

                    @else
                        <div class="mt-3">
                            <span class="badge bg-secondary opacity-50 fw-light">Route Belum Terdaftar</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm p-5">
                <i class="bi bi-folder2-open h1 text-muted"></i>
                <p class="mt-3">Belum ada modul yang ter-generate.</p>
                <a href="/generator" class="btn btn-primary mx-auto">Mulai Generate Sekarang</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection