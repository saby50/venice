<?php

namespace Bitfumes\Multiauth\Http\Controllers;

use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;
use Helper;
use Session;
use Crypt;
use Auth;
class LeadsController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('role:super', ['only'=>'show']);
    }

	function index($status2) {
		$data = array();
		if ($status2=="all") {
			$data = DB::table('leads')->where('lead_type','leads')->orWhere('lead_type','GV Tower')->orderBy('id', 'desc')->paginate(10);
		}else {
			$data = DB::table('leads')->where('status',$status2)->where('lead_type','leads')->orWhere('lead_type','GV Tower')->orderBy('id', 'desc')->paginate(10);
		}
		
		$actions = DB::table('lead_actions')->get();
		$status = DB::table('lead_status')->get();
		$type = 'web';
		return view('multiauth::admin.leads', compact('data','type','actions','status','status2'));
	}
	function add_lead_comment(Request $request) {
		$status = $request['status'];
		$comment = $request['comment'];
		$lead_id = $request['lead_id'];
		$uid = Auth::user()->id;
		$date = date("Y-m-d H:i:s");
		$db = DB::table('lead_comments')->insert(['comment' => $comment,'status' => $status,'uid' => $uid,'lead_id' => $lead_id,'created_at' => $date, 'updated_at' => $date]);

		return redirect('admin/leads/all')->withInput()->with('status','Action Applied');

	}
	function update_lead_status($lead_id,$status) {
		$data = DB::table('leads')->where('id',$lead_id)->update(['status'=>$status]);
		$comment = "Lead Marked ".$status;
		$date = date("Y-m-d H:i:s");
		$uid = Auth::user()->id;
		$add_comment = DB::table('lead_comments')->insert(['comment' => $comment,'status' => 'Status Update','uid' =>$uid,'lead_id' => $lead_id ,'created_at' => $date, 'updated_at' => $date]);
		$getstatus = "";
		if ($data) {
			$getstatus = "success";
		}else {
			$getstatus = "failed";
		}
		return $getstatus;

	}
	function get_lead_data($lead_id) {
		$data = DB::table('lead_comments')->where('lead_id',$lead_id)->orderBy('id', 'desc')->get();
		$comments = "";
		foreach ($data as $key => $value) {
            $created_at = $value->created_at;
            $comment = $value->comment;
            $statuss = $value->status;
            $uid = $value->uid;
            $ndate = date('d-M-Y', strtotime($created_at));
            $ntime = date('H:i A', strtotime($created_at));
            $comments.= '<p style="font-size: 15px;"><i><strong>'.$ndate.'</strong> / '.Helper::get_analyst_name($uid).' / '.$ntime.'<br /><strong>'.$statuss.' - </strong>'.$comment.'</i></p>';
        }
        return $comments;

	}
	function lead_claim($lead_id) {
		$uid = Auth::user()->id;
		$date = date("Y-m-d H:i:s");
		$data = DB::table('lead_claim')->insert(['lead_id'=>$lead_id,'uid' => $uid,'created_at' => $date, 'updated_at' => $date]);
        $status = "";
		if ($data) {
			$status = "success";
		}else {
			$status = "failed";
		}
		return $status;

	} 


}