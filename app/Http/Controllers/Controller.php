<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
// use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Agrego constructor para manejar las alertas con sweetAlert
    // public function __construct()
    // {
    //   $this->middleware(function($request, $next){
    //      if (session('success_message')) {
    //         Alert::success('Bien!', session('success_message'));
    //      }

    //      return $next($request);
    //   });
    // }
}
