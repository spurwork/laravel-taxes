<?php

namespace Appleton\Taxes\Traits;

trait Withable
{
    protected $properties = [];

    public function __call($name, $arguments)
    {
        $property = strtolower($name);
        
        if (substr($property, 0, 4) !== 'with') {
            return array_key_exists($property, $this->properties) ? $this->properties[$property] : null;
        } else {
            if (count($arguments) === 1) {
                $this->properties[substr($property, 4)] = $arguments[0];
            }
        }

        return $this;
    }
}
