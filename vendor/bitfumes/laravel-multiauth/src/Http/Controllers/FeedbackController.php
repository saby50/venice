<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use URL;
class FeedbackController extends Controller
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
     function index($type2,$type3) {
     	$data = DB::table('feedbacks')->join('users','users.id','=','feedbacks.user_id');
     	if ($type2!="all") {
     		if ($type3=="service") {
     			$data = $data->join('services','services.id','=','feedbacks.service_id');
     		}else {
     			$data = $data->join('packs','packs.id','=','feedbacks.service_id');
     		}
     		
     	}
     	$data = $data->select(DB::raw('feedbacks.*'), DB::raw('users.name as name'),DB::raw('users.email as email'),DB::raw('users.phone as phone'));
     	if ($type2!="all") {
     		if ($type3=="service") {
     			$data = $data->where('services.alias',$type2);
     			$data = $data->where('feedbacks.type',$type3);
     		}else {
     			$data = $data->where('packs.alias',$type2);
     			$data = $data->where('feedbacks.type',$type3);
     		}
     		
     	}

     	$data = $data->orderBy('feedbacks.id','desc')->groupBy('feedbacks.order_id')->paginate(10);
        $type = 'web';
        $services = DB::table('services')->get();
        $packs = DB::table('packs')->where('alias','!=','commercial')->get();
     	return view('multiauth::admin.feedbacks.index', compact('data','type','packs','services','type2'));

     }
}