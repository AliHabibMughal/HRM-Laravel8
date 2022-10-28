<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\{Role, Permission};

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::with('permissions')->get();
        return response()->json([
            'status' => true,
            'message' => 'Roles With Permissions Retrieved Successfully',
            'data' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 401);
        }

        $permission = Permission::create(['name' => $request->permission]);
        $role = Role::create([
            'name' => $request->name,

        ])->syncPermissions($permission);
        $role->save();

        // $permission = Permission::create(['name' => 'attendance-list']);
        // $role->syncPermissions($permission);
        // $role->syncPermissions($request->permission);
        return response()->json([
            'status' => true,
            'message' => 'Role Created Successfully',
            'data' => $role,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Role with permissions retrieved successfully',
            'data' => $role,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        $role->delete();
        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully',
            'data' => $role,
        ]);
    }
}
