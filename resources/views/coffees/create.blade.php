@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary">Tambah Coffee Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('coffees.store') }}" method="POST">
                    @csrf
                    <div class='mb-3'>
        <label class='form-label'>Name</label>
        <input type='text' name='name' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Price</label>
        <input type='number' name='price' class='form-control' required>
    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('coffees.index') }}" class="btn btn-light text-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection