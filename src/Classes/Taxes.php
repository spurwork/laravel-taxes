<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Models\Tax;
use Carbon\Carbon;
use Closure;

class Taxes
{
    protected $date = null;
    protected $exemptions = [];
    protected $pay_periods = 1;
    protected $reciprocal_agreement = false;
    protected $location_overrides = [];
    protected $supplemental_earnings = 0;
    protected $suta_location = null;
    protected $wtd_earnings = 0;
    protected $ytd_earnings = 0;

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
    }

    public function setExemptions($exemptions)
    {
        $this->exemptions = $exemptions;
    }

    public function setHomeLocation($location)
    {
        $this->home_location = $location;
    }

    public function setPayPeriods($pay_periods)
    {
        $this->pay_periods = $pay_periods;
    }

    public function setReciprocalAgreement($reciprocal_agreement)
    {
        $this->reciprocal_agreement = $reciprocal_agreement;
    }

    public function setSUTALocation($suta_location)
    {
        $this->suta_location = $suta_location;
    }

    public function setSupplementalEarnings($supplemental_earnings)
    {
        $this->supplemental_earnings = $supplemental_earnings;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setWorkLocation($location)
    {
        $this->work_location = $location;
    }

    public function setWtdEarnings($wtd_earnings)
    {
        $this->wtd_earnings = $wtd_earnings;
    }

    public function setYtdEarnings($ytd_earnings)
    {
        $this->ytd_earnings = $ytd_earnings;
    }

    public function calculate(Closure $closure)
    {
        $closure($this);

        $this->createLocationOverrides();
        $this->bindPayrollData();
        $this->getTaxes();
        $this->bindInterfaces();

        $results = new TaxResults(
            $this->compute('federal')
                + $this->compute('state')
                + $this->compute('local')
        );

        $this->unbindTaxes();
        $this->unbindPayrollData();

        return $results;
    }

    private function bindInterfaces()
    {
        foreach ($this->taxes->pluck('class') as $tax_name) {
            foreach (class_implements($tax_name) as $interface) {
                app()->bind($interface, $tax_name);
            }
        }
    }

    private function bindPayrollData()
    {
        app()->instance(Payroll::class, new Payroll([
            'date' => $this->getDate(),
            'earnings' => $this->earnings,
            'exemptions' => $this->exemptions,
            'pay_periods' => $this->pay_periods,
            'supplemental_earnings' => $this->supplemental_earnings,
            'user' => $this->user,
            'wtd_earnings' => $this->wtd_earnings,
            'ytd_earnings' => $this->ytd_earnings,
        ]));
    }

    private function compute($type)
    {
        $results = [];
        $this->taxes
            ->filter(function ($tax) use ($type) {
                return ($tax->class)::TYPE == $type;
            })
            ->sortBy('class')
            ->sortBy(function ($tax) {
                return ($tax->class)::PRIORITY;
            })
            ->each(function ($tax) use (&$results) {
                $tax_implementation = app($tax->class);
                $results[$tax->class] = [
                    'tax' => $tax_implementation,
                    'amount' => $tax_implementation->compute($tax->taxAreas),
                    'earnings' => $tax_implementation->getEarnings(),
                ];
                app()->instance($tax->class, $tax_implementation);
            });

        return $results;
    }

    private function getDate()
    {
        $test_now = env('TAXES_TEST_NOW');
        $date = is_null($test_now) ? $this->date : Carbon::parse($test_now);

        return  is_null($date) ? Carbon::now() : $date;
    }

    private function getTaxes()
    {
        $this->taxes = Tax::atPoint($this->home_location, $this->work_location)
            ->with(['taxAreas' => function ($query) {
                $query->atPoint($this->home_location, $this->work_location);
            }])
            ->get();

        if (!$this->hasStateIncomeTax()) {
            $this->getStateIncomeTax();
        }

        $this->overrideLocations();
    }

    private function overrideLocations()
    {
        $this->location_overrides->each(function ($location_override) {
            $to_taxes = Tax::atPoint($location_override->to_home_location, $location_override->to_work_location)
                ->with(['taxAreas' => function ($query) use ($location_override) {
                    $query->atPoint($location_override->to_home_location, $location_override->to_work_location);
                }])
                ->get()
                ->filter(function ($to_tax) use ($location_override) {
                    return $to_tax->class === $location_override->to_tax_class || is_subclass_of($to_tax->class, $location_override->to_tax_class);
                });

            $from_taxes = Tax::atPoint($location_override->from_home_location, $location_override->from_work_location)
                ->with(['taxAreas' => function ($query) use ($location_override) {
                    $query->atPoint($location_override->from_home_location, $location_override->from_work_location);
                }])
                ->get()
                ->filter(function ($from_tax) use ($location_override) {
                    return $from_tax->class === $location_override->from_tax_class || is_subclass_of($from_tax->class, $location_override->from_tax_class);
                });

            $from_taxes
                ->each(function ($from_tax) {
                    $this->taxes = $this->taxes->reject(function ($tax) use ($from_tax) {
                        return $tax->class === $from_tax->class;
                    });
                });

            $this->taxes = $this->taxes->concat($to_taxes)->unique('class');
        });
    }

    private function createLocationOverrides()
    {
        $this->location_overrides = collect([]);

        if ($this->reciprocal_agreement) {
            $this->location_overrides->push(new LocationOverride([
                'to_work_location' => $this->home_location,
                'to_tax_class' => BaseStateIncome::class,
                'from_tax_class' => BaseStateIncome::class,
            ]));

            $this->location_overrides->push(new LocationOverride([
                'from_tax_class' => BaseLocal::class,
            ]));
        }

        if (!is_null($this->suta_location)) {
            $this->location_overrides->push(new LocationOverride([
                'to_home_location' => $this->suta_location,
                'to_tax_class' => BaseStateUnemployment::class,
                'from_tax_class' => BaseStateUnemployment::class,
            ]));
        }

        $this->location_overrides = $this->location_overrides
            ->map(function ($location_override) {
                $location_override->to_home_location = $location_override->to_home_location ?? $this->home_location;
                $location_override->from_home_location = $location_override->from_home_location ?? $this->home_location;
                $location_override->to_work_location = $location_override->to_work_location ?? $this->work_location;
                $location_override->from_work_location = $location_override->from_work_location ?? $this->work_location;

                return $location_override;
            });
    }

    private function hasStateIncomeTax()
    {
        return $this->taxes->pluck('class')->contains(function ($tax) {
            return is_subclass_of($tax, BaseStateIncome::class);
        });
    }

    private function getStateIncomeTax()
    {
        $state_income_tax = Tax::atPoint($this->home_location, $this->home_location)
            ->get()
            ->first(function ($tax) {
                return is_subclass_of($tax->class, BaseStateIncome::class);
            });

        if ($state_income_tax) {
            $this->taxes->push($state_income_tax);
        }
    }

    private function unbindPayrollData()
    {
        app()->forgetInstance(Payroll::class);
    }

    private function unbindTaxes()
    {
        $this->taxes
            ->pluck('class')
            ->each(function ($tax_name) {
                app()->forgetInstance($tax_name);
            });
    }

    public function getStateIncomeClass($class, $user, Carbon $date = null)
    {
        $date = is_null($date) ? Carbon::now() : $date;

        app()->instance(Payroll::class, new Payroll([
            'date' => $date,
            'user' => $user,
        ]));

        try {
            $class = app($class);
            $this->unbindPayrollData();

            return $class;
        } catch (\Exception $e) {
            $this->unbindPayrollData();

            return null;
        }
    }
}
