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
class GondolierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
    function index() {
     $data = DB::table('gondoliers')->orderBy('id','desc')->get();
     $type = "web";
     return view('multiauth::admin.gondolier.index', compact('data','type'));
    }
    function create() {
     $data = DB::table('gondoliers')->get();
     $type = "web";
     return view('multiauth::admin.gondolier.create', compact('data','type'));
    }
    function add(Request $request) {
     $name = $request['name'];
     $canal_id = $request['canal'];
     $db = DB::table('gondoliers')->insert(['gondolier_name' => $name, 'canal_id' => $canal_id]);
     if ($db) {
            $notification = "status";
           return redirect('admin/gondolier')->withInput()->with($notification,"Gondolier created!");
         }
    }
    function delete($id) {
       $db = DB::table('gondoliers')->where('id',$id)->delete();
       if ($db) {
        $notification = "status";
           return redirect('admin/gondolier')->withInput()->with($notification,"Gondolier deleted!");
       }
    }
    function reports($type2) {
        $type = "web";

  if ($type2=="all") {
     $Date1 = date('d-m-Y', strtotime('-1 Month'));
     $Date2 = date('d-m-Y');
  }elseif($type2=="todays") {
   $Date1 = date('d-m-Y');
     $Date2 = date('d-m-Y');
  }elseif($type2=="yesterday") {
   $Date1 = date('d-m-Y', strtotime('-1 day'));
     $Date2 = date('d-m-Y', strtotime('-1 day'));
  }elseif($type2=="lastmonth") {
    $Date1 = date('01-m-Y', strtotime('-1 Month'));
     $Date2 =  date("t-m-Y", strtotime($Date1));
  }elseif($type2=="monthly") {
    $Date1 = date('01-m-Y');
     $Date2 = date("t-m-Y", strtotime($Date1));
  }else {
    list($from, $to) = explode('_', $type2);
    $Date1 = $from;
     $Date2 = $to;
  }     
                // Declare two dates 

  
// Declare an empty array 
$daterange = array(); 
  
// Use strtotime function 
$Variable1 = strtotime($Date1); 
$Variable2 = strtotime($Date2); 
  
// Use for loop to store dates into array 
// 86400 sec = 24 hrs = 60*60*24 = 1 day 
for ($currentDate = $Variable1; $currentDate <= $Variable2;  
                                $currentDate += (86400)) { 
                                      
$Store = date('Y-m-d', $currentDate); 
$daterange[] = $Store; 
} 
$data = DB::table('gondoliers')->get();
$filters = DB::table('filter_types')->where('page_name','bookings')->get();
        return view('multiauth::admin.gondolier.reports', compact('type','daterange','data','filters','type2'));
    }


}