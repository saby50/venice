<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
class TaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
		$data = DB::table('taxes')->get();
    $type="web";
    return view('vendor.multiauth.admin.taxes',compact('data','type'));
	}

	function addtax(Request $request) {
       $tax_name = $request['tax_name'];
       $tax_percent = $request['tax_percent'];
       $date = date("Y-m-d H:i:s");
       $data[] = array('tax_name' => $tax_name,'tax_percent' => $tax_percent,'created_at' => $date, 'updated_at' => $date);
       $db = DB::table('taxes')->insert($data);
       if ($db) {
           return redirect('admin/taxes')->withInput()->with('status','Tax added successfully');
       }

    }
    function deletetax($id) {
       $db = DB::table('taxes')->where('id',$id)->delete();
         if ($db) {
           return redirect('admin/taxes')->withInput()->with('status','Tax deleted');
       }
    }
     function edittax($id) {
        $data = DB::table('taxes')->where('id',$id)->get();
        $type="web";
       return view('vendor.multiauth.admin.edittax',compact('data','type'));
    }
    function updatetax(Request $request) {
        $tax_name = $request['tax_name'];
       $tax_percent = $request['tax_percent'];
       $taxid = $request['taxid'];
       $date = date("Y-m-d H:i:s");
       $data = array('tax_name' => $tax_name,'tax_percent' => $tax_percent,'created_at' => $date, 'updated_at' => $date);
       $db = DB::table('taxes')->where('id',$taxid)->update($data);
       if ($db) {
           return redirect('admin/taxes')->withInput()->with('status','Tax Updated');
       }

    }


}