<?php
namespace Appleton\Taxes\Countries\US\Pennsylvania\PennsylvaniaUnemployment;

use Appleton\Taxes\Classes\WorkerTaxes\Taxes\BaseStateUnemployment;

class PennsylvaniaUnemployment extends BaseStateUnemployment
{
    const TYPE = 'state';
    const WITHHELD = false;
    const STATE = 'PA';
}
