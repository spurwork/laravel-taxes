<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20230101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Countries\US\FederalIncome\V20230101\FederalIncome;
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
        $tax_amount = $this->computeTaxAmount($this->makeTaxInformation($parameters), $this->makePayroll($parameters));
        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public function provideTestData(): array
    {
        return [
            'tax_credit_more_than_wages' => [[
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'dependents_deduction_amount' => 2500,
                'earnings' => 500,
                'expected' => 0.0,
            ]],
            'married' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => 1000,
                'expected' => 47.62,
            ]],
            'single' => [[
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'earnings' => 1000,
                'expected' => 83.81,
            ]],
            'head_of_household' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'expected' => 65.95,
            ]],
            'step_2_married' => [[
                'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                'earnings' => 1000,
                'expected' => 83.81,
                'step_2_checked' => true,
            ]],
            'step_2_single' => [[
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'earnings' => 1000,
                'expected' => 145.58,
                'step_2_checked' => true,
            ]],
            'step_2_head_of_household' => [[
                'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'expected' => 115.43,
                'step_2_checked' => true,
            ]],
            '2019_married' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_MARRIED,
                'earnings' => 1000,
                'expected' => 77.38,
            ]],
            '2019_single' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_SINGLE,
                'earnings' => 1000,
                'expected' => 107.55,
            ]],
            '2019_separate' => [[
                'form_version' => '2019',
                'filing_status' => BaseFederalIncome::FILING_SEPERATE,
                'earnings' => 1000,
                'expected' => 107.55,
            ]],
            'other_income' => [[
                'earnings' => 1000,
                'other_income' => 1000,
                'expected' => 86.12,
            ]],
            'deductions' => [[
                'earnings' => 1000,
                'deductions' => 1000,
                'expected' => 81.50,
            ]],
            '2019_allowances' => [[
                'form_version' => '2019',
                'earnings' => 1000,
                'exemptions' => 2,
                'expected' => 83.81,
            ]],
            'dependant_deductions' => [[
                'earnings' => 1000,
                'dependents_deduction_amount' => 1000,
                'expected' => 64.58,
            ]],
            'extra_withholding' => [[
                'earnings' => 1000,
                'extra_withholding' => 25,
                'expected' => 108.81,
            ]],
            '2019_extra_withholding' => [[
                'form_version' => '2019',
                'earnings' => 1000,
                'additional_withholding' => 25,
                'expected' => 132.55,
            ]],
        ];
    }

    /**
     * @dataProvider provideBracket2020Data
     */
    public function testTaxBrackets2020(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount($this->makeTaxInformation($parameters), $this->makePayroll($parameters));
        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public function provideBracket2020Data(): array
    {
        $brackets = [
            BaseFederalIncome::FILING_JOINTLY => FederalIncome::BRACKETS_MARRIED,
            BaseFederalIncome::FILING_SINGLE => FederalIncome::BRACKETS_SINGLE,
            BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => FederalIncome::BRACKETS_HEAD_OF_HOUSEHOLD,
        ];

        // these values come from ADP's tax calculator using the weekly amount as the gross pay
        // https://adpvantage.adp.com/static/v3.6.0.457/paas/portlets/ipay/calculators/salaryPaycheckCalculator.html
        $expected = [
            BaseFederalIncome::FILING_JOINTLY => [0.0, 1.92, 44.62, 202.19, 631.15, 1433.23, 2038.72, 3595.61],
            BaseFederalIncome::FILING_SINGLE => [0.0, 1.92, 23.46, 103.21, 317.88, 719.69, 1022.72, 3357.85],
            BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => [0.0, 1.92, 32.50, 136.30, 286.88, 688.80, 991.85, 3326.80],
        ];

        $arr = [];
        foreach ($brackets as $filing_status => $bracket) {
            foreach ($bracket as $index => $bracketValue) {
                $filing_status_name = match ($filing_status) {
                    BaseFederalIncome::FILING_JOINTLY => 'married',
                    BaseFederalIncome::FILING_SINGLE => 'single',
                    BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => 'head_of_household',
                };

                // calculate an amount that will put them in the correct bracket after the step 2 credit
                $annual_amount = $bracketValue[0]
                    + ($filing_status === BaseFederalIncome::FILING_JOINTLY
                        ? FederalIncome::CREDIT_STEP_2_MARRIED
                        : FederalIncome::CREDIT_STEP_2_NOT_MARRIED)
                    + 1000;
                $weekly_amount = round($annual_amount / 52, 2);

                $arr["{$filing_status_name}_bracket_$index"] = [[
                    'filing_status' => $filing_status,
                    'earnings' => $weekly_amount,
                    'expected' => $expected[$filing_status][$index],
                ]];
            }
        }

        return $arr;
    }

    /**
     * @dataProvider provideBracket2020Step2Data
     */
    public function testTaxBrackets2020Step2(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(['step_2_checked' => true], $parameters)),
            $this->makePayroll($parameters),
        );
        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public function provideBracket2020Step2Data(): array
    {
        $brackets = [
            BaseFederalIncome::FILING_JOINTLY => FederalIncome::BRACKETS_MARRIED_STEP_2,
            BaseFederalIncome::FILING_SINGLE => FederalIncome::BRACKETS_SINGLE_STEP_2,
            BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => FederalIncome::BRACKETS_HEAD_OF_HOUSEHOLD_STEP_2,
        ];


        // these values come from ADP's tax calculator using the weekly amount as the gross pay
        // https://adpvantage.adp.com/static/v3.6.0.457/paas/portlets/ipay/calculators/salaryPaycheckCalculator.html
        $expected = [
            BaseFederalIncome::FILING_JOINTLY => [0.0, 1.92, 23.46, 103.21, 317.88, 719.69, 1022.72, 1801.36],
            BaseFederalIncome::FILING_SINGLE => [0.0, 1.92, 12.88, 53.72, 161.25, 362.92, 514.72, 1682.48],
            BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => [0.0, 1.92, 17.39, 70.27, 145.75, 347.47, 499.29, 1666.95],
        ];

        $arr = [];
        foreach ($brackets as $filing_status => $bracket) {
            foreach ($bracket as $index => $bracketValue) {
                $filing_status_name = match ($filing_status) {
                    BaseFederalIncome::FILING_JOINTLY => 'married',
                    BaseFederalIncome::FILING_SINGLE => 'single',
                    BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD => 'head_of_household',
                };

                // calculate an amount that will put them in the correct bracket
                $annual_amount = $bracketValue[0] + 1000;
                $weekly_amount = round($annual_amount / 52, 2);

                $arr["{$filing_status_name}_bracket_$index"] = [[
                    'filing_status' => $filing_status,
                    'earnings' => $weekly_amount,
                    'expected' => $expected[$filing_status][$index],
                ]];
            }
        }

        return $arr;
    }

    private function makeTaxInformation(array $parameters): FederalIncomeTaxInformation
    {
        $tax_information = Mockery::mock(FederalIncomeTaxInformation::class)->makePartial();
        $tax_information->form_version = $parameters['form_version'] ?? '2020';
        $tax_information->exempt = $parameters['exempt'] ?? false;
        $tax_information->step_2_checked = $parameters['step_2_checked'] ?? false;
        $tax_information->filing_status = $parameters['filing_status'] ?? BaseFederalIncome::FILING_SINGLE;
        $tax_information->exemptions = $parameters['exemptions'] ?? 0;
        $tax_information->deductions = $parameters['deductions'] ?? 0;
        $tax_information->dependents_deduction_amount = $parameters['dependents_deduction_amount'] ?? 0;
        $tax_information->other_income = $parameters['other_income'] ?? 0;
        $tax_information->extra_withholding = $parameters['extra_withholding'] ?? 0;
        $tax_information->additional_withholding = $parameters['additional_withholding'] ?? 0;

        return $tax_information;
    }

    private function makePayroll(array $parameters): Payroll
    {
        return new Payroll(
            [
                'user' => Mockery::mock(User::class),
                'start_date' => Carbon::parse('2023-01-01'),
                'pay_periods' => 52,
                'total_earnings' => $parameters['earnings'],
                'earnings' => $parameters['earnings'],
                'exempted_earnings' => 0,
            ],
            Mockery::mock(WageManager::class),
            Mockery::mock(TaxManager::class),
        );
    }

    private function computeTaxAmount(
        FederalIncomeTaxInformation $tax_information,
        Payroll                     $payroll,
    ): float {
        return (new FederalIncome($tax_information, $payroll))->compute(Collection::empty());
    }
}