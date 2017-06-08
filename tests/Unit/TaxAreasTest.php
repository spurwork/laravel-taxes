<?php

namespace Appleton\Taxes;

use Appleton\Taxes\Models\TaxArea;

class TaxAreasTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\AttallaSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\BirminghamSeeder', '--database' => 'testing']);
    }

    public function testAttalla()
    {
        $result = TaxArea::atPoint(34.0218, -86.0886)
            ->first()
            ->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(46.00, $result);
    }

    public function testBirmingham()
    {
        $result = TaxArea::atPoint(33.5207, -86.8025)
            ->first()
            ->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(23.00, $result);
    }
}
