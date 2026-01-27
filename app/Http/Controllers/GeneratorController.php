<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GeneratorController extends Controller
{
    // Menampilkan halaman form generator
    public function index()
    {
        return view('generator.index');
    }

    // Memproses input dari form
    public function generate(Request $request)
{
    $request->validate([
        'model_name' => 'required|alpha',
        'field_names' => 'required|array',
        'field_types' => 'required|array'
    ]);

    // Menggabungkan array name dan type menjadi format "name:type,price:integer"
    $fieldsArray = [];
    foreach ($request->field_names as $index => $name) {
        $type = $request->field_types[$index];
        $fieldsArray[] = "$name:$type";
    }
    $fieldsString = implode(',', $fieldsArray);

    // Panggil command yang sudah kita buat sebelumnya
    Artisan::call('make:mycrud', [
        'name' => $request->model_name,
        '--fields' => $fieldsString
    ]);

    return back()->with('success', "CRUD {$request->model_name} berhasil di-generate secara visual!");
}
}