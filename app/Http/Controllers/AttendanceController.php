<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:attendance-index|attendance-create|attendance-update|attendance-destroy', ['only' => ['index','store']]);
        $this->middleware('permission:attendance-store', ['only' => ['create','store']]);
        $this->middleware('permission:attendance-update', ['only' => ['edit','update']]);
        $this->middleware('permission:attendance-destroy', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendance = Attendance::with('user')->get();
        return response()->json([
            'status' => true,
            'message' => 'Attendance Records with Employees Retrieved Successfully',
            'data' => $attendance,
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
                'date' => 'date',
                // 'check_in' => 'time',
                // 'check_out' => 'time',
                'leave' => 'boolean',
                'explanation' => 'max:255',
                'user_id' => 'required',
            ],
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Fields Required',
                'errors' => $validate->errors()
            ], 401);
        }

        $currentDay = Carbon::now()->today();
        // $currentDay = Carbon::now()->toDateString();
        $userExists = Attendance::where('date', $currentDay)->where('user_id', $request->user_id)->first();
        if ($userExists) {
            return response()->json([
                'status' => false,
                'message' => "Today's Attendance is Already Marked for This Employee",
            ]);
        }
        $attendance = Attendance::create([
            'date' => Carbon::now()->today(),
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'leave' => $request->leave ?? false,
            'explanation' => $request->explanation,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Attendance Marked Successfully',
            'data' => $attendance,
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
        $attendance = Attendance::with('user')->find($id);
        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Attendance with Employee retrieved successfully',
            'data' => $attendance,

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
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        $validate = Validator::make(
            $request->all(),
            [
                // 'date' => 'date',
                // 'leave' => 'boolean',
                'explanation' => 'max:255',
                // 'user_id' => 'required',
            ],
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 401);
        }

        // $attendance->date = Carbon::now()->today();
        // $attendance->check_in = $request->check_in;
        $attendance->check_out = $request->check_out;
        // $attendance->leave = $request->leave;
        $attendance->explanation = $request->explanation;
        // $attendance->user_id = $request->user_id;
        $attendance->save();
        return response()->json([
            'status' => true,
            'message' => 'Attendance Updated Successfully',
            'data' => $attendance,
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
        $attendance = Attendance::find($id);
        if (!$attendance) {
            return response()->json([
                'status' => false,
                'message' => 'Not Found',
            ]);
        }
        $attendance->delete();
        return response()->json([
            'status' => true,
            'message' => 'Deleted Successfully',
            'data' => $attendance,
        ]);
    }
}
