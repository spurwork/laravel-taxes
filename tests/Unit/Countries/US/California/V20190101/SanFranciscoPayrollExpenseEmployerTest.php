<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\California\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\SanFranciscoPayrollExpenseEmployer;
use Appleton\Taxes\Tests\Unit\Countries\PayrollLiabilityTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class SanFranciscoPayrollExpenseEmployerTest extends PayrollLiabilityTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.california.san_francisco';
    private const TAX_CLASS = SanFranciscoPayrollExpenseEmployer::class;

    /** @dataProvider dataProvider */
    public function testPayrollLiability(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function dataProvider(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS);

        return [
            'with ytd wages under start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999899)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages equal start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999900)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages over start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999999)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(99)
                    ->build(),
            ],
            'wages under start' => [
                $builder
                    ->setWagesInCents(29999000)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages equal start' => [
                $builder
                    ->setWagesInCents(30000000)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages over start' => [
                $builder
                    ->setWagesInCents(30000100)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'combined wages' => [
                $builder
                    ->setWagesInCents(20000000)
                    ->setYtdWagesInCents(20000000)
                    ->setExpectedAmountInCents(38000)
                    ->setExpectedEarningsInCents(10000000)
                    ->build(),
            ],
        ];
    }
//    /** @dataProvider dataProvider */
//    public function testSanFranciscoPayrollEmployer(int $wages,
//                                                    int $ytd_wages,
//                                                    ?float $expected_amount,
//                                                    ?int $expected_wages): void
//    {
//        self::markTestSkipped('need to convert');
//        Carbon::setTestNow(Carbon::parse('2019-01-01'));
//
//        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
//        use ($wages, $ytd_wages) {
//            $payroll_liabilities->setWorkLocation($this->getLocation('us.california.san_francisco'));
//            $payroll_liabilities->setWages($wages);
//            $payroll_liabilities->setQtdWages(0);
//            $payroll_liabilities->setYtdWages($ytd_wages);
//            $payroll_liabilities->setYtdLiabilities(0);
//        });
//
//        self::assertThat($results->getLiability(SanFranciscoPayrollExpenseEmployer::class), self::identicalTo($expected_amount));
//        self::assertThat($results->getWages(SanFranciscoPayrollExpenseEmployer::class), self::identicalTo($expected_wages));
//    }
//
//    /**
//     * @return array {
//     * @type array {
//     * @type int $wages
//     * @type int $ytd_wages
//     * @type ?float $expected_amount
//     * @type ?int $expected_wages
//     *     }
//     * }
//     */
//    public function dataProvider(): array
//    {
//        return [
//            'with ytd wages under start' => [100, 29999899, null, null],
//            'with ytd wages equal start' => [100, 29999900, null, null],
//            'with ytd wages over start' => [100, 29999999, 1, 100],
//            'wages under start' => [29999000, 0, null, null, 29999000],
//            'wages equal start' => [30000000, 0, null, null, 30000000],
//            'wages over start' => [30000100, 0, 1, 30000100],
//            'combined wages' => [20000000, 20000000, 38000, 20000000],
//        ];
//    }
}
