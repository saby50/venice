<?php 
$wallet = "login";
$pay = "login";
$profile = "login";
if (Auth::check()) {
	$wallet = "wallet";
    $pay = "pay";
    $parking = "paynow/11";
    $profile = "profile";
}
?>
<div class="footerpwa">
	<ul class="footer-menu-pwa">
		<?php if (Request::is('/')): ?>
          <li><img src="{{ asset('public/images/pwa/footerhomea.png') }}"><br />Home</li>
		<?php else: ?>
		  <li><a href="<?= URL::to('/') ?>"><img src="{{ asset('public/images/pwa/footerhome.png') }}" onmouseover="this.src='<?= URL::to("public/images/pwa/footerhomea.png") ?>'" onmouseout="this.src='<?= URL::to("public/images/pwa/footerhome.png") ?>'"></a><br />Home</li>
		<?php endif; ?>
		<?php if (Request::is('pay') || Request::is('scanpay') || Request::segment(1)=="paynow"): ?>
		<li><a href="<?= URL::to($pay) ?>"><img src="{{ asset('public/images/pwa/footerpaya.png') }}"> <br /></a>Pay</li>
		<?php else: ?>
		<li><a href="<?= URL::to($pay) ?>"><img src="{{ asset('public/images/pwa/footerpay.png') }}"> <br /></a>Pay</li>
		<?php endif; ?>
		<?php if (Request::is('cart')): ?>
          <li class="cart-area"><a href="<?= URL::to('cart') ?>"><img src="{{ asset('public/images/pwa/carts.PNG') }}"></a></li>
		<?php else: ?>
		  <li class="cart-area" style="position: relative;display: inline-block;"><a href="<?= URL::to('cart') ?>"><img src="{{ asset('public/images/pwa/cartsa.PNG') }}" onmouseover="this.src='<?= URL::to("public/images/pwa/carts.PNG") ?>'" onmouseout="this.src='<?= URL::to("public/images/pwa/cartsa.PNG") ?>'"></a> </li>
		<?php endif; ?>
		<?php if (Request::is('wallet')): ?>
		<li><img src="{{ asset('public/images/pwa/walleta.png') }}"><br />Wallet</li>
		<?php else: ?>
			<li><a href="<?= URL::to($wallet) ?>"><img src="{{ asset('public/images/pwa/wallet.png') }}" onmouseover="this.src='<?= URL::to("public/images/pwa/walleta.png") ?>'" onmouseout="this.src='<?= URL::to("public/images/pwa/wallet.png") ?>'"></a><br />Wallet</li>
		<?php endif; ?>
		<?php if (Request::is('profile')): ?>
		<li><img src="{{ asset('public/images/pwa/footerprofilea.PNG') }}"><br />Profile</li>
		<?php else: ?>
			<li><a href="<?= URL::to($profile) ?>"><img src="{{ asset('public/images/pwa/footerprofile.PNG') }}" onmouseover="this.src='<?= URL::to("public/images/pwa/footerprofilea.PNG") ?>'" onmouseout="this.src='<?= URL::to("public/images/pwa/footerprofile.PNG") ?>'"></a><br />Profile</li>
		<?php endif; ?>
		
		
	</ul>
	
</div>