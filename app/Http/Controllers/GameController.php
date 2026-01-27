<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::all();
        return view('game.index', compact('games'));
    }

    public function create()
    {
        return view('game.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'size' => 'required',
        ]);

        Game::create($request->all());

        return redirect()->route('games.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        return view('game.edit', compact('game'));
    }

    public function update(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->update($request->all());

        return redirect()->route('games.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('games.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}