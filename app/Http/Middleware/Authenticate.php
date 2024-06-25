<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request) 
    {
        //  return $request->expectsJson() ? null : route('api/user');
       return $request->expectsJson(['success'=>false,'message'=>'Unauthorized'])  ;
        /* return response()->json([
            'success'=>false,
            'message' => 'Gagal logout'
        ]); */
    }
}
