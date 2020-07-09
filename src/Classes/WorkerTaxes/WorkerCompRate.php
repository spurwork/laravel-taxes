<?php

namespace Appleton\Taxes\Classes\WorkerTaxes;

class WorkerCompRate
{
    public $state;
    public $position;
    public $class_code;
    public $sub_code;
    public $employer_rate;
    public $employee_rate;

    public function __construct($state, $position, $class_code, $sub_code, $employer_rate, $employee_rate)
    {
        $this->state = $state;
        $this->position = $position;
        $this->class_code = $class_code;
        $this->sub_code = $sub_code;
        $this->employer_rate = $employer_rate;
        $this->employee_rate = $employee_rate;
    }
}