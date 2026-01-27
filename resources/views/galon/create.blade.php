<h1>Tambah Galon</h1>

<form action="{{ route('galons.store') }}" method="POST">
    @csrf
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Capacity</label><br><input type='text' name='capacity' required style='width:100%;'></div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('galons.index') }}">Kembali</a>
</form>