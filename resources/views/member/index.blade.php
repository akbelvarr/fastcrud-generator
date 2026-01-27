@extends('layouts.master')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Manajemen Member</h5>
        <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Member
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Date</th>
                        <th class="text-center" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->age }}</td>
                        <td>{{ $item->date }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('members.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                    Edit
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('members.destroy', $item->id) }}" method="POST" class="d-inline">
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