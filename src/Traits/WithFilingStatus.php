<?php

namespace Appleton\Taxes\Traits;

trait WithFilingStatus
{
    private $filingStatus;

    private function filingStatus()
    {
        return $this->filingStatus;
    }

    public function withFilingStatus($filingStatus)
    {
        $this->filingStatus = $filingStatus;
        return $this;
    }
}
