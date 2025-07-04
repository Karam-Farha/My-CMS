<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('user_access')) abort(403, __('Sorry You Are Not authenticated'));
        if ($request->ajax()) {
            $users = User::query();
            return DataTables::eloquent($users)
                ->addIndexColumn()
                ->addColumn(__('photo'), function ($user) {
                    return $this->prepareImg($user);
                })
                ->addColumn(__('actions'), function ($user) {
                    return $this->prepareBtns($user);
                })
                ->addColumn('roles' , function($user){
                    $res = '';
                    foreach($user->roles as $role)
                        $res = $res . '<div class="badge bg-primary">'.$role->name.'</div>';

                    return $res;
                })
                ->rawColumns(['actions', 'DT_RowIndex', 'photo' , 'roles'])
                ->make(true);
        }
        
        $pageTitle = [
            'title' => 'Users',
            'bread_crumbs' => [
                [
                    'title' => __('Home'),
                    'link'  => route('Admin.home')
                ],
                [
                    'title' => __('All Users'),
                    'link'  => route('users.index')
                ],
            ]
        ];
        return view('Admin.users.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $pageTitle = [
            'title' => 'Add User',
            'bread_crumbs' => [
                [
                    'title' => 'Home',
                    'link'  => route('Admin.home')
                ],
                [
                    'title' => 'Add User',
                    'link'  => route('users.create')
                ],
            ]
        ];
        return view('Admin.users.create', compact('pageTitle', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        $user = User::create($request->all());
        $user->roles()->sync($request->roles);
        if ($request->hasFile('photo')) {
            $user->media()->delete();
            $user->addMedia($request->file('photo'))->toMediaCollection('logo', 'media');
        }
        if ($user)
            return redirect()->route('users.index')->with(['success' => __('Added Successfully')]);
        else {
            return redirect()->route('users.index')->with(['danger' => __('Somthing Went Wrong')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $pageTitle = [
            'title' => 'Edit User',
            'bread_crumbs' => [
                [
                    'title' => 'Home',
                    'link'  => route('Admin.home')
                ],
                [
                    'title' => 'Edit User',
                    'link'  => route('users.edit', $user->id)
                ],
            ]
        ];

        return view('Admin.users.edit', compact('pageTitle', 'roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        if (is_null($input['password'])) {
            $input['password'] = $user->password;
        }
        $user->update($input);
        if ($request->hasFile('photo')) {
            $user->media()->each(function ($media) {
                $media->delete(); // This deletes both DB record and file
            });
            $user->addMedia($request->file('photo'))->toMediaCollection('logo', 'media');
        }
        $user->roles()->sync($request->roles);
        return redirect()->route('users.index')->with(['info' => __('Updated successfully')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->can('user_delete')) {
            if ($user) {
                $user->media()->each(function ($media) {
                    $media->delete();
                });
                $user->delete();
                return response()->json(['status' => 200, 'msg' => __('Deleted successfully')]);
            }
            return response()->json(['status' => 404, 'msg' => __('Not Found')]);
        }
        abort(403, __('Sorry You Are Not authenticated'));

        // return redirect()->route('users.index')->with(['danger' => __('Deleted successfully')]);
    }
}
