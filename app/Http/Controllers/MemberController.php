<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'date' => 'required',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')
                        ->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('members.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}