<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class ServiceController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
      $data = DB::table('services')
              ->join('categories','services.category_id','=','categories.id')
              ->select(DB::raw('services.*'),
                DB::raw('categories.category_name as category_name'))
              ->orderBy('services.id','desc')
              ->get();
    $type = "web";
	 return view('vendor.multiauth.admin.services.index', compact('data', $data,'type'));
	}

	function create() {  
	  $categories = DB::table('categories')->get();
    $taxes = DB::table('taxes')->get();
    $type="web";
    return view('vendor.multiauth.admin.services.create', compact('categories','taxes','type'));
	}
	function add(Request $request) {
		
		$service_name = $request['service_name'];
		$no_of_seats = $request['no_of_seats'];
		$category_id = $request['category_id'];
    $line1 = $request['line1'];
    $line2 = $request['line2'];
    $shortdesc = $request['shortdesc'];
    $description = $request['description'];
    $tax_type = $request['tax_type'];
    $suspend = $request['suspend'];
    $tax_id = $request['tax_id'];
		$date = date("Y-m-d H:i:s");
    $custom_options = $request['custom_options'];
    $capacity = $request['capacity'];
    $slotsize = $request['slotsize'];
    $alias = $request['alias'];
    $duration = $request['duration'];
    $age = $request['age'];
    $featured = $request['featured'];
    $video = $request['video'];
    $note = $request['note'];
    $offline = $request['offline'];
    if ($featured=="") {
      $featured = "no";
    }else {
      $featured = "yes";
    }
   
		$data[] = array('service_name' => $service_name,'no_seats' => $no_of_seats,'duration' => $duration,'age' => $age,'category_id' => $category_id,'tax_id' => $tax_id,'teaser_line_1' => $line1,'teaser_line_2' => $line2,      
      'short_description' => $shortdesc, 'description' => $description, 'tax_type' => $tax_type,'suspend' => $suspend,'alias' => $alias,'slotsize' => $slotsize,'featured' => $featured,'video' => $video,'notes' => $note,'offline' => $offline,'created_at' => $date, 'updated_at' => $date);
       $db = DB::table('services')->insert($data);
       $insertid = DB::getPdo()->lastInsertId();
      foreach ($custom_options as $key => $value) {
        if ($value!="") {
        $db2 = DB::table('service_options')->insert(['option_name' => $value,'capacity' => $capacity[$key],'service_id' => $insertid,'created_at' => $date, 'updated_at' => $date]);
        }
      }

       if ($db) {
           return redirect('admin/services/uploads/'.$insertid);
       }
	}
  function uploads($id) {
    $type = "web";
    return view('vendor.multiauth.admin.services.upload', compact('id','type'));
  }
	 function delete($id) {
      $delete = DB::table('services')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
        return redirect('admin/services')->withInput()->with($notification,"Service deleted");
      }
    }

    function edit($id) {
       $taxes = DB::table('taxes')->get();
    	$categories = DB::table('categories')->get();
    	$data = DB::table('services')->where('id',$id)->get();
       $type = "web";
      $service_options = DB::table('service_options')->where('service_id', $id)->get();
    	return view('vendor.multiauth.admin.services.edit', compact('categories','data','taxes','service_options','type'));
    }

    function update(Request $request) {
      
		$service_name = $request['service_name'];
		$no_of_seats = $request['no_of_seats'];
		$category_id = $request['category_id'];
		$service_id = $request['service_id'];
     $line1 = $request['line1'];
    $line2 = $request['line2'];
    $shortdesc = $request['shortdesc'];
    $description = $request['description'];
    $duration = $request['duration'];
    $age = $request['age'];
    $tax_type = $request['tax_type'];
    $suspend = $request['suspend'];
    $tax_id = $request['tax_id'];
		$date = date("Y-m-d H:i:s");
    $slotsize = $request['slotsize'];
    $alias = $request['alias'];
    $custom_options = $request['custom_options'];
    $capacity = $request['capacity'];
    $featured = $request['featured'];
    $video = $request['video'];
    $note = $request['note'];
    $offline = $request['offline'];
    $status = $request['status'];
     
     if ($featured=="") {
      $featured = "no";
    }else {
      $featured = "yes";
    }
   
   // $delete = DB::table('service_options')->where('service_id',$service_id)->delete();
   // if ($custom_options != "") {
  //      foreach ($custom_options as $key => $value) {
   //     $db2 = DB::table('service_options')->insert(['option_name' => $value,'capacity' => $capacity[$key],'service_id' => $service_id,'created_at' => $date, 'updated_at' => $date]);      
   //    }
 //   }	
    $db = DB::table('services')->where('id',$service_id)->update(['service_name' => $service_name,'no_seats' => $no_of_seats,'duration' => $duration,'age' => $age,'category_id' => $category_id,'tax_id' => $tax_id,'teaser_line_1' => $line1,'teaser_line_2' => $line2, 'short_description' => $shortdesc, 'description' => $description, 'tax_type' => $tax_type,'suspend' => $suspend,'alias' => $alias,'slotsize' => $slotsize,'featured' => $featured,'video' => $video,'notes' => $note,'offline' => $offline,'status' => $status,'created_at' => $date, 'updated_at' => $date]);
    if ($db) {
           return redirect('admin/services/uploads/'.$service_id);
    }
  }
  function categories() {
    	$data = DB::table('categories')
       ->join('venue','categories.venue_id','=','venue.id')
       ->select(DB::raw('categories.*'),
        DB::raw('venue.location_name as location_name'))
       ->orderBy('categories.id','desc')
       ->get();
       $type = "web";
    	return view('vendor.multiauth.admin.categories.index', compact('data','type'));
  }
  function create_categories() {
    	$venue = DB::table('venue')->get();
       $type = "web";

    	return view('vendor.multiauth.admin.categories.create', compact('venue','type'));
    }

    function add_categories(Request $request) {
    	$category_name = $request['category_name'];
    	$fromtime = $request['fromtime'];
    	$totime = $request['totime'];
    	$venue_id = $request['venue_id'];
     
      $date = date("Y-m-d H:i:s");
    	$db = DB::table('categories')->insert(['category_name' => $category_name, 'fromtime' => $fromtime, 'totime' => $totime,'venue_id' => $venue_id,'created_at' => $date, 'updated_at' => $date]);
    	 if ($db) {
           return redirect('admin/categories')->withInput()->with('status','Category Added Successfully');
       }

    }

    function delete_category($id) {
      $delete = DB::table('categories')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
        return redirect('admin/categories')->withInput()->with($notification,"Category deleted");
      }	
    }

    function edit_category($id) {
    	$venue = DB::table('venue')->get();      
      $data = DB::table('categories')->where('id',$id)->get();
       $type = "web";
    	return view('vendor.multiauth.admin.categories.edit', compact('data', 'venue','managers','type'));
    }

    function update_category(Request $request) {
       $category_name = $request['category_name'];
    	$fromtime = $request['fromtime'];
    	$totime = $request['totime'];
        $date = date("Y-m-d H:i:s");
        $venue_id = $request['venue_id'];
       
        $category_id = $request['category_id'];
    	$db = DB::table('categories')->where('id',$category_id)->update(['category_name' => $category_name, 'fromtime' => $fromtime, 'totime' => $totime,'venue_id' => $venue_id,'created_at' => $date, 'updated_at' => $date]);
    	 if ($db) {
           return redirect('admin/categories')->withInput()->with('status','Category Updated');
       }
    }

     function upload_vidicon(Request $request) {
    $destinationPath = "uploads/vidicon";
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
        $db = DB::table('services')->where('id', $id)->update(['video_icon' => $filename]);
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

  function upload_icon(Request $request) {
    $destinationPath = "uploads/icon";
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
        $db = DB::table('services')->where('id', $id)->update(['icon' => $filename]);
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
        $db = DB::table('services')->where('id', $id)->update(['mobile_banner' => $filename]);
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
    function upload_featured(Request $request) {
    $destinationPath = "uploads/featured";
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
        $db = DB::table('services')->where('id', $id)->update(['featured_image' => $filename]);
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
    function upload_forground(Request $request) {
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
        $db = DB::table('services')->where('id', $id)->update(['forground' => $filename]);
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
     function upload_featured_app(Request $request) {
    $destinationPath = "uploads/featured_app";
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
        $db = DB::table('services')->where('id', $id)->update(['featured_app' => $filename]);
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
    function load_featured_app($id) {
    $dir="uploads/featured_app";
    $db = DB::table('services')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->featured_app;

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
   
   function delete_featured_app(Request $request) {
     $output_dir = "uploads/featured_app/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['featured_app' => '']);
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

   function load_featured($id) {
    $dir="uploads/featured";
    $db = DB::table('services')->where('id', $id)->get();
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
   function load_vidicon($id) {
    $dir="uploads/vidicon";
    $db = DB::table('services')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->video_icon;

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
   function load_mobile_banner($id) {
    $dir="uploads/mobile_banner";
    $db = DB::table('services')->where('id', $id)->get();
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
        $db = DB::table('service_gallery')->insert(['img_name' => $filename,'service_id' => $id,'created_at' => $date, 'updated_at' => $date]);
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
   function load_icon($id) {
    $dir="uploads/icon";
    $db = DB::table('services')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->icon;

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
   function load_forground($id) {
    $dir="uploads/forground";
    $db = DB::table('services')->where('id', $id)->get();
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
   function delete_icon(Request $request) {
     $output_dir = "uploads/icon/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['icon' => '']);
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
   function delete_vidicon(Request $request) {
     $output_dir = "uploads/vidicon/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['video_icon' => '']);
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
    function delete_mobile_banner(Request $request) {
     $output_dir = "uploads/mobile_banner/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['mobile_banner' => '']);
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
  
    function delete_featured(Request $request) {
     $output_dir = "uploads/featured/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['featured_image' => '']);
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
   function delete_forground(Request $request) {
     $output_dir = "uploads/forground/";
     $id = $request['id'];
     $db = DB::table('services')->where('id', $id)->update(['forground' => '']);
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

   function load_gallery($id) {
    $dir="uploads/gallery";
    $db = DB::table('service_gallery')->where('service_id', $id)->get();
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
    $db = DB::table('service_gallery')->where('img_name', $fileName)->delete();
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    if (file_exists($filePath))
    {
         unlink($filePath);
     }
      echo "Deleted File: ".$filePath;
    }
   }
   function upload(Request $request) {
    return redirect('admin/services')->withInput()->with('status','Service added successfully');
   }


}