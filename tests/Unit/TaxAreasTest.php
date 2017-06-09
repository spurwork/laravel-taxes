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

        $tax_areas = TaxArea::atPoint(38.9072, -77.0369)->get();

        $this->assertSame('Federal Income Tax', $tax_areas[5]->name);
        $this->assertSame('Federal Unemployment Tax', $tax_areas[4]->name);
        $this->assertSame('Medicare Tax', $tax_areas[3]->name);
        $this->assertSame('Medicare Employer Tax', $tax_areas[2]->name);
        $this->assertSame('Social Security Tax', $tax_areas[1]->name);
        $this->assertSame('Social Security Employer Tax', $tax_areas[0]->name);
    }

    public function testAlabama()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AlabamaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.3182, -86.9023)->get();

        $this->assertSame('Alabama Income Tax', $tax_areas[1]->name);
        $this->assertSame('Alabama Unemployment Tax', $tax_areas[0]->name);
    }

    public function testAttalla()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AttallaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0218, -86.0886)->get();

        $this->assertSame('Attalla Occupational Tax', $tax_areas[0]->name);
    }

    public function testAuburn()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\AuburnSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.6099, -85.4808)->get();

        $this->assertSame('Auburn Occupational Tax', $tax_areas[0]->name);
    }

    public function testBearCreek()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BearCreekSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2748, -87.7006)->get();

        $this->assertSame('Bear Creek Occupational Tax', $tax_areas[0]->name);
    }

    public function testBessemer()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BessemerSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4018, -86.9544)->get();

        $this->assertSame('Bessemer Occupational Tax', $tax_areas[0]->name);
    }

    public function testBirmingham()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BirminghamSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.5207, -86.8025)->get();

        $this->assertSame('Birmingham Occupational Tax', $tax_areas[0]->name);
    }

    public function testBrilliant()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\BrilliantSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0254, -87.7584)->get();

        $this->assertSame('Brilliant Occupational Tax', $tax_areas[0]->name);
    }

    public function testFairfield()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\FairfieldSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4859, -86.9119)->get();

        $this->assertSame('Fairfield Occupational Tax', $tax_areas[0]->name);
    }

    public function testGadsden()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GadsdenSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0143, -86.0066)->get();

        $this->assertSame('Gadsden Occupational Tax', $tax_areas[0]->name);
    }

    public function testGlencoe()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GlencoeSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9570, -85.932)->get();

        $this->assertSame('Glencoe Occupational Tax', $tax_areas[0]->name);
    }

    public function testGoodwater()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GoodwaterSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.0657, -86.0533)->get();

        $this->assertSame('Goodwater Occupational Tax', $tax_areas[0]->name);
    }

    public function testGuin()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\GuinSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9657, -87.9147)->get();

        $this->assertSame('Guin Occupational Tax', $tax_areas[0]->name);
    }

    public function testHackleburg()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HackleburgSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2773, -87.8286)->get();

        $this->assertSame('Hackleburg Occupational Tax', $tax_areas[0]->name);
    }

    public function testHaleyville()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HaleyvilleSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.2265, -87.6214)->get();

        $this->assertSame('Haleyville Occupational Tax', $tax_areas[0]->name);
    }

    public function testHamilton()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\HamiltonSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.1423, -87.9886)->get();

        $this->assertSame('Hamilton Occupational Tax', $tax_areas[0]->name);
    }

    public function testLeeds()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LeedsSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.5482, -86.5444)->get();

        $this->assertSame('Leeds Occupational Tax', $tax_areas[0]->name);
    }

    public function testLynn()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\LynnSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.0470, -87.5497)->get();

        $this->assertSame('Lynn Occupational Tax', $tax_areas[0]->name);
    }

    public function testMidfield()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MidfieldSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.4615, -86.9089)->get();

        $this->assertSame('Midfield Occupational Tax', $tax_areas[0]->name);
    }

    public function testMosses()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\MossesSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.1793, -86.6737)->get();

        $this->assertSame('Mosses Occupational Tax', $tax_areas[0]->name);
    }

    public function testOpelika()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\OpelikaSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.6454, -85.3783)->get();

        $this->assertSame('Opelika Occupational Tax', $tax_areas[0]->name);
    }

    public function testRainbowCity()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RainbowCitySeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9548, -86.0419)->get();

        $this->assertSame('Rainbow City Occupational Tax', $tax_areas[0]->name);
    }

    public function testRedBay()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\RedBaySeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(34.4398, -88.1409)->get();

        $this->assertSame('Red Bay Occupational Tax', $tax_areas[0]->name);
    }

    public function testShorter()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\ShorterSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.3951, -85.9184)->get();

        $this->assertSame('Shorter Occupational Tax', $tax_areas[0]->name);
    }

    public function testSouthside()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SouthsideSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9245, -86.0225)->get();

        $this->assertSame('Southside Occupational Tax', $tax_areas[0]->name);
    }

    public function testSulligent()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\SulligentSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(33.9018, -88.1345)->get();

        $this->assertSame('Sulligent Occupational Tax', $tax_areas[0]->name);
    }

    public function testTuskegee()
    {
        $this->artisan('db:seed', ['--class' => 'Appleton\Taxes\Seeds\US\Alabama\TuskegeeSeeder', '--database' => 'testing']);

        $tax_areas = TaxArea::atPoint(32.4302, -85.7077)->get();

        $this->assertSame('Tuskegee Occupational Tax', $tax_areas[0]->name);
    }
}
