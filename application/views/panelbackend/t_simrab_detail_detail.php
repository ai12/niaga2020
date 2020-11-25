<div class="col-sm-6">
<!-- lv1 -->
<?php 
$from = UI::createTextBox('kode',$row['kode'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["kode"], "kode", "Kode Biaya");
?>

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Uraian");
?>

<?php 
$from = UI::createTextBox('hrg_satuan',$row['hrg_satuan'],'10','10',$edited,'form-control',"style='text-align:right; width:190px'");
echo UI::createFormGroup($from, null, "hrg_satuan", "Nilai Satuan");
?>
<?php 
	$s4 = $this->uri->segment(4);
	if($s4)
	{
		echo "<input type='hidden' name='parent_id' id='parent_id' value='$s4'>";
	}
	else
	{
		$from = UI::createSelect('parent_id',$dataSelect,$row['parent_id'],$edited,'form-control',"style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, null, "parent_id", "Parent Data");
	}
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