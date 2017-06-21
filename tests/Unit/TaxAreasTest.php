<?php

namespace Appleton\Taxes;

use Appleton\Taxes\Models\TaxArea;

class TaxAreasTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function testUS()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\USSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(38.9072, -77.0369)->get()->pluck('name')->toArray();

        $this->assertContains('Federal Income Tax', $tax_areas);
        $this->assertContains('Federal Unemployment Tax', $tax_areas);
        $this->assertContains('Medicare Tax', $tax_areas);
        $this->assertContains('Medicare Employer Tax', $tax_areas);
        $this->assertContains('Social Security Tax', $tax_areas);
        $this->assertContains('Social Security Employer Tax', $tax_areas);
        $this->assertCount(6, $tax_areas);
    }

    public function testAlabama()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AlabamaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.3182, -86.9023)->get()->pluck('name')->toArray();

        $this->assertContains('Alabama Income Tax', $tax_areas);
        $this->assertContains('Alabama Income Tax', $tax_areas);
        $this->assertCount(2, $tax_areas);
    }

    public function testAttalla()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AttallaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0218, -86.0886)->get()->pluck('name')->toArray();

        $this->assertSame(['Attalla Occupational Tax'], $tax_areas);
    }

    public function testAuburn()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AuburnSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.6099, -85.4808)->get()->pluck('name')->toArray();

        $this->assertSame(['Auburn Occupational Tax'], $tax_areas);
    }

    public function testBearCreek()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BearCreekSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2748, -87.7006)->get()->pluck('name')->toArray();

        $this->assertSame(['Bear Creek Occupational Tax'], $tax_areas);
    }

    public function testBessemer()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BessemerSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4018, -86.9544)->get()->pluck('name')->toArray();

        $this->assertSame(['Bessemer Occupational Tax'], $tax_areas);
    }

    public function testBirmingham()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BirminghamSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.5207, -86.8025)->get()->pluck('name')->toArray();

        $this->assertSame(['Birmingham Occupational Tax'], $tax_areas);
    }

    public function testBrilliant()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BrilliantSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0254, -87.7584)->get()->pluck('name')->toArray();

        $this->assertSame(['Brilliant Occupational Tax'], $tax_areas);
    }

    public function testFairfield()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\FairfieldSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4859, -86.9119)->get()->pluck('name')->toArray();

        $this->assertSame(['Fairfield Occupational Tax'], $tax_areas);
    }

    public function testGadsden()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GadsdenSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0143, -86.0066)->get()->pluck('name')->toArray();

        $this->assertSame(['Gadsden Occupational Tax'], $tax_areas);
    }

    public function testGlencoe()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GlencoeSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9570, -85.932)->get()->pluck('name')->toArray();

        $this->assertSame(['Glencoe Occupational Tax'], $tax_areas);
    }

    public function testGoodwater()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GoodwaterSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.0657, -86.0533)->get()->pluck('name')->toArray();

        $this->assertSame(['Goodwater Occupational Tax'], $tax_areas);
    }

    public function testGuin()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GuinSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9657, -87.9147)->get()->pluck('name')->toArray();

        $this->assertSame(['Guin Occupational Tax'], $tax_areas);
    }

    public function testHackleburg()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HackleburgSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2773, -87.8286)->get()->pluck('name')->toArray();

        $this->assertSame(['Hackleburg Occupational Tax'], $tax_areas);
    }

    public function testHaleyville()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HaleyvilleSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2265, -87.6214)->get()->pluck('name')->toArray();

        $this->assertSame(['Haleyville Occupational Tax'], $tax_areas);
    }

    public function testHamilton()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HamiltonSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.1423, -87.9886)->get()->pluck('name')->toArray();

        $this->assertSame(['Hamilton Occupational Tax'], $tax_areas);
    }

    public function testLeeds()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LeedsSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.5482, -86.5444)->get()->pluck('name')->toArray();

        $this->assertSame(['Leeds Occupational Tax'], $tax_areas);
    }

    public function testLynn()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LynnSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0470, -87.5497)->get()->pluck('name')->toArray();

        $this->assertSame(['Lynn Occupational Tax'], $tax_areas);
    }

    public function testMidfield()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MidfieldSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4615, -86.9089)->get()->pluck('name')->toArray();

        $this->assertSame(['Midfield Occupational Tax'], $tax_areas);
    }

    public function testMosses()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MossesSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.1793, -86.6737)->get()->pluck('name')->toArray();

        $this->assertSame(['Mosses Occupational Tax'], $tax_areas);
    }

    public function testOpelika()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\OpelikaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.6454, -85.3783)->get()->pluck('name')->toArray();

        $this->assertSame(['Opelika Occupational Tax'], $tax_areas);
    }

    public function testRainbowCity()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RainbowCitySeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9548, -86.0419)->get()->pluck('name')->toArray();

        $this->assertSame(['Rainbow City Occupational Tax'], $tax_areas);
    }

    public function testRedBay()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RedBaySeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.4398, -88.1409)->get()->pluck('name')->toArray();

        $this->assertSame(['Red Bay Occupational Tax'], $tax_areas);
    }

    public function testShorter()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\ShorterSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.3951, -85.9184)->get()->pluck('name')->toArray();

        $this->assertSame(['Shorter Occupational Tax'], $tax_areas);
    }

    public function testSouthside()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SouthsideSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9245, -86.0225)->get()->pluck('name')->toArray();

        $this->assertSame(['Southside Occupational Tax'], $tax_areas);
    }

    public function testSulligent()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SulligentSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9018, -88.1345)->get()->pluck('name')->toArray();

        $this->assertSame(['Sulligent Occupational Tax'], $tax_areas);
    }

    public function testTuskegee()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\TuskegeeSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.4302, -85.7077)->get()->pluck('name')->toArray();

        $this->assertSame(['Tuskegee Occupational Tax'], $tax_areas);
    }
}
