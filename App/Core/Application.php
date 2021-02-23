<?php

namespace App\Core;

use App\Core\DI;
use App\Core\DI\DependencyContainer;

class Application {
    private Router $router;
    private array $controllers;
    private DependencyContainer $di_container;

    public function __construct() {
        $this->di_container = new DependencyContainer;
    }

    public function start() {
        $this->router = new Router($this->controllers, $this->di_container);
        try {
            $this->router->dispatchRoute();
        } catch(\Exception $ex) {
            echo 'Hiba történt: ' . $ex->getMessage();
        }
    }

    public function controllers(array $controllers) {
        $this->controllers = $controllers;
    }
}