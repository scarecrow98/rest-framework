<?php

namespace App\Core\Attributes;

#[Attribute]
class PostMapping {
    public function __construct(public string $path) {
    
    }
}