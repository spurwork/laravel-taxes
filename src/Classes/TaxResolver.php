<?php

namespace Appleton\Taxes\Classes;

use Carbon\Carbon;

class TaxResolver
{
    public function resolve($names, $date = null, $inject = true)
    {
        $resolved = [];
        $dependencies = [];
        $injected = [];

        if (is_string($names)) {
            $names = [$names];            
        }

        if (is_null($date)) {
            $date = Carbon::now();
        } else {
            if (is_string($date)) {
                $date = Carbon::createFromFormat('Ymd', $date);
            } elseif (!($date instanceof Carbon)) {
                throw new \Exception('The date must be a null, Ymd formatted string or Carbon instance.');
            }
        }

        foreach ($names as $name) {
            $was_resolved = false;
            $basename = class_basename($name);
            $namespace = substr($name, 0, -strlen($basename) - 1);
            $directory = dirname((new \ReflectionClass($name))->getFileName());
            $strategies = array_map('basename', glob($directory.'/V*', GLOB_ONLYDIR));

            foreach ($strategies as $strategy) {
                if ($date->diffInDays(Carbon::createFromFormat('Ymd', substr($strategy, 1)), false) <= 0) {
                    $resolved[] = $namespace.'\\'.$strategy.'\\'.$basename;
                    $was_resolved = true;
                    break;
                }
            }

            if (!$was_resolved) {
                throw new \Exception('The strategy could not be resolved.');
            }
        }

        if ($inject) {
            foreach ($resolved as $resolve) {
                $constructor = new \ReflectionMethod($resolve, '__construct');
                foreach ($constructor->getParameters() as $parameter) {
                    if ($parameter->hasType()) {
                        $dependencies[] = $parameter->getType()->__toString();
                    }
                }
            }

            foreach ($dependencies as $dependency) {
                foreach ($resolved as $resolve) {
                    if (is_subclass_of($resolve, $dependency)) {
                        app()->bind($dependency, $resolve);
                        $injected[] = $dependency;
                    }
                }
            }

            if (count(array_diff($dependencies, $injected))) {
                throw new \Exception('The dependency could not be injected.');
            }
        }

        return $resolved;
    }
}
