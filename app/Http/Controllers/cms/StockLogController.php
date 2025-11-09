<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\StockLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class StockLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize("admin",new User());

        if ($request->ajax()) {
            $data = StockLog::leftJoin("users",'users.id',"=",'stock_logs.user_id')->leftJoin("stocks","=","stock_logs.stock_id")
                              ->select([
                                  'stock_logs.description as description',
                                  'stock_logs.action as Action',
                                  'users.name as user',
                                  'stocks.name as stock',
                                  'stock_logs.created_at as Time'
                              ]);

            return DataTables::of($data)
                ->addIndexColumn()
                // ->filterColumn('Module', function($query, $keyword) {
                //     $sql = "stock_logs.module LIKE ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                // ->filterColumn('Action', function($query, $keyword) {
                //     $sql = "stock_logs.action LIKE ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                ->filterColumn('user', function($query, $keyword) {
                    $sql = "users.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('stock', function($query, $keyword) {
                    $sql = "stocks.stock LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('Time', function($query, $keyword) {
                    $sql = "stock_logs.created_at LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })

                ->make(true);
        }
        return view("cms.stockLogs");

    }

    public function saveStockLogs($data)
    {
        $activityLogs                   =   new StockLog();
        $activityLogs->module_id        =   $data['stock_id'];
        $activityLogs->action           =   $data['action'];
        $activityLogs->description      =   $data['description'];
        $activityLogs->user_id          =   auth()->user()->id;
        $activityLogs->save();
    }
}
