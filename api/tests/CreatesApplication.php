<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        Config::set('database.default', 'sqlite');

        $db = app()->make('db');
        $db->connection()->getPdo()->exec("pragma foreign_keys=1");

        Artisan::call('migrate');

        return $app;
    }
}
