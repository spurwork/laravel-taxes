<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Georgia\V20230101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\V20230101\GeorgiaIncome as GeorgiaIncome2023;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Mockery;
use PHPUnit\Framework\TestCase;

class GeorgiaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideBracketData
     */
    public function testTaxBrackets(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation($parameters),
            $this->makePayroll($parameters),
        );

        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public static function provideBracketData(): array
    {
        $brackets = [
            GeorgiaIncome::FILING_SINGLE => GeorgiaIncome2023::SINGLE_BRACKETS,
            GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING => GeorgiaIncome2023::BOTH_WORKING_BRACKETS,
            GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING => GeorgiaIncome2023::SINGLE_WORKING_BRACKETS,
            GeorgiaIncome::FILING_MARRIED_SEPARATE => GeorgiaIncome2023::BOTH_WORKING_BRACKETS,
            GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD => GeorgiaIncome2023::SINGLE_WORKING_BRACKETS,
        ];

        $expected = [
            GeorgiaIncome::FILING_SINGLE => [0.09, 0.33, 1.0, 1.97, 3.22, 4.97],
            GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING => [0.09, 0.28, 0.76, 1.44, 2.3, 3.82],
            GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING => [0.09, 0.38, 1.25, 2.50, 4.13, 7.09],
            GeorgiaIncome::FILING_MARRIED_SEPARATE => [0.09, 0.28, 0.76, 1.44, 2.3, 3.82],
            GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD => [0.09, 0.38, 1.24, 2.50, 4.13, 7.09],
        ];

        $arr = [];
        foreach ($brackets as $filing_status => $bracket) {
            foreach ($bracket as $index => $bracketValue) {
                $filing_status_name = match ($filing_status) {
                    GeorgiaIncome::FILING_SINGLE => 'single',
                    GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING => 'married_both_working',
                    GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING => 'married_one_working',
                    GeorgiaIncome::FILING_MARRIED_SEPARATE => 'married_separate',
                    GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD => 'head_of_household',
                };

                // calculate an amount that will put them in the correct bracket
                $annual_amount = $bracketValue[0]
                    + GeorgiaIncome2023::STANDARD_DEDUCTIONS[$filing_status]
                    + 500;
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
     * @dataProvider providePersonalAllowanceData
     */
    public function testPersonalAllowances(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation($parameters),
            $this->makePayroll($parameters),
        );

        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public static function providePersonalAllowanceData(): array
    {
        return [
            'single_no_allowances' => [[
                'earnings' => 1000,
                'expected' => 48.21,
            ]],
            'single_one_allowances' => [[
                'earnings' => 1000,
                'personal_allowances' => 1,
                'expected' => 45.22,
            ]],
            'single_two_allowances' => [[
                'earnings' => 1000,
                'personal_allowances' => 2,
                'expected' => 45.22,
            ]],
            'married_both_working_zero_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'earnings' => 1000,
                'expected' => 51.31,
            ]],
            'married_both_working_one_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'earnings' => 1000,
                'personal_allowances' => 1,
                'expected' => 47.22,
            ]],
            'married_both_working_two_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'earnings' => 1000,
                'personal_allowances' => 2,
                'expected' => 47.22,
            ]],
            'married_one_working_zero_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'earnings' => 1000,
                'expected' => 45.12,
            ]],
            'married_one_working_one_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'earnings' => 1000,
                'personal_allowances' => 1,
                'expected' => 41.03,
            ]],
            'married_one_working_two_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'earnings' => 1000,
                'personal_allowances' => 2,
                'expected' => 36.94,
            ]],
            'married_separate_zero_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'earnings' => 1000,
                'expected' => 51.31,
            ]],
            'married_separate_one_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'earnings' => 1000,
                'personal_allowances' => 1,
                'expected' => 47.22,
            ]],
            'married_separate_two_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'earnings' => 1000,
                'personal_allowances' => 2,
                'expected' => 47.22,
            ]],
            'head_of_household_zero_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'expected' => 47.00,
            ]],
            'head_of_household_one_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'personal_allowances' => 1,
                'expected' => 44.02,
            ]],
            'head_of_household_two_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'earnings' => 1000,
                'personal_allowances' => 2,
                'expected' => 44.02,
            ]],
        ];
    }

    /**
     * @dataProvider provideAllowanceData
     */
    public function testAllowances(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation($parameters),
            $this->makePayroll($parameters),
        );

        self::assertThat($tax_amount, self::identicalTo($parameters['expected']));
    }

    public static function provideAllowanceData(): array
    {
        return [
            'single_one_dependent' => [[
                'earnings' => 1000,
                'dependents' => 1,
                'expected' => 44.89,
            ]],
            'single_one_allowances' => [[
                'earnings' => 1000,
                'allowances' => 1,
                'expected' => 44.89,
            ]],
            'single_three_dependents' => [[
                'earnings' => 1000,
                'dependents' => 3,
                'expected' => 38.25,
            ]],
            'single_three_allowances' => [[
                'earnings' => 1000,
                'allowances' => 3,
                'expected' => 38.25,
            ]],
            'married_both_working_one_dependent' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'dependents' => 1,
                'earnings' => 1000,
                'expected' => 47.99,
            ]],
            'married_both_working_three_dependents' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'dependents' => 3,
                'earnings' => 1000,
                'expected' => 41.36,
            ]],
            'married_both_working_one_allowance' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'allowances' => 1,
                'earnings' => 1000,
                'expected' => 47.99,
            ]],
            'married_both_working_three_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'allowances' => 3,
                'earnings' => 1000,
                'expected' => 41.36,
            ]],
            'married_one_working_one_dependent' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'dependents' => 1,
                'earnings' => 1000,
                'expected' => 41.81,
            ]],
            'married_one_working_three_dependents' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'dependents' => 3,
                'earnings' => 1000,
                'expected' => 35.17,
            ]],
            'married_one_working_one_allowance' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'allowances' => 1,
                'earnings' => 1000,
                'expected' => 41.81,
            ]],
            'married_one_working_three_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'allowances' => 3,
                'earnings' => 1000,
                'expected' => 35.17,
            ]],
            'married_separate_one_dependent' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'dependents' => 1,
                'earnings' => 1000,
                'expected' => 47.99,
            ]],
            'married_separate_three_dependents' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'dependents' => 3,
                'earnings' => 1000,
                'expected' => 41.36,
            ]],
            'married_separate_one_allowance' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'allowances' => 1,
                'earnings' => 1000,
                'expected' => 47.99,
            ]],
            'married_separate_three_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_MARRIED_SEPARATE,
                'allowances' => 3,
                'earnings' => 1000,
                'expected' => 41.36,
            ]],
            'head_of_household_one_dependent' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'dependents' => 1,
                'earnings' => 1000,
                'expected' => 43.69,
            ]],
            'head_of_household_three_dependents' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'dependents' => 3,
                'earnings' => 1000,
                'expected' => 37.05,
            ]],
            'head_of_household_one_allowance' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'allowances' => 1,
                'earnings' => 1000,
                'expected' => 43.69,
            ]],
            'head_of_household_three_allowances' => [[
                'filing_status' => GeorgiaIncome::FILING_HEAD_OF_HOUSEHOLD,
                'allowances' => 3,
                'earnings' => 1000,
                'expected' => 37.05,
            ]],
        ];
    }

    private function makeTaxInformation(array $parameters): GeorgiaIncomeTaxInformation
    {
        $tax_information = Mockery::mock(GeorgiaIncomeTaxInformation::class)->makePartial();
        $tax_information->personal_allowances = $parameters['personal_allowances'] ?? 0;
        $tax_information->allowances = $parameters['allowances'] ?? 0;
        $tax_information->dependents = $parameters['dependents'] ?? 0;
        $tax_information->filing_status = $parameters['filing_status'] ?? GeorgiaIncome::FILING_SINGLE;
        $tax_information->exempt = $parameters['exempt'] ?? false;

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
        GeorgiaIncomeTaxInformation $tax_information,
        Payroll                     $payroll,
    ): float {
        return (new GeorgiaIncome2023($tax_information, $payroll))->compute(Collection::empty());
    }
}
