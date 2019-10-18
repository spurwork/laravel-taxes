<?php

namespace Appleton\Taxes\Unit\Countries\US\California;

use Appleton\Taxes\Classes\PayrollLiabilities\PayrollLiabilities;
use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\SanFranciscoPayrollExpenseEmployer;
use Carbon\Carbon;
use TestCase;

class SanFranciscoPayrollExpenseEmployerTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testSanFranciscoPayrollEmployer(int $wages,
                                                    int $ytd_wages,
                                                    ?float $expected_amount,
                                                    ?int $expected_wages): void
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
        use ($wages, $ytd_wages) {
            $payroll_liabilities->setWorkLocation($this->getLocation('us.california.san_francisco'));
            $payroll_liabilities->setWages($wages);
            $payroll_liabilities->setQtdWages(0);
            $payroll_liabilities->setYtdWages($ytd_wages);
            $payroll_liabilities->setYtdLiabilities(0);
        });

        self::assertThat($results->getLiability(SanFranciscoPayrollExpenseEmployer::class), self::identicalTo($expected_amount));
        self::assertThat($results->getWages(SanFranciscoPayrollExpenseEmployer::class), self::identicalTo($expected_wages));
    }

    /**
     * @return array {
     * @type array {
     * @type int $wages
     * @type int $ytd_wages
     * @type ?float $expected_amount
     * @type ?int $expected_wages
     *     }
     * }
     */
    public function dataProvider(): array
    {
        return [
            'with ytd wages under start' => [100, 29999899, null, null],
            'with ytd wages equal start' => [100, 29999900, null, null],
            'with ytd wages over start' => [100, 29999999, 1, 100],
            'wages under start' => [29999000, 0, null, null, 29999000],
            'wages equal start' => [30000000, 0, null, null, 30000000],
            'wages over start' => [30000100, 0, 1, 30000100],
            'combined wages' => [20000000, 20000000, 38000, 20000000],
        ];
    }
}
