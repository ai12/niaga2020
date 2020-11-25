<div class="col-sm-6">

<?php 
$from = UI::createTextBox('site',$row['site'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["site"], "site", "Site");
?>

<?php 
$from = UI::createTextArea('alamat',$row['alamat'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["alamat"], "alamat", "Alamat");
?>

<?php 
$from = UI::createTextBox('telephone_1',$row['telephone_1'],'20','20',$edited,'form-control ',"style='width:200px'");
echo UI::createFormGroup($from, $rules["telephone_1"], "telephone_1", "Telephone 1");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::createTextBox('telephone_2',$row['telephone_2'],'20','20',$edited,'form-control ',"style='width:200px'");
echo UI::createFormGroup($from, $rules["telephone_2"], "telephone_2", "Telephone 2");
?>

<?php 
$from = UI::createTextBox('fax',$row['fax'],'20','20',$edited,'form-control ',"style='width:200px'");
echo UI::createFormGroup($from, $rules["fax"], "fax", "FAX");
?>

<?php 
$from = UI::createSelect('id_status',$mtcustomerstatusarr,$row['id_status'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_status"], "id_status", "Status");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>