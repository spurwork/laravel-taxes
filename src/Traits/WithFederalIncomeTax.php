<?php

namespace Appleton\Taxes\Traits;

trait WithFederalIncomeTax
{
    private $federalIncomeTax;

    private function federalIncomeTax()
    {
        return $this->federalIncomeTax;
    }

    public function withFederalIncomeTax($federalIncomeTax)
    {
        $this->federalIncomeTax = $federalIncomeTax;
        return $this;
    }
}
