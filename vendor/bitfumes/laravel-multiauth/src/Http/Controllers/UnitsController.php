<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;
use Helper;
use Session;
use Crypt;
use Auth;
use App\Mail\UnitFirst;
use URL;
class UnitsController extends Controller
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
	   $data = DB::table('units')->orderBy('id','desc')->get();
	   $type = 'web';	
       return view('multiauth::admin.units.index', compact('data','type'));
	}
	function unit_categories() {
	   $data = DB::table('unit_categories')->get();
	   $type = 'web';	
       return view('multiauth::admin.units.cats', compact('data','type'));
	}

    function recieve() {

       $type = 'web';   
       return view('multiauth::admin.recieve', compact('type'));
    }
       function recieve_payment(Request $request) {
        $phone = "+91".$request['phone'];
         $amount = $request['amount'];
         $unit_id = $request['unit_id'];
         $data = Helper::recivepayment_process($phone, $amount, $unit_id);
        if ($data['status']=="insufficient") {
          return redirect()->back()->withInput()->with('error','Insufficient balance in user wallet!');
        }elseif($data['status']=="user_not_found") {
          return redirect()->back()->withInput()->with('error','User not found');
        }else {
          return redirect('admin/checkotp/'.$phone);
        }

    }
    function checkotp($phone) {
       $type = 'web';   
       return view('multiauth::admin.units.checkotp', compact('type','phone'));
    }
    function get_addon($addonid) {
       $db = DB::table('unit_menu_items_add_ons')->where('id',$addonid)->get();
       $data = array();
       foreach ($db as $key => $value) {
         $addon_list = Helper::get_item_addons_list($value->id);
         $data = array('title' => $value->title, 'type' => $value->type,'addon_list' => $addon_list);
       }

       return $data;

    }

    function send_otp(Request $request) {
        $otp = $request['otp'];
        $phone = $request['phone'];
        $data  = Helper::checkotp_process($phone, $otp);
        $checkotp = DB::table('recieve_pay')->where('phone', $phone)->where('otp', $otp)->get();
        $amount = 0; $unit_id=0;
        foreach ($checkotp as $key => $value) {
            $amount = $value->amount;
            $unit_id = $value->unit_id;
        }

       if ($data['status']=="success") {
          return redirect('admin/units/revenue/todays/'.$unit_id)->withInput()->with('status','Success, You have recieved Rs.'.$amount);
        }else {
          return redirect()->back()->withInput()->with('error','Otp mismatch!');
        }

    }

	function revenue($parameter, $unit_id) {
		$type ="web";
		$data = array();
		$custom = "";
		if (Auth::user()->user_type=="superadmin" || Auth::user()->user_type=="food_analyst") {
			if ($parameter=="todays") {
				 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment')
            
            ->orderBy('wall_history.id','desc');

            if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }

            $data = $data->whereDate('wall_history.created_at', Carbon::today())
            ->get();
			}elseif($parameter=="monthly") {
				$now = Carbon::now();
                $month = $now->month;
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment')
            
            ->orderBy('wall_history.id','desc');
             if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            $data = $data->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="all") {
				
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment');
            if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            $data = $data->orderBy('wall_history.id','desc')
            
            ->get();
			}elseif($parameter=="yesterday") {
				$month = new Carbon('yesterday');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment')
            
            ->orderBy('wall_history.id','desc');
            if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            $data = $data->whereDate('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="lastmonth") {
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment');
              if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            
            $data = $data->orderBy('wall_history.id','desc')
            ->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="custom") {
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment');
              if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            $data = $data->orderBy('wall_history.id','desc')
            
            ->get();
			}else {
				list($from, $to,$custom) = explode("_", $parameter);
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->select(DB::raw('wall_history.*')
                ,DB::raw('units.unit_name as unit_name')
                ,DB::raw('units.id as unit_id'))
            ->where('wall_history.identifier','payment')
            
            ->orderBy('wall_history.id','desc');
            if ($from==$to) {
            $data = $data->whereDate('wall_history.created_at', $from)
                      ->whereDate('wall_history.created_at', $to);
          }else {
              $data = $data->whereBetween('wall_history.created_at', [$from, $to]);
          }
             if ($unit_id!="all") {
                $data = $data->where('unit_id',$unit_id);
            }
            $data = $data->get();
			}
		}else {
			$unit_email = Auth::user()->email;

			if ($parameter=="todays") {
				 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereDate('wall_history.created_at', Carbon::today())
            ->get();
			}elseif($parameter=="monthly") {
				$now = Carbon::now();
                $month = $now->month;
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="all") {
				
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            
            ->get();
			}elseif($parameter=="yesterday") {
				$month = new Carbon('yesterday');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereDate('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="lastmonth") {
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            ->whereMonth('wall_history.created_at', $month)
            ->get();
			}elseif($parameter=="custom") {
                $custom = "custom";
				$month = new Carbon('last month');
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc')
            
            ->get();
			}else {
				list($from, $to,$custom) = explode("_", $parameter);
					 $data = DB::table('wall_history')
            ->join('units','units.id','=','wall_history.unit_id')
            ->where('wall_history.identifier','payment')
            ->where('units.unit_email',$unit_email)
            ->orderBy('wall_history.id','desc');
            if ($from==$to) {
            $data = $data->whereDate('wall_history.created_at', $from)
                      ->whereDate('wall_history.created_at', $to);
          }else {
              $data = $data->whereBetween('wall_history.created_at', [$from, $to]);
          }
           
            $data = $data->get();
			}
           
		}
        
		$filters = DB::table('filter_types')->where('page_name','bookings')->get();
		$units = DB::table('units')->get();
		return view('multiauth::admin.units.revenue', compact('type','data','filters','parameter','custom','units','unit_id','custom2'));
	}
	function units_cat($id) {
	  $data = DB::table('unit_categories')->where('id',$id)->delete();
	  if ($data) {
        $notification = "status";
           return redirect('admin/units/categories')->withInput()->with($notification,"Unit category deleted");
       }	
	}

	function units_cat_edit($id) {
	  $data = DB::table('unit_categories')->where('id',$id)->get();
	  if ($data) {
           $notification = "status";
           return redirect('admin/units/categories')->withInput()->with($notification,"Unit category deleted");
       }	
	}

	function delete($id) {
	   $data = DB::table('units')->where('id',$id)->delete();
	  if ($data) {
        $notification = "status";
           return redirect('admin/units')->withInput()->with($notification,"Units deleted");
       }
	}
	function edit($id) {
	   $data = DB::table('units')->where('id',$id)->get();
	   $type = 'web';
	   $categories = DB::table('unit_categories')->get();	
       $taxes = DB::table('taxes')->get(); 
       return view('multiauth::admin.units.edit', compact('data','type','categories','id','taxes'));
	}
	function create() {
	   $type = 'web';
	   $categories = DB::table('unit_categories')->get();	
     $taxes = DB::table('taxes')->get(); 
       return view('multiauth::admin.units.create', compact('type','categories','taxes'));
	}
	function update(Request $request) {
	   $unit_name = $request['unit_name'];
	   $unit_phone = $request['unit_phone'];
	   $unit_email = $request['unit_email'];
	   $floor_level = $request['floor_level'];
	   $categories = $request['categories'];
       $tags = $request['tags'];
       $tax_id = $request['tax_id'];
       $from = $request['from'];
      $food_card = $request['food_card'];
      $enable_food_order = $request['enable_food_order'];
     $to = $request['to'];
     $price_for_two = $request['price_for_two'];
     $prep_time = $request['prep_time'];
     $suspended = $request['suspended'];
     $order_food = $request['order_food'];
	   $date = date("Y-m-d H:i:s");
	   $unit_id = $request['unit_id'];
	   $db = DB::table('units')->where('id',$unit_id)->update(['unit_name' => $unit_name, 'unit_phone' => $unit_phone,'unit_email' => $unit_email,'floor_level' => $floor_level,'unit_category_id' => $categories,'order_food' => $order_food,'tags' => $tags,'price_for_two' => $price_for_two,'prep_time' => $prep_time,'menu_id' => '0','suspended' => $suspended,'from_time' => $from,'to_time' => $to,'enable_food_order' => $enable_food_order,'tax_id' => $tax_id,'food_card' => $food_card,'created_at' => $date, 'updated_at' => $date]);
	   if ($db) {
	   	return redirect('admin/units')->withInput()->with('status','Unit Updated');
	   }
	}
	function add(Request $request) {
	   $unit_name = $request['unit_name'];
	   $unit_phone = $request['unit_phone'];
	   $unit_email = $request['unit_email'];
	   $floor_level = $request['floor_level'];
	   $categories = $request['categories'];
     $order_food = $request['order_food'];
     $from = $request['from'];
     $to = $request['to'];
     $food_card = $request['food_card'];
     $tax_id = $request['tax_id'];
      $enable_food_order = $request['enable_food_order'];
     $tags = $request['tags'];
     $price_for_two = $request['price_for_two'];
   
	   $date = date("Y-m-d H:i:s");
     $pin = Helper::generatePIN(6);
	   $password = bcrypt($pin);
     $destinationPath = "uploads/foodstore";

      $file = $request->file('foodicon');
      $filename = "";
      if ($file!="") {
         $fdate = date('dmyhis');
      $filename = str_replace(" ", "", $fdate."".$file->getClientOriginalName());
      $file->move($destinationPath,$filename);
      }
     
	   
	   $db = DB::table('units')->insert(['unit_name' => $unit_name, 'unit_phone' => $unit_phone,'unit_email' => $unit_email,'floor_level' => $floor_level,'unit_category_id' => $categories,'order_food' => $order_food,'foodstore' => $filename,'tags' => $tags,'price_for_two' => $price_for_two,'menu_id' => '0','from_time' => $from,'to_time' => $to,'enable_food_order' => $enable_food_order,'tax_id' => $tax_id,'food_card' => $food_card,'created_at' => $date, 'updated_at' => $date]);
	   $db2 = DB::table('admins')->insert(['name' => $unit_name, 'phone' => $unit_phone,'email' => $unit_email,'password' => $password,'active' => '1','user_type' => 'unit_manager','created_at' => $date, 'updated_at' => $date]);
	   if ($db) {

        $content = "Dear ".$unit_name.", login into The Grand Venice Units app with Username: ".$unit_email." and PIN: ".$pin.". App Download Link: http://shorturl.at/gSZ69";

        Helper::send_otp($unit_phone,$content);
        Mail::to($unit_email)->send(new UnitFirst($unit_phone, $pin,$unit_name,$unit_email));     
	   	  return redirect('admin/units')->withInput()->with('status','Unit added');
	   }
	}
	function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function upload_foodstore_app(Request $request) {
    $destinationPath = "uploads/foodstore";
    $file = $request->file('myfile');
    $id = $request['id'];
    $fdate = date('dmyhis');
    if(isset($file))
    {
      $ret = array();

    //  This is for custom errors;
    /*  $custom_error= array();
      $custom_error['jquery-upload-file-error']="File already exists";
      echo json_encode($custom_error);
      die();
    */
      $filename = str_replace(" ", "", $fdate."".$file->getClientOriginalName());

      //You need to handle  both cases
      //If Any browser does not support serializing of multiple files using FormData()
      if(!is_array($file->getClientOriginalName())) //single file
      {
        $fileName = str_replace(" ", "", $fdate."".$file->getClientOriginalName());
        $file->move($destinationPath,$fileName);
        $db = DB::table('units')->where('id', $id)->update(['foodstore' => $filename]);
        $ret[]= $fileName;
      }
      else  //Multiple files, file[]
      {
        $fileCount = count($file->getClientOriginalName());
        for($i=0; $i < $fileCount; $i++)
        {
          $fileName = $filename[$i];
          $file->move($destinationPath,$fileName);
          $ret[]= $fileName;
        }

      }
        return $ret;
     }
}
  function load_foodstore_app($id) {
  $dir="uploads/foodstore";
    $db = DB::table('units')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->foodstore;

          if ($file != "") {
            $filePath = $dir."/".$file;
            $details['name'] = $file;
            $details['path']=URL::to($filePath);
            $details['size']=filesize($filePath);
            $ret[] = $details;

          }


        }
         echo json_encode($ret);
}
  function delete_foodstore_app(Request $request) {
    $output_dir = "uploads/foodstore/";
     $id = $request['id'];
     $db = DB::table('units')->where('id', $id)->update(['foodstore' => '']);
     if($request['op'] == "delete")
    {
    $fileName = $request['name'];
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    if (file_exists($filePath))
    {
         unlink($filePath);
     }
      echo "Deleted File: ".$filePath;
    }
}


}