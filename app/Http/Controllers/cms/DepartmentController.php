<?php

namespace App\Http\Controllers\cms;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['departments']  =   Department::with("head")->get();

        return view("cms.department.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['object']         =   new Department();
        $data['users']          =   User::pluck("name","id")->toArray();
        $data['url']            =   route("department.store");
        $data['method']         =   "POST";

        return view("cms.department.form",$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'head_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Department name is required.',
            'name.unique' => 'This department name already exists.',
            'head_id.required' => 'Please select a department head.',
            'head_id.exists' => 'The selected head does not exist in the user list.',
        ]);

        $department                         =   new Department();
        $department->head_id                =   $request->head_id;
        $department->name                   =   strtolower($request->name);
        $department->save();

        Session::flash("success","Department Created");

        return redirect(route("department.index"));
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
        $data['object']     =   Department::with("head")->find($id);
        if(empty($data['object']))
        {
            Session::flash("error","Data not found");
            return back();
        }
        $data['users']      =   User::pluck("name","id")->toArray();
        $data['url']        =   route("department.update",['department'=>$id]);
        $data['method']     =   "PUT";

        return view("cms.department.form",$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'head_id' => 'required|exists:users,id',
        ], [
            'name.required' => 'Department name is required.',
            'name.unique' => 'This department name already exists.',
            'head_id.required' => 'Please select a department head.',
            'head_id.exists' => 'The selected head does not exist in the user list.',
        ]);

        $department                         =   Department::find($id);
        if(empty($department))
        {
            Session::flash("error","Data Already Deleted");
            return redirect(route("department.index"));
        }

        $department->head_id                =   $request->head_id;
        $department->name                   =   strtolower($request->name);
        $department->update();
        Session::flash("success","Department Updated");

        return redirect(route("department.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
