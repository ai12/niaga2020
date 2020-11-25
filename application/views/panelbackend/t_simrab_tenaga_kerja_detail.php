<div class="col-sm-6">
<?php 
$from = UI::createSelect('jabatan_proyek',$dataSelect,$row['jabatan_proyek'],$edited,'form-control',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "jabatan_proyek", "Jabatan");
?>

<?php 
$from = UI::createTextBox('fungsi',$row['fungsi'],'10','10',$edited,'form-control');
echo UI::createFormGroup($from, null, "fungsi", "Fungsi");
?>

<?php 

$from = UI::createTextNumber('jml_orang', $row['jml_orang'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, null, "jml_orang", "Jumlah Orang");

$from = UI::createTextNumber('jml_hari', $row['jml_hari'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, null, "jml_hari", "Jumlah Hari");
?>

<?php 

$uuid = $row['id'] ? $row['id'] : uuid();
?>
<input type="hidden" name="id" value="<?=$uuid?>">

</div>
<div class="col-sm-6">
                

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>