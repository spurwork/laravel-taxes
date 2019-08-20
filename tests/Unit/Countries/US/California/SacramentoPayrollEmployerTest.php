<?php

namespace Appleton\Taxes\Unit\Countries\US\California;

use Appleton\Taxes\Classes\PayrollLiabilities;
use Appleton\Taxes\Countries\US\California\SacramentoPayrollEmployer\SacramentoPayrollEmployer;
use Carbon\Carbon;
use TestCase;

class SacramentoPayrollEmployerTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testSacramentoPayrollEmployer(int $wages,
                                                  int $ytd_wages,
                                                  int $ytd_liabilities,
                                                  ?float $expected_amount,
                                                  ?int $expected_wages): void
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->payroll_liabilities->calculate(function (PayrollLiabilities $payroll_liabilities)
        use ($wages, $ytd_wages, $ytd_liabilities) {
            $payroll_liabilities->setWorkLocation($this->getLocation('us.california.sacramento'));
            $payroll_liabilities->setWages($wages);
            $payroll_liabilities->setYtdWages($ytd_wages);
            $payroll_liabilities->setYtdLiabilities($ytd_liabilities);
        });

        self::assertThat($results->getLiability(SacramentoPayrollEmployer::class), self::identicalTo($expected_amount));
        self::assertThat($results->getWages(SacramentoPayrollEmployer::class), self::identicalTo($expected_wages));
    }

    /**
     * @return array {
     * @type array {
     * @type int $wages
     * @type int $ytd_wages
     * @type int $ytd_liabilities
     * @type ?float $expected_amount
     * @type ?float $expected_wages
     *     }
     * }
     */
    public function dataProvider(): array
    {
        return [
            'no ytd wages' => [1000, 0, 0, 30.0, 1000],
            'with ytd wages under start' => [100, 999899, 0, null, null],
            'with ytd wages equal start' => [100, 999900, 0, null, null],
            'with ytd wages over start' => [100, 1000000, 0, .0004, 100],
            'wages under start' => [999800, 100, 0, null, null],
            'wages equal start' => [999900, 100, 0, null, null],
            'wages over start' => [1000000, 100, 0, 0.0004, 1000000],
            'with ytd liabilities under max' => [100, 1000000, 499800, .0004, 100],
            'with ytd liabilities equal max' => [100, 1000000, 499900, .0004, 100],
            'with ytd liabilities over max' => [100, 1000000, 500000, null, null],
            'liabilities under max' => [124999999900, 1000000, 0, 499999.9996, 124999999900],
            'liabilities equal max' => [125000000000, 1000000, 0, 500000.0, 125000000000],
            'liabilities over max' => [125000000100, 1000000, 0, 500000.0, 125000000100],
        ];
    }
}
