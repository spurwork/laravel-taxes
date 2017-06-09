<?php

namespace Appleton\Taxes\Traits;

trait WithNonResidentAlien
{
    private $nonResidentAlien;

    private function nonResidentAlien()
    {
        return $this->nonResidentAlien;
    }

    public function withNonResidentAlien($nonResidentAlien)
    {
        $this->nonResidentAlien = $nonResidentAlien;
        return $this;
    }
}
