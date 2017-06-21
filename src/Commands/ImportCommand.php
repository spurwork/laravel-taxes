<?php

namespace Appleton\Taxes\Commands;

use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'taxes:import {country}';

    protected $description = 'Imports governmental unit areas and tax areas for the specified country.';

    public function handle()
    {
        $method = 'import' . $this->argument('country');
        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->error('No importer found for specified country.');
        }
    }

    private function importUS()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\USSeeder']);
    }
}
