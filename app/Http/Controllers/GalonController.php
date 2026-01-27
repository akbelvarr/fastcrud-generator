<?php

namespace App\Http\Controllers;

use App\Models\Galon;
use Illuminate\Http\Request;

class GalonController extends Controller
{
    public function index()
    {
        $galons = Galon::all();
        return view('galon.index', compact('galons'));
    }

    public function create()
    {
        return view('galon.create');
    }

    public function store(Request $request)
    {
        // Validasi sederhana, Anda bisa mengembangkannya nanti
        Galon::create($request->all());

        return redirect()->route('galons.index')
                         ->with('success', 'Data Galon berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galon = Galon::findOrFail($id);
        return view('galon.edit', compact('galon'));
    }

    public function update(Request $request, $id)
    {
        $galon = Galon::findOrFail($id);
        $galon->update($request->all());

        return redirect()->route('galons.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $galon = Galon::findOrFail($id);
        $galon->delete();

        return redirect()->route('galons.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}