<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Category;
use App\Models\StockItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data       =   Stock::join('categories', 'categories.id', '=', 'stocks.category_id')->join('users', 'users.id', '=', 'stocks.created_by')->select(
                'stocks.id as id',
                'stocks.name as name',
                'stocks.description as description',
                'stocks.vendor as vendor',
                'stocks.purchase_date as purchase_date',
                'stocks.total_quantity as total_quantity',
                'stocks.available_quantity as available_quantity',
                'stocks.unit_price as unit_price',
                'stocks.condition as condition',
                'stocks.qr_required as qr_required',
                'stocks.status as status',
                'stocks.created_at as created_at',
                'users.name as created_by',
                'categories.name as category'
            );


            if ($request->order == null) {
                $data->orderBy('stocks.created_at', 'desc');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->filterColumn('created_by', function ($query, $keyword) {
                    $sql = "users.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('category', function ($query, $keyword) {
                    $sql = "categories.name LIKE ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                // ->editColumn('certification_completed', function ($data) {
                //     if ($data->is_completed == 1) {
                //         return '<span class="badge badge-success">Completed</span>';
                //     } else {
                //         return '<span class="badge badge-danger">Not Completed</span>';
                //     }
                // })
                ->editColumn('action', function ($data) {

                    $editUrl        =   route('stock.edit', ['stock' => $data->id]);
                    $deleteUrl      =   route('stock.destroy', ['stock' => $data->id]);
                    $detailUrl      =   route('stock.show', ['stock' => $data->id]);
                    $btn            =   '<div class="row">';
                    $btn            .=  '<a href="' . $editUrl . '"><i class="fa fa-edit ml-2 mr-2"></i></a><a href="' . $detailUrl . '"><i class="fa fa-info-circle ml-2 mr-2"></i></a>';
                    if (auth()->user()->hasRole('admin')) {
                        $btn        .=  '<a style="cursor: pointer;"
                                            onclick="deleteItem(\'' . $deleteUrl . '\')">
                                            <i class="fa fa-trash text-red ml-3"></i>
                                        </a>';
                    }
                    $btn            .=  '</div>';

                    return $btn;
                })
                ->rawColumns(['created_by', 'category', 'action'])
                ->make(true);
        }

        return view('cms.stock.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =   new Stock();
        $data['method']         =   'POST';
        $data['url']            =   route('stock.store');
        $data['categories']     =   Category::pluck('name', 'id')->toArray();
        $data['conditions']     =   ['new' => 'New', 'good' => 'Good', 'needs_repair' => 'Needs Repair', 'damaged' => 'Damaged'];

        return view('cms.stock.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        $stock                      =       new Stock();
        $stock->category_id         =       $request->category_id;
        $stock->name                =       $request->name;
        $stock->description         =       $request->description;
        $stock->vendor              =       $request->vendor;
        $stock->purchase_date       =       $request->purchase_date;
        $stock->total_quantity      =       $request->total_quantity;
        $stock->available_quantity  =       $request->available_quantity;
        $stock->unit_price          =       $request->unit_price;
        $stock->condition           =       $request->condition;
        $stock->qr_required         =       $request->qr_required;
        $stock->created_by          =       auth()->user()->id;
        if ($request->has("image")) {
            $imageName  = "stock_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/stocks/'), $imageName);
            $stock->image  =  $imageName;
        }

        $stock->save();

        if ($stock->qr_required) {

            for ($i = 1; $i <= $stock->total_quantity; $i++) {
                $uniqueCode = strtoupper(Str::slug($stock->name)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                StockItem::create([
                    'stock_id' => $stock->id,
                    'unique_code' => $uniqueCode,
                    'qr_code' => null,
                    'condition' => 'new',
                ]);
            }
        }

        Session::flash("success", "Stock Data Store Successfully");

        return redirect(route("stock.index"));
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
        $data['object']         =   Stock::find($id);
        if (empty($data['object'])) {
            Session::flash("error", "No Data Found");

            return back();
        }
        $data['method']         =   'PUT';
        $data['url']            =   route('stock.update', ['stock' => $id]);
        $data['categories']     =   Category::pluck('name', 'id')->toArray();
        $data['conditions']     =   ['new' => 'New', 'good' => 'Good', 'needs_repair' => 'Needs Repair', 'damaged' => 'Damaged'];

        return view('cms.stock.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, string $id)
    {
        $stock                      =       Stock::find($id);
        if (empty($stock)) {
            Session::flash('error', 'Data Not found');

            return redirect(route('stock.index'));
        }
        $stock->category_id         =       $request->category_id;
        $stock->name                =       $request->name;
        $stock->description         =       $request->description;
        $stock->vendor              =       $request->vendor;
        $stock->purchase_date       =       $request->purchase_date;
        $stock->total_quantity      =       $request->total_quantity;
        $stock->available_quantity  =       $request->available_quantity;
        $stock->unit_price          =       $request->unit_price;
        $stock->condition           =       $request->condition;
        $stock->qr_required         =       $request->qr_required;
        $stock->created_by          =       auth()->user()->id;

        if ($request->has("image")) {
            if (file_exists("uploads/stocks/" . $stock->image)) {
                File::delete("uploads/stocks/" . $stock->image);
            }
            // image upload code
            $imageName  = "stock_" . Carbon::now()->timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/stocks/'), $imageName);
            $stock->image   =  $imageName;
        }

        $stock->update();

        Session::flash("success", "Stock Data Store Successfully");

        return redirect(route("stock.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
