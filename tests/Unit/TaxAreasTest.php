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
        $tax_areas = TaxArea::atPoint(38.9072, -77.0369)->get()->pluck('name')->toArray();

        $this->assertContains('Federal Income Tax', $tax_areas);
        $this->assertContains('Federal Unemployment Tax', $tax_areas);
        $this->assertContains('Medicare Tax', $tax_areas);
        $this->assertContains('Medicare Employer Tax', $tax_areas);
        $this->assertContains('Social Security Tax', $tax_areas);
        $this->assertContains('Social Security Employer Tax', $tax_areas);
    }

    public function testAlabama()
    {
        $tax_areas = TaxArea::atPoint(32.3182, -86.9023)->get()->pluck('name')->toArray();

        $this->assertContains('Alabama Income Tax', $tax_areas);
        $this->assertContains('Alabama Unemployment Tax', $tax_areas);
    }

    public function testAttalla()
    {
        $tax_areas = TaxArea::atPoint(34.0218, -86.0886)->get()->pluck('name')->toArray();

        $this->assertContains('Attalla Occupational Tax', $tax_areas);
    }

    public function testAuburn()
    {
        $tax_areas = TaxArea::atPoint(32.6099, -85.4808)->get()->pluck('name')->toArray();

        $this->assertContains('Auburn Occupational Tax', $tax_areas);
    }

    public function testBearCreek()
    {
        $tax_areas = TaxArea::atPoint(34.2748, -87.7006)->get()->pluck('name')->toArray();

        $this->assertContains('Bear Creek Occupational Tax', $tax_areas);
    }

    public function testBessemer()
    {
        $tax_areas = TaxArea::atPoint(33.4018, -86.9544)->get()->pluck('name')->toArray();

        $this->assertContains('Bessemer Occupational Tax', $tax_areas);
    }

    public function testBirmingham()
    {
        $tax_areas = TaxArea::atPoint(33.5207, -86.8025)->get()->pluck('name')->toArray();

        $this->assertContains('Birmingham Occupational Tax', $tax_areas);
    }

    public function testBrilliant()
    {
        $tax_areas = TaxArea::atPoint(34.0254, -87.7584)->get()->pluck('name')->toArray();

        $this->assertContains('Brilliant Occupational Tax', $tax_areas);
    }

    public function testFairfield()
    {
        $tax_areas = TaxArea::atPoint(33.4859, -86.9119)->get()->pluck('name')->toArray();

        $this->assertContains('Fairfield Occupational Tax', $tax_areas);
    }

    public function testGadsden()
    {
        $tax_areas = TaxArea::atPoint(34.0143, -86.0066)->get()->pluck('name')->toArray();

        $this->assertContains('Gadsden Occupational Tax', $tax_areas);
    }

    public function testGlencoe()
    {
        $tax_areas = TaxArea::atPoint(33.9570, -85.932)->get()->pluck('name')->toArray();

        $this->assertContains('Glencoe Occupational Tax', $tax_areas);
    }

    public function testGoodwater()
    {
        $tax_areas = TaxArea::atPoint(33.0657, -86.0533)->get()->pluck('name')->toArray();

        $this->assertContains('Goodwater Occupational Tax', $tax_areas);
    }

    public function testGuin()
    {
        $tax_areas = TaxArea::atPoint(33.9657, -87.9147)->get()->pluck('name')->toArray();

        $this->assertContains('Guin Occupational Tax', $tax_areas);
    }

    public function testHackleburg()
    {
        $tax_areas = TaxArea::atPoint(34.2773, -87.8286)->get()->pluck('name')->toArray();

        $this->assertContains('Hackleburg Occupational Tax', $tax_areas);
    }

    public function testHaleyville()
    {
        $tax_areas = TaxArea::atPoint(34.2265, -87.6214)->get()->pluck('name')->toArray();

        $this->assertContains('Haleyville Occupational Tax', $tax_areas);
    }

    public function testHamilton()
    {
        $tax_areas = TaxArea::atPoint(34.1423, -87.9886)->get()->pluck('name')->toArray();

        $this->assertContains('Hamilton Occupational Tax', $tax_areas);
    }

    public function testLeeds()
    {
        $tax_areas = TaxArea::atPoint(33.5482, -86.5444)->get()->pluck('name')->toArray();

        $this->assertContains('Leeds Occupational Tax', $tax_areas);
    }

    public function testLynn()
    {
        $tax_areas = TaxArea::atPoint(34.0470, -87.5497)->get()->pluck('name')->toArray();

        $this->assertContains('Lynn Occupational Tax', $tax_areas);
    }

    public function testMidfield()
    {
        $tax_areas = TaxArea::atPoint(33.4615, -86.9089)->get()->pluck('name')->toArray();

        $this->assertContains('Midfield Occupational Tax', $tax_areas);
    }

    public function testMosses()
    {
        $tax_areas = TaxArea::atPoint(32.1793, -86.6737)->get()->pluck('name')->toArray();

        $this->assertContains('Mosses Occupational Tax', $tax_areas);
    }

    public function testOpelika()
    {
        $tax_areas = TaxArea::atPoint(32.6454, -85.3783)->get()->pluck('name')->toArray();

        $this->assertContains('Opelika Occupational Tax', $tax_areas);
    }

    public function testRainbowCity()
    {
        $tax_areas = TaxArea::atPoint(33.9548, -86.0419)->get()->pluck('name')->toArray();

        $this->assertContains('Rainbow City Occupational Tax', $tax_areas);
    }

    public function testRedBay()
    {
        $tax_areas = TaxArea::atPoint(34.4398, -88.1409)->get()->pluck('name')->toArray();

        $this->assertContains('Red Bay Occupational Tax', $tax_areas);
    }

    public function testShorter()
    {
        $tax_areas = TaxArea::atPoint(32.3951, -85.9184)->get()->pluck('name')->toArray();

        $this->assertContains('Shorter Occupational Tax', $tax_areas);
    }

    public function testSouthside()
    {
        $tax_areas = TaxArea::atPoint(33.9245, -86.0225)->get()->pluck('name')->toArray();

        $this->assertContains('Southside Occupational Tax', $tax_areas);
    }

    public function testSulligent()
    {
        $tax_areas = TaxArea::atPoint(33.9018, -88.1345)->get()->pluck('name')->toArray();

        $this->assertContains('Sulligent Occupational Tax', $tax_areas);
    }

    public function testTuskegee()
    {
        $tax_areas = TaxArea::atPoint(32.4302, -85.7077)->get()->pluck('name')->toArray();

        $this->assertContains('Tuskegee Occupational Tax', $tax_areas);
    }
}
