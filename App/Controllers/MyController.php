<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Attributes\GetMapping;
use App\Core\Database\DB;
use App\Services\MyService;

class MyController extends BaseController {
    
    #[GetMapping('/test')]    
    public function test(Request $request, Response $response, MyService $service) {
        echo 'asdasd';
        //print_r(DB::qb()->select('users', '*')->execute()->getCollection());
        
        // return $response->json([
        //     'name' => 'feri'
        // ]);
    }
}