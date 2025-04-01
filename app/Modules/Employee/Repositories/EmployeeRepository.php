<?php
namespace App\Modules\Employee\Repositories;

use App\Repositories\BaseRepository;
use App\Modules\Employee\Models;
use Illuminate\Support\Facades\Request;

class  EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    public function list(Request $request){
        $query = $this->model->query();

        $orderBy = $request->order_by ?? [];
        if(!empty($orderBy)){
            foreach ($orderBy as $column => $direction) {
                $query->orderBy($column, $direction);
            }
        }
        
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}