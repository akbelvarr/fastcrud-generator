<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::all();
        return view('house.index', compact('houses'));
    }

    public function create()
    {
        return view('house.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Owner' => 'required',
            'type' => 'required',
            'price' => 'required',
            'date_place' => 'required',
        ]);

        House::create($request->all());

        return redirect()->route('houses.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);
        return view('house.edit', compact('house'));
    }

    public function update(Request $request, $id)
    {
        $house = House::findOrFail($id);
        $house->update($request->all());

        return redirect()->route('houses.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $house = House::findOrFail($id);
        $house->delete();

        return redirect()->route('houses.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}