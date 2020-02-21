<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
class ManagerController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
        $data = DB::table('admins')
        ->where('admins.user_type','!=','superadmin')
        ->orderBy('admins.id','desc')
        ->get();
		
         $type = "web";
		return view('vendor.multiauth.admin.managers.index',compact('data','type'));
	}
	function create() {
        $db = DB::table('categories')->get();
         foreach ($db as $key => $value) {
        $category_id = $value->id;
        $category_name = $value->category_name;
        $services = DB::table('services')
        ->leftjoin('service_options','services.id','=','service_options.service_id')
         ->select(DB::raw('services.id as service_id'),
            DB::raw('services.service_name as service_name'),
            DB::raw('service_options.option_name as option_name'),
             DB::raw('service_options.id as option_id'),
            DB::raw('services.alias as alias'))
        ->where('category_id',$category_id)
        ->get();
        $categories[$category_name."_".$category_id] = $services;

        }
         $type = "web";
         $roles = DB::table('roles')->get();
		return view('vendor.multiauth.admin.managers.create',compact('categories','type','roles'));
	}
	function add(Request $request) {
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $pin = $request['pin'];
        $services = $request['services'];
         $category_id = $request['category_id'];
         $role = $request['role'];
        $selectcats = "";
         
      
        $date = date("Y-m-d H:i:s");
        $db = DB::table('admins')->insert(['name' => $name, 'email' => $email,'phone' => $phone,'password' => bcrypt($pin),'active' => '1','user_type' => $role ,'created_at' => $date, 'updated_at' => $date]);
         $member_id = DB::getPdo()->lastInsertId();
         if($role=="manager") {
           foreach ($services as $key => $value) {
        if ($value!="" || $value!=NULL) {
            $get_category_id = $this->get_category_id($value);
            $data2 = array('member_id' => $member_id,'category_id' => $get_category_id,'service_id' => $value,'created_at' => $date, 'updated_at' => $date);
            $db2 = DB::table('member_services')->insert($data2);
        }
      }
         }
        

        if ($db) {
           return redirect('admin/manage_users/all')->withInput()->with('status','Manager added!');
        }
	}
    function get_category_id($service_id) {
        $db = DB::table('services')->where('id',$service_id)->get();
        return $db[0]->category_id;
    }
    function delete($id) {
      $delete = DB::table('admins')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
        return redirect('admin/manage_users/all')->withInput()->with($notification,"Manager deleted");
      }
    }
    function edit($id) {
      
    	$data = DB::table('admins')->where('id',$id)->get();

       $db = DB::table('categories')->get();
         foreach ($db as $key => $value) {
        $category_id = $value->id;
        $category_name = $value->category_name;
         $services = DB::table('services')
        ->leftjoin('service_options','services.id','=','service_options.service_id')
         ->select(DB::raw('services.id as service_id'),
            DB::raw('services.service_name as service_name'),
            DB::raw('service_options.option_name as option_name'),
             DB::raw('service_options.id as option_id'),
            DB::raw('services.alias as alias'))
        ->where('category_id',$category_id)
        ->get();
        $categories[$category_name."_".$category_id] = $services;

        }
        $member_services = DB::table('member_services')->where('member_id',$id)->get();
         $type = "web";
         $roles = DB::table('roles')->get();
    	return view('vendor.multiauth.admin.managers.edit', compact('data','id','member_services','categories','type','roles'));
    }
    function update(Request $request) {
    	$name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];
        $pin = $request['pin'];
        $date = date("Y-m-d H:i:s");
         $services = $request['services'];
         $category_id = $request['category_id'];
        $selectcats = "";
        $role = $request['role'];
        $manager_id = $request['manager_id'];

        if ($pin=="") {
           $db = DB::table('admins')->where('id',$manager_id)->update(['name' => $name, 'email' => $email,'phone' => $phone,'user_type' => $role,'created_at' => $date, 'updated_at' => $date]);
        }else {
          $db = DB::table('admins')->where('id',$manager_id)->update(['name' => $name, 'email' => $email,'phone' => $phone,'user_type' => $role,'password' => bcrypt($pin),'created_at' => $date, 'updated_at' => $date]);  
        }
        


         $deleteservices = DB::table('member_services')->where('member_id',$manager_id)->delete();
  if($role=="manager") {
       foreach ($services as $key => $value) {
        if ($value!="" || $value!=NULL) {
            $get_category_id = $this->get_category_id($value);
            $data2 = array('member_id' => $manager_id,'category_id' => $get_category_id,'service_id' => $value,'created_at' => $date, 'updated_at' => $date);
            $db2 = DB::table('member_services')->insert($data2);
        }
      }
    }

        if ($db) {
        	return redirect('admin/manage_users/all')->withInput()->with('status','Managers Updated!');
        }else {
            return redirect('admin/manage_users/all')->withInput()->with('error','Oops some error occured!');
        }
    }

}