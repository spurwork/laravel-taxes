<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalIncome\V20240101;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\TaxManager;
use Appleton\Taxes\Classes\WorkerTaxes\WageManager;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome as BaseFederalIncome;
use Appleton\Taxes\Countries\US\FederalIncome\V20240101\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Tests verified with the paycheck calculator at:
 * https://adpvantage.adp.com/static/v3.6.0.457/paas/portlets/ipay/calculators/salaryPaycheckCalculator.html
 * (occasionally a cent off from the raw math due to rounding)
 */
class FederalIncomeTest extends TestCase
{
    /**
     * @dataProvider bracketJointData
     */
    public function testTaxBracketJoint(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                ['filing_status' => BaseFederalIncome::FILING_JOINTLY],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketJointData(): array
    {
        // standard deduction is 12900
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 249, // (48 + 12900) / 52
                'expected' => 0, // (((48 - 0) * 0) + 0) / 52
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 561, // (16276 + 12900) / 52
                'expected' => 0, // (((16276 - 0) * 0) + 0) / 52
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 562, // (16324 + 12900) / 52
                'expected' => 0.05, // (((16324 - 16300) * 0.1) + 0) / 52
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 1007, // (39464 + 12900) / 52
                'expected' => 44.55, // (((39464 - 16300) * 0.1) + 0) / 52
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 1008, // (39516 + 12900) / 52
                'expected' => 44.65, // (((39516 - 39500) * 0.12) + 2320) / 52
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 2374, // (110548 + 12900) / 52
                'expected' => 208.57, // (((110548 - 39500) * 0.12) + 2320) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 2376, // (110652 + 12900) / 52
                'expected' => 208.91, // (((110652 - 110600) * 0.22) + 10852) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 4427, // (217304 + 12900) / 52
                'expected' => 660.13, // (((217304 - 110600) * 0.22) + 10852) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 4428, // (217356 + 12900) / 52
                'expected' => 660.35, // (((217356 - 217350) * 0.24) + 34337) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 7944, // (400188 + 12900) / 52
                'expected' => 1504.19, // (((400188 - 217350) * 0.24) + 34337) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 7945, // (400240 + 12900) / 52
                'expected' => 1504.50, // (((400240 - 400200) * 0.32) + 78221) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 9935, // (503720 + 12900) / 52
                'expected' => 2141.30, // (((503720 - 400200) * 0.32) + 78221) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 9936, // (503772 + 12900) / 52
                'expected' => 2141.63, // (((503772 - 503750) * 0.35) + 111357) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 14623, // (747496 + 12900) / 52
                'expected' => 3782.08, // (((747496 - 503750) * 0.35) + 111357) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 14624, // (747548 + 12900) / 52
                'expected' => 3782.45, // (((747548 - 747500) * 0.37) + 196669.5) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 20000, // (1027100 + 12900) / 52
                'expected' => 5771.57, // (((1027100 - 747500) * 0.37) + 196669.5) / 52
            ]],
        ];
    }

    /**
     * @dataProvider bracketSingleData
     */
    public function testTaxBracketSingle(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                ['filing_status' => BaseFederalIncome::FILING_SINGLE],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketSingleData(): array
    {
        // standard deduction is 8600
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 166, // (32 + 8600) / 52
                'expected' => 0, // (((32 - 0) * 0) + 0) / 52)
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 280, // (5960 + 8600) / 52
                'expected' => 0, // (((5960 - 0) * 0) + 0) / 52)
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 281, // (6012 + 8600) / 52
                'expected' => 0.02, // (((6012 - 6000) * 0.1) + 0) / 52)
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 503, // (17556 + 8600) / 52
                'expected' => 22.22, // (((17556 - 6000) * 0.1) + 0) / 52)
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 504, // (17608 + 8600) / 52
                'expected' => 22.33, // (((17608 - 17600) * 0.12) + 1160) / 52)
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 1187, // (53124 + 8600) / 52
                'expected' => 104.29, // (((53124 - 17600) * 0.12) + 1160) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 1188, // (53176 + 8600) / 52
                'expected' => 104.46, // (((53176 - 53150) * 0.22) + 5426) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 2213, // (106476 + 8600) / 52
                'expected' => 329.96, // (((106476 - 53150) * 0.22) + 5426) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 2214, // (106528 + 8600) / 52
                'expected' => 330.18, // (((106528 - 106525) * 0.24) + 17168.5) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 3972, // (197944 + 8600) / 52
                'expected' => 752.10, // (((197944 - 106525) * 0.24) + 17168.5) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 3973, // (197996 + 8600) / 52
                'expected' => 752.41, // (((197996 - 197950) * 0.32) + 39110.5) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 4967, // (249684 + 8600) / 52
                'expected' => 1070.49, // (((249684 - 197950) * 0.32) + 39110.5) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 4968, // (249736 + 8600) / 52
                'expected' => 1070.81, // (((249736 - 249725) * 0.35) + 55678.5) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 11999, // (615348 + 8600) / 52
                'expected' => 3531.66, // (((615348 - 249725) * 0.35) + 55678.5) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 12000, // (615400 + 8600) / 52
                'expected' => 3532.03, // (((615400 - 615350) * 0.37) + 183647.25) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 20000, // (1031400 + 8600) / 52
                'expected' => 6492.03, // (((1031400 - 615350) * 0.37) + 183647.25) / 52
            ]],
        ];
    }

    /**
     * @dataProvider bracketHeadOfHouseholdData
     */
    public function testTaxBracketHeadOfHousehold(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                ['filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketHeadOfHouseholdData(): array
    {
        // standard deduction is 8600
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 166, // (32 + 8600) / 52
                'expected' => 0, // (((32 - 0) * 0) + 0) / 52)
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 421, // (13292 + 8600) / 52
                'expected' => 0, // (((13292 - 0) * 0) + 0) / 52)
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 422, // (13344 + 8600) / 52
                'expected' => 0.08, // (((13344 - 13300) * 0.1) + 0) / 52)
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 739, // (29828 + 8600) / 52
                'expected' => 31.78, // (((29828 - 13300) * 0.1) + 0) / 52)
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 740, // (29880 + 8600) / 52
                'expected' => 31.90, // (((29880 - 29850) * 0.12) + 1655) / 52)
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 1634, // (76368 + 8600) / 52
                'expected' => 139.18, // (((76368 - 29850) * 0.12) + 1655) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 1635, // (76420 + 8600) / 52
                'expected' => 139.33, // (((76420 - 76400) * 0.22) + 7241) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 2353, // (113756 + 8600) / 52
                'expected' => 297.29, // (((113756 - 76400) * 0.22) + 7241) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 2354, // (113808 + 8600) / 52
                'expected' => 297.52, // (((113808 - 113800) * 0.24) + 15469) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 4112, // (205224 + 8600) / 52
                'expected' => 719.44, // (((205224 - 113800) * 0.24) + 15469) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 4113, // (205276 + 8600) / 52
                'expected' => 719.72, // (((205276 - 205250) * 0.32) + 37417) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 5107, // (256964 + 8600) / 52
                'expected' => 1037.80, // (((256964 - 205250) * 0.32) + 37417) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 5108, // (257016 + 8600) / 52
                'expected' => 1038.13, // (((257016 - 257000) * 0.35) + 53977) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 12139, // (622628 + 8600) / 52
                'expected' => 3498.98, // (((622628 - 257000) * 0.35) + 53977) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 12140, // (622680 + 8600) / 52
                'expected' => 3499.34, // (((622680 - 622650) * 0.37) + 181954.5) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 20000, // (1031400 + 8600) / 52
                'expected' => 6407.54, // (((1031400 - 622650) * 0.37) + 181954.5) / 52
            ]],
        ];
    }

    /**
     * @dataProvider bracketStep2JointData
     */
    public function testTaxBracketStep2Joint(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                [
                    'filing_status' => BaseFederalIncome::FILING_JOINTLY,
                    'step_2_checked' => true,
                ],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketStep2JointData(): array
    {
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 10, // 520 / 52
                'expected' => 0, // (((520 - 0) * 0) + 0) / 52
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 280, // 14560 / 52
                'expected' => 0, // (((14560 - 0) * 0) + 0) / 52
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 281, // 14612 / 52
                'expected' => 0.02, // (((14612 - 14600) * 0.1) + 0) / 52
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 503, // 26156 / 52
                'expected' => 22.22, // (((26156 - 14600) * 0.1) + 0) / 52
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 504, // 26208 / 52
                'expected' => 22.33, // (((26208 - 26200) * 0.12) + 1160) / 52
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 1187, // 61724 / 52
                'expected' => 104.29, // (((61724 - 26200) * 0.12) + 1160) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 1188, // 61776 / 52
                'expected' => 104.46, // (((61776 - 61750) * 0.22) + 5426) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 2213, // 115076 / 52
                'expected' => 329.96, // (((115076 - 61750) * 0.22) + 5426) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 2214, // 115128 / 52
                'expected' => 330.18, // (((115128 - 115125) * 0.24) + 17168.5) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 3972, // 206544 / 52
                'expected' => 752.1, // (((206544 - 115125) * 0.24) + 17168.5) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 3973, // 206596 / 52
                'expected' => 752.41, // (((206596 - 206550) * 0.32) + 39110.5) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 4967, // 258284 / 52
                'expected' => 1070.49, // (((258284 - 206550) * 0.32) + 39110.5) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 4968, // 258336 / 52
                'expected' => 1070.81, // (((258336 - 258325) * 0.35) + 55678.5) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 7311, // 380172 / 52
                'expected' => 1890.86, // (((380172 - 258325) * 0.35) + 55678.5) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 7312, // 380224 / 52
                'expected' => 1891.22, // (((380224 - 380200) * 0.37) + 98334.75) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 10000, // 520000 / 52
                'expected' => 2885.78, // (((520000 - 380200) * 0.37) + 98334.75) / 52
            ]],
        ];
    }

    /**
     * @dataProvider bracketStep2SingleData
     */
    public function testTaxBracketStep2Single(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                [
                    'filing_status' => BaseFederalIncome::FILING_SINGLE,
                    'step_2_checked' => true,
                ],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketStep2SingleData(): array
    {
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 10, // 520 / 52
                'expected' => 0, // (((520 - 0) * 0) + 0) / 52
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 140, // 7280 / 52
                'expected' => 0, // (((7280 - 0) * 0) + 0) / 52
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 141, // 7332 / 52
                'expected' => 0.06, // (((7332 - 7300) * 0.1) + 0) / 52
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 251, // 13052 / 52
                'expected' => 11.06, // (((13052 - 7300) * 0.1) + 0) / 52
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 252, // 13104 / 52
                'expected' => 11.16, // (((13104 - 13100) * 0.12) + 580) / 52
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 593, // 30836 / 52
                'expected' => 52.08, // (((30836 - 13100) * 0.12) + 580) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 594, // 30888 / 52
                'expected' => 52.23, // (((30888 - 30875) * 0.22) + 2713) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 1106, // 57512 / 52
                'expected' => 164.87, // (((57512 - 30875) * 0.22) + 2713) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 1107, // 57564 / 52
                'expected' => 165.09, // (((57564 - 57563) * 0.24) + 8584.25) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 1986, // 103272 / 52
                'expected' => 376.05, // (((103272 - 57563) * 0.24) + 8584.25) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 1987, // 103324 / 52
                'expected' => 376.36, // (((103324 - 103275) * 0.32) + 19555.25) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 2483, // 129116 / 52
                'expected' => 535.08, // (((129116 - 103275) * 0.32) + 19555.25) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 2484, // 129168 / 52
                'expected' => 535.40, // (((129168 - 129163) * 0.35) + 27839.25) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 5999, // 311948 / 52
                'expected' => 1765.65, // (((311948 - 129163) * 0.35) + 27839.25) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 6000, // 312000 / 52
                'expected' => 1766.02, // (((312000 - 311975) * 0.37) + 91823.63) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 10000, // 520000 / 52
                'expected' => 3246.02, // (((520000 - 311975) * 0.37) + 91823.63) / 52
            ]],
        ];
    }

    /**
     * @dataProvider bracketStep2HeadOfHouseholdData
     */
    public function testTaxBracketStep2HeadOfHousehold(array $parameters): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(array_merge(
                [
                    'filing_status' => BaseFederalIncome::FILING_HEAD_OF_HOUSEHOLD,
                    'step_2_checked' => true,
                ],
                $parameters,
            )),
            $this->makePayroll($parameters),
        );

        self::assertEquals($this->taxAmount($parameters['expected']), $tax_amount);
    }

    public static function bracketStep2HeadOfHouseholdData(): array
    {
        return [
            '0_percent_bracket_low' => [[
                'earnings' => 10, // 520 / 52
                'expected' => 0, // (((520 - 0) * 0) + 0) / 52
            ]],
            '0_percent_bracket_end' => [[
                'earnings' => 210, // 10920 / 52
                'expected' => 0, // (((10920 - 0) * 0) + 0) / 52
            ]],
            '10_percent_bracket_start' => [[
                'earnings' => 211, // 10972 / 52
                'expected' => 0.04, // (((10972 - 10950) * 0.1) + 0) / 52
            ]],
            '10_percent_bracket_end' => [[
                'earnings' => 369, // 19188 / 52
                'expected' => 15.84, // (((19188 - 10950) * 0.1) + 0) / 52
            ]],
            '12_percent_bracket_start' => [[
                'earnings' => 370, // 19240 / 52
                'expected' => 15.95, // (((19240 - 19225) * 0.12) + 827.5) / 52
            ]],
            '12_percent_bracket_end' => [[
                'earnings' => 817, // 42484 / 52
                'expected' => 69.59, // (((42484 - 19225) * 0.12) + 827.5) / 52
            ]],
            '22_percent_bracket_start' => [[
                'earnings' => 818, // 42536 / 52
                'expected' => 69.78, // (((42536 - 42500) * 0.22) + 3620.5) / 52
            ]],
            '22_percent_bracket_end' => [[
                'earnings' => 1176, // 61152 / 52
                'expected' => 148.54, // (((61152 - 42500) * 0.22) + 3620.5) / 52
            ]],
            '24_percent_bracket_start' => [[
                'earnings' => 1177, // 61204 / 52
                'expected' => 148.76, // (((61204 - 61200) * 0.24) + 7734.5) / 52
            ]],
            '24_percent_bracket_end' => [[
                'earnings' => 2056, // 106912 / 52
                'expected' => 359.72, // (((106912 - 61200) * 0.24) + 7734.5) / 52
            ]],
            '32_percent_bracket_start' => [[
                'earnings' => 2057, // 106964 / 52
                'expected' => 360.02, // (((106964 - 106925) * 0.32) + 18708.5) / 52
            ]],
            '32_percent_bracket_end' => [[
                'earnings' => 2553, // 132756 / 52
                'expected' => 518.74, // (((132756 - 106925) * 0.32) + 18708.5) / 52
            ]],
            '35_percent_bracket_start' => [[
                'earnings' => 2554, // 132808 / 52
                'expected' => 519.06, // (((132808 - 132800) * 0.35) + 26988.5) / 52
            ]],
            '35_percent_bracket_end' => [[
                'earnings' => 6069, // 315588 / 52
                'expected' => 1749.31, // (((315588 - 132800) * 0.35) + 26988.5) / 52
            ]],
            '37_percent_bracket_start' => [[
                'earnings' => 6070, // 315640 / 52
                'expected' => 1749.67, // (((315640 - 315625) * 0.37) + 90977.25) / 52
            ]],
            '37_percent_bracket_high' => [[
                'earnings' => 10000, // 520000 / 52
                'expected' => 3203.77, // (((520000 - 315625) * 0.37) + 90977.25) / 52
            ]],
        ];
    }

    public function testTaxBracket2019Allowances(): void
    {
        // annual wages = 1000 × 52 = 52000
        // dependent deduction amount = 4300

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation([
                'form_version' => '2019',
                'exemptions' => 0,
            ]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            101.69, // 12% bracket: (((52000 - 17600 - (0 * 4300)) * 0.12) + 1160) / 52
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation([
                'form_version' => '2019',
                'exemptions' => 1,
            ]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            91.77, // 12% bracket: (((52000 - 17600 - (1 * 4300)) * 0.12) + 1160) / 52
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation([
                'form_version' => '2019',
                'exemptions' => 2,
            ]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            81.84, // 12% bracket: (((52000 - 17600 - (2 * 4300)) * 0.12) + 1160) / 52
            $tax_amount,
        );
    }

    public function testOtherIncome(): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['other_income' => 0]),
            $this->makePayroll(['earnings' => 1010]) // ((1000 × 52) + 520) / 52
        );
        self::assertEquals(
            83.05, // 12% bracket: (((((1010 × 52) − 8600 + 0) - 17600) * 0.12) + 1160) / 52
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['other_income' => 520]),
            $this->makePayroll(['earnings' => 1000]),
        );
        self::assertEquals(
            83.05, // 12% bracket: (((((1000 × 52) − 8600 + 520) - 17600) * 0.12) + 1160) / 52
            $tax_amount,
        );
    }

    public function testOtherDeductions(): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['deductions' => 0]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            81.84, // 12% bracket: (((((1000 × 52) − 8600 - 0) - 17600) * 0.12) + 1160) / 52
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['deductions' => 100]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            81.62, // 12% bracket: (((((1000 × 52) − 8600 - 100) - 17600) * 0.12) + 1160) / 52
            $tax_amount,
        );
    }

    public function testDependents(): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['dependents_deduction_amount' => 0]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            81.84, // 12% bracket: (((((1000 × 52) − 8600) - 17600) * 0.12) + 1160 - 0) / 52
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['dependents_deduction_amount' => 100]),
            $this->makePayroll(['earnings' => 1000]),
        );
        self::assertEquals(
            79.92, // 12% bracket: (((((1000 × 52) − 8600) - 17600) * 0.12) + 1160 - 100) / 52
            $tax_amount,
        );
    }

    public function testAdditionalWithholding(): void
    {
        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['extra_withholding' => 0]),
            $this->makePayroll(['earnings' => 1000])
        );
        self::assertEquals(
            81.84, // 12% bracket: ((((((1000 × 52) − 8600) - 17600) * 0.12) + 1160) / 52) + 0
            $tax_amount,
        );

        $tax_amount = $this->computeTaxAmount(
            $this->makeTaxInformation(['extra_withholding' => 100]),
            $this->makePayroll(['earnings' => 1000]),
        );
        self::assertEquals(
            181.85, // 12% bracket: ((((((1000 × 52) − 8600) - 17600) * 0.12) + 1160) / 52) + 100
            $tax_amount,
        );
    }

    /** @noinspection PhpUndefinedFieldInspection */
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
                'start_date' => Carbon::parse('2024-01-01'),
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

    private function taxAmount(float $input): float
    {
        return round(intval($input * 100) / 100, 2);
    }
}
