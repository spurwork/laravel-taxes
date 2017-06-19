<?php

namespace Appleton\Taxes\Traits;

trait WithExemptions
{
    private $exemptions;

    private function exemptions()
    {
        return $this->exemptions;
    }

    public function withExemptions($exemptions)
    {
        $this->exemptions = $exemptions;
        return $this;
    }
}
