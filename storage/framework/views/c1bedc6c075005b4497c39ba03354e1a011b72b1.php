<?php $__env->startSection('title'); ?>
Pay
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<div class="recyclerview" style="margin-top: 70px;">
	<div class="row">
		<div class="col-12 gv-balance">
			
			<input type="text" name="search" class="form-control searchbox" placeholder="Search by Keywords, Entity....."  ng-model="searchText"><br />
      <button class="button" style="display: none;">Vibrate</button>
			
		</div>
	</div>
	
	
</div>
<div class="row">
     <video id="preview" width="100%" style="width: 100%;"></video>
  </div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.gv-box').click(function() {
          var data = $(this).attr('data');
          window.location = data;
		});

		$('.searchbox').click(function() {
           window.location = "<?= URL::to('pay')  ?>";
		});

	});

</script>

<script type="text/javascript">
  
	let opts = {
  // Whether to scan continuously for QR codes. If false, use scanner.scan() to manually scan.
  // If true, the scanner emits the "scan" event when a QR code is scanned. Default true.
  continuous: true,
  
  // The HTML element to use for the camera's video preview. Must be a <video> element.
  // When the camera is active, this element will have the "active" CSS class, otherwise,
  // it will have the "inactive" class. By default, an invisible element will be created to
  // host the video.
  video: document.getElementById('preview'),
  
  // Whether to horizontally mirror the video preview. This is helpful when trying to
  // scan a QR code with a user-facing camera. Default true.
  mirror: false,
  
  // Whether to include the scanned image data as part of the scan result. See the "scan" event
  // for image format details. Default false.
  captureImage: false,
  
  // Only applies to continuous mode. Whether to actively scan when the tab is not active.
  // When false, this reduces CPU usage when the tab is not active. Default true.
  backgroundScan: true,
  
  // Only applies to continuous mode. The period, in milliseconds, before the same QR code
  // will be recognized in succession. Default 5000 (5 seconds).
  refractoryPeriod: 5000,
  
  // Only applies to continuous mode. The period, in rendered frames, between scans. A lower scan period
  // increases CPU usage but makes scan response faster. Default 1 (i.e. analyze every frame).
  scanPeriod: 1
};
      let scanner = new Instascan.Scanner(opts);
      scanner.addListener('scan', function (content) { 
          window.location = "<?= URL::to('paynow/') ?>/"+content;
      });
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[1]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });

      

      
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\nxampp\htdocs\venice\resources\views/wallet/scanpay.blade.php ENDPATH**/ ?>