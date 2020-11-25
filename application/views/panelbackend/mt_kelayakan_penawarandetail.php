<div class="col-sm-6">

<?php 
$from = UI::createTextBox('max_nego',$row['max_nego'],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, $rules["max_nego"], "max_nego", "MAX Nego");
?>

<?php 
$from = UI::createTextBox('layak',$row['layak'],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, $rules["layak"], "layak", "Layak");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>