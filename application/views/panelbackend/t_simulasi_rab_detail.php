<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama_pekerjaan',$row['nama_pekerjaan'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama_pekerjaan"], "nama_pekerjaan", "Nama RAB");
?>

<?php 
$tahun = $row['tahun'] ?  $row['tahun'] : date('Y');
$from = UI::createTextBox('tahun',$tahun,'10','10',$edited,'form-control',"style='text-align:right; width:190px' min='0' step='".date('Y')."'");
echo UI::createFormGroup($from, null, "tahun", "Tahun");
?>
<?php 
$from = UI::createTextArea('keterangan',$row['keterangan'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, null, "keterangan", "Catatan");

$tanggal = $row['tanggal'] ? $row['tanggal'] : date("d-m-Y");
$uuid = $row['id'] ? $row['id'] : uuid();
?>
<input type="hidden" name="tanggal" value="<?=$tanggal?>">
<input type="hidden" name="id" value="<?=$uuid?>">

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>