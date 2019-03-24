<?php

namespace Appleton\Taxes\Classes;

class ReciprocalAgreement
{
    public $resident_location;
    public $reciprocal_location;
    public $to_home_location;
    public $to_work_location;
    public $to_tax_class;
    public $from_tax_class;

    public function __construct($resident_location, $reciprocal_location) {
        $this->resident_location = $resident_location;
        $this->reciprocal_location = $reciprocal_location;
    }
}
