<?php

namespace Appleton\Taxes\Unit\Countries\US\Vermont;

use Appleton\Taxes\Countries\US\Vermont\VermontIncome\VermontIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Vermont\VermontIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class VermontIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testVermontIncome(string $filing_status, int $allowances, int $additional_withholding,
                                      int $federal_additional_withholding, bool $exempt,
                                      int $earnings, int $supplemental_earnings, ?float $result): void
    {
        Carbon::setTestNow('2019-01-01');

        VermontIncomeTaxInformation::forUser($this->user)->update([
            'filing_status' => $filing_status,
            'allowances' => $allowances,
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
        ]);

        FederalIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $federal_additional_withholding,
        ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $supplemental_earnings) {
            $taxes->setHomeLocation($this->getLocation('us.vermont'));
            $taxes->setWorkLocation($this->getLocation('us.vermont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setSupplementalEarnings($supplemental_earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(VermontIncome::class));
    }

    public function provideTestData(): array
    {
        // [$filing_status, $allowances, $additional_withholding, $federal_additional_withholding, $exempt, $earnings, $result]
        return [
            'test case 2' => [VermontIncome::FILING_SINGLE, 0, 0, 0, false, 300, 0, 8.06],
            'test case 3' => [VermontIncome::FILING_SINGLE, 2, 0, 0, false, 1000, 0, 26.55],
            'test case 4' => [VermontIncome::FILING_SINGLE, 2, 0, 0, false, 2500, 0, 129.87],
            'test case 6' => [VermontIncome::FILING_MARRIED_FILING_JOINTLY, 2, 0, 0, false, 1000, 0, 22.08],
            'test case 7' => [VermontIncome::FILING_MARRIED_FILING_JOINTLY, 0, 0, 0, false, 2000, 0, 78.94],
            'test case 8' => [VermontIncome::FILING_MARRIED_FILING_JOINTLY, 2, 0, 0, false, 2000, 0, 68.15],
            'test case 9' => [VermontIncome::FILING_SINGLE, 0, 0, 0, false, 50, 0, null],
            'additional withholding' => [VermontIncome::FILING_SINGLE, 0, 10, 0, false, 300, 0, 18.06],
            'federal additional withholding' => [VermontIncome::FILING_SINGLE, 0, 10, 10, false, 300, 0, 21.06],
            'supplemental earnings' => [VermontIncome::FILING_SINGLE, 0, 0, 0, false, 300, 10, 7.79],
            'exempt' => [VermontIncome::FILING_SINGLE, 0, 0, 0, true, 300, 0, null],
        ];
    }
}
