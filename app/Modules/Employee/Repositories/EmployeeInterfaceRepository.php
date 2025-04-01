<?php
namespace App\Modules\Employee\Repositories;

interface EmployeeRepositoryInterface
{
    public function list(Request $request);
}