<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class HomeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
     function index() {
     	$data = DB::table('slides')->get();
      $type = "web";
     	return view('vendor.multiauth.admin.home.index', compact('data','type'));
     }

     function create() {
      $type = "web";
   
     	return view('vendor.multiauth.admin.home.create',compact('type'));
     }
     function add(Request $request) {
     	$slider_name = $request['slider_name'];
     	$position = $request['position'];
      $slider_link = $request['slider_link'];
     	$date = date("Y-m-d H:i:s");
     	$db = DB::table('slides')->insert(['slide_name' => $slider_name,'position' => $position,'slider_link' => $slider_link,'created_at' => $date, 'updated_at' => $date]);
        $slide_id = DB::getPdo()->lastInsertId();      
     	if ($db) {
     		return redirect('admin/slide/uploads/'.$slide_id);
     	}

     }
     function update(Request $request) {
     	$slider_name = $request['slider_name'];
     	$position = $request['position'];
     	$date = date("Y-m-d H:i:s");
     	$slide_id = $request['slider_id'];
      $slider_link = $request['slider_link'];
     	$db = DB::table('slides')->where('id',$slide_id)->update(['slide_name' => $slider_name,'position' => $position,'slider_link' => $slider_link,'updated_at' => $date]);
              
     	if ($db) {
     		return redirect('admin/slide/uploads/'.$slide_id);
     	}

     }

     function delete($id) {
     	$db = DB::table('slides')->where('id',$id)->delete();
     	if ($db) {
     		return redirect('admin/slides/')->withInput()->with('status','Slide deleted!');
     	}
     }

     function edit($id) {
      $type = "web";
     	$data = DB::table('slides')->where('id',$id)->get();
     	return view('vendor.multiauth.admin.home.edit', compact('data','id','type'));
     }


     function uploads($id) {
      $type = "web";
          return view('vendor.multiauth.admin.home.upload', compact('id','type'));
     }

    function upload_banner(Request $request) {
    $destinationPath = "uploads/banner";
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
        $db = DB::table('slides')->where('id', $id)->update(['banner' => $filename]);
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
    $dir="uploads/banner";
    $db = DB::table('slides')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->banner;

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
     $output_dir = "uploads/banner/";
     $id = $request['id'];
     $db = DB::table('slides')->where('id', $id)->update(['banner' => '']);
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
        $db = DB::table('slides')->where('id', $id)->update(['banner_mobile' => $filename]);
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
    $db = DB::table('slides')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->banner_mobile;

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
     $db = DB::table('slides')->where('id', $id)->update(['banner_mobile' => '']);
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

   function uploadr() {
   	return redirect('admin/slides')->withInput()->with('status','Slide added successfully');
   }

   function movies() {
    $data = DB::table('movies')->get();
    $type = 'web';
    return view('vendor.multiauth.admin.movies.index', compact('data','type'));
   }
   function movie_create() {
     $type = 'web';
     $languages = DB::table('languages')->get();
    return view('vendor.multiauth.admin.movies.create', compact('type','languages'));
   }
   function movie_edit($id) {
    $type = 'web';
     $languages = DB::table('languages')->get();
     $data = DB::table('movies')->where('id',$id)->get();
    return view('vendor.multiauth.admin.movies.edit', compact('type','languages','data','id'));
   }
   function movie_add(Request $request) {
      $movie_name = $request['movie_name'];
      $slots = $request['slots'];
      $language = $request['language'];
      $url = $request['url'];
      $synopsis = $request['synopsis'];
      $sub_text = $request['sub_text'];
      $date = date("Y-m-d H:i:s");
      $db = DB::table('movies')->insert(['movie_name' => $movie_name,'synopsis' => $synopsis,'sub_text' => $sub_text,'url' => $url,'slots' => $slots,'language' => $language,'created_at' => $date, 'updated_at' => $date]);
      $insertid = DB::getPdo()->lastInsertId();
      if ($db) {
        return redirect('admin/movies/upload/'.$insertid);
      }
   }
  function movie_update(Request $request) {
      $movie_name = $request['movie_name'];
      $slots = $request['slots'];
      $language = $request['language'];
      $url = $request['url'];
      $synopsis = $request['synopsis'];
      $sub_text = $request['sub_text'];
      $movie_id = $request['movie_id'];
      $date = date("Y-m-d H:i:s");
      $db = DB::table('movies')->where('id',$movie_id)->update(['movie_name' => $movie_name,'synopsis' => $synopsis,'sub_text' => $sub_text,'url' => $url,'slots' => $slots,'language' => $language,'updated_at' => $date]);
     
      if ($db) {
        return redirect('admin/movies/upload/'.$movie_id);
      }
   }
   function movie_upload($id) {
    $type = 'web';
     return view('vendor.multiauth.admin.movies.upload', compact('type','id'));
   }

   function upload_icon(Request $request) {
    $destinationPath = "uploads/moviecover";
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
        $db = DB::table('movies')->where('id', $id)->update(['movie_img' => $filename]);
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
    $dir="uploads/moviecover";
    $db = DB::table('movies')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->movie_img;

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
     $output_dir = "uploads/moviecover/";
     $id = $request['id'];
     $db = DB::table('movies')->where('id', $id)->update(['movie_img' => '']);
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
   function upload_r() {
    return redirect('admin/movies')->withInput()->with('status','Movie created successfully');
   }
   function movie_delete($id) {
    $db = DB::table('movies')->where('id',$id)->delete();
    return redirect('admin/movies')->withInput()->with('status','Movie deleted!');
   }


}