<h1>Daftar Laptop</h1>

<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Processor</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laptops as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->brand }}</td>
            <td>{{ $item->processor }}</td>
            <td>{{ $item->harga }}</td>
            <td>
                <a href="#">Edit</a> | <button>Hapus</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>