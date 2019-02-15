<?php

namespace Appleton\Taxes;

use Appleton\Taxes\Models\TaxArea;

class TaxAreasTest extends \TestCase
{
    public function testUS()
    {
        list($latitude, $longitude) = $this->getLocation('us');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Federal Income Tax', $tax_areas);
        $this->assertContains('Federal Unemployment Tax', $tax_areas);
        $this->assertContains('Medicare Tax', $tax_areas);
        $this->assertContains('Medicare Employer Tax', $tax_areas);
        $this->assertContains('Social Security Tax', $tax_areas);
        $this->assertContains('Social Security Employer Tax', $tax_areas);
    }

    public function testAlabama()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Alabama Income Tax', $tax_areas);
        $this->assertContains('Alabama Unemployment Tax', $tax_areas);
    }

    public function testAttalla()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.attalla');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Attalla Occupational Tax', $tax_areas);
    }

    public function testAuburn()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.auburn');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Auburn Occupational Tax', $tax_areas);
    }

    public function testBearCreek()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.bearcreek');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Bear Creek Occupational Tax', $tax_areas);
    }

    public function testBessemer()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.bessemer');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Bessemer Occupational Tax', $tax_areas);
    }

    public function testBirmingham()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.birmingham');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Birmingham Occupational Tax', $tax_areas);
    }

    public function testBrilliant()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.brilliant');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Brilliant Occupational Tax', $tax_areas);
    }

    public function testFairfield()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.fairfield');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Fairfield Occupational Tax', $tax_areas);
    }

    public function testGadsden()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.gadsden');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Gadsden Occupational Tax', $tax_areas);
    }

    public function testGlencoe()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.glencoe');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Glencoe Occupational Tax', $tax_areas);
    }

    public function testGoodwater()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.goodwater');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Goodwater Occupational Tax', $tax_areas);
    }

    public function testGuin()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.guin');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Guin Occupational Tax', $tax_areas);
    }

    public function testHackleburg()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.hackleburg');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Hackleburg Occupational Tax', $tax_areas);
    }

    public function testHaleyville()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.haleyville');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Haleyville Occupational Tax', $tax_areas);
    }

    public function testHamilton()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.hamilton');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Hamilton Occupational Tax', $tax_areas);
    }

    public function testLeeds()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.leeds');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Leeds Occupational Tax', $tax_areas);
    }

    public function testLynn()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.lynn');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Lynn Occupational Tax', $tax_areas);
    }

    public function testMidfield()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.midfield');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Midfield Occupational Tax', $tax_areas);
    }

    public function testMosses()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.mosses');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Mosses Occupational Tax', $tax_areas);
    }

    public function testOpelika()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.opelika');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Opelika Occupational Tax', $tax_areas);
    }

    public function testRainbowCity()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.rainbowcity');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Rainbow City Occupational Tax', $tax_areas);
    }

    public function testRedBay()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.redbay');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Red Bay Occupational Tax', $tax_areas);
    }

    public function testShorter()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.shorter');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Shorter Occupational Tax', $tax_areas);
    }

    public function testSouthside()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.southside');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Southside Occupational Tax', $tax_areas);
    }

    public function testSulligent()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.sulligent');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Sulligent Occupational Tax', $tax_areas);
    }

    public function testTuskegee()
    {
        list($latitude, $longitude) = $this->getLocation('us.alabama.tuskegee');

        $tax_areas = TaxArea::atPoint([$latitude, $longitude], [$latitude, $longitude])->get()->map(function($tax_area) {
            return $tax_area->tax->name;
        })->toArray();

        $this->assertContains('Tuskegee Occupational Tax', $tax_areas);
    }
}
