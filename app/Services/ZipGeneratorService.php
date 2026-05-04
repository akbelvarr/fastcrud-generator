<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class ZipGeneratorService
{
    protected $tempDir;
    protected $zipPath;

    public function generateZip($name, $fieldArray, $options = [])
    {
        $timestamp = now()->format('YmdHis');
        $modelName = Str::studly(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        
        $this->tempDir = storage_path('app/temp_cruds/' . $timestamp . '_' . Str::random(5));
        
        // Buat folder sementara
        File::makeDirectory($this->tempDir, 0755, true);
        File::makeDirectory($this->tempDir . '/app/Models', 0755, true);
        File::makeDirectory($this->tempDir . '/app/Http/Controllers', 0755, true);
        File::makeDirectory($this->tempDir . '/database/migrations', 0755, true);
        
        $folderName = Str::kebab(Str::plural($modelName));
        File::makeDirectory($this->tempDir . '/resources/views/' . $folderName, 0755, true);

        // 1. Generate Controller
        $this->generateController($modelName, $fieldArray);
        
        // 2. Generate Model
        $this->generateModel($modelName, $fieldArray, $options['timestamps'] ?? false, $options['softdeletes'] ?? false);
        
        // 3. Generate Views
        $this->generateViews($modelName, $fieldArray, $options['timestamps'] ?? false);
        $this->generateLayout();
        
        // 4. Generate Migration
        $this->generateMigration($modelName, $fieldArray, $options['timestamps'] ?? false, $options['softdeletes'] ?? false);

        // 5. Buat README
        $this->generateReadme($modelName);

        // 6. Zip Folder
        $singularName = Str::singular($modelName);
        $fileName = $singularName . '_Module_' . time() . '.zip';
        $this->zipPath = storage_path('app/temp_cruds/' . $fileName);

        $this->createZipArchive();

        // 7. Bersihkan folder temporary (Tinggalkan ZIP-nya)
        File::deleteDirectory($this->tempDir);

        return $fileName;
    }

    protected function generateModel($name, $fieldArray, $timestamps = false, $softdeletes = false)
    {
        $fillableFields = [];
        foreach ($fieldArray as $field) {
            $fieldName = explode(':', $field)[0];
            $fillableFields[] = "'$fieldName'";
        }
        $fillableString = implode(', ', $fillableFields);

        $extraTraits = "";
        $extraProps = "";

        if ($softdeletes) {
            $extraTraits .= "use \\Illuminate\\Database\\Eloquent\\SoftDeletes;\n    ";
        }

        if (!$timestamps) {
            $extraProps .= "public \$timestamps = false;\n    ";
        }

        $template = str_replace(
            ['{{modelName}}', '{{fillable}}', '// {{extraTraits}}', '// {{extraProps}}'],
            [$name, $fillableString, $extraTraits, $extraProps],
            File::get(base_path('stubs/Model.stub'))
        );

        File::put($this->tempDir . "/app/Models/{$name}.php", $template);
    }

    protected function generateController($name, $fieldArray)
    {
        $validationRules = "";
        $storeLogic = "\$data = \$request->all();\n";
        $updateLogic = "\$data = \$request->all();\n";
        $modelCamel = Str::camel($name);
        $updateLogic .= "        \$" . $modelCamel . " = " . $name . "::findOrFail(\$id);\n";

        foreach ($fieldArray as $field) {
            $parts = explode(':', $field);
            $fieldName = $parts[0];
            $fieldType = $parts[1] ?? 'string';

            $rules = ['required'];
            switch ($fieldType) {
                case 'integer':
                case 'bigInteger':
                    $rules[] = 'integer';
                    break;
                case 'decimal':
                case 'float':
                case 'double':
                    $rules[] = 'numeric';
                    break;
                case 'boolean':
                    $rules[] = 'boolean';
                    break;
                case 'date':
                case 'datetime':
                    $rules[] = 'date';
                    break;
                case 'file':
                    $rules[] = 'file|mimes:pdf,doc,docx,xls,xlsx,txt,zip|max:5120';
                    $storeLogic .= "        if (\$request->hasFile('$fieldName')) {\n            \$data['$fieldName'] = \$request->file('$fieldName')->store('uploads', 'public');\n        }\n";
                    $updateLogic .= "        if (\$request->hasFile('$fieldName')) {\n            if (\$" . $modelCamel . "->" . $fieldName . ") { \\Illuminate\\Support\\Facades\\Storage::disk('public')->delete(\$" . $modelCamel . "->" . $fieldName . "); }\n            \$data['$fieldName'] = \$request->file('$fieldName')->store('uploads', 'public');\n        }\n";
                    break;
                case 'image':
                    $rules[] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
                    $storeLogic .= "        if (\$request->hasFile('$fieldName')) {\n            \$data['$fieldName'] = \$request->file('$fieldName')->store('uploads', 'public');\n        }\n";
                    $updateLogic .= "        if (\$request->hasFile('$fieldName')) {\n            if (\$" . $modelCamel . "->" . $fieldName . ") { \\Illuminate\\Support\\Facades\\Storage::disk('public')->delete(\$" . $modelCamel . "->" . $fieldName . "); }\n            \$data['$fieldName'] = \$request->file('$fieldName')->store('uploads', 'public');\n        }\n";
                    break;
                case 'string':
                case 'text':
                    $rules[] = 'string';
                    if ($fieldType === 'string') {
                        $rules[] = 'max:255';
                    }
                    break;
            }

            $ruleString = implode('|', $rules);
            $validationRules .= "'$fieldName' => '$ruleString',\n            ";
        }

        $storeLogic .= "\n        {$name}::create(\$data);";
        $updateLogic .= "\n        \$" . $modelCamel . "->update(\$data);";

        $searchableField = explode(':', $fieldArray[0])[0]; 

        $template = File::get(base_path('stubs/Controller.stub'));

        $newContent = str_replace(
            [
                '{{modelName}}', 
                '{{modelNamePlural}}', 
                '{{modelNameSingular}}', 
                '{{modelPath}}', 
                '{{validationRules}}',
                '{{searchableField}}',
                '{{storeLogic}}',
                '{{updateLogic}}'
            ],
            [
                $name, 
                Str::kebab(Str::plural($name)), 
                $modelCamel, 
                Str::kebab(Str::plural($name)), 
                trim($validationRules),
                $searchableField,
                trim($storeLogic),
                trim($updateLogic)
            ],
            $template
        );

        File::put($this->tempDir . "/app/Http/Controllers/{$name}Controller.php", $newContent);
    }

    protected function generateMigration($name, $fieldArray, $timestamps = false, $softdeletes = false)
    {
        $tableName = Str::snake(Str::plural($name));
        $timestamp = date('Y_m_d_His');
        $fileName = $timestamp . "_create_{$tableName}_table.php";
        
        $migrationFields = "";
        foreach ($fieldArray as $field) {
            $parts = explode(':', $field);
            $fieldName = $parts[0];
            $fieldType = $parts[1] ?? 'string';
            
            // Konversi image & file menjadi varchar/string di database
            $dbType = $fieldType;
            if ($fieldType === 'file' || $fieldType === 'image') {
                $dbType = 'string';
            }
            
            $migrationFields .= "\$table->$dbType('$fieldName');\n            ";
        }

        if ($timestamps) {
            $migrationFields .= "\$table->timestamps();\n            ";
        }
        
        if ($softdeletes) {
            $migrationFields .= "\$table->softDeletes();\n            ";
        }

        $template = str_replace(
            ['{{tableName}}', '// {{fieldPenanda}}'],
            [$tableName, trim($migrationFields)],
            File::get(base_path('stubs/migration.stub'))
        );

        File::put($this->tempDir . "/database/migrations/{$fileName}", $template);
    }

    protected function generateViews($name, $fieldArray, $timestamps = false)
    {
        $folderName = Str::kebab(Str::plural($name)); 
        $viewPath = $this->tempDir . "/resources/views/{$folderName}";
        
        $headers = ""; $body = ""; $formsCreate = ""; $formsEdit = "";
        $modelCamel = Str::camel($name);
        $hasFile = false;

        foreach ($fieldArray as $field) {
            $parts = explode(':', $field);
            $fieldName = $parts[0];
            $fieldType = $parts[1] ?? 'string';

            if ($fieldType === 'file' || $fieldType === 'image') {
                $hasFile = true;
            }

            switch ($fieldType) {
                case 'integer':
                case 'bigInteger':
                    $inputHtml = "<input type='number' name='$fieldName' class='form-control' required>";
                    $editValue = "value='{{ $$modelCamel->$fieldName }}'";
                    $inputHtmlEdit = "<input type='number' name='$fieldName' $editValue class='form-control' required>";
                    break;
                case 'text':
                    $inputHtml = "<textarea name='$fieldName' class='form-control' rows='3' required></textarea>";
                    $inputHtmlEdit = "<textarea name='$fieldName' class='form-control' rows='3' required>{{ $$modelCamel->$fieldName }}</textarea>";
                    break;
                case 'date':
                case 'datetime':
                    $inputHtml = "<input type='datetime-local' name='$fieldName' class='form-control' required>";
                    $editValue = "value='{{ $$modelCamel->$fieldName }}'";
                    $inputHtmlEdit = "<input type='datetime-local' name='$fieldName' $editValue class='form-control' required>";
                    break;
                case 'decimal':
                case 'float':
                case 'double':
                    $inputHtml = "<input type='number' step='0.01' name='$fieldName' class='form-control' required>";
                    $editValue = "value='{{ $$modelCamel->$fieldName }}'";
                    $inputHtmlEdit = "<input type='number' step='0.01' name='$fieldName' $editValue class='form-control' required>";
                    break;
                case 'boolean':
                    $inputHtml = "<select name='$fieldName' class='form-select' required><option value='1'>Ya</option><option value='0'>Tidak</option></select>";
                    $inputHtmlEdit = "<select name='$fieldName' class='form-select' required><option value='1' {{ $$modelCamel->$fieldName == 1 ? 'selected' : '' }}>Ya</option><option value='0' {{ $$modelCamel->$fieldName == 0 ? 'selected' : '' }}>Tidak</option></select>";
                    break;
                case 'file':
                case 'image':
                    $inputHtml = "<input type='file' name='$fieldName' class='form-control' required>";
                    $inputHtmlEdit = "<input type='file' name='$fieldName' class='form-control'>\n        <small class='text-muted d-block mt-1'>Biarkan kosong jika tidak ingin mengubah file/gambar.</small>";
                    break;
                default:
                    $inputHtml = "<input type='text' name='$fieldName' class='form-control' required>";
                    $editValue = "value='{{ $$modelCamel->$fieldName }}'";
                    $inputHtmlEdit = "<input type='text' name='$fieldName' $editValue class='form-control' required>";
                    break;
            }

            $labelName = ucfirst(str_replace('_', ' ', $fieldName));
            
            $sortIconUrl = "{{ request('sort_by') == '$fieldName' ? (request('sort_dir') == 'asc' ? '↑' : '↓') : '' }}";
            $headers .= "<th>
                                <a href=\"{{ route('{$folderName}.index', array_merge(request()->query(), ['sort_by' => '$fieldName', 'sort_dir' => request('sort_by') == '$fieldName' && request('sort_dir') == 'asc' ? 'desc' : 'asc'])) }}\" class=\"text-decoration-none text-dark\">
                                    $labelName $sortIconUrl
                                </a>
                            </th>\n            ";
                            
            if ($fieldType === 'boolean') {
                $body .= "<td>
                                    <span class=\"badge {{ \$item->$fieldName ? 'bg-success' : 'bg-secondary' }}\">
                                        {{ \$item->$fieldName ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>\n            ";
            } elseif ($fieldType === 'image') {
                $body .= "<td>
                                    @if(\$item->$fieldName)
                                        <img src=\"{{ asset('storage/' . \$item->$fieldName) }}\" alt=\"Image\" class=\"img-thumbnail\" style=\"max-width: 80px; max-height: 80px;\">
                                    @else
                                        <span class=\"text-muted\">-</span>
                                    @endif
                                </td>\n            ";
            } elseif ($fieldType === 'file') {
                $body .= "<td>
                                    @if(\$item->$fieldName)
                                        <a href=\"{{ asset('storage/' . \$item->$fieldName) }}\" class=\"btn btn-sm btn-outline-primary\" download>
                                            <i class=\"bi bi-download\"></i> Unduh File
                                        </a>
                                    @else
                                        <span class=\"text-muted\">-</span>
                                    @endif
                                </td>\n            ";
            } else {
                $body .= "<td>{{ \$item->$fieldName }}</td>\n            ";
            }

            $formsCreate .= "<div class='mb-3'>\n        <label class='form-label'>" . $labelName . "</label>\n        $inputHtml\n    </div>\n    ";
            $formsEdit .= "<div class='mb-3'>\n        <label class='form-label'>" . $labelName . "</label>\n        $inputHtmlEdit\n    </div>\n    ";
        }



        $indexTemplate = str_replace(
            ['{{modelName}}', '{{modelNamePlural}}', '{{tableHeaders}}', '{{tableBody}}'],
            [$name, $folderName, trim($headers), trim($body)],
            File::get(base_path('stubs/views/index.stub'))
        );
        File::put($viewPath . "/index.blade.php", $indexTemplate);

        $enctype = $hasFile ? 'enctype="multipart/form-data"' : '';

        $createTemplate = str_replace(
            ['{{modelName}}', '{{modelNamePlural}}', '{{formFields}}', '{{enctype}}'],
            [$name, $folderName, trim($formsCreate), $enctype],
            File::get(base_path('stubs/views/create.stub'))
        );
        File::put($viewPath . "/create.blade.php", $createTemplate);

        $editTemplate = str_replace(
            ['{{modelName}}', '{{modelNamePlural}}', '{{modelNameSingular}}', '{{formFieldsEdit}}', '{{enctype}}'],
            [$name, $folderName, $modelCamel, trim($formsEdit), $enctype],
            File::get(base_path('stubs/views/edit.stub'))
        );
        File::put($viewPath . "/edit.blade.php", $editTemplate);
    }

    protected function generateLayout()
    {
        $layoutPath = $this->tempDir . '/resources/views/layouts';
        if (!File::exists($layoutPath)) {
            File::makeDirectory($layoutPath, 0755, true);
        }
        
        if (File::exists(base_path('stubs/views/master.stub'))) {
            File::copy(base_path('stubs/views/master.stub'), $layoutPath . '/master.blade.php');
        }
    }

    protected function generateReadme($name)
    {
        $pluralPath = strtolower(Str::plural($name));
        $routeCode = "Route::resource('{$pluralPath}', \\App\\Http\\Controllers\\{$name}Controller::class);";
        
        $readmeContent = "--- MODUL GENERATED BY AVW STORE ---\n\n";
        $readmeContent .= "Modul: {$name}\n";
        $readmeContent .= "Tanggal Generate: " . date('Y-m-d H:i:s') . "\n\n";
        $readmeContent .= "PANDUAN INSTALASI:\n";
        $readmeContent .= "1. Copy folder app/, database/, dan resources/ di dalam ZIP ini lalu timpa ke root direktori Laravel Anda.\n";
        $readmeContent .= "2. Buka file routes/web.php dan tambahkan baris berikut:\n\n";
        $readmeContent .= "   {$routeCode}\n\n";
        $readmeContent .= "3. Jalankan perintah 'php artisan migrate' di terminal Anda.\n";
        $readmeContent .= "4. Akses modul di browser melalui alamat: /{$pluralPath}\n\n";
        $readmeContent .= "Terima kasih telah menggunakan FastCRUD AVW Generator!";

        File::put($this->tempDir . "/README_CARA_PAKAI.txt", $readmeContent);
    }

    protected function createZipArchive()
    {
        $zip = new ZipArchive;
        if ($zip->open($this->zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            
            $files = File::allFiles($this->tempDir);
            foreach ($files as $file) {
                // Gunakan relative pathname bawaan Symfony Finder dan standarisasi slash
                $relativePath = str_replace('\\', '/', $file->getRelativePathname());
                $zip->addFile($file->getRealPath(), $relativePath);
            }
            $zip->close();
        }
    }
}
