<h1>Edit Task</h1>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class='mb-3'>
        <label class='form-label'>Title</label>
        <input type='text' name='title' value='{{ $task->title }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Description</label>
        <textarea name='description' class='form-control' rows='3' required>{{ $task->description }}</textarea>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Deadline</label>
        <input type='date' name='deadline' value='{{ $task->deadline }}' class='form-control' required>
    </div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('tasks.index') }}">Kembali</a>
</form>