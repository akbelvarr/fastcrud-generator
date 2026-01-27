<h1>Edit Member</h1>

<form action="{{ route('members.update', $member->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class='mb-3'>
        <label class='form-label'>Name</label>
        <input type='text' name='name' value='{{ $member->name }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Age</label>
        <input type='number' name='age' value='{{ $member->age }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Date</label>
        <input type='date' name='date' value='{{ $member->date }}' class='form-control' required>
    </div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('members.index') }}">Kembali</a>
</form>