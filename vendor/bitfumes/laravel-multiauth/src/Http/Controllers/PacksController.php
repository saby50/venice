<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use URL;
class PacksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }

	function index() {
      $data = DB::table('packs')->orderBy('packs.id','desc')->get();
      $packs_options = DB::table('packs_type')->first();
       $type = "web";
		return view('vendor.multiauth.admin.packs.index', compact('data','packs_options','type'));

	}

	function create($pack_type) {
		$services = DB::table('services')->get();
		 $packs_options = DB::table('packs_type')->get();
     $taxes = DB::table('taxes')->get();
		 $categories = array();

		if ($pack_type=="hybrid") {
			$db = DB::table('categories')->get();
		}else if($pack_type=="occasional") {
      $db = DB::table('categories')->where('alias','gondolaride')->get();
    }else {
			$db = DB::table('categories')->where('alias',$pack_type)->get();
		}

		 foreach ($db as $key => $value) {
    	$category_id = $value->id;
    	$category_name = $value->category_name;
    	$services = DB::table('services')
         ->select(DB::raw('services.id as service_id'),
         	DB::raw('services.service_name as service_name'),
         	DB::raw('services.alias as alias'))
    	->where('category_id',$category_id)
    	->get();
    	$categories[$category_name."_".$category_id] = $services;

    }
     $type = "web";
	

	    return view('vendor.multiauth.admin.packs.create', compact('services','categories','pack_type','packs_options','taxes','type'));
	}
   function edit($id) {
    $services = DB::table('services')->get();
    $taxes = DB::table('taxes')->get();
    $packs_options = DB::table('packs_type')->get();
    $data = DB::table('packs')->where('id',$id)->get();
    $pack_type = "";
    $categories = array();
    foreach ($data as $key => $value) {
       $pack_type = $value->pack_type;
    }
    if ($pack_type=="hybrid") {
      $db = DB::table('categories')->get();
    }else if($pack_type=="occasional") {
      $db = DB::table('categories')->where('alias','gondolaride')->get();
    }else {
      $db = DB::table('categories')->where('alias',$pack_type)->get();
    }
    foreach ($db as $key => $value) {
      $category_id = $value->id;
      $category_name = $value->category_name;
      $services = DB::table('services')
         ->select(DB::raw('services.id as service_id'),
          DB::raw('services.service_name as service_name'),
          DB::raw('services.alias as alias'))
      ->where('category_id',$category_id)
      ->get();
      $categories[$category_name."_".$category_id] = $services;
    }
    $packs_services = DB::table('packs_services')->where('pack_id',$id)->get();
    $packs_inclusions = DB::table('packs_inclusions')->where('pack_id',$id)->get();
      $type = "web";
    return view('vendor.multiauth.admin.packs.edit', compact('services', 'packs_options', 'categories','data','packs_inclusions','taxes','id','packs_services','type'));
   }
	function get_services($category_id) {
		$services = DB::table('services')->where('category_id',$category_id)->get();
		$options = array();
		$op = "";
		foreach ($services as $key => $value) {
			$service_name = $value->service_name;
			
			$options[] = array('service_name' => $service_name,'id' => $value->id);

		}
		return $options;

	}
  function get_quantity($service_id,$pack_id) {
    $db = DB::table('packs_services')
          ->where('service_id',$service_id)
          ->where('pack_id',$pack_id)
          ->get();
    return $db;
  }
	function add(Request $request) {
      $pack_name = $request['pack_name'];
      $rates = $request['rates'];
      $pack_type = $request['pack_type'];
      $category_id = $request['category_id'];
      $services = $request['services'];
      $quantity = $request['quantity'];
      $line1 = $request['line1'];
      $line2 = $request['line2'];
      $shortdesc = $request['shortdesc'];
      $description = $request['description'];
      $note = $request['note'];
      $inclusion = $request['inclusion'];
      $alias = $request['alias'];
      $slotsize = $request['slotsize'];
      $age = $request['age'];
      $duration = $request['duration'];
      $whours = $request['whours'];
      $wdays = $request['wdays'];
      $tax_type = $request['tax_type'];
      $tax_id = $request['tax_id'];
      $date = date("Y-m-d H:i:s");
      $featured = $request['featured'];
      $video = $request['video'];
      $offline = $request['offline'];
      $no_of_seats = $request['no_of_seats'];
      if ($featured=="") {
        $featured = "no";
      }else {
        $featured = "yes";
      }

      $data = array('pack_name' => $pack_name,'price' => $rates,'pack_type' => $pack_type, 'teaser_line_1' => $line1,'teaser_line_2' => $line2,'short_description' => $shortdesc,'description' => $description,'note' => $note,'background' => '','icon' => '','alias' => $alias,'age' => $age,'slotsize' => $slotsize,'duration' => $duration,'whours' => $whours,'wdays' => $wdays,'tax_id' => $tax_id,'tax_type' => $tax_type,'featured' => $featured,'video' => $video,'offline' => $offline,'no_seats' => $no_of_seats,'created_at' => $date, 'updated_at' => $date);
      $db = DB::table('packs')->insert($data);
      $pack_id = DB::getPdo()->lastInsertId();
      $fservices = "";

   
      if ($services) {
       foreach ($services as $key => $value) {
        if ($value!="" || $value!=NULL) {
          $get_category_id = $this->get_category_id($value);
          $data2 = array('pack_id' => $pack_id,'category_id' => $get_category_id,'service_id' => $value,'quantity' => $quantity[$key],'created_at' => $date, 'updated_at' => $date);
          $db2 = DB::table('packs_services')->insert($data2);
        }
      }
      }
      
       foreach ($inclusion as $key => $value) {
      	if ($value!="" || $value!=NULL) {
      		$data3 = array('pack_id' => $pack_id,'inclusions' => $value,'created_at' => $date, 'updated_at' => $date);
      		$db3 = DB::table('packs_inclusions')->insert($data3);
      	}
      }
      return redirect('admin/packs/uploads/'.$pack_id);
	}
  function update(Request $request) {
      $pack_name = $request['pack_name'];
      $rates = $request['rates'];
      $pack_type = $request['pack_type'];
      $category_id = $request['category_id'];
      $services = $request['services'];
      $quantity = $request['quantity'];
      $line1 = $request['line1'];
      $line2 = $request['line2'];
      $shortdesc = $request['shortdesc'];
      $description = $request['description'];
      $note = $request['note'];
      $inclusion = $request['inclusion'];
      $alias = $request['alias'];
      $slotsize = $request['slotsize'];
      $age = $request['age'];
      $duration = $request['duration'];
      $whours = $request['whours'];
      $wdays = $request['wdays'];
      $tax_type = $request['tax_type'];
      $tax_id = $request['tax_id'];
      $date = date("Y-m-d H:i:s");
      $pack_id = $request['pack_id'];
      $offline = $request['offline'];
      $featured = $request['featured'];
      $video = $request['video'];
      $status = $request['status'];
      $no_of_seats = $request['no_of_seats'];
      if ($featured=="") {
        $featured = "no";
      }else {
        $featured = "yes";
      }
           
      $db = DB::table('packs')->where('id',$pack_id)->update(['pack_name' => $pack_name,'price' => $rates,'pack_type' => $pack_type, 'teaser_line_1' => $line1,'teaser_line_2' => $line2,'short_description' => $shortdesc,'description' => $description,'note' => $note,'alias' => $alias,'age' => $age,'slotsize' => $slotsize,'duration' => $duration,'whours' => $whours,'wdays' => $wdays,'tax_id' => $tax_id,'tax_type' => $tax_type,'featured' => $featured,'video' => $video,'offline' => $offline,'no_seats' => $no_of_seats,'status' => $status,'created_at' => $date, 'updated_at' => $date]);

       $deleteservices = DB::table('packs_services')->where('pack_id',$pack_id)->delete();
     if ($services) {
      foreach ($services as $key => $value) {
        if ($value!="" || $value!=NULL) {
          $get_category_id = $this->get_category_id($value);
          $data2 = array('pack_id' => $pack_id,'category_id' => $get_category_id,'service_id' => $value,'quantity' => $quantity[$key],'created_at' => $date, 'updated_at' => $date);
          $db2 = DB::table('packs_services')->insert($data2);
        }
      }
      }

       $deleteinclutions = DB::table('packs_inclusions')->where('pack_id',$pack_id)->delete();

       foreach ($inclusion as $key => $value) {
        if ($value!="" || $value!=NULL) {
          $data3 = array('pack_id' => $pack_id,'inclusions' => $value,'created_at' => $date, 'updated_at' => $date);
          $db3 = DB::table('packs_inclusions')->insert($data3);
        }
      }
      if ($db) {
          return redirect('admin/packs/uploads/'.$pack_id);
      }
  }
	function get_category_id($service_id) {
		$db = DB::table('services')->where('id',$service_id)->get();
		return $db[0]->category_id;
	}
	function delete($id) {
	  $delete = DB::table('packs')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
      	$delete2 = DB::table('packs_inclusions')->where('pack_id',$id)->delete();
      	$delete3 = DB::table('packs_services')->where('pack_id',$id)->delete();	
        $delete4 = DB::table('packs_gallery')->where('pack_id',$id)->delete(); 
        return redirect('admin/packs')->withInput()->with($notification,"Packs deleted");
      }
	}

	function uploads($id) {
     $type = "web";
		return view('vendor.multiauth.admin.packs.upload', compact('id','type'));
	}
  function upload(Request $request) {
    return redirect('admin/packs')->withInput()->with('status','Pack added successfully');
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
        $db = DB::table('packs')->where('id', $id)->update(['icon' => $filename]);
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
    $db = DB::table('packs')->where('id', $id)->get();
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
    function delete_icon(Request $request) {
     $output_dir = "uploads/icon/";
     $id = $request['id'];
     $db = DB::table('packs')->where('id', $id)->update(['icon' => '']);
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
        $db = DB::table('packs')->where('id', $id)->update(['background' => $filename]);
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
    function load_forground($id) {
    $dir="uploads/forground";
    $db = DB::table('packs')->where('id', $id)->get();
       $filename = null;
        $ret= array();
        foreach ($db as $key => $value) {
          $file = $value->background;

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

    function delete_forground(Request $request) {
     $output_dir = "uploads/forground/";
     $id = $request['id'];
     $db = DB::table('packs')->where('id', $id)->update(['background' => '']);
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
        $db = DB::table('packs_gallery')->insert(['img_name' => $filename,'pack_id' => $id,'created_at' => $date, 'updated_at' => $date]);
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
    $db = DB::table('packs_gallery')->where('pack_id', $id)->get();
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
    $db = DB::table('packs_gallery')->where('img_name', $fileName)->delete();
    $fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files
    $filePath = $output_dir. $fileName;

    if (file_exists($filePath))
    {
         unlink($filePath);
     }
      echo "Deleted File: ".$filePath;
    }
   }
  

   function get_packs_price($quantity, $pack_id) {
      $db = DB::table('packs')
      ->join('taxes','packs.tax_id','=','taxes.id')
      ->select(DB::raw('packs.*'),
        DB::raw('taxes.tax_percent as tax_percent'))
      ->where('id', $pack_id)
      ->get();
       $tax_percent = "";
        $price = "";
      foreach ($db as $key => $value) {
        $tax_percent = $value->tax_percent;
        $price = $value->price;
      }

      $finalprice = $price * $quantity * $tax_percent/100;
      return $finalprice;
   }
   function delete_featured(Request $request) {
     $output_dir = "uploads/featured/";
     $id = $request['id'];
     $db = DB::table('packs')->where('id', $id)->update(['featured_image' => '']);
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
    $db = DB::table('packs')->where('id', $id)->get();
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
        $db = DB::table('packs')->where('id', $id)->update(['featured_image' => $filename]);
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
        $db = DB::table('packs')->where('id', $id)->update(['mobile_banner' => $filename]);
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
    $db = DB::table('packs')->where('id', $id)->get();
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
     $db = DB::table('packs')->where('id', $id)->update(['mobile_banner' => '']);
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
        $db = DB::table('packs')->where('id', $id)->update(['video_icon' => $filename]);
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

     function load_vidicon($id) {
    $dir="uploads/vidicon";
    $db = DB::table('packs')->where('id', $id)->get();
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
   function delete_vidicon(Request $request) {
     $output_dir = "uploads/vidicon/";
     $id = $request['id'];
     $db = DB::table('packs')->where('id', $id)->update(['video_icon' => '']);
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
        $db = DB::table('packs')->where('id', $id)->update(['featured_app' => $filename]);
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
    $db = DB::table('packs')->where('id', $id)->get();
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
     $db = DB::table('packs')->where('id', $id)->update(['featured_app' => '']);
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