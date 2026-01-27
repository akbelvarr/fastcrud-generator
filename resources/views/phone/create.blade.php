<h1>Tambah Phone</h1>

<form action="{{ route('phones.store') }}" method="POST">
    @csrf
    <div style='margin-bottom: 10px;'>
    <label>Name</label><br>
    <input type='text' name='name' required style='width: 100%;'>
</div>
        <div style='margin-bottom: 10px;'>
    <label>Stock</label><br>
    <input type='text' name='stock' required style='width: 100%;'>
</div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('phones.index') }}">Kembali</a>
</form>