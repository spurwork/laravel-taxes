<?php

namespace Appleton\Taxes\Countries\US\Oregon\OregonUnemployment;

use Appleton\Taxes\Classes\BaseStateUnemployment;
use Illuminate\Database\Eloquent\Collection;

class OregonUnemployment extends BaseStateUnemployment
{
	const TYPE = 'state';
	const WITHHELD = false;
}