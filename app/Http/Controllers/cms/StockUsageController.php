<?php

namespace App\Http\Controllers\cms;

use App\Models\Stock;
use App\Models\StockItem;
use App\Models\Department;
use App\Models\StockUsage;
use Illuminate\Http\Request;
use App\Models\StockConditionLog;
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
                'stock_usages.returned_quantity as returned_quantity',
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
                ->editColumn('return_stock', function ($data) {

                    $editUrl        =   route('stock-usage.returnForm', ['id' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit ml-2 mr-2"></i></a>';
                    $btn            .=  '</div>';

                    return $btn;
                })
                ->rawColumns(['department', 'stock', 'return_stock'])
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
        $data['departments']    =   Department::pluck('name', 'id')->toArray();

        return view('cms.stockUsage.form', $data);
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
            Session::flash('error', 'Not enough stock available.');
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

        if ($stock->qr_required == 1) {
            // Assign items to department (if item-based)
            $stockItems     =       StockItem::where('stock_id', $stock->id)
                ->whereNull('assigned_department')
                ->take($request->quantity)
                ->get();

            foreach ($stockItems as $item) {
                $item->update(['assigned_department' => $request->department_id]);
            }
        }

        StockConditionLog::create([
            'stock_id'          =>      $stock->id,
            'stock_usage_id'    =>      $stockUsage->id,
            'condition'         =>      $stock->condition,
            'quantity'          =>      $request->quantity,
            'type'              =>      'issue',
        ]);

        return redirect()->route('stock-usage.index')->with('success', 'Stock assigned successfully.');
    }

    public function returnForm($id)
    {
        $data['usage']          =   StockUsage::with(['stock' => function ($query) use ($id) {
            $usage = StockUsage::find($id);

            $query->with(['stockItems' => function ($itemQuery) use ($usage) {
                $itemQuery->where('assigned_department', $usage->department_id)
                    ->whereNotNull('assigned_department');
                // ->whereNull('returned_at'); // only show items not yet returned
            }]);
        }])->findOrFail($id);

        $data['conditions']     =   ['new' => 'New', 'good' => 'Good', 'needs_repair' => 'Needs Repair', 'damaged' => 'Damaged'];

        return view('cms.stockUsage.return', $data);
    }



    public function returnStock(Request $request, $id)
    {
        $usage = StockUsage::findOrFail($id);
        $stock = Stock::findOrFail($usage->stock_id);

        if ($stock->qr_required) {
            $request->validate([
                'return_date'       => 'required|date',
                'remarks'           => 'nullable|string',
                'returned_items'    => 'required|array',
            ]);
        } else {
            $request->validate([
                'return_date'           => 'required|date',
                'remarks'               => 'nullable|string',
                'condition_on_return'   => 'required|array',
                'condition_on_return.*' => 'integer|min:0',
            ]);
        }

        // ==============================
        // Handle QR-Required Items
        // ==============================
        if ($stock->qr_required) {
            // Get issued item IDs for this department
            $issuedItemIds = StockItem::where('stock_id', $usage->stock_id)
                ->where('assigned_department', $usage->department_id)
                ->pluck('id')
                ->toArray();

            $returnedItems = $request->returned_items ?? [];

            // Filter only items that have a non-null condition
            $filteredReturned = array_filter($returnedItems, function ($condition) {
                return !is_null($condition) && $condition !== '';
            });

            // Only consider issued items (ignore unissued ones)
            $validReturnedItems = array_intersect(array_keys($filteredReturned), $issuedItemIds);
            $totalReturned = count($validReturnedItems);

            // Handle null safely
            $alreadyReturned = $usage->returned_quantity ?? 0;

            // Prevent over-returning
            if (($alreadyReturned + $totalReturned) > $usage->quantity) {
                return back()->with('error', 'Return quantity cannot exceed issued quantity.');
            }

            // Update stock usage record
            $usage->update([
                'returned_quantity'   => $alreadyReturned + $totalReturned,
                'return_date'         => $request->return_date,
                'condition_on_return' => json_encode($filteredReturned),
                'remarks'             => $request->remarks,
            ]);

            // Update each returned stock item
            foreach ($validReturnedItems as $itemId) {
                $condition = $filteredReturned[$itemId] ?? null;

                if ($condition) {
                    $item = StockItem::where('id', $itemId)
                        ->where('assigned_department', $usage->department_id)
                        ->first();

                    if ($item) {
                        // Mark item as returned
                        $item->update([
                            'assigned_department' => null,
                            'condition' => $condition,
                        ]);

                        // Log the return
                        StockConditionLog::create([
                            'stock_id'          => $stock->id,
                            'stock_usage_id'    => $usage->id,
                            'condition'         => $condition,
                            'quantity'          => 1,
                            'type'              => 'return',
                        ]);

                        // Increase available if usable
                        if (in_array($condition, ['new', 'good'])) {
                            $stock->increment('available_quantity', 1);
                        }
                    }
                }
            }
        }

        // Handle Non-QR Items
        else {
            $totalReturned = array_sum($request->condition_on_return ?? []);
            $alreadyReturned = $usage->returned_quantity ?? 0;

            if (($alreadyReturned + $totalReturned) > $usage->quantity) {
                return back()->with('error', 'Return quantity cannot exceed issued quantity.');
            }

            $usage->update([
                'returned_quantity'   => $alreadyReturned + $totalReturned,
                'return_date'         => $request->return_date,
                'condition_on_return' => json_encode($request->condition_on_return),
                'remarks'             => $request->remarks,
            ]);

            // Calculate usable quantity (new + good)
            $usableQty = ($request->condition_on_return['new'] ?? 0)
                + ($request->condition_on_return['good'] ?? 0);

            if ($usableQty > 0) {
                $stock->increment('available_quantity', $usableQty);
            }

            // Create condition logs
            foreach ($request->condition_on_return as $condition => $qty) {
                if ($qty > 0) {
                    StockConditionLog::create([
                        'stock_id'          => $stock->id,
                        'stock_usage_id'    => $usage->id,
                        'condition'         => $condition,
                        'quantity'          => $qty,
                        'type'              => 'return',
                    ]);
                }
            }
        }

        return redirect()->route('stock-usage.index')
            ->with('success', 'Stock returned successfully.');
    }
}
