@extends('multiauth::layouts.main') 


@section('title')
Leads
@endsection

@section('content')
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Leads</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Lead(s)</h2>

			</div>
		</div>
		<div class="col-md-8 column">
			<div class="top-bar-chart">
				<div class="quick-report">
					<div class="quick-report-infos">

					</div>
				
				</div>

			</div><!-- Top Bar Chart -->
		</div>
	</div>
</div><!-- Top Bar Chart -->

<div class="panel-content">

	<div class="row">
	@if (session('status'))
				<div class="widget no-color">
						<div class="alert alert-success">
								<div class="notify-content">
									 {{ session('status') }}!

								</div>
						</div>
						</div>
				</div>
			@endif
			</div>
	<div class="row">

		<div class="col-md-12">
			<div class="widget">
			
				<div class="product-filter">


					<div class="row">
						<div class="col-md-4">
							<label>Filter by Status</label>
							<select class="form-control selector">
								<option value="all">All</option>
							    <?php foreach($status as $k => $v): ?>
							    <?php if($status2==$v->status): ?>		    
								<option value="<?= $v->status ?>" selected><?= $v->status ?></option>
								<?php else: ?>
									<option value="<?= $v->status ?>"><?= $v->status ?></option>
								<?php endif; ?>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-12" style="margin-top: 40px;">
							
							<?php if (count($data) != 0): ?>
							<table class="table">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Site Visit Date</th>
											<th>Site Visit Time</th>
											<th>Action</th>
											<th>Status</th>
											
										</tr>
									</thead>
							<?php foreach ($data as $key => $value): ?>

								<tbody>
									<?php if(Auth::user()->user_type=="superadmin"): ?>
									<tr>
										<td><?= $value->name ?><br />
										<?php 
											$authid = Auth::user()->id;
                                            $claimed = Helper::claimed_checked($value->id);
                                            $claimeduserid = 0;
                                            foreach ($claimed as $j => $m) {
                                            	$claimeduserid = $m->uid;
                                            }
                                            if(count($claimed) != 0 && $claimeduserid==$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by you</strong>';
                                            }elseif(count($claimed) != 0 && $claimeduserid!=$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by '.Helper::get_analyst_name($claimeduserid).'</strong>';
                                            }else {
                                              	echo '<a class="claim" data="'.$value->id.'" style="color:#000;text-decoration:underline;">Claim Lead</a>';
                                            }
										?>
										</td>
										<td><?= $value->email ?></td>
										<td><?= $value->phone ?></td>
										<td><?= $value->date ?></td>
										<td><?= $value->time ?><?php 
										$lead_id = $value->id;
										$getstatus = $value->status;
										$commentsdata = Helper::get_comments($lead_id);
										$statusarray = array();
										foreach ($commentsdata as $key => $value) {
											$statusarray[] = $value->status;
										}
										 ?></td>
										<td>
                                             <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php else: ?>
											<?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php elseif (count($claimed)==0): ?>
												<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php else: ?>
										    <select class="form-control actions" name="actions" data="<?= $lead_id  ?>">
											<?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($actions as $key => $value): ?>
												
													<option value="<?= $value->actions ?>"><?= $value->actions ?></option>
												
											
										<?php endforeach; ?>
										</select>

                                        <?php if(count($commentsdata) != 0): ?>
										<a href="#" class="followupbtn" data="<?= $lead_id ?>">View Follow-ups</a>
										<?php endif; ?></td>
										<td>
											 <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control status" name="status" data1="<?= $lead_id ?>" disabled="disabled">
										    <?php else: ?>
										    <?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    	<?php elseif (count($claimed)==0): ?>
												 <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    <?php else: ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>">
										    <?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($status as $k => $v): ?>
											<?php if($v->status != "Fresh"): ?>
										    <?php if($getstatus==$v->status): ?>
											<option value="<?= $v->status ?>" selected><?= $v->status ?></option>
											<?php else: ?>
										    <option value="<?= $v->status ?>"><?= $v->status ?></option>
											<?php endif; ?>
												<?php endif; ?>
										    <?php endforeach; ?>
										</select>
										<div class="loader">Updating...</div></td>
										
									</tr>
									<?php else: ?>
										<?php 
											$authid = Auth::user()->id;
                                            $claimed = Helper::claimed_checked($value->id);
                                            $claimeduserid = 0;
                                            foreach ($claimed as $j => $m) {
                                            	$claimeduserid = $m->uid;
                                            }

										?>
										<?php if(count($claimed) != 0 && $claimeduserid==$authid): ?>
										<tr>
										<td><?= $value->name ?><br />
										<?php 
										
                                            if(count($claimed) != 0 && $claimeduserid==$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by you</strong>';
                                            }elseif(count($claimed) != 0 && $claimeduserid!=$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by '.Helper::get_analyst_name($claimeduserid).'</strong>';
                                            }else {
                                              	echo '<a class="claim" data="'.$value->id.'" style="color:#000;text-decoration:underline;">Claim Lead</a>';
                                            }
										?>
										</td>
										<td><?= $value->email ?></td>
										<td><?= $value->phone ?></td>
										<td><?= $value->date ?></td>
										<td><?= $value->time ?><?php 
										$lead_id = $value->id;
										$getstatus = $value->status;
										$commentsdata = Helper::get_comments($lead_id);
										$statusarray = array();
										foreach ($commentsdata as $key => $value) {
											$statusarray[] = $value->status;
										}
										 ?></td>
										<td>
                                             <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php else: ?>
											<?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php elseif (count($claimed)==0): ?>
												<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php else: ?>
										    <select class="form-control actions" name="actions" data="<?= $lead_id  ?>">
											<?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($actions as $key => $value): ?>
												
													<option value="<?= $value->actions ?>"><?= $value->actions ?></option>
												
											
										<?php endforeach; ?>
										</select>

                                        <?php if(count($commentsdata) != 0): ?>
										<a href="#" class="followupbtn" data="<?= $lead_id ?>">View Follow-ups</a>
										<?php endif; ?></td>
										<td>
											 <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control status" name="status" data1="<?= $lead_id ?>" disabled="disabled">
										    <?php else: ?>
										    <?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    	<?php elseif (count($claimed)==0): ?>
												 <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    <?php else: ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>">
										    <?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($status as $k => $v): ?>
											<?php if($v->status != "Fresh"): ?>
										    <?php if($getstatus==$v->status): ?>
											<option value="<?= $v->status ?>" selected><?= $v->status ?></option>
											<?php else: ?>
										    <option value="<?= $v->status ?>"><?= $v->status ?></option>
											<?php endif; ?>
												<?php endif; ?>
										    <?php endforeach; ?>
										</select>
										<div class="loader">Updating...</div></td>
										
									</tr>
									<?php elseif(count($claimed)==0): ?>
										<tr>
										<td><?= $value->name ?><br />
										<?php 
										
                                            if(count($claimed) != 0 && $claimeduserid==$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by you</strong>';
                                            }elseif(count($claimed) != 0 && $claimeduserid!=$authid) {
                                                echo '<strong data="<?= $value->id ?>">Claimed by '.Helper::get_analyst_name($claimeduserid).'</strong>';
                                            }else {
                                              	echo '<a class="claim" data="'.$value->id.'" style="color:#000;text-decoration:underline;">Claim Lead</a>';
                                            }
										?>
										</td>
										<td><?= $value->email ?></td>
										<td><?= $value->phone ?></td>
										<td><?= $value->date ?></td>
										<td><?= $value->time ?><?php 
										$lead_id = $value->id;
										$getstatus = $value->status;
										$commentsdata = Helper::get_comments($lead_id);
										$statusarray = array();
										foreach ($commentsdata as $key => $value) {
											$statusarray[] = $value->status;
										}
										 ?></td>
										<td>
                                             <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id ?>" disabled="disabled">
											<?php else: ?>
											<?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
											<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php elseif (count($claimed)==0): ?>
												<select class="form-control actions" name="actions" data="<?= $lead_id  ?>" disabled="disabled">
											<?php else: ?>
										    <select class="form-control actions" name="actions" data="<?= $lead_id  ?>">
											<?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($actions as $key => $value): ?>
												
													<option value="<?= $value->actions ?>"><?= $value->actions ?></option>
												
											
										<?php endforeach; ?>
										</select>

                                        <?php if(count($commentsdata) != 0): ?>
										<a href="#" class="followupbtn" data="<?= $lead_id ?>">View Follow-ups</a>
										<?php endif; ?></td>
										<td>
											 <?php if($getstatus=="Converted" || $getstatus=="Cold" || $getstatus=="Duplicate"): ?>
											<select class="form-control status" name="status" data1="<?= $lead_id ?>" disabled="disabled">
										    <?php else: ?>
										    <?php if(count($claimed) != 0 && $claimeduserid!=$authid): ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    	<?php elseif (count($claimed)==0): ?>
												 <select class="form-control status" name="status" data1="<?= $lead_id ?>"  disabled="disabled">
										    <?php else: ?>
										    <select class="form-control status" name="status" data1="<?= $lead_id ?>">
										    <?php endif; ?>
										    <?php endif; ?>
											<option value=""></option>
											<?php foreach($status as $k => $v): ?>
											<?php if($v->status != "Fresh"): ?>
										    <?php if($getstatus==$v->status): ?>
											<option value="<?= $v->status ?>" selected><?= $v->status ?></option>
											<?php else: ?>
										    <option value="<?= $v->status ?>"><?= $v->status ?></option>
											<?php endif; ?>
												<?php endif; ?>
										    <?php endforeach; ?>
										</select>
										<div class="loader">Updating...</div></td>
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
								</tbody>
						
							<?php endforeach; ?>

							</table>
							{{ $data->links() }}
							<?php else: ?>
								No Leads Found
						<?php endif; ?>

							
						</div>
						<div class="col-md-4">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- Panel Content -->
</div>
 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
 	<form method="post" action="{{ asset('admin/add_lead_comment') }}">
 		@csrf
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Add Comments</h4>
         <input type="hidden" name="lead_id" value="" class="lead_id">
         <input type="hidden" name="status" value="" class="status">
       </div>
       <div class="modal-body">
       	<strong>Action: </strong> <span class="action"></span><br /><br />
         <textarea class="form-control" name="comment"></textarea>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         <button type="submit" class="btn btn-primary">Submit</button>
       </div>
     </div>
   </div>
   </form>
 </div>
 <!-- Modal -->
 <div class="modal fade" id="myModal2" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Alert</h4>
        
       </div>
       <div class="modal-body">
       	<p>Lead Claimed!</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-primary claimedby" data-dismiss="modal">OK</button>
       </div>
     </div>
   </div>
  
 </div>
  <!-- Modal -->
 <div class="modal fade" id="myModal3" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <input type="hidden" name="" class="status3" value="">
         <input type="hidden" name="" class="lead_id3" value="">
         <h4 class="modal-title">Alert</h4>
        
       </div>
       <div class="modal-body">
       	<p class="modalcontent"></p>
       </div>
       <div class="modal-footer">
       	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
         <button type="button" class="btn btn-primary statusyes">Yes</button>
       </div>
     </div>
   </div>
  
 </div>
 <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <h3>Follow-ups</h3>
  <span class="showfollowups">
  	
  </span>
</div>
 <style type="text/css">
	 .loader {
    display: none;
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.8) url({{ asset('images/loader2.gif')  }}) center center no-repeat;
    z-index: 1000;
}
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 999;
  top: 0;
  right: 0;
  background-color: #FFF;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
  border-left: solid 1px #ccc;
}

.sidenav span {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px !important;
  color: #818181;
  display: block;
  transition: 0.3s;
}
.sidenav h3 {
  padding: 8px 8px 8px 32px;
}
.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<script type="text/javascript">
	$(document).ready(function() {
       $(".actions").on('change', function() {
       	 var value =  $(this).find('option:selected').val();
       	 var data = $(this).attr('data');
       	 $('.lead_id').attr('value',data);
       	 $('.action').html(value);
       	 $('.status').attr('value',value);

       	 if (value != "Claimed") {
       	 	$("#myModal").modal('show');
       	 }

         
       });
       $(".status").on('change', function() {
       	setTimeout( function() { $('.loader').show(); }, 100 );
        setTimeout( function() { $('.loader').hide(); }, 600 );
       	var status = $(this).find('option:selected').val();
       	var lead_id = $(this).attr('data1');
       	
       	var url = "<?= URL::to('admin/update_lead_status/"+lead_id+"/"+status+"') ?>";
       	if (status == "Cold" || status == "Converted" || status == "Duplicate") {
       		$("#myModal3").modal('show');
       		$('.modalcontent').html("Are you sure you want to mark the lead as '<strong>"+status+"</strong>'? You will not be able to change the status/action after this.");
       		$('.status3').attr('value',status);
       		$('.lead_id3').attr('value',lead_id);
       	}else {
       		   $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
       	$("#myModal2").modal('show');
       	$('.modal-body p').html('Status Updated!');
       
        }
     })

       	}
         

       });

       $('.statusyes').click(function() {
       	$("#myModal3").modal('hide');
           var lead_id = $('.lead_id3').val();
           var status = $('.status3').val();
           	var url = "<?= URL::to('admin/update_lead_status/"+lead_id+"/"+status+"') ?>";

              $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
       	$("#myModal2").modal('show');
       	$('.modal-body p').html('Status Updated!');
       
        }
     })
       });
       	
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".selector").change(function() {
				var data = $('.selector').find(":selected").val();
		var url = "<?= URL::to('admin/leads') ?>/"+data;
		window.location = url;
		});
		$(".claim").click(function() {
			 var lead_id = $(this).attr('data');
			var url = "<?= URL::to('admin/lead_claim/"+lead_id+"') ?>";
            $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
       	$("#myModal2").modal('show');
       	$(this).html("<strong>Claimed by you</strong>");
       
        }
     });
		});
		$(".claimedby").click(function() {
			var data = $('.selector').find(":selected").val();
			window.location = '<?= URL::to('admin/leads/') ?>/'+data;
		})
	});
</script>
<script>
$(".followupbtn").click(function() {
 document.getElementById("mySidenav").style.width = "350px";
 var lead_id = $(this).attr('data');
 var html = "";
 var url = "<?= URL::to('admin/get_lead_data/"+lead_id+"') ?>";
            $.ajax({
       url: url,
       type: 'GET',
       context: this,
       success: function(result) {
       console.log(result);
       $('.showfollowups').html(result);
       
        }
     });
});

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>
@endsection
