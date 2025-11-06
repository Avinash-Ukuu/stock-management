<?php

namespace App\Http\Controllers\cms;

use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Department;
use App\Models\StockUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StockUsageController extends Controller
{
    public function index(Request $request)
    {
        $data['usages']     =   StockUsage::with(['stock', 'department'])->latest()->get();

          if ($request->ajax()) {
            $data       =   StockUsage::join('stocks', 'stocks.id', '=', 'stock_usages.stock_id')->leftJoin('departments', 'departments.id', '=', 'stock_usages.department_id')->select(
                'stock_usages.id as id',
                'stock_usages.quantity as quantity',
                'stock_usages.issue_date as issue_date',
                'stock_usages.return_date as return_date',
                'stock_usages.condition_on_return as condition_on_return',
                'stock_usages.remarks as remarks',
                'stock_usages.created_at as created_at',
                'departments.name as department',
                'stocks.name as stock'
            );

            if ($request->order == null) {
                $data->orderBy('stock_usages.created_at', 'desc');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->filterColumn('stock', function ($query, $keyword) {
                    $sql = "stocks.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('department', function ($query, $keyword) {
                    $sql = "departments.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->rawColumns(['department', 'stock'])
                ->make(true);
        }

        return view('cms.stockUsage.index');
    }

    public function create()
    {
        $data['object']         =   new StockUsage();
        $data['method']         =   'POST';
        $data['url']            =   route('stock-usage.store');
        $stocks                 =   Stock::where('available_quantity', '>', 0)->get();
        $stockOptions           =   $stocks->mapWithKeys(function ($stock) {
                                            return [$stock->id => $stock->name . ' (' . $stock->available_quantity . ')'];
                                        });

        $data['stocks']         =   $stockOptions;
        $data['departments']    =   Department::pluck('name','id')->toArray();

        return view('cms.stockUsage.form',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_id'      => 'required|exists:stocks,id',
            'department_id' => 'required|exists:departments,id',
            'quantity'      => 'required|integer|min:1',
            'issue_date'    => 'required|date',
        ]);

        $stock          =       Stock::findOrFail($request->stock_id);

        if ($stock->available_quantity < $request->quantity) {
            Session::flash('error','Not enough stock available.');
            return back();
        }

        // Create usage record
        $stockUsage     =       StockUsage::create([
                                    'stock_id' => $stock->id,
                                    'department_id' => $request->department_id,
                                    'quantity' => $request->quantity,
                                    'issue_date' => $request->issue_date,
                                    'remarks' => $request->remarks,
                                ]);

        // Update stock quantity
        $stock->decrement('available_quantity', $request->quantity);

        if($stock->qr_required == 1)
        {
            // Assign items to department (if item-based)
            $stockItems     =       StockItem::where('stock_id', $stock->id)
                                    ->whereNull('assigned_department')
                                    ->take($request->quantity)
                                    ->get();

            foreach ($stockItems as $item) {
                $item->update(['assigned_department' => $request->department_id]);
            }
        }

        return redirect()->route('stock-usage.index')->with('success', 'Stock assigned successfully.');
    }
}
