<?php

namespace Appleton\Taxes\Unit\Countries\US\Nevada;

use Appleton\Taxes\Classes\PayrollLiabilities;
use Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\NevadaGrossPayrollEmployer;
use Carbon\Carbon;
use TestCase;

class NevadaGrossPayrollEmployerTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testSanFranciscoPayrollEmployer(int $wages,
                                                    int $qtd_wages,
                                                    ?float $expected_amount,
                                                    ?int $expected_wages): void
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
        use ($wages, $qtd_wages) {
            $payroll_liabilities->setWorkLocation($this->getLocation('us.nevada'));
            $payroll_liabilities->setWages($wages);
            $payroll_liabilities->setYtdWages(0);
            $payroll_liabilities->setQtdWages($qtd_wages);
            $payroll_liabilities->setYtdLiabilities(0);
        });

        self::assertThat($results->getLiability(NevadaGrossPayrollEmployer::class), self::identicalTo($expected_amount));
        self::assertThat($results->getWages(NevadaGrossPayrollEmployer::class), self::identicalTo($expected_wages));
    }

    /**
     * @return array {
     * @type array {
     * @type int $wages
     * @type int $qtd_wages
     * @type ?float $expected_amount
     * @type ?int $expected_wages
     *     }
     * }
     */
    public function dataProvider(): array
    {
        return [
            'with qtd wages under start' => [100, 4999800, null, null],
            'with qtd wages equal start' => [100, 4999900, null, null],
            'with qtd wages over start' => [100, 4999999, 2, 100],
            'wages under start' => [4999900, 0, null, null, 4999900],
            'wages equal start' => [5000000, 0, null, null, 5000000],
            'wages over start' => [5000100, 0, 2, 5000100],
            'combined wages' => [3000000, 3000000, 14750, 3000000],
        ];
    }
}
