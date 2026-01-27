<h1>Edit Game</h1>

<form action="{{ route('games.update', $game->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' value='{{ $game->name }}' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Size</label><br><input type='text' name='size' value='{{ $game->size }}' required style='width:100%;'></div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('games.index') }}">Kembali</a>
</form>