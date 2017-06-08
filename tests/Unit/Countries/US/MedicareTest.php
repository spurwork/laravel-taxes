<?php

namespace Appleton\Taxes\Countries\US;

use Appleton\Taxes\Countries\US;

class MedicareTest extends \TestCase
{
    public function testMedicare()
    {
        $taxes = $this->app->make(Medicare::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(33.35, $result);
    }

    public function testMedicareWithAdditionalTax()
    {
        $taxes = $this->app->make(Medicare::class);

        $result = $taxes
            ->withEarnings(2300)
            ->withYtdEarnings(200000)
            ->compute();

        $this->assertSame(54.05, $result);
    }

    public function testMedicareEmployer()
    {
        $taxes = $this->app->make(MedicareEmployer::class);

        $result = $taxes
            ->withEarnings(2300)
            ->compute();

        $this->assertSame(33.35, $result);
    }

    public function testCaseStudy1()
    {
        $taxes = $this->app->make(Medicare::class);

        $result = $taxes
            ->withEarnings(66.68)
            ->withYtdEarnings(0)
            ->compute();

        $this->assertSame(0.97, $result);
    }
}
