<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        // Validasi sederhana, Anda bisa mengembangkannya nanti
        Employee::create($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Data Employee berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employees.index')
                         ->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employees.index')
                         ->with('success', 'Data berhasil dihapus!');
    }

}