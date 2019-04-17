<?php

namespace Appleton\Taxes\Countries\US\Indiana\CrawfordIncome\V20190101;

use Appleton\Taxes\Countries\US\Indiana\CrawfordIncome\CrawfordIncome as BaseCrawfordIncome;

class CrawfordIncome extends BaseCrawfordIncome
{
    public function getTaxRate(): float
    {
        return 0.01;
    }
}