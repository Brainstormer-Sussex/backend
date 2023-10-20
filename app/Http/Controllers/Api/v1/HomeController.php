<?php

namespace App\Http\Controllers\Web\v1;

use App\Helpers\ApiResponseHandler;
use App\Helpers\AppException;
use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            return view('welcome');
        }catch (\Exception $e){
//            AppException::log($e);
//            return ApiResponseHandler::failure(__('messages.general.failed'), $e->getMessage());
        }
    }
}
