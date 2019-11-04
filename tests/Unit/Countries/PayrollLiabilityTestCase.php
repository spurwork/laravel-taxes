<?php

namespace Appleton\Taxes\Tests\Unit\Countries;

use Appleton\Taxes\Classes\PayrollLiabilities\PayrollLiabilities;
use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Carbon\Carbon;

class PayrollLiabilityTestCase extends UnitTestCase
{
    protected $payroll_liabilities;

    public function setUp(): void
    {
        parent::setUp();
        $this->payroll_liabilities = app(PayrollLiabilities::class);
    }

    protected function validate(TestParameters $parameters): void
    {
        Carbon::setTestNow(Carbon::parse($parameters->getDate()));

        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
        use ($parameters) {
            $payroll_liabilities->setWorkLocation($this->getLocation($parameters->getHomeLocation()));
            $payroll_liabilities->setWages($parameters->getWagesInCents());
            $payroll_liabilities->setQtdWages($parameters->getQtdWagesInCents() ?? 0);
            $payroll_liabilities->setYtdWages($parameters->getYtdWagesInCents() ?? 0);
            $payroll_liabilities->setYtdLiabilities($parameters->getYtdLiabilitiesInCents() ?? 0);
        });

        if ($parameters->getExpectedAmountInCents() === null
            || $parameters->getExpectedAmountInCents() === 0) {
            self::assertNull($results->getLiability($parameters->getTaxClass()));
            return;
        }

        self::assertThat((int)$results->getLiability($parameters->getTaxClass()),
            self::identicalTo($parameters->getExpectedAmountInCents()));
        self::assertThat($results->getWages($parameters->getTaxClass()),
            self::identicalTo($parameters->getExpectedEarningsInCents()));
    }
}
