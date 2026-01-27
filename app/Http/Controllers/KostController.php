<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function index()
    {
        $kosts = Kost::all();
        return view('kost.index', compact('kosts'));
    }

    public function create()
    {
        return view('kost.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'room' => 'required',
            'masuk' => 'required',
            'keluar' => 'required',
        ]);

        Kost::create($request->all());

        return redirect()->route('kosts.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kost = Kost::findOrFail($id);
        return view('kost.edit', compact('kost'));
    }

    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);
        $kost->update($request->all());

        return redirect()->route('kosts.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->delete();

        return redirect()->route('kosts.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}