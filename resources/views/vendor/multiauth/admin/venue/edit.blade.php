@extends('multiauth::layouts.main') 


@section('title')
Edit Location
@endsection


@section('content')
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
				<h2>Location</h2>

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
  <form action="{{ URL::to('admin/venue/update') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="row">
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
            <?php
              $fromtime = "";
              $totime = "";
              $dayarray = array();
            foreach ($data as $key => $value) {
              $location_name = $value->location_name;
              $authorized_person = $value->authorized_person;
              $email = $value->email;
              $phone = $value->phone;
              $address = $value->address;
              $location_id = $value->id;
            
              $id = $value->id;
              $fromtime = $value->fromtime;
              $totime = $value->totime;
              $dayarray = explode(',', $value->days);
            }

            ?>
             <div class="col-md-6">
                <label>Location Name</label>
                <input type="text" class="form-control "   placeholder="Enter your address" name="location" value="<?= $location_name ?>"  required>
              </div>
              <div class="col-md-6">
                <label>Category</label>

                  <select class="form-control" name="category">

                      <?php foreach ($category as $key => $value): ?>
                        <option value="<?= $value->id ?>"><?= $value->category_name ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
               <div class="col-md-6">
                    <label>Opening Time</label>

                      <input type="text" class="form-control from" name="from" value="" autocomplete="off" id="from" required="">
                    </div>
                    <div class="col-md-6">
                      <label>Closing Time</label>
                      <input type="text" class="form-control to" name="to" value="" id="to" autocomplete="off" required="">
                    </div>
           
                <div class="col-md-6">
                  <label>Authorised Person</label>

                    <input type="text" class="form-control" name="authorised_person" value="<?= $authorized_person ?>"  required>
                    <input type="hidden" name="location_id" value="<?= $location_id ?>">


                  </div>
                  <div class="col-md-6">
                    <label>Email</label>
                      <input type="text" class="form-control" name="email" value="<?= $email ?>"  required>
                    </div>

                      <div class="col-md-6">
                        <label>Phone</label>
                          <input type="text" class="form-control" name="phone" value="<?= $phone ?>"  required>
                        </div>
                        <div class="col-md-6">
                          <label>Google Address</label>
                            <input type="text" class="form-control autocomplete" id="autocomplete" 
                              onFocus="geolocate()" name="address" value="<?= $address ?>"  id="street_number"  required>
                          </div>
                               <div class="col-md-6">                     
                        <label>Days</label><br />
                        <?php foreach ($days as $key => $value): ?>
                          <?php if(in_array($value, $dayarray)): ?>
                          <label style="margin-right:20px;"> <input type="checkbox" class="form-control" value="<?= $value ?>" name="days[]" checked="checked"> <?= $value ?></label>
                          <?php else: ?>
                             <label style="margin-right:20px;"> <input type="checkbox" class="form-control" value="<?= $value ?>" name="days[]" > <?= $value ?></label>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div> 

              <div class="col-md-12">
                <br />
								<table id="address" style="display:none;">
						      <tr>
						        <td class="label">Street address</td>
						        <td class="slimField"><input class="field" id="street_number"
						              disabled="true"></input></td>
						        <td class="wideField" colspan="2"><input class="field" id="route"
						              disabled="true"></input></td>
						      </tr>
						      <tr>
						        <td class="label">City</td>
						        <!-- Note: Selection of address components in this example is typical.
						             You may need to adjust it for the locations relevant to your app. See
						             https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete-addressform
						        -->
						        <td class="wideField" colspan="3"><input class="field" id="locality"
						              disabled="true"></input></td>
						      </tr>
						      <tr>
						        <td class="label">State</td>
						        <td class="slimField"><input class="field"
						              id="administrative_area_level_1" disabled="true"></input></td>
						        <td class="label">Zip code</td>
						        <td class="wideField"><input class="field" id="postal_code"
						              disabled="true"></input></td>
						      </tr>
						      <tr>
						        <td class="label">Country</td>
						        <td class="wideField" colspan="3"><input class="field"
						              id="country" disabled="true"></input></td>
						      </tr>
						    </table>
                <input type="submit" class="btn btn-primary" value="Submit">

              </div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
</div><!-- Panel Content -->
</div>
<script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type  {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPnzXgbgNXtvLNPDVIFvlVxcGwBKRH2sk&libraries=places&callback=initAutocomplete"
        async defer></script>
        <script>
$(document).ready(function() {
  $('.from').timepicker({
    timeFormat: 'h:mm p',
    interval: 60,
    defaultTime: '<?= $fromtime ?>',
    startTime: '<?= $fromtime ?>',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});
$('.to').timepicker({
  timeFormat: 'h:mm p',
  interval: 60,
  defaultTime: '<?= $totime ?>',
  startTime: '<?= $totime ?>',
  dynamic: false,
  dropdown: true,
  scrollbar: true
});
});

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection
