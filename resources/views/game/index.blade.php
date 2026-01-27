<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm">
        {{ session('success') }}
    </div>
@endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Daftar Game</h2>
        <a href="{{ route('games.create') }}" class="btn btn-primary shadow-sm">+ Tambah Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
            <th>Size</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
            <td>{{ $item->size }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('games.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('games.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
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