<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Daftar Event</h2>
        <a href="{{ route('events.create') }}" class="btn btn-primary shadow-sm">+ Tambah Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
            <th>Description</th>
            <th>Quota</th>
            <th>Date</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->quota }}</td>
            <td>{{ $item->date }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('events.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('events.destroy', $item->id) }}" method="POST" style="display:inline;">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // Konfirmasi Hapus yang Keren
    function confirmDelete(event, formId) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>