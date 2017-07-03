<?php

namespace Appleton\Taxes\Traits;

class HasWageBaseTest extends \TestCase
{
    public function testHasWageBase()
    {
        $mock = $this->getMockForTrait(HasWageBase::class);
        $mock->earnings = 1;
        $mock->ytd_earnings = 95;
        $mock->wage_base = 100;

        $this->assertSame(1, $mock->getBaseEarnings());
    }
}
