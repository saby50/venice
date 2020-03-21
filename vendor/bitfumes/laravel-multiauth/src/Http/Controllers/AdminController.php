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
use App\User;
class AdminController extends Controller
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
  

    public function index($parameter,$type)
    {  
        $data = array();

        if ($parameter=="all") {
            $data = $this->getall();
        }elseif($parameter=="service" && $type=="all") {
            $data = $this->getservices();
        }elseif($parameter=="service" && $type!="all") {
            $data = $this->getservicesbytype($type);
        }elseif($parameter=="packs" && $type!="all") {
            $data = $this->getpacksbytype($type);
        }elseif($parameter=="packs" && $type=="all") {
             $data = $this->getpacks();
        }elseif($parameter=="events" && $type=="all") {
             $data = $this->getevents();
        }

        $services = DB::table('services')->get();
        $packs = DB::table('packs')->where('pack_type','!=', 'leads')->get();
        $filters = DB::table('filter_types')->where('page_name','dash')->get();
        $paymentcat = DB::table('filter_types')
        ->where('page_name','booking2')
        ->where('filter_value','!=','all')
        ->where('filter_value','!=','online')
        ->where('filter_value','!=','offline')
        ->get();

        $paymentmode = DB::table('filter_types')
        ->where('page_name','booking2')
        ->where('filter_value','=','offline')
        ->orWhere('filter_value','=','online')
        ->get();
        $foc_reasons = DB::table('foc_reasons')->get();

        return view('multiauth::admin.home', compact('data','services','packs','filters','parameter','type','paymentcat','paymentmode','foc_reasons'));
    }
  

     function getpacksbytype($type) {
         $todaydate = date('d');
        //Today Service Bookings
        $todaydataserv = DB::table('bookings_packs')
                ->whereDate('bookings_packs.created_at', Carbon::today())
                ->groupBy('bookings_packs.order_id')
                ->where('bookings_packs.status','success')
                ->where('bookings_packs.pack_id',$type)
                ->get();
        $todayamount = 0;
        $todayservamount = 0;        
        foreach ($todaydataserv as $key => $value) {
             $todayamount += $value->price + $value->tax;
        }
       
       $todaysbookings = count($todaydataserv);


        //Service Total Bookings
        $sertotal = DB::table('bookings_packs')                   
                    ->where('bookings_packs.status','success')
                     ->where('bookings_packs.pack_id',$type)
                    ->get();
        $totalamount = 0;
        $seramount = 0;
       
        foreach ($sertotal as $key => $value) {
             $totalamount += $value->price + $value->tax;
        } 

        $totalsale =  count($sertotal);
        
        $now = Carbon::now();
        $month = $now->month;

        
         //Service this Month Bookings
        $monthsertotal = DB::table('bookings_packs')                   
                    ->whereMonth('bookings_packs.created_at',$month)
                    ->where('bookings_packs.status','success')
                     ->where('bookings_packs.pack_id',$type)
                    ->get();

        $monthlytotal = 0;
        $monthlyser = 0;        
        foreach ($monthsertotal as $key => $value) {
             $monthlyser += $value->price + $value->tax;
        } 

        $monthlytotal = $monthlyser;
        $monthbookings = count($monthsertotal);


          $lastmonth = new Carbon('last month');
          //Service last Month Bookings
       $lastmonthsertotal = DB::table('bookings_packs')                   
                    ->whereMonth('bookings_packs.created_at',$lastmonth)
                    ->where('bookings_packs.status','success')
                     ->where('bookings_packs.pack_id',$type)
                    ->get();
        $lastmonthtotal = 0;  
        foreach ($lastmonthsertotal as $key => $value) {
             $lastmonthtotal += $value->price + $value->tax;
        } 

        $lastmonthbookings = count($lastmonthsertotal);

        $data = array('todayamount' => $todayamount, 'todaysbookings' => $todaysbookings,'monthlytotal' => $monthlytotal,'monthbookings' => $monthbookings,'totalamount' => $totalamount,'totalsale' => $totalsale,'lastmonth' => $lastmonthtotal, 'lastmonthbookings' => $lastmonthbookings);

        return $data;
    }

     function getservicesbytype($type) {
       $monthtotal = $this->get_monthly_total('service',$type);
        $total = $this->get_total('service',$type);
        $total_today = $this->get_total_today('service',$type);
        $get_total_last_month = $this->get_total_last_month('service',$type);
    

       $data = array('monthlytotal' => $monthtotal['monthlytotal'], 'monthbookings' => $monthtotal['monthbookings'],'totalamount' => $total['totalamount'],'totalsale' => $total['totalsale'],'todayamount' => $total_today['todayamount'], 'todaysbookings' => $total_today['todaysbookings'],'lastmonth' => $get_total_last_month['lastmonth'], 'lastmonthbookings' => $get_total_last_month['lastmonthbookings']);
    
        return $data;
    }

    function getall() {


        $monthtotal = $this->get_monthly_total('all','all');
        $total = $this->get_total('all','all');
        $total_today = $this->get_total_today('all','all');
        $get_total_last_month = $this->get_total_last_month('all','all');
    

       $data = array('monthlytotal' => $monthtotal['monthlytotal'], 'monthbookings' => $monthtotal['monthbookings'],'totalamount' => $total['totalamount'],'totalsale' => $total['totalsale'],'todayamount' => $total_today['todayamount'], 'todaysbookings' => $total_today['todaysbookings'],'lastmonth' => $get_total_last_month['lastmonth'], 'lastmonthbookings' => $get_total_last_month['lastmonthbookings']);
    
        return $data;
    }

    function get_monthly_total($type,$parameter) {
         $date = date('d-m-Y');
      
     $data = array();
     $now = Carbon::now();
     $month = $now->month;

     if ($type=="all" && $parameter=="all") {
         $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service')
                ->whereMonth('bookings.created_at', $month)  
                ->where('bookings.status','success')                        
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month) 
              ->where('bookings_packs.status','success')       
               ->orderBy('bookings_packs.created_at','desc')
              ->get();


           $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereMonth('booking_events.created_at', $month)  
              ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
              ->get();

            foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

          $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }  
        
        foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
             $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }  
                foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }            
     }elseif($type=="service" && $parameter=="all") {
        $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service')
                ->where('bookings.status','success')
                ->whereMonth('bookings.created_at', $month)                          
                ->orderBy('bookings.created_at','desc')
                ->get();
        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

          $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }
                

     }elseif($type=="service" && $parameter!="all") {
        $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service')
                ->where('bookings.service_id',$parameter)
                ->where('bookings.status','success')
                ->whereMonth('bookings.created_at', $month)                          
                ->orderBy('bookings.created_at','desc')
                ->get();
        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

          $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }
                

     }elseif($type=="packs" && $parameter=="all") {
         $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month)
              ->where('bookings_packs.status','success')        
               ->orderBy('bookings_packs.created_at','desc')
              ->get();
      foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
             $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      


       }elseif($type=="packs" && $parameter!="all") {
         $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month)  
              ->where('bookings_packs.status','success')        
               ->where('bookings_packs.pack_id',$parameter)      
               ->orderBy('bookings_packs.created_at','desc')
              ->get();
      foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
             $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      


       }elseif($type=="events" && $parameter=="all") {
         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->where('booking_events.status','success')        
               ->orderBy('booking_events.created_at','desc')
              ->get();  
                foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }        


       }elseif($type=="events" && $parameter!="all") {
         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->where('booking_events.event_id',$parameter) 
              ->where('booking_events.status','success')     
               ->orderBy('booking_events.created_at','desc')
              ->get();  
                foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }        


       }


            

         
                
      

      

       $data2 = array();

        $monthbookings = count($data);
        $monthlytotal = 0;

        foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }

          $data2 = array('monthlytotal' => $monthlytotal,'monthbookings' => $monthbookings);


          return $data2;

    }

    function get_total_today($type,$parameter) {
         $date = date('d-m-Y');
      
     $data = array();
     $now = Carbon::now();
     $month = $now->month;

     if ($type=="all" && $parameter=="all") {
            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.status','success')
                ->where('bookings.type','service')
                ->whereDate('bookings.created_at', Carbon::today())                          
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereDate('bookings_packs.created_at', Carbon::today()) 
               ->where('bookings_packs.status','success')       
               ->orderBy('bookings_packs.created_at','desc')
              ->get();


         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereDate('booking_events.created_at', Carbon::today())  
              ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
              ->get();    

          foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }            
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }
     }elseif($type=="service" && $parameter=="all") {
        $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.status','success')
                ->where('bookings.type','service')
                ->whereDate('bookings.created_at', Carbon::today())                          
                ->orderBy('bookings.created_at','desc')
                ->get();

                 foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

     }elseif($type=="service" && $parameter!="all") {
        $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  

                ->where('bookings.type','service')
                 ->where('bookings.status','success')
                ->where('bookings.service_id',$parameter)
                ->whereDate('bookings.created_at', Carbon::today())                          
                ->orderBy('bookings.created_at','desc')
                ->get();

                 foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

     }elseif($type=="packs" && $parameter=="all") {

         $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereDate('bookings_packs.created_at', Carbon::today())  
               ->where('bookings_packs.status','success')      
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

               foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

     }elseif($type=="packs" && $parameter!="all") {

         $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
               ->where('bookings_packs.service_id',$parameter)
              ->whereDate('bookings_packs.created_at', Carbon::today())  
               ->where('bookings_packs.status','success')      
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

               foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

     }elseif($type=="events" && $parameter=="all") {

          $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereDate('booking_events.created_at', Carbon::today()) 
               ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
              ->get(); 

              foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }      

     }elseif($type=="events" && $parameter!="all") {

          $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereDate('booking_events.created_at', Carbon::today())
               ->where('booking_events.service_id',$parameter) 
               ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
              ->get(); 

              foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }      

     }

          

       $data2 = array();

        $monthbookings = count($data);
        $monthlytotal = 0;

        foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }

          $data2 = array('todayamount' => $monthlytotal,'todaysbookings' => $monthbookings);


          return $data2;

    }

     function get_total_last_month($type,$parameter) {
    
      $data = array();
      $monthlytotal = 0;

     if ($type=="all" && $parameter=="all") {
          $month = new Carbon('last month');
            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.status','success')
                ->where('bookings.type','service')
                ->whereMonth('bookings.created_at', $month)                                       
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month) 
              ->where('bookings_packs.status','success')       
               ->orderBy('bookings_packs.created_at','desc')
              ->get();


         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereMonth('booking_events.created_at', $month) 
              ->where('booking_events.status','success')      
               ->orderBy('booking_events.created_at','desc')
              ->get();    

          foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }            
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

         foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }
     }elseif($type=="service" && $parameter=="all") {
       
           $month = new Carbon('last month');
            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.status','success')
                ->where('bookings.type','service')
                ->whereMonth('bookings.created_at', $month)                                       
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month)
              ->where('bookings_packs.status','success')        
               ->orderBy('bookings_packs.created_at','desc')
              ->get();


         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereMonth('booking_events.created_at', $month)
              ->where('booking_events.status','success')     
               ->orderBy('booking_events.created_at','desc')
              ->get();    

          foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => "0");
            
          }            
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => "0");
            
        }      

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

         foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }


     }elseif($type=="service" && $parameter!="all") {
       
           $month = new Carbon('last month');
            $db = DB::table('bookings')
                ->select(DB::raw('bookings.*'))  
                ->where('bookings.type','service')
                ->where('bookings.status','success')
                ->where('bookings.service_id',$parameter)
                ->whereMonth('bookings.updated_at', $month)
                ->groupBy('bookings.order_id')                                       
                ->get(); 


                $amount = 0;

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;
            $amount = $value->amount;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

         foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['price'] + $v['tax'];
        }



     }elseif($type=="packs" && $parameter=="all") {


          $month = new Carbon('last month');
            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.status','success')
                ->where('bookings.type','service')
                ->whereMonth('bookings.created_at', $month)                                       
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month) 
              ->where('bookings_packs.status','success')       
               ->orderBy('bookings_packs.created_at','desc')
              ->get();


         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereMonth('booking_events.created_at', $month) 
              ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
              ->get();    

          foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' =>  "0");
            
          }            
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => "0");

            
        }

         foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }
      

     }elseif($type=="packs" && $parameter!="all") {


        $month = new Carbon('last month');
      


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))  
              ->whereMonth('bookings_packs.created_at', $month) 
              ->where('bookings_packs.pack_id',$parameter) 
              ->where('bookings_packs.status','success')         
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

          
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

      

         foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['price'] + $v['tax'];
        }
      

     }elseif($type=="events" && $parameter=="all") {
         $month = new Carbon('last month');

         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
              ->whereMonth('booking_events.created_at', $month) 
              ->where('booking_events.status','success')   
               ->orderBy('booking_events.created_at','desc')
                ->groupBy('booking_events.order_id')
              ->get();    

              foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $amount);
            
          }   

            foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

             $monthlytotal += $v['price'] + $v['tax'];
             
           }
          
        }
   

     }

          

       $data2 = array();

        $monthbookings = count($data);
        

       

          $data2 = array('lastmonth' => $monthlytotal,'lastmonthbookings' => $monthbookings);


          return $data2;

    }


    function get_total($type,$parameter) {
         $date = date('d-m-Y');
      
     $data = array();
     $now = Carbon::now();
     $month = $now->month;


     if ($type=="all" && $parameter=="all") {
         
            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service')  
                ->where('bookings.status','success')                 
                ->orderBy('bookings.created_at','desc')
                ->get();


            $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name')) 
               ->where('bookings_packs.status','success') 
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

           
                
         foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }      

        foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }
     }elseif($type=="service" && $parameter=="all") {


            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service') 
                ->where('bookings.status','success')                  
                ->orderBy('bookings.created_at','desc')
                ->get();

                 foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

     }elseif($type=="service" && $parameter!="all") {


            $db = DB::table('bookings')
                ->leftjoin('service_options','bookings.optional','=','service_options.id')  
                ->select(DB::raw('bookings.*'),
                    DB::raw('service_options.option_name as option_name'))  
                ->where('bookings.type','service')
                ->where('bookings.status','success')   
                ->where('bookings.service_id',$parameter)                           
                ->orderBy('bookings.created_at','desc')
                ->get();

                 foreach ($db as $key => $value) {
            $service_id = $value->service_id;
            $optional = $value->optional;

            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);

            
        }

     }elseif($type=="packs" && $parameter=="all") {

           $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name'))
                    ->where('bookings_packs.status','success')  
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

               foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }    


     }elseif($type=="packs" && $parameter!="all") {

           $db2 = DB::table('bookings_packs')
                ->leftjoin('service_options','bookings_packs.optional','=','bookings_packs.id') 
              ->select(DB::raw('bookings_packs.*'),
                    DB::raw('service_options.option_name as option_name')) 
                    ->where('bookings_packs.pack_id',$parameter)
                    ->where('bookings_packs.status','success')    
               ->orderBy('bookings_packs.created_at','desc')
              ->get();

               foreach ($db2 as $key => $value) {
            $service_id = $value->pack_id;
            $optional = $value->optional;
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
        }    


     }elseif($type=="events" && $parameter=="all") {

         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
               ->orderBy('booking_events.created_at','desc')
               ->where('booking_events.status','success')
              ->get();    

 foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }     
     }elseif($type=="events" && $parameter!="all") {

         $db3 = DB::table('booking_events')
              ->select(DB::raw('booking_events.*'))
               ->where('booking_events.event_id',$parameter)
               ->where('booking_events.status','success')    
               ->orderBy('booking_events.created_at','desc')
              ->get();    

 foreach ($db3 as $key => $value) {
            $data[$value->order_id][] = array('price' => $value->price,'tax' => $value->tax,'status'=> $value->status,'amount' => $value->amount);
            
          }     
     }


       $data2 = array();

        $monthbookings = count($data);
        $monthlytotal = 0;

        foreach ($data as $key => $value) {
           foreach ($value as $k => $v) {

            
             
           }
           $monthlytotal += $v['amount'];
        }

          $data2 = array('totalamount' => $monthlytotal,'totalsale' => $monthbookings);


          return $data2;

    }

     function getservices() {
       $monthtotal = $this->get_monthly_total('service','all');
        $total = $this->get_total('service','all');
        $total_today = $this->get_total_today('service','all');
    $get_total_last_month = $this->get_total_last_month('service','all');

         $data = array('monthlytotal' => $monthtotal['monthlytotal'], 'monthbookings' => $monthtotal['monthbookings'],'totalamount' => $total['totalamount'],'totalsale' => $total['totalsale'],'todayamount' => $total_today['todayamount'], 'todaysbookings' => $total_today['todaysbookings'],'lastmonth' => $get_total_last_month['lastmonth'], 'lastmonthbookings' => $get_total_last_month['lastmonthbookings']);
    
        return $data;
    }
    function getevents() {
         $monthtotal = $this->get_monthly_total('events','all');
        $total = $this->get_total('events','all');
        $total_today = $this->get_total_today('events','all');
        $get_total_last_month = $this->get_total_last_month('events','all');

         $data = array('monthlytotal' => $monthtotal['monthlytotal'], 'monthbookings' => $monthtotal['monthbookings'],'totalamount' => $total['totalamount'],'totalsale' => $total['totalsale'],'todayamount' => $total_today['todayamount'], 'todaysbookings' => $total_today['todaysbookings'],'lastmonth' => $get_total_last_month['lastmonth'], 'lastmonthbookings' => $get_total_last_month['lastmonthbookings']);
    
        return $data;
    }
      function getpacks() {
        $monthtotal = $this->get_monthly_total('packs','all');
        $total = $this->get_total('packs','all');
        $total_today = $this->get_total_today('packs','all');
        $get_total_last_month = $this->get_total_last_month('packs','all');

         $data = array('monthlytotal' => $monthtotal['monthlytotal'], 'monthbookings' => $monthtotal['monthbookings'],'totalamount' => $total['totalamount'],'totalsale' => $total['totalsale'],'todayamount' => $total_today['todayamount'], 'todaysbookings' => $total_today['todaysbookings'],'lastmonth' => $get_total_last_month['lastmonth'], 'lastmonthbookings' => $get_total_last_month['lastmonthbookings']);
    
        return $data;
    }

    public function show()
    {
        $admins = Admin::where('id', '!=', auth()->id())->get();
        return view('multiauth::admin.show', compact('admins'));
    }

    public function showChangePasswordForm()
    {
        return view('multiauth::admin.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'oldPassword'   => 'required',
            'password'      => 'required|confirmed',
        ]);
        auth()->user()->update(['password' => bcrypt($data['password'])]);

        return redirect(route('admin.home'))->with('message', 'Your password is changed successfully');
    }
    function users() {
        $data = DB::table('users')->orderBy('users.id','desc')->paginate(10);
       
        $type = "web";
        return view('vendor.multiauth.admin.user', compact('data','type'));
    }
    function exportFile($records) {
     $heading = false;
    if(!empty($records))
      foreach($records as $row) {
      if(!$heading) {
        // display field/column names as a first row
        echo implode("\t", array_keys($row)) . "\n";
        $heading = true;
      }
      echo implode("\t", array_values($row)) . "\n";
      }
    exit;
   }
   function export_data() {
     $data = DB::table('users')->orderBy('users.id')->get();
     $array = array();
     foreach ($data as $key => $value) {
       $array[] = array('Phone' => $value->phone, 'Name' => $value->name,'Email' => $value->email);
     }
     $filename = "USERS".date('dmyHis') . ".xls";     
     header("Content-Type: application/vnd.ms-excel");
     header("Content-Disposition: attachment; filename=\"$filename\"");
     return  $this->exportFile($array);
   }
    function sendsms(Request $request) {
      $user_phone = $request['user_phone'];
      $phones = "";
      foreach ($user_phone as $key => $value) {
        $phones .=  $value.",";
      }
      $phoneno =  rtrim($phones,",");
      Session::put('phoneno',$phoneno);
      return redirect('admin/compose');
      
    }
    function compose() {
      $phoneno = Session::get('phoneno');
       $type = "web";
      return view('vendor.multiauth.admin.compose', compact('phoneno','type'));
    }
    function send(Request $request) {
      $phoneno = Session::get('phoneno');
      $content =  $request['message'];
      Helper::send_multiple_otp($phoneno, $content);
      return redirect('admin/users')->withInput()->with('status','Bulk SMS sent!');

    }
    function get_users() {
         $data = DB::table('users')->get();
         return $data;
    }
    function refundinitiate(Request $request) {
       $order_id = $request['order_id'];
       $refund_id = $request['refund_id'];
       $reason = $request['reason'];

      $checkid = DB::table('bookings')
        ->where('order_id',$order_id)
        ->get();
      $phone = ""; $amount = 0;
      foreach ($checkid as $key => $value) {
          $book_pack_id = $value->id;
          $updated_at = $value->updated_at;
          $phone  = $value->phone;
          $amount = $value->amount;
      }

       $db = DB::table('bookings')->where('order_id',$order_id)->update(['refund' => 'yes','refund_id' => $refund_id, 'amount' => '0','price' => '0','tax' =>'0','refund_reason' => $reason,'created_at' => $updated_at,'updated_at' => $updated_at]);
       $db2 = DB::table('bookings_packs')->where('order_id',$order_id)->update(['refund' => 'yes','refund_id' => $refund_id, 'amount' => '0','price' => '0','tax' =>'0','refund_reason' => $reason,'created_at' => $updated_at,'updated_at' => $updated_at]);
       if ($db) {
          $content = "Your order ".$order_id." dated ".date('d M, Y',strtotime($updated_at))." for Rs. ".$amount." is initiated for refund. It would take 7-10 working days for the processing. Regards";
          Helper::send_otp($phone,$content);
         
       }

       return redirect()->back()->withInput()->with('status','Refund Initiated');
    }

    function changedate(Request $request) {
      $order_id = $request['order_id'];
      $service_id = $request['service_id'];
      $type = $request['type'];
      $fromdate = date('d-m-Y',strtotime($request['fromdate']));
      $book_pack_id = 0;
      $updated_at = "";
      

      if ($type=="packs") {
        $checkid = DB::table('bookings_packs')
        ->where('pack_id',$service_id)
        ->where('order_id',$order_id)
        ->get();

      foreach ($checkid as $key => $value) {
          $book_pack_id = $value->id;
          $updated_at = $value->updated_at;
      }
        $db = DB::table('bookings_packs')
        ->where('pack_id',$service_id)
        ->where('order_id',$order_id)
        ->update(['date' => $fromdate,'created_at' => $updated_at,'updated_at' => $updated_at]);
       
        $db2 = DB::table('bookings')
        ->where('book_pack_id',$book_pack_id)
        ->where('order_id',$order_id)
        ->update(['date' => $fromdate,'created_at' => $updated_at,'updated_at' => $updated_at]);
      }else {
       $checkid = DB::table('bookings')
        ->where('order_id',$order_id)
        ->get();

      foreach ($checkid as $key => $value) {
          $book_pack_id = $value->id;
          $updated_at = $value->updated_at;
      }
         $db2 = DB::table('bookings')
        ->where('service_id',$service_id)
        ->where('order_id',$order_id)
        ->update(['date' => $fromdate,'created_at' => $updated_at,'updated_at' => $updated_at]);
      }

      return redirect()->back()->withInput()->with('status','Arrival Date Changed');
    }
    function settings() {
      $type = 'web';
      $services = DB::table('services')->get();
      $version = DB::table('versions')->get();
      $packs = DB::table('packs')->get();
      $data = DB::table('mailers')->get();
      $food_order = DB::table('food_order_status')->get();
      return view('vendor.multiauth.admin.settings.index', compact('type','services','packs','data','version','food_order'));
    }
    function update_version(Request $request) {
      $version = $request['version'];
      $db = DB::table('versions')->update(['version' => $version]);
      return redirect()->back()->withInput()->with('status','Version updated!');

    }

    function maintenance() {
       $data = DB::table('maintenance')->get();
       $type = 'web';
      return view('vendor.multiauth.admin.maintenance',compact('data','type'));
    }
    function addmailers(Request $request) {
      $service = $request['service'];
      $email = $request['email'];
      $date = date("Y-m-d H:i:s");
      $db = DB::table('mailers')->insert(['service' => $service,'emails' => $email, 'created_at' => $date,'updated_at' => $date]);

      return redirect()->back()->withInput()->with('status','Email Added');

    }
    function delete_mailer($id) {
      $delete = DB::table('mailers')->where('id',$id)->delete();
      if ($delete) {
        return redirect()->back()->withInput()->with('status','Email Deleted');
      }
    }
     function edit_mailer($id) {
      $type = 'web';
      $data = DB::table('mailers')->where('id',$id)->get();
       $services = DB::table('services')->get();
      $packs = DB::table('packs')->get();
      return view('vendor.multiauth.admin.settings.edit', compact('type','services','packs','data','id'));
    }
    function updatemailers(Request $request) {
       $service = $request['service'];
      $email = $request['email'];
      $date = date("Y-m-d H:i:s");
      $id = $request['id'];
      $db = DB::table('mailers')->where('id',$id)->update(['service' => $service,'emails' => $email,'updated_at' => $date]);

      return redirect('admin/settings')->withInput()->with('status','Email Updated');
    }

     function main_update(Request $request) {
    $android_maintenance = $request['android_maintenance'];
    $ios_maintenance = $request['ios_maintenance'];
    $message = $request['message'];
    if ($android_maintenance=="") {
      $android_maintenance = "false";     
     
    }
    if ($ios_maintenance=="") {     
      $ios_maintenance = "false";
      
    }
    $date = date("Y-m-d H:i:s");
    $update = DB::table('maintenance')->where('id','1')->update(['maintenance' => $android_maintenance,'message' => $message,'updated_at' => $date]);
    $update1 = DB::table('maintenance')->where('id','2')->update(['maintenance' => $ios_maintenance,'message' => $message,'updated_at' => $date]);

     if ($update) {
         $notification = "status";
        return redirect('admin/maintenance')->withInput()->with($notification, 'Maintenance Updated');
      }


  }
  function update_food_order(Request $request) {
     $food_order = $request['food_order'];
  
    if ($food_order=="no") {
      $fstatus = "yes";     
     
    }else {
      $fstatus = "no";
    }
    $db = DB::table('food_order_status')->where('id','1')->update(['status' => $fstatus]);
    $notification = "status";
    return redirect('admin/settings')->withInput()->with($notification,'Food Order Updated');
  }
}
