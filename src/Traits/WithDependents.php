<?php

namespace Appleton\Taxes\Traits;

trait WithDependents
{
    private $dependents;

    private function dependents()
    {
        return $this->dependents;
    }

    public function withDependents($dependents)
    {
        $this->dependents = $dependents;
        return $this;
    }
}
