<?php

namespace Appleton\Taxes\Traits;

trait WithSupplementalWages
{
    private $supplementalWages;

    private function supplementalWages()
    {
        return $this->supplementalWages;
    }

    public function withSupplementalWages($supplementalWages)
    {
        $this->supplementalWages = $supplementalWages;
        return $this;
    }
}
