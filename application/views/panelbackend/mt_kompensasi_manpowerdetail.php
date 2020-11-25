<div class="col-sm-6">

<?php 
$from = UI::createSelect('id_jabatan_proyek',$mtjabatanproyekarr,$row['id_jabatan_proyek'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_jabatan_proyek"], "id_jabatan_proyek", "Jabatan Proyek");
?>

<?php 
$from = UI::createSelect('id_level_jabatan',$mtleveljabatanarr,$row['id_level_jabatan'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_level_jabatan"], "id_level_jabatan", "Level Jabatan");
?>

</div>
<div class="col-sm-6">

<?php
$i=1;
foreach($mtjenisttparr as $key=>$val){
	$from = UI::createTextBox('nilai['.$key.']',$row['nilai'][$key],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
	echo UI::createFormGroup($from, $rules["nilai[$key]"], "nilai[$key]", $val);
	$i++;
}
?>


<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>