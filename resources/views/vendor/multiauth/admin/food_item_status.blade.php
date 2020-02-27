<!DOCTYPE html>
<html>
<head>
	<title>Food Item Status</title>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="row" style="padding: 10px;">
	<div class="col-12" style="margin-bottom: 20px;">
		<input type="text" class="form-control" name="search" id="search" placeholder="Search by item name">
		
	</div>
    
	<?php foreach($data as $key => $value): ?>
		 <div class="fcontent">
	<div class="col-6 stitles" style="text-align: left;">
        <?= $value->item_name ?>
		
	</div>

	<div class="col-6 sf-align-right" style="text-align: right;">

		<label class="switch">
            <?php if($value->status=="active"): ?>
             <input type="checkbox" name="veg" value="inactive" data="<?= $value->id ?>" class="status" checked="checked">
             <?php else: ?>
              <input type="checkbox" name="veg" value="active" data="<?= $value->id ?>" class="status">
              <?php endif; ?>
            <span class="slider round"></span>
          </label>   
	</div>
	</div>
<?php endforeach; ?>

</div>
<script type="text/javascript">
	$(document).ready(function() {
         $(".status").change(function() {
            var data = $(this).attr('data');
            var status = $(this).val();
            if (status=="active") {
            	$(this).val("inactive");
            }else {
				$(this).val("active");
            }

            var url = "<?= URL::to('admin/api/change_status') ?>";
            var formData = {
            	'_token':'{{ csrf_token()}}',
            	'item_id': data,
            	'status': status
            };
             $.post(url,  formData, function (resp,textStatus, jqXHR) {
                
      		 });
           
            
         });
         $('#search').keyup(function(){
  		    // Search text
 			var text = $(this).val();
 
  			// Hide all content class element
 			$('.fcontent').hide();

           // Search and show
           $('.fcontent .stitles:contains("'+text+'")').closest('.fcontent').show();
 
         });
	});
	$.expr[":"].contains = $.expr.createPseudo(function(arg) {
  return function( elem ) {
   return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
  };
});
</script>
<style type="text/css">
	.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.fcontent {
	display: contents;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
</body>
</html>