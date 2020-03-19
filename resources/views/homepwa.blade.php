@extends('layouts.main2')

@section('title')
Home
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<?php foreach($slider as $key => $value): ?>        
			<div class="slider-pwa">
				<a href="<?= URL::to($value->slider_link) ?>"><img data-u="image" src="<?= asset('public/uploads/banner/'.$value->banner) ?>" class="desktop" data="<?= URL::to($value->slider_link) ?>" alt="<?= $value->banner ?>" /></a>
				<a href="<?= URL::to($value->slider_link) ?>"><img data-u="image" src="<?= asset('public/uploads/mobile_banner/'.$value->banner_mobile) ?>" data="<?= URL::to($value->slider_link) ?>" class="mobile" alt="<?= $value->banner ?>"  /></a>
			</div>
		<?php endforeach; ?>
		
	</div>
	<?php if(count($events)!= 0): ?>
	<div class="col-12">
		<!-- Start RecyclerView -->
		<div class="recyclerview">
			<div class="row">

				<div class="col-12">
					<div class="recyclerviewhead" style="color: #EE0000;">
						 Featured Events
					</div>
					<div class="recyclerviewhead2">
						<?php if(count($events) > 1): ?>
						<a href="<?= URL::to('categories#eventss') ?>">View All</a>
					<?php endif; ?>
					</div>		
				</div>
			</div>
			<?php $i=0; foreach($events as $key => $value): ?>
			<a href="<?= URL::to('events/'.$value->event_alias."#bookingform") ?>">
				<div class="featured-pwa ripple">
					<div class="row">
						<div class="col-4">

							<img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>"  alt="<?= $value->featured_app ?>">
						</div>	
						<div class="col-8" style="padding-left: 24px;">
							<span class="title"><?= $value->event_name ?></span><br />
							<span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
							<span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'packs');
							
							?>
								<?= date('l, F j Y',strtotime($value->start_date)) ?> (<?= $value->start_time ?>)
							</span>
						</div>
					</div>
				</div>
			</a>
			<?php if($i == count($events) - 1): ?>
				<?php else: ?>
					<hr />
				<?php endif; ?>
				

				<?php 
				$i++;
				?>

			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
	<div class="col-12">
		<!-- Start RecyclerView -->
		<div class="recyclerview">
			<div class="row">

				<div class="col-12">
					<div class="recyclerviewhead" style="color: #EE0000;">
						 Featured Packs
					</div>
					<div class="recyclerviewhead2">
						<a href="<?= URL::to('categories#packss') ?>">View All</a>
					</div>		
				</div>
			</div>
			<?php $i=0; foreach($featured2 as $key => $value): ?>
			<a href="<?= URL::to('packs/'.$value->alias."#bookingform") ?>">
				<div class="featured-pwa ripple">
					<div class="row">
						<div class="col-4">

							<img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>"  alt="<?= $value->featured_image ?>">
						</div>	
						<div class="col-8" style="padding-left: 24px;">
							<span class="title"><?= $value->pack_name ?></span><br />
							<span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
							<span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'packs');
							if (count($rates)==1) {
								echo '<i class="fa fa-rupee"></i> '.$rates[0];
							}elseif (count($rates)==0) {
								echo 'Get Quote';
							}else {
								echo '<i class="fa fa-rupee"></i> '.min($rates). " - <i class='fa fa-rupee'></i> ".max($rates);
							}
							?></span>
						</div>
					</div>
				</div>
			</a>
			<?php if($i == count($featured2) - 1): ?>
				<?php else: ?>
					<hr />
				<?php endif; ?>
				

				<?php 
				$i++;
				?>

			<?php endforeach; ?>
		</div>
		<!-- End RecyclerView -->
		<div id="doeSupported"></div>
		<div class="wallet-box ripple">
			<?php 
			$wallet = "login";
			if (Auth::check()) {
				$wallet = "wallet";
			}
			?>

			<div class="row">
				<div class="col-5">
					<img src="{{ asset('public/images/pwa/walleticon.PNG') }}" class="walleticon" alt="walleticon.PNG" ><br />

					<?php if(Auth::check()): ?>
						Your GV-Pay Balance<br />
						<h3><i class="fa fa-rupee"></i> <?= Crypt::decrypt(Auth::user()->wall_am) ?></h3>
						<?php else: ?>
							Please <a href="<?= URL::to($wallet) ?>">Login</a> For GV Pay Balance
						<?php endif; ?>

					</div>
					<div class="col-7">
						<img src="{{ asset('public/images/pwa/earn.PNG') }}" alt="earn.PNG"><br />
						<div style="margin-top: 3px;">Get UPTO <span style="color: #6be61a;font-size: 20px;">10%</span> EXTRA ON GV PAY</div>
						<a href="{{ URL::to($wallet) }}"><img src="{{ asset('public/images/pwa/recharge.PNG') }}" style="margin-bottom: -22px;" alt="recharge.PNG" class="wallrech"></a>

					</div>

				</div>

			</div>
			<!-- Start RecyclerView -->
			<div class="recyclerview">
				<div class="row">

					<div class="col-12">
						<div class="recyclerviewhead" style="color: #EE0000;">

							 Featured Activities

						</div>
						<div class="recyclerviewhead2">
							<a href="<?= URL::to('categories#activities') ?>">View All</a>
						</div>		
					</div>
				</div>
				<?php $i=0; foreach($featured as $key => $value): ?>
				<a href="<?= URL::to('booking/'.$value->alias."#bookingform") ?>">
					<div class="featured-pwa ripple">
						<div class="row">
							<div class="col-4">

								<img class="img-fluid mx-auto d-block" src="<?= URL::to('public/uploads/featured_app/'.$value->featured_app) ?>" alt="<?= $value->featured_image ?>">
							</div>	
							<div class="col-8">
								<span class="title"><?= $value->service_name ?></span><br />
								<span class="desc"><?= $value->teaser_line_1 ?> <?= $value->teaser_line_2 ?></span><br />
								<span class="prices"><?php $rates = Helper::get_all_rates($value->id, 'service');
								if (count($rates)==1) {
									echo '<i class="fa fa-rupee"></i> '.$rates[0];
								}elseif (count($rates)==0) {
									echo 'Get Quote';
								}else {
									echo '<i class="fa fa-rupee"></i> '.min($rates). " - <i class='fa fa-rupee'></i> ".max($rates);
								}
								?></span>
							</div>
						</div>
					</div>
				</a>
				<?php if($i == count($featured) - 1): ?>
					<?php else: ?>
						<hr />
					<?php endif; ?>


					<?php 
					$i++;
					?>

				<?php endforeach; ?>
			</div>
			<!-- End RecyclerView -->
		</div>
		<div class="col-12 commercial-area">
			<img src="{{ asset('public/images/pwa/commercial.JPG') }}" alt="commercial.JPG">

		</div>
		<?php if(Helper::get_menu_item_count()!=0): ?>
		<div class="col-md-12">
		<!-- Start RecyclerView -->
			<div class="recyclerview">
				<div class="row">

					<div class="col-12">
						<div class="recyclerviewhead" style="color: #EE0000;">
							
							Order Food
							
						</div>
						<div class="recyclerviewhead2">
							<a href="<?= URL::to('foodorder#restaurants') ?>">View All</a>
						</div>		
					</div>
				</div>
				<?php $i=0; foreach($foodorder as $key => $value): ?>
				
				<a href="<?= URL::to('show-menu/all/'.Crypt::encrypt($value->id)) ?>">
					<div class="featured-pwa ripple">
						<div class="row">
							<div class="col-4">
								<img class="img-fluid mx-auto d-block feature" src="<?= URL::to('public/uploads/foodstore/'.$value->foodstore) ?>" alt="<?= $value->foodstore ?>"><span style="color: #000;">Prep: <?= $value->prep_time ?></span>
							</div>	
							<div class="col-8">
								<span class="title"><?= $value->unit_name ?></span><br />
								<span class="desc"><?= $value->tags ?></span><br />
								<hr />
                                <div class="desc"  style="margin-top: 10px;">
                                    <div class="row">
                                    <div class="col-6" style="font-size: 8px;">
                                    	<?php 
                   							$nonveg = Helper::get_veg_non($value->id);
									    ?>
									    <?php if(in_array('veg', $nonveg)): ?>
                                        <img src="{{ asset('public/images/veg.png') }}" style="width: 15px;height: 15px;">
                                    	<?php endif; ?>
                                    	<?php if(in_array('nonveg', $nonveg)): ?>
                                         <img src="{{ asset('public/images/nonveg.png') }}" style="width: 15px;height: 15px;">
                                    	<?php endif; ?>
                                        
                                    </div>

                                     <div class="col-6" style="text-align: right;">
                                        <i class='fa fa-rupee'></i> <?= $value->price_for_two ?> For Two
                                    </div></div>
                                    </div>
                                
                            </div>
						</div>
					</div>
				</a>
				<?php if($i == count($foodorder) - 1): ?>
					<?php else: ?>
						<hr />
					<?php endif; ?>
					

					<?php 
					$i++;
					?>

				<?php endforeach; ?>
			</div>

			<!-- End RecyclerView -->
</div>
<?php endif; ?>
	</div>
	<script type="text/javascript">

		function init(val){
			alert(val);
		}
	</script>
<style type="text/css">
	.featureimage {
    width: 107px;
    height: 90px;
    border-radius: 15px;
    background-position: center !important;
    background-size: cover !important;
    border: solid 1px #ccc;

}
.feature {
	border: solid 1px #ccc;
}
</style>
	@endsection