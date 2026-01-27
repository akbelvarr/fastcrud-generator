<h1>Tambah Employee</h1>

<form action="{{ route('employees.store') }}" method="POST">
    @csrf
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Age</label><br><input type='text' name='age' required style='width:100%;'></div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('employees.index') }}">Kembali</a>
</form>