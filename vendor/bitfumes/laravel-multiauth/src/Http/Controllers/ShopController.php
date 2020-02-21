<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class ShopController extends Controller
{  

	public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }

	public function index() {

     $data = DB::table('shops')
             ->leftjoin('shop_category','shops.shop_category_id','=','shop_category.id')
             ->select(DB::raw('shops.*'),
               DB::raw('shop_category.category_name as category_name'))
             ->orderBy('shops.id','desc')
             ->get();

              $type = "web";
     return view('vendor.multiauth.admin.shops.index', compact('data','type'));
	}
	public function create() {
	  $categories = DB::table('shop_category')->get();
     $type = "web";
    return view('vendor.multiauth.admin.shops.create', compact('categories','type'));
	}

	function add(Request $request) {
      $shop_name = $request['shop_name'];
      $shop_category_id = $request['shop_category_id'];
      $shop_alias = $request['shop_alias'];
      $floor_level = $request['floor_level'];
      $number_unit = $request['number_unit'];
      $video = $request['video'];
      $shortdesc = $request['shortdesc'];
      $description = $request['description'];
       $line1 = $request['line1'];
    $line2 = $request['line2'];
      $suspend = $request['suspend'];
      $priorty = $request['priorty'];
      $date = date("Y-m-d H:i:s");
      $data = array('shop_name' => $shop_name,'shop_alias' => $shop_alias,'short_description' => $shortdesc,'description' => $description,'shop_category_id' => $shop_category_id,'floor_level' => $floor_level,'number_unit' => $number_unit,'video' => $video,'suspend' => $suspend,'priorty' => $priorty,'teaser_line_1' => $line1,'teaser_line_2' => $line2,'created_at' => $date, 'updated_at' => $date);
      $db = DB::table('shops')->insert($data);
       $insertid = DB::getPdo()->lastInsertId();
      if ($db) {
      	return redirect('admin/shops/uploads/'.$insertid);
      }
	}
  function edit($id) {
     $categories = DB::table('shop_category')->get();
     $data = DB::table('shops')->where('id',$id)->get();
      $type = "web";
    return view('vendor.multiauth.admin.shops.edit',compact('categories','data','type')); 
  }
  function update(Request $request) {
      $shop_name = $request['shop_name'];
      $shop_category_id = $request['shop_category_id'];
      $shop_alias = $request['shop_alias'];
      $floor_level = $request['floor_level'];
      $number_unit = $request['number_unit'];
      $video = $request['video'];
         $line1 = $request['line1'];
    $line2 = $request['line2'];
      $shortdesc = $request['shortdesc'];
      $description = $request['description'];
      $suspend = $request['suspend'];
      $priorty = $request['priorty'];
      $shop_id = $request['shop_id'];
      $date = date("Y-m-d H:i:s");
      
      $db = DB::table('shops')->where('id',$shop_id)->update(['shop_name' => $shop_name,'shop_alias' => $shop_alias,'short_description' => $shortdesc,'description' => $description,'shop_category_id' => $shop_category_id,'floor_level' => $floor_level,'number_unit' => $number_unit,'video' => $video,'suspend' => $suspend,'priorty' => $priorty,'teaser_line_1' => $line1,'teaser_line_2' => $line2,'created_at' => $date, 'updated_at' => $date]);
      
      if ($db) {
        return redirect('admin/shops/uploads/'.$shop_id);
      }
  }

	function uploads($id) {
         return view('vendor.multiauth.admin.shops.upload', compact('id'));
	}

  function shop_categories() {
    $data = DB::table('shop_category')->get();
     $type = "web";
    return view('vendor.multiauth.admin.shops.shop_categories', compact('data','type'));
  }
   function shop_categories_create() {
   $type = "web";
    return view('vendor.multiauth.admin.shops.shop_categories_create', compact('data','type'));
  }
  function cat_add(Request $request) {
    $category_name = $request['category_name'];
    $date = date("Y-m-d H:i:s");
    $db = DB::table('shop_category')->insert(['category_name' => $category_name,'created_at' => $date, 'updated_at' => $date]);
    if ($db) {
      return redirect('admin/shop_categories')->withInput()->with('status','Category Created');
    }
  }
  function delete_category($id) {
    $db = DB::table('shop_category')->where('id',$id)->delete();
    if ($db) {
      return redirect('admin/shop_categories')->withInput()->with('status','Category Deleted!');
    }
  }
  function cat_update(Request $request) {
    $category_name = $request['category_name'];
    $category_id = $request['category_id'];
    $date = date("Y-m-d H:i:s");
    $db = DB::table('shop_category')->where('id',$category_id)->update(['category_name' => $category_name, 'updated_at' => $date]);
    if ($db) {
      return redirect('admin/shop_categories')->withInput()->with('status','Category Updated');
    }
  }
  function edit_category($id) {
    $data = DB::table('shop_category')->where('id',$id)->get();
     $type = "web";
      return view('vendor.multiauth.admin.shops.shop_categories_edit', compact('data','id','type'));
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
        $db = DB::table('shops')->where('id', $id)->update(['banner' => $filename]);
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
    $db = DB::table('shops')->where('id', $id)->get();
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
     $output_dir = "uploads/forground/";
     $id = $request['id'];
     $db = DB::table('shops')->where('id', $id)->update(['banner' => '']);
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
        $db = DB::table('shops')->where('id', $id)->update(['banner_mobile' => $filename]);
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
    $db = DB::table('shops')->where('id', $id)->get();
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
     $db = DB::table('shops')->where('id', $id)->update(['banner_mobile' => '']);
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
        $db = DB::table('shop_gallery')->insert(['img_name' => $filename,'shop_id' => $id,'created_at' => $date, 'updated_at' => $date]);
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
    $db = DB::table('shop_gallery')->where('shop_id', $id)->get();
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
    $db = DB::table('shop_gallery')->where('img_name', $fileName)->delete();
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    if (file_exists($filePath))
    {
         unlink($filePath);
     }
      echo "Deleted File: ".$filePath;
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
        $db = DB::table('shops')->where('id', $id)->update(['featured_image' => $filename]);
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
    function load_featured($id) {
    $dir="uploads/featured";
    $db = DB::table('shops')->where('id', $id)->get();
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

    function delete_featured(Request $request) {
     $output_dir = "uploads/featured/";
     $id = $request['id'];
     $db = DB::table('shops')->where('id', $id)->update(['featured_image' => '']);
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


    function upload_home_banner(Request $request) {
    $destinationPath = "uploads/home_banner";
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
        $db = DB::table('shops')->where('id', $id)->update(['combo_banner' => $filename]);
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
    function load_home_banner($id) {
    $dir="uploads/home_banner";
    $db = DB::table('shops')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->combo_banner;

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

    function delete_home_banner(Request $request) {
     $output_dir = "uploads/home_banner/";
     $id = $request['id'];
     $db = DB::table('shops')->where('id', $id)->update(['combo_banner' => '']);
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


    function upload_home_mobile_banner(Request $request) {
    $destinationPath = "uploads/home_mobile_banner";
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
        $db = DB::table('shops')->where('id', $id)->update(['combo_banner_mobile' => $filename]);
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
    function load_home_mobile_banner($id) {
    $dir="uploads/home_mobile_banner";
    $db = DB::table('shops')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->combo_banner_mobile;

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

    function delete_home_mobile_banner(Request $request) {
     $output_dir = "uploads/home_mobile_banner/";
     $id = $request['id'];
     $db = DB::table('shops')->where('id', $id)->update(['combo_banner_mobile' => '']);
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

    function upload_logo(Request $request) {
    $destinationPath = "uploads/logos";
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
        $db = DB::table('shops')->where('id', $id)->update(['logo' => $filename]);
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
    function load_logo($id) {
    $dir="uploads/logos";
    $db = DB::table('shops')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->logo;

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

    function delete_logo(Request $request) {
     $output_dir = "uploads/logos/";
     $id = $request['id'];
     $db = DB::table('shops')->where('id', $id)->update(['logo' => '']);
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
    return redirect('admin/shops')->withInput()->with('status','Shop added successfully');
   }

   function delete($id) {
   	$db = DB::table('shops')->where('id',$id)->delete();
   	$shop_gallery = DB::table('shop_gallery')->where('shop_id',$id)->delete();
   	if ($db) {
   		return redirect('admin/shops')->withInput()->with('error','Shop Deleted');
   	}
   }

}