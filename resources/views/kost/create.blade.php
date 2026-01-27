@extends('layouts.master')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="m-0 font-weight-bold text-primary">Tambah Kost Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('kosts.store') }}" method="POST">
                    @csrf
                    <div class='mb-3'>
        <label class='form-label'>Name</label>
        <input type='text' name='name' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Room</label>
        <input type='number' name='room' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Masuk</label>
        <input type='date' name='masuk' class='form-control' required>
    </div>
    <div class='mb-3'>
        <label class='form-label'>Keluar</label>
        <input type='date' name='keluar' class='form-control' required>
    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kosts.index') }}" class="btn btn-light text-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection