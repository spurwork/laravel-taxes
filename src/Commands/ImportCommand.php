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
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\USSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AlabamaSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AttallaSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AuburnSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BearCreekSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BessemerSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BirminghamSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BrilliantSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\FairfieldSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GadsdenSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GlencoeSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GoodwaterSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GuinSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HackleburgSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HaleyvilleSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HamiltonSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LeedsSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LynnSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MidfieldSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MossesSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\OpelikaSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RainbowCitySeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RedBaySeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\ShorterSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SouthsideSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SulligentSeeder']);
        $this->call('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\TuskegeeSeeder']);
    }
}
