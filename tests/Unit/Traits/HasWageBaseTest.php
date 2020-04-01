<?php

namespace Appleton\Taxes\Tests\Unit\Traits;

use Appleton\Taxes\Tests\Unit\Classes\WorkerTaxes\Taxes\StateTax1;
use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Appleton\Taxes\Traits\HasWageBase;
use Illuminate\Database\Eloquent\Collection;

class HasWageBaseTest extends UnitTestCase
{
    public function testHasWageBase()
    {
        $mock = new class {
            use HasWageBase;

            const WAGE_BASE = 100;
            const TAX_RATE = 0.001;
            const WITHHELD = false;

            public $payroll;

            public function __construct()
            {
                $this->payroll = new class {
                    public $earnings = 100;
                    public $ytd_earnings = 90;

                    public function getEarnings()
                    {
                        return $this->earnings;
                    }

                    public function getYtdTaxableWages()
                    {
                        return $this->ytd_earnings;
                    }

                    public function getTaxClass()
                    {
                        return StateTax1::class;
                    }
                };
            }
        };

        $this->assertSame(0.01, $mock->compute(Collection::make([])));
    }
}
