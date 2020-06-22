<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes;

use Appleton\Taxes\Classes\WorkerTaxes\Payroll;
use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseLocal;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\DetroitTax\DetroitTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\DetroitTax\V20200101\DetroitTax as DetroitCityTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GrandRapidsTax\GrandRapidsTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\GrandRapidsTax\V20200101\GrandRapidsTax as GrandRapidsCityTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandParkTax\HighlandParkTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\HighlandParkTax\V20200101\HighlandParkTax as HighlandParkCityTax;
use Appleton\Taxes\Countries\US\Michigan\MichiganCityTaxes\SaginawTax\SaginawTax;
use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Illuminate\Database\Eloquent\Collection;

abstract class MichiganCityTax extends BaseLocal
{
    const WITHHELD = true;

    public const DEFAULT_TAX_RATE = 0.005;

    protected $resident_city_only_living_and_working_with_tax = false;
    protected $resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax = false;
    protected $resident_city_no_tax_primary_city_has_tax = false;
    protected $resident_city_no_work_has_tax_and_works_in_different_city_with_tax = false;
    protected $resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax = false;
    protected $resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax = false;
    protected $resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax = false;

    protected $payroll;
    protected $percentage_worked;
    protected $tax_information;

    abstract protected static function getCityName(): string;
    abstract protected static function getExemptionAmount(): int;
    abstract protected static function getResidencyTaxRate(): float;
    abstract protected static function getNonresidencyTaxRate(): float;

    public function __construct(MichiganIncomeTaxInformation $tax_information, Payroll $payroll)
    {
        parent::__construct($payroll);
        $this->tax_information = $tax_information;
        $this->getCityStatus();
    }

    public function doesApply(Collection $tax_areas): bool
    {
        return $this->tax_information->resident_city === $this->getCityName()
            || $this->tax_information->primary_nonresident_city === $this->getCityName()
            || $this->tax_information->secondary_nonresident_city === $this->getCityName();
    }

    // pass in the resident or non resident total
    public function getExemptionAmountTotal($number_of_exemptions): int
    {
        return ($this->getExemptionAmount() * $number_of_exemptions) / $this->payroll->pay_periods;
    }

    public function isSpecialCity($city)
    {
        if ($city === DetroitTax::getCityName() || $city === GrandRapidsTax::getCityName() || $city === SaginawTax::getCityName() || $city === HighlandParkTax::getCityName()) {
            return true;
        }

        return false;
    }

    public function getCityEarnings($is_resident_city)
    {
        if ($is_resident_city) {
            return max($this->payroll->getEarnings() - $this->getExemptionAmountTotal($this->tax_information->resident_exemptions), 0);
        } else {
            if ($this->percentage_worked > 0) {
                return max(($this->payroll->getEarnings() * ($this->percentage_worked  * 0.01)) - $this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions), 0);
            } else {
                return max($this->payroll->getEarnings() - $this->getExemptionAmountTotal($this->tax_information->nonresident_exemptions), 0);
            }
        }
    }

    public function compute(Collection $tax_areas)
    {
        if ($this->tax_information->exempt) {
            return 0.0;
        }

        if ($this->tax_information->resident_city === $this->getCityName()) {
            return round($this->getRate() * $this->getCityEarnings(true), 2);
        }

        return round($this->getRate() * $this->getCityEarnings(false), 2);
    }

    public function getRate()
    {
        if ($this->tax_information->resident_city === $this->getCityName()) {
            if ($this->resident_city_only_living_and_working_with_tax
                || $this->resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax) {
                return $this->getResidencyTaxRate();
            } elseif ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax && $this->isSpecialCity($this->tax_information->resident_city)) {
                return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, true);
            } elseif (($this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax || $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax)
                && $this->isSpecialCity($this->tax_information->resident_city)) {
                return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, true);
            } elseif ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax
                || $this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax
                || $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
                return self::DEFAULT_TAX_RATE;
            }
        } elseif ($this->tax_information->primary_nonresident_city === $this->getCityName()) {
            if ($this->resident_city_no_tax_primary_city_has_tax) {
                return $this->getNonresidencyTaxRate();
            } elseif ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax && $this->isSpecialCity($this->tax_information->primary_nonresident_city)) {
                return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, false);
            } elseif ($this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax) {
                return self::DEFAULT_TAX_RATE;
            } elseif ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax && $this->isSpecialCity($this->tax_information->primary_nonresident_city)) {
                if ($this->tax_information->primary_nonresident_city_percentage_worked >= $this->tax_information->secondary_nonresident_city_percentage_worked) {
                    $this->percentage_worked = $this->tax_information->primary_nonresident_city_percentage_worked;
                    return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->primary_nonresident_city, false);
                }
            } elseif ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
                if ($this->tax_information->primary_nonresident_city_percentage_worked >= $this->tax_information->secondary_nonresident_city_percentage_worked) {
                    $this->percentage_worked = $this->tax_information->primary_nonresident_city_percentage_worked;
                    return self::DEFAULT_TAX_RATE;
                }
            } elseif ($this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax  && $this->isSpecialCity($this->tax_information->primary_nonresident_city)) {
                return $this->getSpecialCityRate($this->tax_information->primary_nonresident_city, $this->tax_information->secondary_nonresident_city, false);
            } elseif ($this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
                $this->percentage_worked = $this->tax_information->primary_nonresident_city_percentage_worked;
                return self::DEFAULT_TAX_RATE;
            }
        } elseif ($this->tax_information->secondary_nonresident_city === $this->getCityName()) {
            if ($this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax && $this->isSpecialCity($this->tax_information->secondary_nonresident_city)) {
                return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, false);
            } elseif ($this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax) {
                return self::DEFAULT_TAX_RATE;
            } elseif ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax && $this->isSpecialCity($this->tax_information->secondary_nonresident_city)) {
                if ($this->tax_information->secondary_nonresident_city_percentage_worked > $this->tax_information->primary_nonresident_city_percentage_worked) {
                    $this->percentage_worked = $this->tax_information->secondary_nonresident_city_percentage_worked;
                    return $this->getSpecialCityRate($this->tax_information->resident_city, $this->tax_information->secondary_nonresident_city, false);
                }
            } elseif ($this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax) {
                if ($this->tax_information->secondary_nonresident_city_percentage_worked > $this->tax_information->primary_nonresident_city_percentage_worked) {
                    $this->percentage_worked = $this->tax_information->secondary_nonresident_city_percentage_worked;
                    return self::DEFAULT_TAX_RATE;
                }
            } elseif ($this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax  && $this->isSpecialCity($this->tax_information->secondary_nonresident_city)) {
                return $this->getSpecialCityRate($this->tax_information->primary_nonresident_city, $this->tax_information->secondary_nonresident_city, false);
            } elseif ($this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax) {
                $this->percentage_worked = $this->tax_information->secondary_nonresident_city_percentage_worked;
                return self::DEFAULT_TAX_RATE;
            }
        }
    }

    public function getSpecialCityRate($resident_city, $work_city, $is_resident_city)
    {
        $resident_city_resident_rate = 0;
        $resident_city_nonresident_rate = 0;
        $work_city_nonresident_rate = 0;

        if ($resident_city === DetroitTax::getCityName()) {
            $resident_city_resident_rate = DetroitCityTax::getResidencyTaxRate();
            $resident_city_nonresident_rate = DetroitCityTax::getNonResidencyTaxRate();
        } elseif ($resident_city === GrandRapidsTax::getCityName() || $resident_city === SaginawTax::getCityName()) {
            $resident_city_resident_rate = GrandRapidsCityTax::getResidencyTaxRate();
            $resident_city_nonresident_rate = GrandRapidsCityTax::getNonResidencyTaxRate();
        } elseif ($resident_city === HighlandParkTax::getCityName()) {
            $resident_city_resident_rate = HighlandParkCityTax::getResidencyTaxRate();
            $resident_city_nonresident_rate = HighlandParkCityTax::getNonResidencyTaxRate();
        }

        if ($work_city === DetroitTax::getCityName()) {
            $work_city_nonresident_rate = DetroitCityTax::getNonResidencyTaxRate();
        } elseif ($work_city === GrandRapidsTax::getCityName() || $work_city === SaginawTax::getCityName()) {
            $work_city_nonresident_rate = GrandRapidsCityTax::getNonResidencyTaxRate();
        } elseif ($work_city === HighlandParkTax::getCityName()) {
            $work_city_nonresident_rate = HighlandParkCityTax::getNonResidencyTaxRate();
        }

        if ($work_city_nonresident_rate < $resident_city_nonresident_rate) {
            if ($is_resident_city) {
                return max($resident_city_resident_rate - $work_city_nonresident_rate, 0);
            } else {
                return $work_city_nonresident_rate;
            }
        } else {
            if ($is_resident_city) {
                return $resident_city_nonresident_rate;
            } else {
                return $work_city_nonresident_rate;
            }
        }
    }

    protected function getCityStatus()
    {
        // Resident living and working in city that levies tax
        if ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city === $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_only_living_and_working_with_tax = true;
        // resident living in a city that levies a tax and works in another city
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city === ''
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_work_has_tax_and_works_in_different_city_with_no_tax = true;
        // nonresident working in a city that levies the local tax but does not live in a city that levies a local tax
        } elseif ($this->tax_information->resident_city === ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_tax_primary_city_has_tax = true;
        // resident living in a city that levies a tax and works in another city that levies a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city !== $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city === '') {
            $this->resident_city_no_work_has_tax_and_works_in_different_city_with_tax = true;
        // lives AND works in a city that levies a tax AND works in another city that levies a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->resident_city === $this->getCityName()
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->resident_city === $this->tax_information->primary_nonresident_city
            && $this->tax_information->secondary_nonresident_city !== '') {
            $this->resident_city_is_primary_work_city_with_tax_works_in_different_city_with_tax = true;
        // Lives in a city that levies a tax AND works in 2 other cities that both levy a tax
        } elseif ($this->tax_information->resident_city !== ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city !== ''
            && $this->tax_information->primary_nonresident_city !== $this->tax_information->secondary_nonresident_city) {
            $this->resident_city_no_work_has_tax_works_in_2_other_cities_that_have_tax = true;
        // Lives in a city with no tax AND works in 2 other cities that both levy a tax
        } elseif ($this->tax_information->resident_city === ''
            && $this->tax_information->primary_nonresident_city !== ''
            && $this->tax_information->secondary_nonresident_city !== ''
            && $this->tax_information->primary_nonresident_city !== $this->tax_information->secondary_nonresident_city) {
            $this->resident_city_no_work_no_tax_works_in_2_other_cities_that_have_tax = true;
        }
    }
}
