@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary">Edit Cafe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cafes.update', $cafe->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class='mb-3'>
        <label class='form-label'>Name</label>
        <input type='text' name='name' value='{{ $cafe->name }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Description</label>
        <textarea name='description' class='form-control' rows='3' required>{{ $cafe->description }}</textarea>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Lebar</label>
        <input type='number' name='lebar' value='{{ $cafe->lebar }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Start_operation</label>
        <input type='date' name='start_operation' value='{{ $cafe->start_operation }}' class='form-control' required>
    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cafes.index') }}" class="btn btn-light text-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Update Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection