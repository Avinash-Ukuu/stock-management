<?php

namespace App\Http\Controllers\cms;

use App\Models\Stock;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $data['departmentCount']        =       Department::count();
        $data['categoryCount']          =       Category::count();
        $data['stockCount']             =       Stock::count();

        return view('cms.dashboard',$data);
    }
}
