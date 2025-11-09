<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\StockItem;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StockItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data       =   StockItem::join('stocks', 'stocks.id', '=', 'stock_items.stock_id')->leftJoin('departments', 'departments.id', '=', 'stock_items.assigned_department')->select(
                'stock_items.id as id',
                'stock_items.unique_code as unique_code',
                'stock_items.qr_code as qr_code',
                'stock_items.condition as condition',
                'stock_items.created_at as created_at',
                'departments.name as assigned_department',
                'stocks.name as stock'
            );

            if ($request->order == null) {
                $data->orderBy('stock_items.created_at', 'desc');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->filterColumn('stock', function ($query, $keyword) {
                    $sql = "stocks.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('assigned_department', function ($query, $keyword) {
                    $sql = "departments.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('assigned_department', function ($data) {
                    return $data->assigned_department ?? 'N/A';
                })
                ->editColumn('action', function ($data) {

                    $editUrl        =   route('stock-item.edit', ['stock_item' => $data->id]);
                    // $deleteUrl      =   route('stock-item.destroy', ['stock_item' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit ml-2 mr-2"></i></a>';
                    // if (auth()->user()->hasRole('admin')) {
                    //     $btn        .=  '<a style="cursor: pointer;"
                    //                         onclick="deleteItem(\'' . $deleteUrl . '\')">
                    //                         <i class="fa fa-trash text-red ml-3"></i>
                    //                     </a>';
                    // }
                    $btn            .=  '</div>';

                    return $btn;
                })
                ->rawColumns(['assigned_department', 'stock', 'action'])
                ->make(true);
        }

        return view('cms.stockItem.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['object']         =   StockItem::with(['stock','assignedTo','assignedDepartment'])->find($id);
        if (empty($data['object'])) {
            Session::flash("error", "No Data Found");

            return back();
        }
        $data['method']         =   'PUT';
        $data['url']            =   route('stock-item.update', ['stock_item' => $id]);
        $data['conditions']     =   ['new' => 'New', 'good' => 'Good', 'needs_repair' => 'Needs Repair', 'damaged' => 'Damaged'];
        $data['departments']    =   Department::pluck('name','id')->toArray();

        return view('cms.stockItem.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stockItem              =   StockItem::with('stock')->find($id);
        if (empty($stockItem)) {
            Session::flash('error', 'Data Not found');

            return redirect(route('stock-item.index'));
        }

        $data['description']        =   auth()->user()->name." has updated ".$stockItem->stock->name." stock item data";
        $data['action']             =   "updated";
        $data['stock_id']           =   $stockItem->stock->id;
        saveStockLogs($data);

        $stockItem->unique_code         =       $request->unique_code;
        $stockItem->qr_code             =       $request->qr_code;
        $stockItem->condition           =       $request->condition;
        $stockItem->assigned_department =       $request->assigned_department;
        $stockItem->save();

        Session::flash('success','Data Updated');
        return redirect(route('stock-item.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
