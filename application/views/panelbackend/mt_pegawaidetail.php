<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'45','45',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>

<?php 
$from = UI::createTextBox('unit',$row['unit'],'3','3',$edited,$class='form-control ',"style='width:30px'");
echo UI::createFormGroup($from, $rules["unit"], "unit", "Unit");
?>

<?php 
$from = UI::createTextBox('direktorat',$row['direktorat'],'6','6',$edited,$class='form-control ',"style='width:60px'");
echo UI::createFormGroup($from, $rules["direktorat"], "direktorat", "Direktorat");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::createTextBox('subdit',$row['subdit'],'6','6',$edited,$class='form-control ',"style='width:60px'");
echo UI::createFormGroup($from, $rules["subdit"], "subdit", "Subdit");
?>

<?php 
$from = UI::createTextBox('jabatan',$row['jabatan'],'562','100',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["jabatan"], "jabatan", "Jabatan");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>