<h1>Edit Event</h1>

<form action="{{ route('events.update', $event->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class='mb-3'>
        <label class='form-label'>Title</label>
        <input type='text' name='title' value='{{ $event->title }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Description</label>
        <textarea name='description' class='form-control' rows='3' required>{{ $event->description }}</textarea>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Quota</label>
        <input type='number' name='quota' value='{{ $event->quota }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Date</label>
        <input type='date' name='date' value='{{ $event->date }}' class='form-control' required>
    </div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('events.index') }}">Kembali</a>
</form>