<?php

namespace Appleton\Taxes\Classes;

use Carbon\Carbon;

class TaxResolver
{
    private $dependencies = [];
    private $resolved = [];

    private function getDate($date)
    {
        if (is_null($date)) {
            $this->date = Carbon::now();
        } else {
            if (is_string($date)) {
                $this->date = Carbon::createFromFormat('Ymd', $date);
            } elseif ($date instanceof Carbon) {
                $this->date = $date;
            } else {
                throw new \Exception('The date must be a null, Ymd formatted string or Carbon instance.');
            }
        }
    }

    private function getDependencies($class)
    {
        if (!method_exists($class, '__construct')) return;
        $constructor = new \ReflectionMethod($class, '__construct');
        foreach ($constructor->getParameters() as $parameter) {
            if ($parameter->hasType()) {
                $dependency = $parameter->getType()->__toString();
                if (is_subclass_of($dependency, BaseTax::class) && !in_array($dependency, $this->dependencies)) {
                    $this->dependencies[] = $dependency;
                    $this->getDependencies($dependency);
                }
            }
        }
    }

    private function getStrategies($class)
    {
        return array_reverse(array_map('basename', glob(dirname((new \ReflectionClass($class))->getFileName()).'/V*', GLOB_ONLYDIR)));
    }

    private function resolveDependencies()
    {
        foreach ($this->dependencies as $dependency) {
            foreach ($this->resolved as $class) {
                if (is_subclass_of($class, $dependency)) {
                    app()->bind($dependency, $class);
                }
            }
        }
    }

    private function resolveImplementation($class)
    {
        $basename = class_basename($class);
        $namespace = substr($class, 0, -strlen($basename) - 1);
        foreach ($this->getStrategies($class) as $strategy) {
            if ($this->date->diffInDays(Carbon::createFromFormat('Ymd', substr($strategy, 1)), false) <= 0) {
                $resolve = $namespace.'\\'.$strategy.'\\'.$basename;
                $this->resolved[] = $resolve;
                app()->bind($class, $resolve);
                return $resolve;
            }
        }
        throw new \Exception('The strategy could not be found.');
    }

    public function resolve($classes, $date = null)
    {
        $this->getDate($date);
        foreach ($classes as $class) {
            $this->getDependencies($this->resolveImplementation($class));
        }
        $this->resolveDependencies();
        return $this->resolved;
    }
}
