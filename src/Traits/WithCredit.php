<?php

namespace Appleton\Taxes\Traits;

trait WithCredit
{
    private $credit;

    private function credit()
    {
        return $this->credit;
    }

    public function withCredit($credit)
    {
        $this->credit = $credit;
        return $this;
    }
}
