<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:salary-index|salary-create|salary-update|salary-destroy', ['only' => ['index','store']]);
        $this->middleware('permission:salary-store', ['only' => ['create','store']]);
        $this->middleware('permission:salary-update', ['only' => ['edit','update']]);
        $this->middleware('permission:salary-destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary = Salary::with('user')->get();
        return response()->json([
            'status' => true,
            'message' => 'All Salaries with Employees Retrieved Successfully',
            'data' => $salary,
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
        $validate = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric|digits:5',
                'user_id' => 'required',
            ],
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'enter salary amount & user_id',
                'errors' => $validate->errors()
            ], 401);
        }

        $currentMonth = Carbon::now()->startOfMonth();
        $userExists = Salary::where('date', $currentMonth)->where('user_id', $request->user_id)->first();
        if ($userExists) {
            return response()->json([
                'status' => false,
                'message' => 'This Employee Already Has Salary of This Month',
            ]);
        }

        $salary = Salary::create([
            'amount' => $request->amount,
            'date' => Carbon::now()->startOfMonth(),
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Salary Added Successfully',
            'data' => $salary,
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
        $salary = Salary::with('user')->find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Salary with Employee retrieved successfully',
            'data' => $salary,

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
        $salary = Salary::find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        $validateSalary = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric|digits:5',
                'user_id' => 'required',
            ],
        );
        if ($validateSalary->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Enter Salary Amount & User ID',
                'errors' => $validateSalary->errors()
            ], 401);
        }
        $salary->amount = $request->amount;
        $salary->date = Carbon::now()->startOfMonth();
        $salary->user_id = $request->user_id;
        $salary->save();
        return response()->json([
            'status' => true,
            'message' => 'Salary Updated Successfully',
            'data' => $salary,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salary = Salary::find($id);
        if (!$salary) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        $salary->delete();
        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully',
            'data' => $salary,
        ]);
    }
}
