<?php

use App\Http\Controllers\cms\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cms\DashboardController;
use App\Http\Controllers\cms\DepartmentController;
use App\Http\Controllers\cms\ModuleController;
use App\Http\Controllers\cms\PermissionController;
use App\Http\Controllers\cms\RoleController;
use App\Http\Controllers\cms\StockController;
use App\Http\Controllers\cms\StockItemController;
use App\Http\Controllers\cms\StockUsageController;
use App\Http\Controllers\cms\UserController;

// Dashboard
Route::get('dashboard',         [DashboardController::class,'dashboard'])->name('dashboard');

// User Management( User, Role, Permission, Module )
Route::resource('user',                     UserController::class);
Route::resource('role',                     RoleController::class);
Route::resource('permission',               PermissionController::class);
Route::resource('module',                   ModuleController::class);
Route::get("assign/user/roles/{id}",        [UserController::class,'assignRoleForm'])->name('assignRoles');
Route::post("submit/user/roles",            [UserController::class,'assignRole'])->name('submitRole');
Route::get("assign/role/permissions/{id}",  [RoleController::class,'assignPermissionForm'])->name('assignPermissions');
Route::post("submit/role/permissions",      [RoleController::class,'assignPermission'])->name('submitPermission');
Route::get("/change/password",              [UserController::class,'changePassword'])->name("changePassword");
Route::post("/update/password",             [UserController::class,'updatePassword'])->name("updatePassword");

//Stock category
Route::resource('category',                 CategoryController::class);

//Stock
Route::resource('stock',                    StockController::class);

//Stock Item
Route::resource('stock-item',               StockItemController::class);

//Department
Route::resource('department',               DepartmentController::class);

//Stock Usage
Route::get('stock-usage',                   [StockUsageController::class,'index'])->name('stock-usage.index');
Route::get('stock-usage/create',            [StockUsageController::class,'create'])->name('stock-usage.create');
Route::post('stock-usage/store',            [StockUsageController::class,'store'])->name('stock-usage.store');
Route::get('stock-usage/return/{id}',       [StockUsageController::class, 'returnForm'])->name('stock-usage.returnForm');
Route::post('stock-usage/return/{id}',      [StockUsageController::class, 'returnStock'])->name('stock-usage.returnStock');

