<h1>Edit Employee</h1>

<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div style='margin-bottom:10px;'><label>Name</label><br><input type='text' name='name' value='{{ $employee->name }}' required style='width:100%;'></div>
<div style='margin-bottom:10px;'><label>Age</label><br><input type='text' name='age' value='{{ $employee->age }}' required style='width:100%;'></div>
    <br>
    <button type="submit">Update Data</button>
    <a href="{{ route('employees.index') }}">Kembali</a>
</form>