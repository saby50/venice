<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class EventsController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
    function index() {
    	$data = DB::table('events')->orderBy('events.id','desc')->get();
      $type = "web";
    	return view('vendor.multiauth.admin.events.index', compact('data','type'));
    }
    function events_bookings() {
      $data = DB::table('booking_events')
              ->join('events','events.id','=','booking_events.event_id')
              ->select(DB::raw('booking_events.*'),
                DB::raw('events.event_name as event_name'),
             DB::raw('events.start_date as event_date'),
             DB::raw('events.start_time as event_time'))
              ->get();
        $type = 'web';     
	      return view('vendor.multiauth.admin.events.bookings', compact('data','type'));
    }
    function create() {
    	 $taxes = DB::table('taxes')->get();
        $type = "web";
    	return view('vendor.multiauth.admin.events.create', compact('data','taxes','type'));
    }
    function add(Request $request) {
      $event_name = $request['event_name'];
      $event_alias = $request['event_alias'];
      $event_date = $request['event_date'];
      $event_time  = $request['event_time'];
      $line1 = $request['line1'];
      $line2 = $request['line2'];
      $suspend = $request['suspend'];
      $rate_type = $request['rate_type'];
      $tax_id = $request['tax_id'];
      $price = $request['price'];
      $shortdesc = $request['shortdesc'];
      $description = $request['description'];
      $date = date("Y-m-d H:i:s");
      $data = array('event_name' => $event_name,'start_date' => '','start_time' =>'','end_date' => '','end_time' => '','teaser_line_1' => $line1,'teaser_line_2' => $line2,'event_description' => $description,'event_short_description' => $shortdesc,'event_price' => $price,'event_alias' => $event_alias,'tax_id' => $tax_id,'rate_type' => $rate_type,'created_at' => $date, 'updated_at' => $date);
      $db = DB::table('events')->insert($data);
       $insertid = DB::getPdo()->lastInsertId();
      if ($db) {
      	return redirect('admin/events/uploads/'.$insertid);
      }
    }
    function uploads($id) {
    	return view('vendor.multiauth.admin.events.uploads', compact('id'));
    }

    function upload_banner(Request $request) {
    $destinationPath = "uploads/forground";
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
        $db = DB::table('events')->where('id', $id)->update(['forground' => $filename]);
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
    function load_banner($id) {
    $dir="uploads/forground";
    $db = DB::table('events')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->forground;

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

    function delete_banner(Request $request) {
     $output_dir = "uploads/forground/";
     $id = $request['id'];
     $db = DB::table('events')->where('id', $id)->update(['forground' => '']);
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

   function upload_gallery(Request $request) {
    $destinationPath = "uploads/gallery";
    $file = $request->file('myfile2');
    $id = $request['id'];
    $date = date("Y-m-d H:i:s");
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
        $db = DB::table('event_gallery')->insert(['img_name' => $filename,'event_id' => $id,'created_at' => $date, 'updated_at' => $date]);
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
    function load_gallery($id) {
    $dir="uploads/gallery";
    $db = DB::table('event_gallery')->where('event_id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->img_name;

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

    function delete_gallery(Request $request) {
     $output_dir = "uploads/gallery/";
     $id = $request['id'];
     
     if($request['op'] == "delete")
    {
    $fileName = $request['name'];
    $fileid = $request['id'];
    $db = DB::table('event_gallery')->where('img_name', $fileName)->delete();
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    if (file_exists($filePath))
    {
         unlink($filePath);
     }
      echo "Deleted File: ".$filePath;
    }
   }

   function upload_mobile_banner(Request $request) {
    $destinationPath = "uploads/mobile_banner";
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
        $db = DB::table('events')->where('id', $id)->update(['mobile_banner' => $filename]);
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
    function load_mobile_banner($id) {
    $dir="uploads/mobile_banner";
    $db = DB::table('events')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->mobile_banner;

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

    function delete_mobile_banner(Request $request) {
     $output_dir = "uploads/mobile_banner/";
     $id = $request['id'];
     $db = DB::table('events')->where('id', $id)->update(['mobile_banner' => '']);
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
    function uploadr(Request $request) {
    return redirect('admin/events')->withInput()->with('status','Event added successfully');
   }


   function delete($id) {
   	$db = DB::table('events')->where('id',$id)->delete();
   	$event_gallery = DB::table('event_gallery')->where('event_id',$id)->delete();
   	if ($db) {
   		return redirect('admin/events')->withInput()->with('error','Event Deleted');
   	}
   }


}