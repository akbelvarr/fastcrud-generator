<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use Illuminate\Http\Request;

class BakeryController extends Controller
{
    public function index(Request $request)
    {
        $query = Bakery::query();

        // Logika Pencarian: Mencari di kolom pertama (biasanya Nama/Judul)
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination: Menampilkan 10 data per halaman
        $bakeries = $query->latest()->paginate(10);

        return view('bakeries.index', compact('bakeries'));
    }

    public function create()
    {
        return view('bakeries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'exp_date' => 'required',
        ]);

        Bakery::create($request->all());

        return redirect()->route('bakeries.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $bakery = Bakery::findOrFail($id);
        return view('bakeries.edit', compact('bakery'));
    }

    public function update(Request $request, $id)
    {
        $bakery = Bakery::findOrFail($id);
        $bakery->update($request->all());

        return redirect()->route('bakeries.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $bakery = Bakery::findOrFail($id);
        $bakery->delete();

        return redirect()->route('bakeries.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}