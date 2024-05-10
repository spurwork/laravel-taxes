<?php

namespace Appleton\Taxes;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase;

class InitDb extends TestCase
{
    public static function initDb(): void
    {
        $init_db = new self('');
        $init_db->setUp();

        $init_db->artisan('migrate:fresh');
        $init_db->artisan('migrate', [
            '--database' => 'testing',
            '--path' => 'migrations',
        ]);
        $init_db->artisan('migrate', [
            '--database' => 'testing',
            '--path' => dirname(__DIR__).'/src/migrations',
            '--realpath' => true,
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->useEnvironmentPath(__DIR__.'/..');

        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        parent::getEnvironmentSetUp($app);

        $app['config']->set('database.default', 'testing');

        $app['config']->set('database.connections.testing', [
            'driver' => 'pgsql',
            'host' => env('TEST_DB_HOST'),
            'port' => env('TEST_DB_PORT', 5432),
            'database' => env('TEST_DB_DATABASE'),
            'username' => env('PG_USER', env('TEST_DB_USERNAME')),
            'password' => env('PG_PASSWORD', env('TEST_DB_PASSWORD')),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ]);
    }
}
