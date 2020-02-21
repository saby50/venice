@extends('layouts.main2')

@section('title')
Home
@endsection

@section('content')
<div class="tabs">
      <div class="tab ">
       <a href="{{ URL::to('profile') }}">Update Profile</a>
      </div>
      <div class="tab tabopen">
        <a href="{{ URL::to('profile/pin') }}">Update PIN</a>
      </div>
      
    </div>
<div class="recyclerview" style="margin-top: 100px;padding-top: 40px;">
	  <form class="" method="post" action="{{ URL::to('profile/update') }}">
	  	    @csrf
                            @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                           </div>
                          
                           @endif
                            @if (session('status'))
                           <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                           </div>
                           @endif
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Name" value="<?= Auth::user()->name ?>">
				
			</div>
			<div class="form-group">
				<input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= Auth::user()->phone ?>" readonly>
				
			</div>
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Email" value="<?= Auth::user()->email ?>">
				
			</div>
			<div class="form-group">
				 <button type="submit" class="btn checkoutbtn"> Update</button>
				
			</div>
		</div>
		<div class="col-md-12">
			
			
		</div>
	</div>
</form>
</div>


@endsection