<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
class VenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }
	function index() {
	 $data = DB::table('venue')
      ->select(DB::raw('venue.id as id'),
      DB::raw('venue_categories.category_name as category_name'),
      DB::raw('venue.location_name as location_name'),
      DB::raw('venue.authorized_person as authorized_person'),
      DB::raw('venue.email as email'),
      DB::raw('venue.phone as phone'),
      DB::raw('venue.address as address'),
      DB::raw('venue.fromtime as fromtime'),
      DB::raw('venue.totime as totime'))
      ->join('venue_categories', 'venue.category','=','venue_categories.id','left')->orderBy('venue.id','desc')->get();
       $type="web";
		return view('vendor.multiauth.admin.venue.index', compact('data', $data,'type'));
	}

	function create() {
      $category = DB::table('venue_categories')->get();
      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      $type="web";
      return view('vendor.multiauth.admin.venue.create', compact('category','days','type'));
	}

	function add(Request $request) {
      $location = $request['location'];
      $category = $request['category'];
      $authorised_person = $request['authorised_person'];
      $email = $request['email'];
      $phone = $request['phone'];
      $address = $request['address'];
      $days = $request['days'];
      $daysop = "";  
      foreach ($days as $key => $value) {
        $daysop .= $value.",";
      }
    
      $date = date("Y-m-d H:i:s");
      $from = $request['from'];
      $to = $request['to'];

      $data = array('location_name' => $location,'category' => $category, 'authorized_person' => $authorised_person, 'email' => $email, 'phone' => $phone,
    'address' => $address,'fromtime' => $from,'totime' => $to,'days' => $daysop ,'created_at' => $date,'updated_at' => $date);
     $db = DB::table('venue')->insert($data);

     if ($db) {
       $notification = "status";
       return redirect('admin/venue')->withInput()->with($notification,"Venue created successfully");
     }
    }
     function delete($id) {
      $delete = DB::table('venue')->where('id', $id)->delete();
      if ($delete) {
      	$notification = "status";
        return redirect('admin/venue')->withInput()->with($notification,"Venue deleted!");
      }
    }
      function edit($id) {
      $category = DB::table('venue_categories')->get();
      $data = DB::table('venue')
      ->where('venue.id', $id)
      ->select(DB::raw('venue.id as id'),
      DB::raw('venue_categories.category_name as category_name'),
      DB::raw('venue.location_name as location_name'),
      DB::raw('venue.authorized_person as authorized_person'),

      DB::raw('venue.email as email'),
      DB::raw('venue.phone as phone'),
      DB::raw('venue.days as days'),
      DB::raw('venue.fromtime as fromtime'),
      DB::raw('venue.totime as totime'),

      DB::raw('venue.address as address'))
      ->join('venue_categories', 'venue.category','=','venue_categories.id')->get();
      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      $type="web";

      return view('vendor.multiauth.admin.venue.edit', compact('category', 'data','days','type'));
    }

    function update(Request $request) {
      $location_id = $request['location_id'];
      $location = $request['location'];
      $category = $request['category'];
      $authorised_person = $request['authorised_person'];
      $email = $request['email'];
      $phone = $request['phone'];
      $address = $request['address'];
      $date = date("Y-m-d H:i:s");
      $from = $request['from'];
      $to = $request['to'];
      $days = $request['days'];
      $daysop = "";  
      foreach ($days as $key => $value) {
        $daysop .= $value.",";
      }
    
      $data = array('location_name' => $location,'category' => $category, 'authorized_person' => $authorised_person, 'email' => $email, 'phone' => $phone,
    'address' => $address,'fromtime' => $from,'totime' => $to, 'days' => $daysop, 'created_at' => $date,'updated_at' => $date);
     $db = DB::table('venue')->where('id', $location_id)->update($data);
     if ($db) {
       $notification = "status";
       return redirect('admin/venue')->withInput()->with($notification,"Venue updated successfully");
     }
    }

}