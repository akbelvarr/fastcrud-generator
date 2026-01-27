<h1>Tambah Task</h1>

<form action="{{ route('tasks.store') }}" method="POST">
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
        <label class='form-label'>Deadline</label>
        <input type='date' name='deadline' class='form-control' required>
    </div>
    <br>
    <button type="submit">Simpan Data</button>
    <a href="{{ route('tasks.index') }}">Kembali</a>
</form>