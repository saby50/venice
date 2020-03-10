<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>The Grand Venice Mall | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="theme-color" content="#37367c"/>
    <?php if (\Request::is('/')): ?>
    <meta property="title" content="The Grand Venice Mall">
    <meta property="description" content="Do you want a perfect day out? Come to the Grand Venice Mall. The perfect destination for everyone who wants to have some fun and shop to their heart's delight. NCR's biggest tourist attraction featuring the best of architectural elements from Venice beckon you to experience unlimited happiness.">
    <meta property="og:title" content="The Grand Venice Mall">
    <meta property="og:description" content="Do you want a perfect day out? Come to the Grand Venice Mall. The perfect destination for everyone who wants to have some fun and shop to their heart's delight. NCR's biggest tourist attraction featuring the best of architectural elements from Venice beckon you to experience unlimited happiness.">
    <meta property="og:image" content="{{ asset('public/images/GV03.jpg') }}">
    
    <?php else: ?>
     @yield('includes')
    <?php endif; ?>
    <script src="{{ asset('public/js/jquery-2.1.3.js') }}"></script>
    @yield('meta')
     
    <!-- Favicons -->
    <link href="{{ asset('public/images/favicon.png') }}" rel="icon">
    <link href="{{ asset('public/images/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
    <!-- Bootstrap CSS File -->
    <link href="{{ asset('public/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
       <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Libraries CSS Files -->
    <link href="{{ asset('public/lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/lib/animate/animate.min.css') }}" rel="stylesheet">

    <link href="{{ asset('manifest.json') }}" rel="manifest">

    <!-- Main Stylesheet File -->
    <link href="{{ asset('public/css/front/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/front/media.css') }}" rel="stylesheet">
      <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery-ui.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('public/css/jquery.timepicker.min.css') }}">
    <script src="{{ asset('public/js/jquery.timepicker.min.js') }}"></script>
    <?php 
$check_mobile = Helper::check_mobile();
if($check_mobile=="1"):?>
 <link rel="stylesheet" type="text/css" href="{{ asset('public/css/front/stylepwa.css') }}"> 
    <script src="{{ asset('notification.js') }}"></script>

    <?php endif; ?>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1374080652739991');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1374080652739991&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TBRV3B8');</script>
<!-- End Google Tag Manager -->
</head>

<body>
  
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBRV3B8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php 
$check_mobile = Helper::check_mobile();
if($check_mobile=="1"):?>
@include('layouts.headerpwa')

 @yield('content')

     @include('layouts.footerpwa')
 <script type="text/javascript">
     if ($(window).width() < 960) {
        window.addEventListener('load', e => {
  if ('serviceWorker' in navigator) {
    try {
       navigator.serviceWorker.register('<?= URL::to('sw.js') ?>');
       console.log('SW Registered!');
    }catch(error) {
    
    }
  }
});
}
else {
  
}
    $(document).ready(function() {
       let orn = getOrientation();
       if (orn=="landscape-primary") {
        $("#landScapeError").show();
       }else if (orn=="landscape-secondary") {
              $("#landScapeError").show();
      }
   
            
        function getOrientation() {
            let _orn = screen.msOrientation ||
            (screen.orientation || screen.mozOrientation).type;
        
            switch(_orn){
                case 'portrait-primary':
                case 'portrait-secondary':
                    
                    break;
                case 'landscape-primary':
                    console.log('This is the laptop/desktop version')
                    break;
                case 'landscape-secondary':
                    break;
                case undefined:
                    //not supported
                    break;
                default:
                    //something unknown
            }
            return _orn;
        }
        
        window.addEventListener('orientationchange', (ev)=>{
            orn = getOrientation();
            if (orn=="landscape-primary") {
              $("#landScapeError").show();
            }else if (orn=="landscape-secondary") {
              $("#landScapeError").show();
            }else {
              $('#landScapeError').hide();
            }
        })

        $(".parking").click(function() {
            $("#myModal").modal('show');
        });

    });
      
     </script>

     <?php if(Helper::get_device_platform()!="ios"): ?>
     <div class="init-loader" id="init-loader">
        <img src="{{ asset('public/images/loader.gif') }}">
     </div>
   <?php endif; ?>

     <div id="landScapeError">
      <div class="row">
        <div class="col-5">
          <img src="{{ asset('public/images/LandscapeMode_bhpxby.webp') }}">
          
        </div>
        <div class="col-7">
          <div class="_3Xca2"><strong>Rotate your device</strong></div>
       <div class="_2yYj6">We do not support landscape mode yet. Please go back to portrait mode for the best experience</div>
        </div>
        
      </div>
       
     </div>

    
<script type="text/javascript">
  $(function () {
    // page is loaded, it is safe to hide loading animation
    $('.init-loader').show();
    

   $( window ).on( "load", function() {
       $('.init-loader').hide();
    });
});

   
</script>
 <!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="">
      <span class="close">&times;</span>
      
    </div>
    <div class="modal-body">
      <p class="balance-error" style="font-size: 16px;">Coming Soon!<br />
    </p>
      
    </div>
    <div style="margin-top: 30px;">
      <h3>Modal Footer</h3>
    </div>
  </div>

</div>
<?php else: ?>
@include('layouts.header')

     @yield('content')

     @include('layouts.footer')
  <?php endif; ?>

</body>
</html>