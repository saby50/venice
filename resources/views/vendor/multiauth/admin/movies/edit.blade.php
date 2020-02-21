@extends('multiauth::layouts.main') 


@section('title')
Movie
@endsection


@section('content')
<?php 
foreach ($data as $key => $value) {
  $movie_name = $value->movie_name;
  $url =  $value->url;
  $synopsis = $value->synopsis;
  $slots = $value->slots;
  $language = $value->language;
  $sub_text = $value->sub_text;
}
?>
<div class="main-content style2"> 
<div class="breadcrumbs">
  <ul>
    <li><a href="#/" title="">Home</a></li>
    <li><a href="#/pages/portfolio" title="">Edit</a></li>
  </ul>
</div>

<div class="heading-sec">
  <div class="row">
    <div class="col-md-4 column">
      <div class="heading-profile">
        <h2>Movie</h2>

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
  <form action="{{ URL::to('admin/movies/update') }}" method="post">
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
               <label>Movie Name:</label>
               <input type="text" class="form-control" name="movie_name" value="<?= $movie_name ?>"  required>
              </div>
                 <div class="col-md-6">
                    <label>Slots</label>
                      <input type="text" class="form-control" name="slots" value="<?= $slots ?>"  required>
                    </div>

              <div class="col-md-6">
               <label>Language:</label>
               <select class="form-control" name="language">
                <?php foreach ($languages as $key => $value): ?>
                  <?php if($language==$value->lang_code): ?>
                  <option value="<?= $value->lang_code ?>" selected><?= $value->lang_name ?></option>
                  <?php else: ?>
                    <option value="<?= $value->lang_code ?>"><?= $value->lang_name ?></option>

                  <?php endif; ?>

                <?php endforeach; ?>
                 
               </select>
              </div>
              <input type="hidden" name="movie_id" value="<?= $id ?>">
                <div class="col-md-6">
               <label>Bookmyshow URL:</label>
                 <input type="text" class="form-control" name="url"  value="<?= $url ?>"  required>
              </div>
              <div class="col-md-12">
               <label>Sub Text:</label>
                <input type="text" class="form-control" name="sub_text"  value="<?= $sub_text ?>"  required>
              </div>
               <div class="col-md-12" style="margin-top: 20px;">
               <label>Synopsis:</label>
               <textarea class="form-control" name="synopsis"><?= $synopsis ?></textarea>
              </div>

            
              <div class="col-md-12">
               <br />
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
          </div>

        </div>
      </div>
  
  </div>
</form>
</div><!-- Panel Content -->
</div>

@endsection
