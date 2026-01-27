<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [];
        // 1. Ambil semua file di folder app/Models
        $modelFiles = File::files(app_path('Models'));

        foreach ($modelFiles as $file) {
            $modelName = $file->getFilenameWithoutExtension();
            
            // Abaikan file bawaan Laravel jika ada
            if ($modelName == 'User') continue;

            // 2. Gunakan refleksi untuk menghitung jumlah data secara dinamis
            $className = "App\\Models\\" . $modelName;
            $routeName = strtolower(Str::plural($modelName)) . ".index";    
            if (class_exists($className)) {
                $stats[] = [
                    'label' => Str::plural($modelName),
                    'count' => $className::count(),
                    'link'  => Route::has($routeName) ? $routeName : null,
                    'icon'  => 'bi-database-fill'
                ];
            }
        }

        return view('home', compact('stats'));
    }
}
