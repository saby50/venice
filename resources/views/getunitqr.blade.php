<div style="width: 100%;text-align: center;">

<div ><?= QrCode::size(300)->generate($id); ?></div><br />
<h2 style="margin-top: -50px;">Paying to <?php $units =  Helper::get_unit($id); echo $units['unit_name'] ?></h2>
</div>
