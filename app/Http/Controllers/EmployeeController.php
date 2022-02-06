<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all_employee_record($date=null)
    {
        //
        if ($date == null){
            $selected_date = $date = Carbon::now('+06:00')->toDateString();
        } else {
            $selected_date = $date;
        }
        $employee_list = DB::table('users')->where('role', 'employee')->get();
        $date_list = DB::table('checkin_checkout_employees')->select('date')->distinct()->get();
        $selected_records = DB::table('checkin_checkout_employees')->where('date', $selected_date)->get();
        $all_record = array();
        $cnt = -1;
        
        foreach($selected_records as $records)
        {
            $cnt ++;
            $start = strtotime($records->checkin_at);
            if ($records->checkout_at){
                $end = $records->checkout_at;
            } else {
                $end = Carbon::now('+06:00')->format('H:i');
            }
            $end = strtotime($end);
            $name = DB::table('users')->select('username')->where('id', $records->employee_id)->first();
            $all_record[$cnt] = array(
                $name,
                $records->checkin_at,
                $records->checkout_at,
                (int)(($end - $start)/(60*60))
            );
        }
        $single_employee_record = false;
        
        return view('dashboard', compact('single_employee_record', 'employee_list', 'all_record', 'selected_date', 'date_list'));
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
        DB::table('users')->insert([
            'role' => 'employee',
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::Make($request->password),
        ]);
        return $this->all_employee_record();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function employee_home()
    {
        //
        $employee = Auth::user();
        $date = Carbon::now('+06:00')->toDateString();
        $entry = DB::table('checkin_checkout_employees')->where('employee_id', $employee->id)->where('date', $date)->first();
        return view('employee_home', compact('date', 'entry'));
    }

    public function checkin()
    {
        //
        $employee = Auth::user();
        $datetime = Carbon::now('+06:00');
        $date = $datetime->toDateString();
        $time = $datetime->format('H:i');
        $exist = DB::table('checkin_checkout_employees')->where('date', $date);
        if (!count($exist)){
            DB::insert(
                'insert into checkin_checkout_employees (employee_id, date, checkin_at) 
                values (?, ?, ?)', 
                [$employee->id, $date, $time]
            );
        }
        $entry = DB::table('checkin_checkout_employees')->where('employee_id', $employee->id)->where('date', $date)->first();
        return view('employee_home', compact('date', 'entry'));
    }

    public function checkout()
    {
        //
        $employee = Auth::user();
        $datetime = Carbon::now('+06:00');
        $date = $datetime->toDateString();
        $time = $datetime->format('H:i');
        DB::update('update checkin_checkout_employees set checkout_at = ? where employee_id = ?', [$time, $employee->id]);
        $entry = DB::table('checkin_checkout_employees')->where('employee_id', $employee->id)->where('date', $date)->first();
        return view('employee_home', compact('date', 'entry'));
    }

    public function employee_record($id)
    {
        //
        $employee_list = DB::table('users')->where('role', 'employee')->get();
        $date_list = DB::table('checkin_checkout_employees')->select('date')->distinct()->get();
        $selected_records = DB::table('checkin_checkout_employees')->where('employee_id', $id)->get();
        $all_record = array();
        $cnt = -1;
        $name = DB::table('users')->select('username')->where('id', $id)->first();
        foreach($selected_records as $records)
        {
            $cnt ++;
            $start = strtotime($records->checkin_at);
            if ($records->checkout_at){
                $end = $records->checkout_at;
            } else {
                $end = Carbon::now('+06:00')->format('H:i');
            }
            $end = strtotime($end);
            $all_record[$cnt] = array(
                $records->date,
                $records->checkin_at,
                $records->checkout_at,
                (int)(($end - $start)/(60*60))
            );
        }
        $single_employee_record = true;
        return view('dashboard', compact('name', 'single_employee_record', 'employee_list', 'all_record', 'date_list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
