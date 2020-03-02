<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use URL;
class MenuController extends Controller
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
   function addmenu($unit_id) {
	    $type = 'web';
      $data = DB::table('unit_menu_items')->where('unit_id',$unit_id)->orderBy('id','desc')->get();
      return view('multiauth::admin.menu.index', compact('type','unit_id','data'));
   }
   function createitem($unit_id) {
   	  $type = 'web';	
   	  $categories = DB::table('food_categories')->orderBy('category_name')->get();
      return view('multiauth::admin.menu.createmenuitem', compact('type','unit_id','categories'));
   }
   function addons_create(Request $request) {
     $title = $request['addon_name'];
     $type = $request['type'];
     $addonname = $request['addonname'];
     $addonprice = $request['addonprice'];
     $date = date("Y-m-d H:i:s");
     $item_id = $request['item_id'];
     $unit_id = $request['unit_id'];
     $db = DB::table('unit_menu_items_add_ons')->insert(['title' => $title, 'type' => $type, 'item_id' => $item_id,'created_at' => $date, 'updated_at' => $date]);
     $item_addon_id = DB::getPdo()->lastInsertId();

     if ($addonname!="" || $addonname!=null) {
       foreach ($addonname as $key => $value) {
         $db2 = DB::table('unit_menu_items_add_ons_list')->insert(['addon_name' => $value, 'cost' => $addonprice[$key], 'item_addon_id' => $item_addon_id,'created_at' => $date, 'updated_at' => $date]);
       }
     }
      if($db) {
        return redirect('admin/addmenu/'.$unit_id)->withInput()->with('status','Addon added successfully!');
      }

   }
   function addmenuitem(Request $request) {
   	  $itemname = $request['item_name'];
   	  $price = $request['price'];
   	  $description = $request['description'];
   	  $featured = $request['featured'];
   	  $status = $request['status'];
      $date = date("Y-m-d H:i:s");
      $unit_id = $request['unit_id'];
      $food_category_id = $request['food_category_id'];
      $veg_nonveg = $request['veg_nonveg'];
      $addonprice = $request['addonprice'];
      $destinationPath = "uploads/featured_item";
      $file = $request->file('featured');
      $from = $request['from'];
      $to = $request['to'];
      $fdate = date('dmyhis');
      $filename = "";
      if ($file!="") {
        $filename = str_replace(" ", "", $fdate."".$file->getClientOriginalName());
        $file->move($destinationPath,$filename);
      }
      

      $addon = $request['addon'];
   	  $db = DB::table('unit_menu_items')->insert(['unit_id' => $unit_id,'item_name' => $itemname,'price' => $price,'status' => $status,'featured' => $featured,'description' => $description,'food_category_id' => $food_category_id,'veg_nonveg' => $veg_nonveg,'featured_image' => $filename,'from_time' => $from,'to_time' => $to,'created_at' => $date, 'updated_at' => $date]);
      $insert_id = DB::getPdo()->lastInsertId();
     
   	  if($db) {
   	  	return redirect('admin/addmenu/'.$unit_id)->withInput()->with('status','');
   	  }
   }
   function deleteitem($item_id) {
    $db = DB::table('unit_menu_items')->where('id',$item_id)->delete();
    if($db) {
        return redirect()->back()->withInput()->with('status','Item is deleted successfully!');
      }

   }

   function edititem($item_id) {
    $type = 'web';  
    $categories = DB::table('food_categories')->orderBy('category_name')->get();
    $data = DB::table('unit_menu_items')->where('id',$item_id)->get();
    return view('multiauth::admin.menu.editmenuitem', compact('type','unit_id','categories','data','item_id'));
   }
   function deleteaddons($addonid) {
     $db = DB::table('unit_menu_items_add_ons')->where('id',$addonid)->delete();
     $db2 = DB::table('unit_menu_items_add_ons_list')->where('item_addon_id',$addonid)->delete();
    if($db) {
        return redirect()->back()->withInput()->with('status','Addon is deleted successfully!');
      }

   }
   function addons_edit(Request $request) {
       $title = $request['addon_name'];
       $type = $request['type'];
       $item_addon_id = $request['item_addon_id'];
       $addonname = $request['addonname'];
       $addonprice = $request['addonprice'];
       $addonid = $request['addonid'];
        $date = date("Y-m-d H:i:s");
       $db = DB::table('unit_menu_items_add_ons')->where('id',$item_addon_id)->update(['title' => $title, 'type' => $type]);

       foreach ($addonid as $key => $value) {
        if ($value!="" || $value!=null) {
          $db2 = DB::table('unit_menu_items_add_ons_list')->where('id',$value)->update(['addon_name' => $addonname[$key], 'cost' => $addonprice[$key]]);
        }else {
          $db2 = DB::table('unit_menu_items_add_ons_list')->insert(['addon_name' => $addonname[$key], 'cost' => $addonprice[$key], 'item_addon_id' => $item_addon_id,'created_at' => $date, 'updated_at' => $date]);
        }
         
       }

       return redirect()->back()->withInput()->with('status','Addon is updated successfully!');
   }
   function removeaddon($addonid) {
     $db = DB::table('unit_menu_items_add_ons_list')->where('id',$addonid)->delete();
     $status = "";
     if ($db) {
       $status = "success";
     }else {
       $status = "failed";
     }
   }
   function updatemenuitem(Request $request) {
      $itemname = $request['item_name'];
      $price = $request['price'];
      $description = $request['description'];
      $item_id = $request['item_id'];
      $featured = $request['featured'];
      $status = $request['status'];
      $date = date("Y-m-d H:i:s");
      $unit_id = $request['unit_id'];
      $food_category_id = $request['food_category_id'];
      $veg_nonveg = $request['veg_nonveg'];
       $addonprice = $request['addonprice'];
      $addon = $request['addon'];
      
      $from = $request['from'];
      $to = $request['to'];
     
      $db = DB::table('unit_menu_items')->where('id',$item_id)->update(['unit_id' => $unit_id,'item_name' => $itemname,'price' => $price,'status' => $status,'featured' => $featured,'description' => $description,'food_category_id' => $food_category_id,'veg_nonveg' => $veg_nonveg,'from_time' => $from,'to_time' => $to,'created_at' => $date, 'updated_at' => $date]);
      if($db) {
        return redirect('admin/addmenu/'.$unit_id)->withInput()->with('status','Item Updated successfully!');
      }

   }

   function upload_featured_item(Request $request) {

     $destinationPath = "uploads/featured_item";
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
        $db = DB::table('unit_menu_items')->where('id', $id)->update(['featured_image' => $filename]);
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

   function load_featured_item($id) {
     $dir="uploads/featured_item";
    $db = DB::table('unit_menu_items')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->featured_image;

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
   function delete_featured_item(Request $request) {
     $output_dir = "uploads/featured_item/";
     $id = $request['id'];
     $db = DB::table('unit_menu_items')->where('id', $id)->update(['featured_image' => '']);
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