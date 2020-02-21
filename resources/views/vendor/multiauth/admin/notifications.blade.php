<script type="text/javascript">
   $(document).ready(function() {
    var type = "<?= $type ?>";
    if (type=="web" || type=="all") {
      
    
    var usertype = "<?= Auth::user()->user_type ?>";
    
     if (usertype=="unit_manager") {
        var suspended = "<?= Helper::check_if_unit_suspended(Auth::user()->email); ?>";
    if (suspended=="yes") {
       $("#myModalSuspended").modal({backdrop: 'static', keyboard: false});
    }
    var count = "<?php if (Auth::user()->user_type=="unit_manager") {
          echo Helper::checknewbookings(Auth::user()->email);
    }else {
      echo "0";
    }  ?>";
      var url = "<?= URL::to('/admin/api/checknewbookings/'.Auth::user()->email) ?>";
window.setInterval(function(){
  $.get(url, function(data) {
      if (data > count) {
         notifyMe();
      }
  });
}, 5000);
function notifyMe() {
  var usertype = "<?= Auth::user()->user_type ?>";
  var useremail = "<?= Auth::user()->email ?>";
 var unit_id = "<?php if (Auth::user()->user_type=="unit_manager") {
          echo Helper::get_unit_manager_id(Auth::user()->email);
    }else {
      echo "0";
    }   ?>";
      const title = 'Wallet Payment';
const options = {
  icon: '<?= URL::to("/images/favicon.png") ?>',
  body: 'New GV Pay Payment Received'
};
  // Let's check if the browser supports notifications
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have alredy been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    if (usertype=="unit_manager") {
      var notification = new Notification(title,options); 
      window.setInterval(function(){
           window.location = "<?= URL::to('/admin/units/revenue/todays/') ?>/"+unit_id;
      }, 2000);
    }
    
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== 'denied' || Notification.permission === "default") {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
       if (usertype=="unit_manager") {

         var notification = new Notification(title,options);  
         window.setInterval(function(){

          window.location = "<?= URL::to('/admin/units/revenue/todays/') ?>/"+unit_id;
      }, 2000);
      }
      }
    });

  }

  // At last, if the user has denied notifications, and you 
  // want to be respectful there is no need to bother them any more.
}

     }else if(usertype=="superadmin") {
      var count = "<?php if (Auth::user()->user_type=="superadmin") {
          echo Helper::get_booking_counts();
    }else {
      echo "0";
    }  ?>";
  var url = "<?= URL::to('/admin/api/get_booking_counts') ?>";
    window.setInterval(function(){
  $.get(url, function(data) {
      if (data > count) {
         notifyMe();
      }
  });
}, 5000);

    function notifyMe() {
  var usertype = "<?= Auth::user()->user_type ?>";
  var useremail = "<?= Auth::user()->email ?>";
 
      const title = 'Online Booking';
const options = {
  icon: '<?= URL::to("/images/favicon.png") ?>',
  body: 'New Booking Received'
};
  // Let's check if the browser supports notifications
  if (!("Notification" in window)) {
    console.log("This browser does not support desktop notification");
  }

  // Let's check whether notification permissions have alredy been granted
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
    if (usertype=="superadmin") {
      var notification = new Notification(title,options); 
      window.setInterval(function(){
           window.location = "<?= URL::to('/admin/bookings/s/todays/all') ?>";
      }, 2000);
    }
    
  }

  // Otherwise, we need to ask the user for permission
  else if (Notification.permission !== 'denied' || Notification.permission === "default") {
    Notification.requestPermission(function (permission) {
      // If the user accepts, let's create a notification
      if (permission === "granted") {
       if (usertype=="superadmin") {

         var notification = new Notification(title,options);  
         window.setInterval(function(){

          window.location = "<?= URL::to('/admin/bookings/s/todays/all') ?>";
      }, 2000);
      }
      }
    });

  }

  // At last, if the user has denied notifications, and you 
  // want to be respectful there is no need to bother them any more.
}


     }else {

     }
 }
  });
</script>