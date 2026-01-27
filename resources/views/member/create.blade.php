<h1>Tambah Member</h1>

<form action="{{ route('members.store') }}" method="POST">
    @csrf
    <div class='mb-3'>
        <label class='form-label'>Name</label>
        <input type='text' name='name' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Age</label>
        <input type='number' name='age' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Date</label>
        <input type='date' name='date' class='form-control' required>
    </div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('members.index') }}">Kembali</a>
</form>