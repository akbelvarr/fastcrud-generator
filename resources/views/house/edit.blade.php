@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary">Edit House</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('houses.update', $house->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class='mb-3'>
        <label class='form-label'>Owner</label>
        <input type='text' name='Owner' value='{{ $house->Owner }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Type</label>
        <textarea name='type' class='form-control' rows='3' required>{{ $house->type }}</textarea>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Price</label>
        <input type='number' name='price' value='{{ $house->price }}' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Date_place</label>
        <input type='date' name='date_place' value='{{ $house->date_place }}' class='form-control' required>
    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('houses.index') }}" class="btn btn-light text-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Update Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection