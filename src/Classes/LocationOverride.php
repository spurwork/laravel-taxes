<?php

namespace Appleton\Taxes\Classes;

class LocationOverride
{
    public $from_home_location;
    public $from_work_location;
    public $to_home_location;
    public $to_work_location;
    public $to_tax_class;
    public $from_tax_class;

    public function __construct($parameters) {
        $this->from_home_location = $parameters['from_home_location'] ?? null;
        $this->from_work_location = $parameters['from_work_location'] ?? null;
        $this->to_home_location = $parameters['to_home_location'] ?? null;
        $this->to_work_location = $parameters['to_work_location'] ?? null;
        $this->to_tax_class = $parameters['to_tax_class'] ?? null;
        $this->from_tax_class = $parameters['from_tax_class'] ?? null;
    }
}
