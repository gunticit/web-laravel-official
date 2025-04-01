<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo mới modules theo mô hình HMVC';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $moduleName = ucfirst($this->argument('name'));

        $modulePath = app_path('Modules/' . $moduleName);

        if (file_exists($modulePath)) {
            if ($this->confirm("Module $moduleName đã tồn tại. Bạn có muốn xóa và tạo lại không?")) {
                File::deleteDirectory($modulePath);
                $this->info("Module $moduleName đang tiến hành tạo mới...");
            } else {
                $this->error("Module $moduleName đã tồn tại và không có bất kỳ thay đổi.");
                return;
            }
        }

        $this->createFolder($modulePath);

        [
            $routeTemplate, 
            $routeApiTemplate, 
            $viewTemplate, 
            $modelsTemplate, 
            $controllersTemplate, 
            $repositoriesTemplate, 
            $interfaceRepositoriesTemplate, 
            $servicesTemplate, 
            $tablesTemplate
        ] = $this->getRouteTemplate($moduleName);

        File::put("$modulePath/Routes/web.php", $routeTemplate);
        File::put("$modulePath/Routes/api.php", $routeApiTemplate);
        File::put("$modulePath/Views/index.blade.php", $viewTemplate);
        File::put("$modulePath/Controllers/{$moduleName}Controller.php", $controllersTemplate);
        File::put("$modulePath/Repositories/{$moduleName}Repository.php", $repositoriesTemplate);
        File::put("$modulePath/Repositories/{$moduleName}InterfaceRepository.php", $interfaceRepositoriesTemplate);
        File::put("$modulePath/Services/{$moduleName}Service.php", $servicesTemplate);    
        File::put("$modulePath/Models/{$moduleName}Model.php", $modelsTemplate);
        File::put("$modulePath/Models/{$moduleName}Table.php", $tablesTemplate);

        $this->info("Tạo module $moduleName thành công!");
    }

    private function createFolder($modulePath){
        mkdir($modulePath, 0755, true);
        mkdir($modulePath . '/Controllers', 0755);
        mkdir($modulePath . '/Repositories', 0755);
        mkdir($modulePath . '/Services', 0755);
        mkdir($modulePath . '/Models', 0755);
        mkdir($modulePath . '/Views', 0755);
        mkdir($modulePath . '/Routes', 0755);
    }

    /**
     * Get template for route file
     *
     * @return array
     */
    
    private function getRouteTemplate(string $moduleName): array{
        $routeTemplate = file_get_contents(__DIR__ . '/stubs/routes.stub');
        $routeApiTemplate = file_get_contents(__DIR__ . '/stubs/routes.stub');
        $viewTemplate = file_get_contents(__DIR__ . '/stubs/view.stub');
        $modelsTemplate = file_get_contents(__DIR__ . '/stubs/models.stub');
        $controllersTemplate = file_get_contents(__DIR__ . '/stubs/controllers.stub');
        $repositoriesTemplate = file_get_contents(__DIR__ . '/stubs/repositories.stub');
        $interfaceRepositoriesTemplate = file_get_contents(__DIR__ . '/stubs/interface-repositories.stub');
        $servicesTemplate = file_get_contents(__DIR__ . '/stubs/services.stub');
        $tablesTemplate =  file_get_contents(__DIR__ . '/stubs/table.stub');

        $routeTemplate = str_replace('{{moduleName}}', $moduleName, $routeTemplate);
        $routeApiTemplate = str_replace('{{moduleName}}', $moduleName, $routeApiTemplate);
        $viewTemplate = str_replace('{{moduleName}}', $moduleName, $viewTemplate);
        $modelsTemplate = str_replace('{{moduleName}}', $moduleName, $modelsTemplate);
        $controllersTemplate = str_replace('{{moduleName}}', $moduleName, $controllersTemplate);
        $repositoriesTemplate = str_replace('{{moduleName}}', $moduleName, $repositoriesTemplate);
        $interfaceRepositoriesTemplate = str_replace('{{moduleName}}', $moduleName, $interfaceRepositoriesTemplate);
        $servicesTemplate = str_replace('{{moduleName}}', $moduleName, $servicesTemplate);
        $tablesTemplate = str_replace('{{moduleName}}', $moduleName, $tablesTemplate);

        return [$routeTemplate, $routeApiTemplate, $viewTemplate, $modelsTemplate, $controllersTemplate, $repositoriesTemplate, $interfaceRepositoriesTemplate, $servicesTemplate, $tablesTemplate];
    }
}
