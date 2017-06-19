<?php

namespace Appleton\Taxes\Traits;

trait WithPersonalExemption
{
    private $personalExemption = true;

    private function personalExemption()
    {
        return $this->personalExemption;
    }

    public function withPersonalExemption($personalExemption)
    {
        $this->personalExemption = $personalExemption;
        return $this;
    }
}
