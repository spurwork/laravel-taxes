<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20210101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Countries\US\FederalIncome\V20210101\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class FederalIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testTax(array $parameters): void
    {
        $wage_manager = Mockery::mock(WageManager::class);
        $tax_manager = Mockery::mock(TaxManager::class);
        $tax_information = Mockery::mock(FederalIncomeTaxInformation::class)->makePartial();
        $tax_information->form_version = $parameters['form_version'] ?? '2020';
        $tax_information->exempt = $parameters['exempt'] ?? false;
        $tax_information->step_2_checked = $parameters['step_2_checked'] ?? false;
        $tax_information->filing_status = $parameters['filing_status'] ?? BaseFederalIncome::FILING_SINGLE;
        $tax_information->exemptions = $parameters['exemptions'] ?? 0;
        $tax_information->dependents_deduction_amount = $parameters['dependents_amount'] ?? 0;
        $tax_information->other_income = $parameters['other_income'] ?? 0;
        $tax_information->extra_withholding = $parameters['additional_withholding'] ?? 0;
        $tax_information->additional_withholding = $parameters['additional_withholding'] ?? 0;

        $payroll = new Payroll([
            'user' => Mockery::mock(User::class),
            'start_date' => Carbon::now(),
            'pay_periods' => 52,
            'total_earnings' => $parameters['earnings'],
            'earnings' => $parameters['earnings'],
            'exempted_earnings' => 0,
        ], $wage_manager, $tax_manager);

        $tax_amount = (new FederalIncome($tax_information, $payroll))->compute(Collection::empty());
        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public function provideTestData(): array
    {
        return [
            'married' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => 1000,
                'expected' => 54.42,
            ]],
            'single' => [[
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'earnings' => 1000,
                'expected' => 87.21,
            ]],
            'head of household' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'expected' => 71.15,
            ]],
            'dependants' => [[
                'earnings' => 1000,
                'dependents_amount' => 1000,
                'expected' => 67.98,
            ]],
            'other income' => [[
                'earnings' => 1000,
                'other_income' => 12000,
                'expected' => 135.91,
            ]],
            'additional withholding' => [[
                'earnings' => 1000,
                'additional_withholding' => 12,
                'expected' => 99.21,
            ]],
            'with step 2' => [[
                'step_2_checked' => true,
                'earnings' => 1000,
                'expected' => 153.54,
            ]],
            '2019 married' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => 1000,
                'expected' => 84.19,
            ]],
            '2019 single' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'earnings' => 1000,
                'expected' => 121.52,
            ]],
            '2019 head of household' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'expected' => 121.52,
            ]],
            '2019 dependants' => [[
                'form_version' => '2019',
                'earnings' => 1000,
                'exemptions' => 2,
                'expected' => 87.21,
            ]],
            '2019 additional withholding' => [[
                'form_version' => '2019',
                'earnings' => 1000,
                'additional_withholding' => 12,
                'expected' => 133.52,
            ]],
            'married bracket 1' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (10000 + 12900) / 52,
                'expected' => 0.0,
            ]],
            'married bracket 2' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (30000 + 12900) / 52,
                'expected' => 34.23,
            ]],
            'married bracket 3' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (80000 + 12900) / 52,
                'expected' => 148.80,
            ]],
            'married bracket 4' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (150000 + 12900) / 52,
                'expected' => 419.48,
            ]],
            'married bracket 5' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (300000 + 12900) / 52,
                'expected' => 1098.34,
            ]],
            'married bracket 6' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (400000 + 12900) / 52,
                'expected' => 1649.03,
            ]],
            'married bracket 7' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (500000 + 12900) / 52,
                'expected' => 2304.20,
            ]],
            'married bracket 8' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => (700000 + 12900) / 52,
                'expected' => 3673.24,
            ]],
            'married with step 2 bracket 1' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 10000 / 52,
                'expected' => 0.0,
            ]],
            'married with step 2 bracket 2' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 20000 / 52,
                'expected' => 14.32,
            ]],
            'married with step 2 bracket 3' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 40000 / 52,
                'expected' => 59.51,
            ]],
            'married with step 2 bracket 4' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 75000 / 52,
                'expected' => 182.45,
            ]],
            'married with step 2 bracket 5' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 100000 / 52,
                'expected' => 288.63,
            ]],
            'married with step 2 bracket 6' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 200000 / 52,
                'expected' => 784.82,
            ]],
            'married with step 2 bracket 7' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 300000 / 52,
                'expected' => 1445.22,
            ]],
            'married with step 2 bracket 8' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'step_2_checked' => true,
                'earnings' => 400000 / 52,
                'expected' => 2146.49,
            ]],
            'single bracket 1' => [[
                'earnings' => (2000 + 8600) / 52,
                'expected' => 0.0,
            ]],
            'single bracket 2' => [[
                'earnings' => (10000 + 8600) / 52,
                'expected' => 11.63,
            ]],
            'single bracket 3' => [[
                'earnings' => (30000 + 8600) / 52,
                'expected' => 56.28,
            ]],
            'single bracket 4' => [[
                'earnings' => (50000 + 8600) / 52,
                'expected' => 113.06,
            ]],
            'single bracket 5' => [[
                'earnings' => (100000 + 8600) / 52,
                'expected' => 328.32,
            ]],
            'single bracket 6' => [[
                'earnings' => (200000 + 8600) / 52,
                'expected' => 837.75,
            ]],
            'single bracket 7' => [[
                'earnings' => (400000 + 8600) / 52,
                'expected' => 2176.18,
            ]],
            'single bracket 8' => [[
                'earnings' => (600000 + 8600) / 52,
                'expected' => 3550.20,
            ]],
            'single with step 2 bracket 1' => [[
                'step_2_checked' => true,
                'earnings' => 5000 / 52,
                'expected' => 0.0,
            ]],
            'single with step 2 bracket 2' => [[
                'step_2_checked' => true,
                'earnings' => 10000 / 52,
                'expected' => 7.16,
            ]],
            'single with step 2 bracket 3' => [[
                'step_2_checked' => true,
                'earnings' => 20000 / 52,
                'expected' => 29.75,
            ]],
            'single with step 2 bracket 4' => [[
                'step_2_checked' => true,
                'earnings' => 30000 / 52,
                'expected' => 59.49
            ]],
            'single with step 2 bracket 5' => [[
                'step_2_checked' => true,
                'earnings' => 50000 / 52,
                'expected' => 144.31,
            ]],
            'single with step 2 bracket 6' => [[
                'step_2_checked' => true,
                'earnings' => 100000 / 52,
                'expected' => 392.41,
            ]],
            'single with step 2 bracket 7' => [[
                'step_2_checked' => true,
                'earnings' => 200000 / 52,
                'expected' => 1059.14,
            ]],
            'single with step 2 bracket 8' => [[
                'step_2_checked' => true,
                'earnings' => 300000 / 52,
                'expected' => 1744.50,
            ]],
            'head of household bracket 1' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (5000 + 8600) / 52,
                'expected' => 0.0,
            ]],
            'head of household bracket 2' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (20000 + 8600) / 52,
                'expected' => 18.84,
            ]],
            'head of household bracket 3' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (50000 + 8600) / 52,
                'expected' => 86.38,
            ]],
            'head of household bracket 4' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (75000 + 8600) / 52,
                'expected' => 164.46,
            ]],
            'head of household bracket 5' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (100000 + 8600) / 52,
                'expected' => 271.55,
            ]],
            'head of household bracket 6' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (200000 + 8600) / 52,
                'expected' => 771.40,
            ]],
            'head of household bracket 7' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (400000 + 8600) / 52,
                'expected' => 2106.25,
            ]],
            'head of household bracket 8' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => (600000 + 8600) / 52,
                'expected' => 3477.86,
            ]],
            'head of household with step 2 bracket 1' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 5000 / 52,
                'expected' => 0.0,
            ]],
            'head of household with step 2 bracket 2' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 10000 / 52,
                'expected' => 1.15,
            ]],
            'head of household with step 2 bracket 3' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 20000 / 52,
                'expected' => 21.73,
            ]],
            'head of household with step 2 bracket 4' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 40000 / 52,
                'expected' => 74.61,
            ]],
            'head of household with step 2 bracket 5' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 75000 / 52,
                'expected' => 231.31,
            ]],
            'head of household with step 2 bracket 6' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 100000 / 52,
                'expected' => 359.24,
            ]],
            'head of household with step 2 bracket 7' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 200000 / 52,
                'expected' => 1024.18,
            ]],
            'head of household with step 2 bracket 8' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'step_2_checked' => true,
                'earnings' => 300000 / 52,
                'expected' => 1708.33,
            ]],
        ];
    }
}