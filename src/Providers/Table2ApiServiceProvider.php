<?php

namespace Asif\Table2api\Providers;

use Asif\Table2api\Commands\Table2ApiGeneratorCommand;
use Illuminate\Support\ServiceProvider;

class Table2ApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            Table2ApiGeneratorCommand::class,
        ]);
        $this->loadTableToApi();
    }

    public function register()
    {
    }

    private function loadTableToApi()
    {
        $basePath = base_path("api/v1");
        if (file_exists($basePath)) {
            $moduleFolders = scandir($basePath);
            $modules = array_diff($moduleFolders, ['.', '..']);

            foreach ($modules as $module) {
                $this->loadTableToApiRoutes($module);
            }
        }
    }

    private function loadTableToApiRoutes($module)
    {
        $routesApiPath = base_path('api/v1/' . $module . '/Routes/' . 'api.php');

        if (file_exists($routesApiPath)) {
            include $routesApiPath;
        }
    }
}
