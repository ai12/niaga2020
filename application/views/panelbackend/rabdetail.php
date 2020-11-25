<div class="col-sm-6">

<?php 
$from = UI::createSelect('id_proyek_pekerjaan',$rabpekerjaanarr,$row['id_proyek_pekerjaan'],$edited,$class='form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_proyek_pekerjaan"], "id_proyek_pekerjaan", "Pekerjaan");
?>

<?php 
$from = UI::createTextBox('versi',$row['versi'],'20','20',$edited,$class='form-control ',"style='width:200px'");
echo UI::createFormGroup($from, $rules["versi"], "versi", "Versi");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::createCheckBox('is_final',1,$row['is_final'], "Final",$edited,$class='iCheck-helper ',"");
echo UI::createFormGroup($from, $rules["is_final"], "is_final");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>