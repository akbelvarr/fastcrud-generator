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

    public function generate(Request $request)
    {
        $request->validate([
            'model_name' => 'required|alpha',
            'field_names' => 'required|array',
            'field_types' => 'required|array'
        ]);

        $fieldsArray = [];
        foreach ($request->field_names as $index => $name) {
            $type = $request->field_types[$index];
            $fieldsArray[] = "$name:$type";
        }

        $options = [];
        if ($request->has('timestamps')) {
            $options['timestamps'] = true;
        }

        if ($request->has('softdeletes')) {
            $options['softdeletes'] = true;
        }

        // Generate files in temporary location and zip them
        $zipService = new \App\Services\ZipGeneratorService();
        $fileName = $zipService->generateZip($request->model_name, $fieldsArray, $options);

        // Return a success view
        $modelName = ucfirst(\Illuminate\Support\Str::studly($request->model_name));
        return view('generator.output', compact('fileName', 'modelName'))->with('success', "CRUD {$modelName} berhasil di-generate!");
    }

    public function download($fileName)
    {
        $filePath = storage_path('app/temp_cruds/' . $fileName);
        
        if (!file_exists($filePath)) {
            abort(404, 'File ZIP tidak ditemukan atau sudah kadaluarsa.');
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}