@extends('layouts.master')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Manajemen Bakery</h5>
        <a href="{{ route('bakeries.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Bakery
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('bakeries.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari data..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary btn-sm">Cari</button>
                @if(request('search'))
                    <a href="{{ route('bakeries.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                @endif
            </form>
        </div>
    </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th width="50">No</th>
                        <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Exp_date</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bakeries as $item)
                    <tr>
                        <td class="fw-bold">{{$loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->exp_date }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('bakeries.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('bakeries.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(event, 'delete-form-{{ $item->id }}')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-center">
        {{ $bakeries->appends(request()->query())->links() }}
    </div>

        </div>
    </div>
</div>
@endsection @push('scripts')
<script>
    // Notifikasi Sukses Otomatis
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // Konfirmasi Hapus
    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush