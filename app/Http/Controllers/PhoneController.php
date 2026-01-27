<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function index()
    {
        $phones = Phone::all();
        return view('phone.index', compact('phones'));
    }

    public function create()
    {
        return view('phone.create');
    }

    public function store(Request $request)
    {
        // Validasi sederhana, Anda bisa mengembangkannya nanti
        Phone::create($request->all());

        return redirect()->route('phones.index')
                         ->with('success', 'Data Phone berhasil ditambahkan!');
    }
}