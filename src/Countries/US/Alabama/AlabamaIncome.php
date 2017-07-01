<?php

namespace Appleton\Taxes\Countries\US\Alabama;

use Appleton\Taxes\Classes\BaseIncomeTax;
use Appleton\Taxes\Countries\US\FederalIncome;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class AlabamaIncome extends BaseIncomeTax
{
    const TYPE = 'state';
    const WITHHELD = true;

    const FILING_ZERO = 0;
    const FILING_SINGLE = 1;
    const FILING_HEAD_OF_HOUSEHOLD = 2;
    const FILING_MARRIED = 3;
    const FILING_SEPERATE = 4;

    const SINGLE_BRACKETS = [
        [0, 0.02, 0],
        [500, 0.04, 10],
        [3000, 0.05, 110],
    ];

    const MARRIED_BRACKETS = [
        [0, 0.02, 0],
        [1000, 0.04, 20],
        [6000, 0.05, 220],
    ];

    const STANDARD_DEDUCTIONS = [
        self::FILING_SINGLE => [
            'base' => 20499.99,
            'amount' => 2500,
            'modifier' => [
                'amount' => 25,
                'per' => 500,
            ],
        ],
        self::FILING_SEPERATE => [
            'base' => 10249.99,
            'amount' => 3750,
            'modifier' => [
                'amount' => 88,
                'per' => 250,
            ]
        ],
        self::FILING_MARRIED => [
            'base' => 20499.99,
            'amount' => 7500,
            'modifier' => [
                'amount' => 175,
                'per' => 500,
            ]
        ],
        self::FILING_HEAD_OF_HOUSEHOLD => [
            'base' => 20499.99,
            'amount' => 4700,
            'modifier' => [
                'amount' => 135,
                'per' => 500,
            ]
        ],
    ];

    const PERSONAL_EXEMPTION_ALLOWANCES = [
        self::FILING_SINGLE => 1500,
        self::FILING_HEAD_OF_HOUSEHOLD => 3000,
        self::FILING_MARRIED => 3000,
        self::FILING_SEPERATE => 1500,
    ];

    const DEPENDENT_EXEMPTION_BRACKETS = [
        [0, 1000],
        [20000, 500],
        [100000, 300]
    ];

    protected $earnings;
    protected $federal_income_tax;
    protected $pay_periods;
    protected $user;
    protected $tax_information;

    public function __construct($earnings, $pay_periods, $tax_information = null, $user = null)
    {
        $this->earnings = $earnings;
        $this->federal_income_tax = app()->makeWith(FederalIncome::class, [
            'earnings' => $earnings,
            'pay_periods' => $pay_periods,
            'user' => $user,
        ])->compute();
        $this->pay_periods = $pay_periods;
        $this->user = $user;
        $this->tax_information = $this->resolveTaxInformation(AlabamaIncomeTaxInformation::class, $tax_information, $user);
    }

    public function getAdjustedEarnings()
    {
        $adjusted_earnings = ($this->earnings * $this->pay_periods) - ($this->federal_income_tax * $this->pay_periods);

        if ($this->tax_information->filing_status != self::FILING_ZERO) {
            $adjusted_earnings = $adjusted_earnings - $this->getPersonalDeducation() - $this->getPersonalExemptionAllowance() - $this->getDependentExemption();
        }

        return $adjusted_earnings;
    }

    public function getDependentExemption()
    {
        $gross_earnings = $this->earnings * $this->pay_periods;
        $dependent_exemption = $this->getTaxBracket($gross_earnings, self::DEPENDENT_EXEMPTION_BRACKETS);
        return $dependent_exemption[1] * $this->tax_information->dependents;
    }

    public function getPersonalDeducation()
    {
        $gross_earnings = $this->earnings * $this->pay_periods;
        $standard_deduction = self::STANDARD_DEDUCTIONS[$this->tax_information->filing_status];
        $deduction = $standard_deduction['amount'];

        if ($gross_earnings > $standard_deduction['base']) {
            $deduction -= $standard_deduction['modifier']['amount'] * (($gross_earnings - $standard_deduction['base']) / $standard_deduction['modifier']['per']);
        }

        return $deduction;
    }

    public function getPersonalExemptionAllowance()
    {
        if (array_key_exists($this->tax_information->filing_status, self::PERSONAL_EXEMPTION_ALLOWANCES)) {
            return self::PERSONAL_EXEMPTION_ALLOWANCES[$this->tax_information->filing_status];
        } else {
            return 0;
        }
    }

    public function getTaxBrackets()
    {
        return ($this->tax_information->filing_status >= self::FILING_MARRIED) ? self::MARRIED_BRACKETS : self::SINGLE_BRACKETS;
    }
}
