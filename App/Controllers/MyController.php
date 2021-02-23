<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;

class MyController extends BaseController {
    
    #[GetMapping('/test')]    
    public function test(Request $request, Response $response) {
        return $response->json([
            'name' => 'feri'
        ]);
    }
}