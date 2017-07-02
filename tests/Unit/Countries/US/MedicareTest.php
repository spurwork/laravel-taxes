<?php

namespace Appleton\Taxes\Countries\US\Medicare;

use Appleton\Taxes\Countries\US;

class MedicareTest extends \TestCase
{
    public function testMedicare()
    {
        $result = $this->app->makeWith(Medicare::class, [
            'earnings' => 2300,
        ])->compute();

        $this->assertSame(33.35, $result);
    }

    public function testMedicareWithAdditionalTax()
    {
        $result = $this->app->makeWith(Medicare::class, [
            'earnings' => 2300,
            'ytd_earnings' => 200000,
        ])->compute();

        $this->assertSame(54.05, $result);
    }

    public function testMedicareEmployer()
    {
        $result = $this->app->makeWith(MedicareEmployer::class, [
            'earnings' => 2300,
            'ytd_earnings' => 200000,
        ])->compute();

        $this->assertSame(33.35, $result);
    }

    public function testCaseStudy1()
    {
        $result = $this->app->makeWith(Medicare::class, [
            'earnings' => 66.68,
        ])->compute();

        $this->assertSame(0.97, $result);
    }
}
