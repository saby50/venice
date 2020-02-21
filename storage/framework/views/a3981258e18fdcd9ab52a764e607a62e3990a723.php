<?php $__env->startSection('title'); ?>
Pay
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<div class="recyclerview firstbox" ng-app="myApp" ng-controller="myCtrl">
	<div class="row">
		<div class="col-12 gv-balance">
			
			<input type="text" name="search" class="form-control searchbox" placeholder="Search by Keywords, Entity....."  ng-model="searchText" autofocus="autofocus">
			
		</div>
	</div>
	<div class="row" style="padding: 15px;">
		
		<div class="col-12 ripple unit_tabs " dir-paginate="d in data | filter:searchText | itemsPerPage:1000">
			<div class="row">
			<div class="col-6">
				<?php 
                    $unit_id = '<% d.id %>';
 

				?>
					<a href="<?php echo e(URL::to('paynow')); ?>/<?= $unit_id ?>" class="areaclick"><strong><% d.unit_name %></strong><br />
			<span><% d.floor_level %></span></a>
			</div>
		  <div class="col-6">
			<a href="<?php echo e(URL::to('paynow')); ?>/<?= $unit_id ?>"><button class="btn payBtn">Pay</button></a>
		  </div>
		</div>

	   </div>
	  
	</div>
	
</div>

<script type="text/javascript" src="<?php echo e(asset('public/js/dirPagination.js')); ?>"></script>
<script type="text/javascript" src="<?= asset('public/js/jquery.vibrate.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});
		$('.searchbox').vibrate();

		$('.searchbox').click();
		
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/wallet/pay.blade.php ENDPATH**/ ?>