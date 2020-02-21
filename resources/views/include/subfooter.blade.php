
   <?php 
    $guest = Helper::get_guest_services();
   ?>
    <section id="bottombanner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 wow fadeInUp" data-wow-delay="0.2s" style="padding-left: 0;z-index: 500;">
                        <div class="pic1">
                            <a href="<?= URL::to('commercial') ?>"><img src="{{ asset('public/images/commercial.jpg') }}" class="web_banner"></a>
                           <a href="<?= URL::to('commercial') ?>"> <img src="{{ asset('public/images/commercial_mobile.jpg') }}" class="mobile_banner"></a>
                          
                        </div>
                    </div>
                </div>
            </div>
        </section>
   <section id="aminities">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="content">
                            <h2>THE GRAND VENICE</h2>
                            <h5 style="text-transform: uppercase;">A True Architectural Wonder With World Class Shopping Options
</h5>
                            <img src="{{ asset('public/images/GV-Underline.png') }}">
                            <p class="mt-2">Get set to be astonished by the beautiful Grand Venice; a true architectural wonder. The beautiful architecture comes together with some of the best shopping options from all around the world. A sight to behold and a haven for the shopping lovers. It is truly incomparable. </p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- #aminities -->
        <!--==========================
      GV Section
    ============================-->
        <section id="gv">
            <div class="container-fluid">
                <div class="row">
                    <ul class="list-inline">
                        <li class="list-inline-item GV011"><img src="{{ asset('public/images/GV01.jpg') }}" class="GV01"></li>
                        <li class="list-inline-item GV022"><img src="{{ asset('public/images/GV02.jpg') }}" class="GV02"></li>
                        <li class="list-inline-item GV033"><img src="{{ asset('public/images/GV03.jpg') }}" class="GV03"></li>
                        <li class="list-inline-item GV044"><img src="{{ asset('public/images/GV04.jpg') }}" class="GV04"></li>
                        <li class="list-inline-item GV055"><img src="{{ asset('public/images/GV05.jpg') }}" class="GV05"></li>
                    </ul>
                </div>
            </div>
        </section>


          <section id="guest-services">
    <div class="container ">
      <div class="row slidertop">
        <h3 style="text-align: center;">Guest Services</h3>
        
      </div>
        <div class="row text-center">
            <div class="col-12">
                <div class="customer-logos">
                  <?php foreach($guest as $key => $value): ?>
  <div class="slide"><img src="<?= asset('public/images/icons/'.$value->image_name) ?>"><br /><div><?= $value->text ?></div></div>
                <?php endforeach; ?>
</div>
    
            </div>
        </div>
    </div>      
  </section>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
  <script type="text/javascript">
      $(document).ready(function(){
  $('.customer-logos').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 1000,
    arrows: false,
    dots: false,
    pauseOnHover: false,
    responsive: [{
      breakpoint: 768,
      settings: {
        slidesToShow: 2
      }
    },{
      breakpoint: 800,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 520,
      settings: {
        slidesToShow: 1
      }
    }]
  });
});
  </script>
