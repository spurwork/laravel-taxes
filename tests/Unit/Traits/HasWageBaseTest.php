<?php

namespace Appleton\Taxes\Traits;

class HasWageBaseTest extends \TestCase
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
                };
            }
        };

        $this->assertSame(1, $mock->getBaseEarnings());
    }
}
