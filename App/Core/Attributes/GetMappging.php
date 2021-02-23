<?php

namespace App\Core\Attributes;

#[Attribute]
class GetMapping {
    public function __construct(public string $path) {
        echo  $path;
    }
}