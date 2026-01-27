<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\Request;

class CoffeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Coffee::query();

        // Logika Pencarian: Mencari di kolom pertama (biasanya Nama/Judul)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination: Menampilkan 10 data per halaman
        $coffees = $query->latest()->paginate(10);

        return view('coffees.index', compact('coffees'));
    }

    public function create()
    {
        return view('coffees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        Coffee::create($request->all());

        return redirect()->route('coffees.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $coffee = Coffee::findOrFail($id);
        return view('coffees.edit', compact('coffee'));
    }

    public function update(Request $request, $id)
    {
        $coffee = Coffee::findOrFail($id);
        $coffee->update($request->all());

        return redirect()->route('coffees.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $coffee = Coffee::findOrFail($id);
        $coffee->delete();

        return redirect()->route('coffees.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}