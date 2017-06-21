<?php

namespace Appleton\Taxes\Commands;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Appleton\Taxes\Models\TaxArea;

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
}
