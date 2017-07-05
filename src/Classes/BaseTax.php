<?php

namespace Appleton\Taxes\Classes;

class BaseTax
{
    public function built()
    {
        //abstract
    }

    public function build($parameters)
    {
        $this->parameters = $parameters;
        foreach ($parameters as $key => $value) {
            $this->$key = $value;
        }
        if (defined('static::TAX_INFORMATION')) {
            if (is_null($this->user)) {
                $this->tax_information = app(static::TAX_INFORMATION)::getDefault($this->date);
            } else {
                $this->tax_information = (static::TAX_INFORMATION)::forUser($this->user)->first();
                if (is_null($this->tax_information)) {
                    throw new \Exception('The tax information for that user could not be loaded.');
                }
            }
        }
        $this->built();
        return $this;
    }

    public function compute()
    {
        return round($this->earnings * static::TAX_RATE, 2);
    }
}
