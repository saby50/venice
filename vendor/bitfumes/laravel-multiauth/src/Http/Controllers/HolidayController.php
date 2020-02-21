<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class HolidayController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
      $data = DB::table('holidays')->get();
      $type = "web";
	  return view('vendor.multiauth.admin.holidays.index', compact('data','type'));
	}
	function create() {
		$type = "web";
	  return view('vendor.multiauth.admin.holidays.create', compact('data','type'));
	}
	function add(Request $request) {
		$holiday_name = $request['holiday_name'];
		$holidate = $request['date'];
		 $date = date("Y-m-d H:i:s");
		$db = DB::table('holidays')->insert(['holiday' => $holiday_name ,'date' => $holidate,'created_at' => $date, 'updated_at' => $date]);

		 if ($db) {
         	$notification = "status";
           return redirect('admin/holidays')->withInput()->with($notification,"Holiday created!");
         }

	}
	function edit($id) {
		$data = DB::table('holidays')->where('id',$id)->get();
		$type = "web";
	    return view('vendor.multiauth.admin.holidays.edit', compact('data','type','id'));
	}
	function update(Request $request) {
		$holiday_name = $request['holiday_name'];
		$holidate = $request['date'];
		$holiday_id = $request['holiday_id'];
		$date = date("Y-m-d H:i:s");
		$db = DB::table('holidays')->where('id',$holiday_id)->update(['holiday' => $holiday_name ,'date' => $holidate, 'updated_at' => $date]);

		 if ($db) {
         	$notification = "status";
           return redirect('admin/holidays')->withInput()->with($notification,"Holiday Updated!");
         }

	}
	function delete($id) {
		$delete = DB::table('holidays')->where('id', $id)->delete();
		if ($delete) {
         	$notification = "status";
           return redirect('admin/holidays')->withInput()->with($notification,"Holiday Deleted!");
         }

	}



}