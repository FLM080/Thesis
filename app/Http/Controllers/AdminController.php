<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\DatabaseSchemaService;
use App\Models\BaseModel;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $deleteRoute = 'deleteUser';
        $tableId = 'id';
        $columns = collect(DatabaseSchemaService::getColumnNames('users'))->reject(function ($column) {
            return $column === 'password';
        });
        $editRoute = 'editUser';
        $searchRoute = 'admin';
        $editType = 'user';
        

        $search = $request->get('search');
        $items = User::where('name', 'like', "%{$search}%")
        ->orWhere('email', 'like', "%{$search}%")
        ->orWhere('user_admin_privilege', 'like', "%{$search}%")
        ->get()
        ->map(function ($user) {
            $user->admin_status_display = $user->admin_status;
            return $user;
        });


        if ($request->ajax()) {
            return view('partials._table', ['items' => $items, 'columns' => $columns, 'deleteRoute' => $deleteRoute, 'tableId' => $tableId, 'editRoute' => $editRoute, 'editType' => $editType]);
        }

        return view('admin.users', compact('items', 'columns', 'deleteRoute', 'tableId', 'editRoute', 'searchRoute', 'editType'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'user_admin_privilege' => 'required|in:0,1',
    ]);

    $user = User::find($id);

    if ($request->has('user_admin_privilege')) {
        $user->user_admin_privilege = $request->user_admin_privilege;
    }

    if ($user->isDirty()) {
        if ($user->save()) {
            notify()->success(__('User updated successfully'));
        } else {
            notify()->error(__('User could not be updated'));
        }
    } else {
        notify()->info(__('No changes made'));
    }

    return redirect()->route('admin');
}
    
    public function destroy($id)
    {
        if($id == auth()->user()->id) {
            notify()->error(__('You cannot delete yourself'));
            return redirect()->route('admin');
        }
        if(User::destroy($id)) {
            notify()->success(__('User deleted successfully'));
        } else {
            notify()->error(__('User could not be deleted'));
        }
        return redirect()->route('admin');
    }
}
