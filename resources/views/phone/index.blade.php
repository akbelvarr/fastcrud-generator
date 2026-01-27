<h1>Daftar Phone</h1>

<a href="{{ route('phones.create') }}" style="margin-bottom: 10px; display: inline-block;">
    + Tambah Phone Baru
</a>

<table border="1" style="width: 100%; border-collapse: collapse;">
    </table>

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Stock</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($phones as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->stock }}</td>
            <td>
                <a href="#">Edit</a> | <button>Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>