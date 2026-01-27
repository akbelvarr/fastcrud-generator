<h1>Daftar Galon</h1>

<a href="{{ route('galons.create') }}">+ Tambah Galon Baru</a>

<table border="1" style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Capacity</th> <th>Aksi</th>      </tr>
    </thead>
    <tbody>
        @foreach($galons as $item)
        <tr>
            <td>{{ $item->id }}</td> <td>{{ $item->name }}</td>
            <td>{{ $item->capacity }}</td>    <td>             <a href="{{ route('galons.edit', $item->id) }}">Edit</a> | 
                <form action="{{ route('galons.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>