<h1>Tambah Game</h1>

<form action="{{ route('games.store') }}" method="POST">
    @csrf
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Size</label><br><input type='text' name='size' required style='width:100%;'></div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('games.index') }}">Kembali</a>
</form>