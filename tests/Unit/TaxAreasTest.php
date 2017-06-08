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
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\AuburnSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\BearCreekSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\BessemerSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\BirminghamSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\BrilliantSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\FairfieldSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\GadsdenSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\GlencoeSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\GoodwaterSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\GuinSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\HackleburgSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\HaleyvilleSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\HamiltonSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\LeedsSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\LynnSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\MidfieldSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\MossesSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\OpelikaSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\RainbowCitySeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\RedBaySeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\ShorterSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\SouthsideSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\SulligentSeeder', '--database' => 'testing']);
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\TuskegeeSeeder', '--database' => 'testing']);
    }

    public function testAttalla()
    {
        $tax_area = TaxArea::atPoint(34.0218, -86.0886)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Attalla, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }

    public function testAuburn()
    {
        $tax_area = TaxArea::atPoint(32.6099, -85.4808)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Auburn, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testBearCreek()
    {
        $tax_area = TaxArea::atPoint(34.2748, -87.7006)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Bear Creek, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testBessemer()
    {
        $tax_area = TaxArea::atPoint(33.4018, -86.9544)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Bessemer, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testBirmingham()
    {
        $tax_area = TaxArea::atPoint(33.5207, -86.8025)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Birmingham, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testBrilliant()
    {
        $tax_area = TaxArea::atPoint(34.0254, -87.7584)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Brilliant, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testFairfield()
    {
        $tax_area = TaxArea::atPoint(33.4859, -86.9119)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Fairfield, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testGadsden()
    {
        $tax_area = TaxArea::atPoint(34.0143, -86.0066)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Gadsden, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }

    public function testGlencoe()
    {
        $tax_area = TaxArea::atPoint(33.9570, -85.932)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Glencoe, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }

    public function testGoodwater()
    {
        $tax_area = TaxArea::atPoint(33.0657, -86.0533)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Goodwater, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(17.25, $result);
    }

    public function testGuin()
    {
        $tax_area = TaxArea::atPoint(33.9657, -87.9147)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Guin, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testHackleburg()
    {
        $tax_area = TaxArea::atPoint(34.2773, -87.8286)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Hackleburg, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testHaleyville()
    {
        $tax_area = TaxArea::atPoint(34.2265, -87.6214)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Haleyville, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testHamilton()
    {
        $tax_area = TaxArea::atPoint(34.1423, -87.9886)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Hamilton, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testLeeds()
    {
        $tax_area = TaxArea::atPoint(33.5482, -86.5444)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Leeds, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testLynn()
    {
        $tax_area = TaxArea::atPoint(34.0470, -87.5497)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Lynn, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testMidfield()
    {
        $tax_area = TaxArea::atPoint(33.4615, -86.9089)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Midfield, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testMosses()
    {
        $tax_area = TaxArea::atPoint(32.1793, -86.6737)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Mosses, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testOpelika()
    {
        $tax_area = TaxArea::atPoint(32.6454, -85.3783)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Opelika, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(34.5, $result);
    }

    public function testRainbowCity()
    {
        $tax_area = TaxArea::atPoint(33.9548, -86.0419)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Rainbow City, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }

    public function testRedBay()
    {
        $tax_area = TaxArea::atPoint(34.4398, -88.1409)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Red Bay, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(11.5, $result);
    }

    public function testShorter()
    {
        $tax_area = TaxArea::atPoint(32.3951, -85.9184)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Shorter, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testSouthside()
    {
        $tax_area = TaxArea::atPoint(33.9245, -86.0225)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Southside, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }

    public function testSulligent()
    {
        $tax_area = TaxArea::atPoint(33.9018, -88.1345)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Sulligent, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(23.00, $result);
    }

    public function testTuskegee()
    {
        $tax_area = TaxArea::atPoint(32.4302, -85.7077)->first();

        $result = $tax_area->tax
            ->withEarnings(2300)
            ->compute();

        $this->assertSame('Tuskegee, AL', $tax_area->governmentalUnitArea->name);
        $this->assertSame(46.00, $result);
    }
}
