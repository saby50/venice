@extends('multiauth::layouts.main') 
@section('title')
Shops
@endsection
@section('content')
<?php 
$shop_id = 0;
foreach ($data as $key => $value) {
  $shop_name = $value->shop_name;
  $shop_alias = $value->shop_alias;
  $short_description = $value->short_description;
  $description = $value->description;
  $shop_category_id = $value->shop_category_id;
  $floor_level = $value->floor_level;
  $number_unit = $value->number_unit;
  $suspend = $value->suspend;
  $priorty = $value->priorty;
  $video = $value->video;
  $shop_id = $value->id;
  $teaser_line_1 = $value->teaser_line_1;
   $teaser_line_2 = $value->teaser_line_2;
}

?>
<div class="main-content style2"> 
<div class="breadcrumbs">
	<ul>
		<li><a href="#/" title="">Home</a></li>
		<li><a href="#/pages/portfolio" title="">Create</a></li>
	</ul>
</div>

<div class="heading-sec">
	<div class="row">
		<div class="col-md-4 column">
			<div class="heading-profile">
				<h2>Shop</h2>

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
  <form action="{{ URL::to('admin/shops/update') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="col-md-12">
			<div class="widget">
				<div class="product-filter">
          <div class="row">
            <div class="col-md-12">
          @if (session('status'))
                <div class="widget no-color">
                    <div class="notify orange-skin with-color">
                        <div class="notify-content">
                            <h3>Congratulation! {{ session('status') }}</h3>

                        <a title="" class="close">x</a>
                        </div>
                    </div>
                    </div>
                </div>
              @endif
              </div>
					<div class="row formarea">
            <div class="col-md-6">
                <label>Shop Name</label>
                <input type="text" class="form-control" name="shop_name" value="<?= $shop_name ?>"  required>
              </div>
              
             
         
           
                  <div class="col-md-6">
                    <label>Shop Category</label>
                       <select class="form-control" name="shop_category_id">

                      <?php foreach ($categories as $key => $value): ?>
                        <?php if($shop_category_id==$value->id): ?>
                        <option value="<?= $value->id ?>" selected><?= $value->category_name ?></option>
                        <?php else: ?>
                          <option value="<?= $value->id ?>" ><?= $value->category_name ?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                  </select>
                  <input type="hidden" name="shop_id" value="<?= $shop_id ?>">
                    </div>


                     
                  
                     <div class="col-md-6">
                      <label>Shop Alias</label><br />
                   <input type="text" class="form-control" name="shop_alias" value="<?= $shop_alias ?>" required>
                   
                    </div>
                         <div class="col-md-6">
                  <label>Floor Level</label>
                    <input type="text" class="form-control" name="floor_level" value="<?= $floor_level ?>" required>
                  </div>
                      <div class="col-md-6">
                  <label>Number(Unit)</label>
                    <input type="text" class="form-control" name="number_unit"  value="<?= $number_unit ?>"  required>
                  </div>
                    <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Video</label><br />
                   <input type="text" name="video" value="" class="form-control"  value="<?= $video ?>">
                   
                    </div>
                          <div class="col-md-6">
                      <label>Teaser Line 1</label><br />
                   <input type="text" class="form-control" name="line1" value="<?= $teaser_line_1 ?>"  required>
                   
                    </div>
                        <div class="col-md-6">
                      <label>Teaser Line 2</label><br />
                   <input type="text" class="form-control" name="line2" value="<?= $teaser_line_2 ?>"  required>
                   
                    </div>
                      <div class="col-md-6">
                    	<label>Short Description</label><br />
                       <textarea class="form-control" id="summernote" name="shortdesc"><?= $short_description ?></textarea>
                   
                    </div>

                    <div class="col-md-6">
                      <label>Description</label><br />
                       <textarea class="form-control" id="summernote2" name="description"><?= $description ?></textarea>                  
                    </div>
             
                    <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Suspend</label><br />
                   <?php if($suspend=="yes"): ?>
                         <input type="radio" name="suspend" value="yes" checked="checked"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspend" value="no"  > No

                      <?php else: ?>
                         <input type="radio" name="suspend" value="yes"> Yes &nbsp;&nbsp;&nbsp;&nbsp;  <input type="radio" name="suspend" value="no"  checked="checked"> No

                      <?php endif; ?>
                  
                   
                    </div>
                     <div class="col-md-6" style="margin-bottom: 20px;">
                      <label>Priorty</label><br />
                     <select class="form-control priorty" name="priorty">
                      <?php for($i=1; $i < 31; $i++): ?>
                        <?php if($priorty==$i): ?>
                        <option value="<?= $i ?>" selected><?= $i ?></option>
                        <?php else: ?>
                          <option value="<?= $i ?>"><?= $i ?></option>
                      <?php endif; ?>
                      <?php endfor; ?>
                       
                     </select>
                   
                    </div>
                    
                   
                    
                    
                   
              <div class="col-md-12">
               
                <input type="submit" class="btn btn-primary" value="Next">

              </div>
					</div>

				</div>
			</div>
	
	</div>
</form>
</div><!-- Panel Content -->
</div>
<script>
$(document).ready(function()
{
 $('#summernote').summernote();
   $('#summernote2').summernote();
  $(".addfield").click(function() {
    $(".addonfields")
    .append(' <div class="row1">    <div class="col-md-6" style="margin-top:0px;"> \n\
            <label>Custom Option</label>\n\
              <input type="text" class="form-control" name="custom_options[]" required>\n\
      </div>\n\
      <div class="col-md-6" style="margin-top:0px;">\n\
        <label>Capacity</label>\n\
          <input type="number" class="form-control" name="capacity[]" required>\n\
          <a class="minus"><i class="fa fa-minus-square-o removeto" aria-hidden="true"></i></a>\n\
  </div></div>');
  });
  $(document).on("click", ".removeto", function (e) { //user click on remove text
      e.preventDefault();
      $(this).closest('.row1').remove();
      x--;
  })
});
</script>
@endsection
