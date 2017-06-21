<?php

namespace Appleton\Taxes\Commands;

use Illuminate\Console\Command;

class SeedCommand extends Command
{
    protected $signature = 'seed {country}';

    protected $description = 'Seeds the database with governmental unit areas and tax areas for the specified country.';

    public function handle()
    {
        $method = 'seed' . $this->argument('country');
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->error('No seeder found for specified country.');
        }
    }

    private function seedUS()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\USSeeder']);
    }
}
