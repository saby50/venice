@extends('layouts.main2')

@section('title')
Notifications
@endsection

@section('content')
<br /><br />
<div class="col-12" style="padding: 0px;">
		<div class="recyclerview">
			<div class="row">

			<div class="col-12">
				
				
			</div>
          	</div>
          		<?php if(count($data) != 0): ?>
			<?php $i=0; foreach($data as $key => $value): ?>
				
				<div class="featured-pwa ripple">
					
				
				
					<div class="row">
					<div class="col-8">
						 <span class="" style="font-size: 12px;color: #000000;font-weight: 500"><?= $value->title ?></span><br />
					</div>
					<div class="col-4" style="text-align: right;">
						 <span class="date"><?= date('d M, Y', strtotime($value->created_at)) ?></span><br />
					</div>
					<div class="col-12">
						 <span class="desc"><?= $value->message ?></span><br />
					</div>
					 
					  
				</div>
				</div>
				
			
				<?php if($i == count($data) - 1): ?>
				<?php else: ?>
					<hr />
				<?php endif; ?>
				

				<?php 
                   $i++;
				?>

			<?php endforeach; ?>
			<?php else: ?>
				<center><img src="{{ asset('public/images/oops2.png') }}"><br /><br /><p style="color: #000;">No Notifications Yet!</p></center>
			<?php endif; ?>
		</div>
</div>
</div>
<style type="text/css">
	.headpwa {
		display: none;
	}
	.footerpwa {
		display: none;
	}
	.recyclerview {
 
    margin-top: -50px;
}
</style>
@endsection