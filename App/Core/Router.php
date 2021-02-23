<?php

namespace App\Core;

use App\Core\DI\DependencyContainer;

class Router {
    private string $path;
    private string $http_method;
    private DependencyContainer $di_container;
    //private array $controllers;

    public function __construct(private array $controllers, DependencyContainer $di_container) {
        $this->path = '/' . trim($_GET['url'] ?? '', '/');
        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->di_container = $di_container;
        //$this->controllers = $controllers;
    }

    public function dispatchRoute() {
        foreach ($this->controllers as $controller_class) {
            $reflection = new \ReflectionClass($controller_class);

            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes();

                foreach ($attributes as $attr) {                    
                    if (
                        (str_ends_with($attr->getName(), 'GetMapping') && $this->http_method === 'GET' ) || 
                        (str_ends_with($attr->getName(), 'PostMapping') && $this->htt_method === 'POST')
                        ) {
                        
                        [ $path ] = $attr->getArguments();
                        
                        if ($this->tryMatchRoute($path)) {
                            $controller_instance = $reflection->newInstance();

                            $params = $method->getParameters();
                            $injectables = [];

                            foreach ($params as $param) {
                                $injectables[] = $this->di_container->instance($param->getType()->getName());
                            }

                            call_user_func_array([$controller_instance, $method->getName()], $injectables);
                            
                            return;
                        }
                    }
                }
            }
        }

        throw new \Exception('Route cannot be matched.');
    }

    private function tryMatchRoute(string $mapping_path) {
        return $mapping_path === $this->path;
    }
}