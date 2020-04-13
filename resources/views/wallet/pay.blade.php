@extends('layouts.main2')

@section('title')
Pay
@endsection

@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<div class="recyclerview firstbox" ng-app="myApp" ng-controller="myCtrl">
	<div class="row">
		<div class="col-6 paybox">
			<a href="{{ URL::to('wallet') }}"><img src="<?= URL::to('public/images/gv_pocket.JPG') ?>" style="width: 50%;"></a>
			<div style="font-size: 12px;margin-top: 10px;">Balance: Rs. <?= Crypt::decrypt(Auth::user()->wall_am) ?></div>
			
		</div>
		<div class="col-6 paybox">
			<a href="{{ URL::to('food_card') }}"><img src="<?= URL::to('public/images/food_card.JPG') ?>" style="width: 50%;"></a>
			<div style="font-size: 12px;margin-top: 10px;">Balance: Rs. <?= Crypt::decrypt(Auth::user()->food_card) ?></div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 gv-balance">
			
			<input type="text" name="search" class="form-control searchboxarea" placeholder="Search by Keywords, Entity....."  ng-model="searchText" autofocus="autofocus">
			
		</div>
	</div>
	<div class="row" style="padding: 15px;">
		
		<div class="col-12 ripple unit_tabs " dir-paginate="d in data | filter:searchText | itemsPerPage:1000">
			<div class="row">
			<div class="col-6">
				<?php 
                    $unit_id = '<% d.id %>';
 

				?>
					<a href="{{ URL::to('paynow') }}/<?= $unit_id ?>" class="areaclick"><strong><% d.unit_name %></strong><br />
			<span><% d.floor_level %></span></a>
			</div>
		  <div class="col-6">
			<a href="{{ URL::to('paynow') }}/<?= $unit_id ?>"><button class="btn payBtn">Pay</button></a>
		  </div>
		</div>

	   </div>
	  
	</div>
	
</div>

<script type="text/javascript" src="{{ asset('public/js/dirPagination.js') }}"></script>
<script type="text/javascript" src="<?= asset('public/js/jquery.vibrate.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});
		$('.searchboxarea').vibrate();

		$('.searchboxarea').click();
		
	});
	  var app = angular.module('myApp', ['angularUtils.directives.dirPagination'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });
      var url = "<?= URL::to('api/get_units') ?>";

      app.controller('myCtrl', function($scope, $http) {
        $http.get(url)
       .then(function(response) {
           $scope.data = response.data;
       });
      });
</script>
<style type="text/css">
	.paybox {
		padding: 10px;
		text-align: center;
		border: solid 1px #ccc;
		margin-bottom: 20px;
	}
	.paybox a {
		color: #000;
	}
</style>
@endsection