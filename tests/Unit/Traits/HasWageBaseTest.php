<?php

namespace Appleton\Taxes\Traits;

class HasWageBaseTest extends \TestCase
{
    public function testHasWageBase()
    {
        $mock = $this->getMockForTrait(HasWageBase::class);
        $mock->payroll = new \stdClass();
        $mock->payroll->earnings = 1;
        $mock->payroll->ytd_earnings = 95;
        $mock->wage_base = 100;

        $this->assertSame(1, $mock->getBaseEarnings());
    }
}
