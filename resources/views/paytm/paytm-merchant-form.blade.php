@extends('layouts.main2')
@section('title')
Please wait...
@endsection
@section('content')
<div class="col-md-12" style="text-align: center;padding-top: 200px;padding-bottom: 200px;">
    <h1>Please do not refresh this page...</h1>
</div>
<form method="post" action="{{ $paytm_txn_url }}" name="f1">
    {{ csrf_field()  }}
    <table border="1">
        <tbody>
		<?php
		foreach($paramList as $name => $value) {
			echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
		}
		?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
        </tbody>
    </table>
    <script type="text/javascript">
		document.f1.submit();
    </script>
</form>

@endsection

@section('footer')
Book A Pitch
@endsection
