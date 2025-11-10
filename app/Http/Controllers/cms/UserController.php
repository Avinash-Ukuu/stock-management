<?php

namespace App\Http\Controllers\cms;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize("admin", new User());

        $data['users']          =   User::where('id','<>',auth()->user()->id)->get();

        return view('cms.user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $this->authorize("admin", new User());

        $data['object']         =   new User();
        $data['method']         =   'POST';
        $data['url']            =   route('user.store');

        return view('cms.user.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $this->authorize("admin", new User());

        $user                   =   new User();
        $user->name             =   $request->name;
        $user->email            =   $request->email;
        $password               =   Str::random(8);
        // $user->password         =   Hash::make($password);
        $user->password         =   Hash::make('password');
        if ($request->has("profile_pic")) {
            $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic  =  $imageName;
        }
        $user->save();

        // Mail::to($user->email)->send(new UserMail($user,$password));

        Session::flash("success", "User Account Created");

        return redirect(route("user.index"));
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
        $this->authorize("admin", new User());

        $data['object']     =   User::find($id);
        if (empty($data['object'])) {
            Session::flash("error", "User Already Deleted");
            return back();
        }
        $data['url']        =   route("user.update", ['user' => $id]);
        $data['method']     =   "PUT";

        return view("cms.user.form", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $this->authorize("admin", new User());

        $user                   =   User::find($id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }
        $user->name             =   $request->name;
        $user->email            =   $request->email;
        if ($request->has("profile_pic")) {
            if (file_exists("uploads/users/" . $user->profile_pic)) {
                File::delete("uploads/users/" . $user->profile_pic);
            }
            // image upload code
            $imageName  = "user_" . Carbon::now()->timestamp . '.' . $request->file('profile_pic')->getClientOriginalExtension();
            $request->file('profile_pic')->move(public_path('uploads/users/'), $imageName);
            $user->profile_pic   =  $imageName;
        }

        $user->update();

        Session::flash("success", "User Account Updated");
        return redirect(route("user.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize("admin", new User());

        $user   =   User::find($id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return back();
        }

        if (file_exists("uploads/users/" . $user->profile_pic)) {
            File::delete("uploads/users/" . $user->profile_pic);
        }
        if ($user->roles->isNotEmpty()) {
            foreach ($user->roles as $role) {
                $role->permissions()->detach();
            }
        }
        $user->roles()->detach();
        $user->delete();
        Session::flash("success", "User Account Deleted");
        return redirect(route("user.index"));
    }

    public function changePassword()
    {
        return view("cms.user.changePasswordForm");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $hashValue      =   Hash::make($request->password);
        auth()->user()->update(['password' => $hashValue]);
        Session::flash('success', 'Password Changed Successfully');

        return redirect(route('dashboard'));
    }

    public function assignRoleForm(Request $request)
    {
        $this->authorize("admin", new User());
        $data['user']   =   User::with('roles')->find($request->id);
        if (empty($data['user'])) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }
        $data['roles']  =   Role::all()->pluck("name", "id")->toArray();

        return view("cms.user.assignRole", $data);
    }

    public function assignRole(Request $request)
    {
        $this->authorize("admin", new User());
        $user                   =   User::find($request->id);
        if (empty($user)) {
            Session::flash("error", "User Already Deleted");
            return redirect(route("user.index"));
        }

        $user->roles()->sync($request->role_id);

        Session::flash('success', 'Roles Assigned Successfully');

        return back();
    }

}
