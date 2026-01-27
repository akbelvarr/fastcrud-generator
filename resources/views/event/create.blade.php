<h1>Tambah Event</h1>

<form action="{{ route('events.store') }}" method="POST">
    @csrf
    <div class='mb-3'>
        <label class='form-label'>Title</label>
        <input type='text' name='title' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Description</label>
        <textarea name='description' class='form-control' rows='3' required></textarea>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Quota</label>
        <input type='number' name='quota' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Date</label>
        <input type='date' name='date' class='form-control' required>
    </div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('events.index') }}">Kembali</a>
</form>