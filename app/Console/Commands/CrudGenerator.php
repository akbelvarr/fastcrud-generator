<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CrudGenerator extends Command
{
    // Nama perintah yang akan diketik di terminal
    protected $signature = 'make:mycrud {name} {--fields=}';

    protected $description = 'Generate CRUD files from custom stubs';

    public function handle()
    {
        $name = $this->argument('name'); // Mengambil input nama (misal: Product)'
        $fields = $this->option('fields'); 

        $fieldArray = explode(',', $fields);

        // 1. Jalankan fungsi generate Controller
        $this->generateController($name, $fieldArray);
        $this->generateModel($name);
        $this->generateRoute($name);

        $this->generateViews($name, $fields);
        $this->generateMigration($name, $fields);

            // 2. --- DI SINI TEMPAT LOGIKA OTOMASI SIDEBAR ---
        // Gunakan Str::plural untuk nama menu yang jamak (misal: Member -> Members)
        $menuName = $name;
        $menuRoute = strtolower(Str::plural($name));
        $sidebarPath = resource_path('views/layouts/master.blade.php');

        // Cek apakah file layout master ada
        if (File::exists($sidebarPath)) {
            // Kode HTML menu yang akan disisipkan (menggunakan Bootstrap Icons)
            $newMenuHtml = '<a href="/' . $menuRoute . '"><i class="bi bi-folder me-2"></i> ' . $menuName . '</a>';

            $currentSidebar = File::get($sidebarPath);

        // Cek agar tidak terjadi duplikasi menu jika Anda generate ulang model yang sama
        if (!str_contains($currentSidebar, $newMenuHtml)) {
            // Kita cari komentar penanda di master.blade.php lalu sisipkan menu di atasnya
            $updatedSidebar = str_replace(
                '',
                $newMenuHtml . "\n            " . '',
                $currentSidebar
            );

            File::put($sidebarPath, $updatedSidebar);
            $this->info("Sidebar: Menu $menuName otomatis ditambahkan.");
        }
    }

    $this->info("CRUD $name berhasil di-generate secara utuh ke dalam sistem!");
}


    protected function generateRoute($name)
{
    $variableName = Str::kebab(Str::plural($name)); // Contoh: Product -> products
    $controllerName = "{$name}Controller";
    
    // Baris kode yang akan ditambahkan ke web.php
    $routeLine = "\nRoute::resource('$variableName', App\Http\Controllers\\$controllerName::class);";

    // Path ke file routes/web.php
    $routePath = base_path('routes/web.php');

    // Menambahkan baris ke akhir file
    File::append($routePath, $routeLine);

    $this->info("Route: Added Route::resource for $variableName to web.php.");
}


    protected function generateModel($name)
{
    $template = str_replace(
        ['{{modelName}}'],
        [$name],
        File::get(base_path('stubs/Model.stub'))
    );

    File::put(app_path("Models/{$name}.php"), $template);
    $this->info("Model: app/Models/{$name}.php created.");
}



protected function generateMigration($name, $fields)
{
    $tableName = Str::plural(strtolower(Str::snake($name)));
    $fileName = date('Y_m_d_His') . "_create_{$tableName}_table.php";
    
    // Mengubah "name:string,price:integer" menjadi kode Laravel Migration
    $fieldArray = explode(',', $fields);
    $migrationFields = "";
    foreach ($fieldArray as $field) {
        $parts = explode(':', $field);
        $fieldName = $parts[0];
        $fieldType = $parts[1] ?? 'string';
        $migrationFields .= "\$table->$fieldType('$fieldName');\n            ";
    }

    $template = str_replace(
        ['{{tableName}}', '// {{fieldPenanda}}'],
        [$tableName, $migrationFields],
        File::get(base_path('stubs/migration.stub'))
    );

    File::put(database_path("migrations/{$fileName}"), $template);
}



    protected function generateViews($name, $fields)
{
    // 1. Konsistensi Penamaan: Gunakan Plural (Jamak) agar cocok dengan Controller
    $folderName = strtolower(Str::plural($name)); 
    $viewPath = resource_path("views/{$folderName}");

    if (!File::exists($viewPath)) {
        File::makeDirectory($viewPath, 0755, true);
    }

    $fieldArray = explode(',', $fields);
    $headers = ""; $body = ""; $formsCreate = ""; $formsEdit = "";

    foreach ($fieldArray as $field) {
        $parts = explode(':', $field);
        $fieldName = $parts[0];
        $fieldType = $parts[1] ?? 'string';

        // Logika Smart UI Anda tetap dipertahankan
        switch ($fieldType) {
            case 'integer':
            case 'bigInteger':
                $inputHtml = "<input type='number' name='$fieldName' class='form-control' required>";
                $editValue = "value='{{ $".strtolower($name)."->$fieldName }}'";
                $inputHtmlEdit = "<input type='number' name='$fieldName' $editValue class='form-control' required>";
                break;
            case 'text':
                $inputHtml = "<textarea name='$fieldName' class='form-control' rows='3' required></textarea>";
                $inputHtmlEdit = "<textarea name='$fieldName' class='form-control' rows='3' required>{{ $".strtolower($name)."->$fieldName }}</textarea>";
                break;
            case 'date':
                $inputHtml = "<input type='date' name='$fieldName' class='form-control' required>";
                $editValue = "value='{{ $".strtolower($name)."->$fieldName }}'";
                $inputHtmlEdit = "<input type='date' name='$fieldName' $editValue class='form-control' required>";
                break;
            default:
                $inputHtml = "<input type='text' name='$fieldName' class='form-control' required>";
                $editValue = "value='{{ $".strtolower($name)."->$fieldName }}'";
                $inputHtmlEdit = "<input type='text' name='$fieldName' $editValue class='form-control' required>";
                break;
        }

        $headers .= "<th>" . ucfirst($fieldName) . "</th>\n            ";
        $body .= "<td>{{ \$item->$fieldName }}</td>\n            ";

        $formsCreate .= "<div class='mb-3'>\n        <label class='form-label'>" . ucfirst($fieldName) . "</label>\n        $inputHtml\n    </div>\n    ";
        $formsEdit .= "<div class='mb-3'>\n        <label class='form-label'>" . ucfirst($fieldName) . "</label>\n        $inputHtmlEdit\n    </div>\n    ";
    }

    // 2. Gunakan $folderName yang sudah jamak untuk semua file view
    // Generate INDEX.BLADE.PHP
    $indexTemplate = str_replace(
        ['{{modelName}}', '{{modelNamePlural}}', '{{tableHeaders}}', '{{tableBody}}'],
        [$name, $folderName, trim($headers), trim($body)],
        File::get(base_path('stubs/views/index.stub'))
    );
    File::put($viewPath . "/index.blade.php", $indexTemplate);

    // Generate CREATE.BLADE.PHP
    $createTemplate = str_replace(
        ['{{modelName}}', '{{modelNamePlural}}', '{{formFields}}'],
        [$name, $folderName, trim($formsCreate)],
        File::get(base_path('stubs/views/create.stub'))
    );
    File::put($viewPath . "/create.blade.php", $createTemplate);

    // Generate EDIT.BLADE.PHP
    $editTemplate = str_replace(
        ['{{modelName}}', '{{modelNamePlural}}', '{{modelNameSingular}}', '{{formFieldsEdit}}'],
        [$name, $folderName, strtolower($name), trim($formsEdit)],
        File::get(base_path('stubs/views/edit.stub'))
    );
    File::put($viewPath . "/edit.blade.php", $editTemplate);

    $this->info("Views untuk $name berhasil dibuat di folder: $folderName");
}


    protected function generateController($name, $fieldArray)
{
    // 1. Logika Validasi (Menyiapkan aturan required untuk semua field)
    $validationRules = "";
    foreach ($fieldArray as $field) {
        $fieldName = explode(':', $field)[0];
        $validationRules .= "'$fieldName' => 'required',\n            ";
    }

    // 2. Logika Search (BARU: Ambil kolom pertama sebagai target pencarian default)
    // Misalnya jika input: name:string, age:integer. Maka 'name' jadi searchableField.
    $searchableField = explode(':', $fieldArray[0])[0]; 

    $template = File::get(base_path('stubs/Controller.stub'));

    // 3. Proses Injeksi Placeholder ke Stub
    $newContent = str_replace(
        [
            '{{modelName}}', 
            '{{modelNamePlural}}', 
            '{{modelNameSingular}}', 
            '{{modelPath}}', 
            '{{validationRules}}',
            '{{searchableField}}' // Placeholder baru untuk logika pencarian
        ],
        [
            $name, 
            strtolower(Str::plural($name)), 
            strtolower($name), 
            strtolower(Str::plural($name)), 
            trim($validationRules),
            $searchableField // Nilai kolom pencarian
        ],
        $template
    );

    // 4. Penyimpanan File Controller
    $filePath = app_path("Http/Controllers/{$name}Controller.php");
    File::put($filePath, $newContent);
    $this->info("Controller: {$name}Controller.php created with Search & Validation logic.");
}
}