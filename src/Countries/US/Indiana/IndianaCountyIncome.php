<?php


namespace Appleton\Taxes\Countries\US\Indiana;


use Appleton\Taxes\Countries\US\Indiana\AdamsIncome\AdamsIncome;
use Appleton\Taxes\Countries\US\Indiana\AllenIncome\AllenIncome;

abstract class IndianaCountyIncome extends IndianaLocalIncome
{
    private const COUNTY_CODES = [
        1 => AdamsIncome::class,
        2 => AllenIncome::class,
    ];
}