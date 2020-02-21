<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Helper;
use Session;
use Crypt;
class FocController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	public function index() {
		$data = DB::table('foc')->get();
		$type = 'web';
		return view('vendor.multiauth.admin.foc.index', compact('data','type'));
	}
	public function create() {
		$type = 'web';
	   return view('vendor.multiauth.admin.foc.create',compact('type'));	
	}
	public function add(Request $request) {
		$name =  $request['name'];
		$phone = $request['phone'];
		$email = $request['email'];
		$date = date("d F Y, h:i A");
		$db = DB::table('foc')->insert(['name' => $name, 'phone' => $phone, 'email' => $email,'created_at' => $date, 'updated_at' => $date]);
		if ($db) {
			return redirect('admin/foc')->withInput()->with('status','FOC Manager Added');
		}
	}
	public function delete($id) {
		$delete = DB::table('foc')->where('id',$id)->delete();
		if ($delete) {
			return redirect('admin/foc')->withInput()->with('status','FOC manager deleted!');
		}

	}
	public function edit($id) {
		$type = 'web';
		$data = DB::table('foc')->where('id',$id)->get();
	   return view('vendor.multiauth.admin.foc.edit',compact('type','data','id'));	
	}
	public function update(Request $request) {
		$name = $request['name'];
		$email = $request['email'];
		$phone = $request['phone'];
		$foc_id = $request['foc_id'];
		$date = date("d F Y, h:i A");
		$db = DB::table('foc')->where('id',$foc_id)->update(['name' => $name, 'phone' => $phone, 'email' => $email,'updated_at' => $date]);
		if ($db) {
			return redirect('admin/foc')->withInput()->with('status','FOC manager updated!');
		}
	}
	public function reasons() {
		$data = DB::table('foc_reasons')->get();
		$type = 'web';
		return view('vendor.multiauth.admin.foc.reasons', compact('data','type'));
	}
	public function reason_create() {
	   $type = 'web';
	   return view('vendor.multiauth.admin.foc.create_reasons',compact('type'));	
	}
	public function reason_add(Request $request) {
		$reason = $request['reason'];
		$date = date("d F Y, h:i A");
         $db = DB::table('foc_reasons')->insert(['reason' => $reason,'created_at' => $date, 'updated_at' => $date]);
         if ($db) {
			return redirect('admin/reasons')->withInput()->with('status','Reason Created!');
		}


	}
	public function reasons_delete($id) {
        $delete = DB::table('foc_reasons')->where('id',$id)->delete();
		if ($delete) {
			return redirect('admin/reasons')->withInput()->with('status','Reasons deleted!');
		}
	}
	public function reasons_edit($id) {
		$type = 'web';
		$data = DB::table('foc_reasons')->where('id',$id)->get();
	   return view('vendor.multiauth.admin.foc.edit_reasons',compact('type','data','id'));	
	}
	public function reason_update(Request $request) {
		$reason = $request['reason'];
		$date = date("d F Y, h:i A");
		$reason_id = $request['reason_id'];
        $db = DB::table('foc_reasons')->where('id',$reason_id)->update(['reason' => $reason,'created_at' => $date, 'updated_at' => $date]);
         if ($db) {
			return redirect('admin/reasons')->withInput()->with('status','Reason Updated!');
		}


	}




}