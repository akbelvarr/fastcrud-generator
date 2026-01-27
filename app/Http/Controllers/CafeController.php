<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cafe::query();

        // Logika Pencarian: Mencari di kolom pertama (biasanya Nama/Judul)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination: Menampilkan 10 data per halaman
        $cafes = $query->latest()->paginate(10);

        return view('cafes.index', compact('cafes'));
    }

    public function create()
    {
        return view('cafes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'lebar' => 'required',
            'start_operation' => 'required',
        ]);

        Cafe::create($request->all());

        return redirect()->route('cafes.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $cafe = Cafe::findOrFail($id);
        return view('cafes.edit', compact('cafe'));
    }

    public function update(Request $request, $id)
    {
        $cafe = Cafe::findOrFail($id);
        $cafe->update($request->all());

        return redirect()->route('cafes.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $cafe = Cafe::findOrFail($id);
        $cafe->delete();

        return redirect()->route('cafes.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}