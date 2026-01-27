<h1>Daftar Employee</h1>

<a href="{{ route('employees.create') }}" style="margin-bottom: 10px; display: inline-block;">+ Tambah Employee Baru</a>


<table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $item)
        <tr>
            <td>
                <a href="{{ route('employees.edit', $item->id) }}">Edit</a> | 
                <form action="{{ route('employees.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>