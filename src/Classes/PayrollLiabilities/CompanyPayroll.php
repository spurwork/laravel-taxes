<?php

namespace Appleton\Taxes\Classes\PayrollLiabilities;

use Appleton\Taxes\Models\GovernmentalUnitArea;
use Carbon\Carbon;

class CompanyPayroll
{
    private $date;
    private $wages;
    private $qtd_wages;
    private $ytd_wages;
    private $ytd_liabilities;

    public function __construct(Carbon $date, $gross_wages, $qtd_wages, $ytd_wages, $ytd_liabilities)
    {
        $this->date = $date;
        $this->wages = $gross_wages;
        $this->qtd_wages = $qtd_wages;
        $this->ytd_wages = $ytd_wages;
        $this->ytd_liabilities = $ytd_liabilities;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getWages(GovernmentalUnitArea $tax_area = null): int
    {
        if (is_callable($this->wages)) {
            return ($this->wages)($tax_area);
        }

        return $this->wages;
    }

    public function getQtdWages(GovernmentalUnitArea $tax_area = null): int
    {
        if (is_callable($this->qtd_wages)) {
            return ($this->qtd_wages)($tax_area);
        }

        return $this->qtd_wages;
    }

    public function getYtdWages(GovernmentalUnitArea $tax_area = null): int
    {
        if (is_callable($this->ytd_wages)) {
            return ($this->ytd_wages)($tax_area);
        }

        return $this->ytd_wages;
    }

    public function getYtdLiabilities(string $tax_class = null): int
    {
        if (is_callable($this->ytd_liabilities)) {
            return ($this->ytd_liabilities)($tax_class);
        }

        return $this->ytd_liabilities;
    }
}
