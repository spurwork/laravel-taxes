<?php

namespace Appleton\Taxes\Commands;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Appleton\Taxes\Models\TaxArea;
use Artisan;

class ImportCommandTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->addCommand(ImportCommand::class);
    }

    public function testImportUS()
    {
        $this->artisan('taxes:import', ['country' => 'US']);
        $this->assertSame(27, GovernmentalUnitArea::count());
        $this->assertSame(33, TaxArea::count());
    }

    public function testImportUSTwice()
    {
        $this->artisan('taxes:import', ['country' => 'US']);
        $this->artisan('taxes:import', ['country' => 'US']);
        $this->assertSame(27, GovernmentalUnitArea::count());
        $this->assertSame(33, TaxArea::count());
    }

    public function testImportNoCountry()
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "country").');

        $this->artisan('taxes:import');
        $this->assertSame(0, GovernmentalUnitArea::count());
        $this->assertSame(0, TaxArea::count());
    }

    public function testImportBadCountry()
    {
        $this->artisan('taxes:import', ['country' => 'XX']);
        $this->assertSame(0, GovernmentalUnitArea::count());
        $this->assertSame(0, TaxArea::count());
        $this->assertSame("No importer found for specified country.\n", Artisan::output());
    }
}
