<?php

namespace Appleton\Taxes\Tests\Unit\Traits;

use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Appleton\Taxes\Traits\HasWageBase;

class HasWageBaseTest extends UnitTestCase
{
    public function testHasWageBase()
    {
        $mock = new class {
            use HasWageBase;

            const WAGE_BASE = 100;

            public $payroll;

            public function __construct()
            {
                $this->payroll = new class {
                    public $earnings = 1;
                    public $ytd_earnings = 95;
                    public function getEarnings()
                    {
                        return $this->earnings;
                    }
                    public function getYtdEarnings()
                    {
                        return $this->ytd_earnings;
                    }
                };
            }
        };

        $this->assertSame(1, $mock->getBaseEarnings());
    }
}
