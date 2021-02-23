<?php

namespace App\Core\DI;

use ReflectionClass;

class DependencyContainer {
    private array $instances = [];

    public function instance($class) {
        if (!empty($this->instances[$class])) {
            return $this->instances[$class];
        }

        $reflection = new ReflectionClass($class);
        $parameters = $reflection->getConstructor()?->getParameters() ?? [];

        $injectables = [];
        foreach ($parameters as $param) {
            $param_class = $param->getType()->getName();
            $injectables[] = $this->instance($param_class);
        }

        $this->instances[$class] = $reflection->newInstance(...$injectables);
        return $this->instances[$class];
    }


}