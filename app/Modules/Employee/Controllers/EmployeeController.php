<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends BaseController
{
    private $service;
    public function __construct(
        EmployeeService $service,
    ){
        $this->service = $service;
    }

    public function index(Request $request){
    }
}