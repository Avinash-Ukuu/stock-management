<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories']  =   Category::all();

        return view("cms.category.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']     =   new Category();
        $data['url']        =   route("category.store");
        $data['method']     =   "POST";

        return view("cms.category.form",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category                   =   new Category();
        $category->name             =   $request->name;
        $category->save();

        Session::flash("success","Category Created");

        return redirect(route("category.index"));
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
        $data['object']     =   Category::find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Category Already Deleted");
            return back();
        }
        $data['url']        =   route("category.update",['category'=>$id]);
        $data['method']     =   "PUT";

        return view("cms.category.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category                   =   Category::find($id);
        if(empty($category))
        {
            Session::flash("error","Category Already Deleted");
            return redirect(route("category.index"));
        }

        $category->name             =   $request->name;
        $category->update();
        Session::flash("success","Category Updated");

        return redirect(route("category.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $this->authorize("admin",new User());
        // $category                   =   Category::find($id);
        // if(empty($category))
        // {
        //     Session::flash("error","Category Already Deleted");
        //     return back();
        // }
        // Stock::where('category_id',$category->id)->delete();
        // $category->delete();
        // Session::flash("success","Category Deleted");

        // return redirect(route("category.index"));
    }
}
