<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'quota' => 'required',
            'date' => 'required',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('events.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}