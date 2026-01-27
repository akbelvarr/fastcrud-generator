<h1>Edit Galon</h1>

<form action="{{ route('galons.update', $galon->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' value='{{ $galon->name }}' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Capacity</label><br><input type='text' name='capacity' value='{{ $galon->capacity }}' required style='width:100%;'></div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('galons.index') }}">Kembali</a>
</form>