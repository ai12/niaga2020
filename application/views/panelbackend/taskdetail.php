<div class="col-sm-6">
				

<?php 
$from = UI::createTextArea('nama',$row['nama'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Kegiatan");
?>

<?php 
unset($mttipekegiatantaskarr[5]);
$from = UI::createSelect('id_tipe_kegiatan_task',$mttipekegiatantaskarr,$row['id_tipe_kegiatan_task'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_tipe_kegiatan_task"], "id_tipe_kegiatan_task", "Tipe Kegiatan");
?>

<?php 
$from = UI::createSelect('id_customer',$customerarr,$row['id_customer'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listcustomer')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_customer"], "id_customer", "Customer");
?>

<?php 
$from = UI::createTextBox('lokasi',$row['lokasi'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["lokasi"], "lokasi", "Lokasi");
?>


<?php 
$from = UI::createSelect('id_pegawai',$pegawaiarr,$row['id_pegawai'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_pegawai"], "id_pegawai", "Pegawai");
?>

</div>
<div class="col-sm-6">

<?php 
$from = UI::createTextArea('catatan',$row['catatan'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["catatan"], "catatan", "Catatan");
?>

<?php 
$from = UI::createTextBox('tgl_awal',$row['tgl_awal'],'11','11',$edited,'form-control datetimepicker ',"style='text-align:right; width:100%'");
echo UI::createFormGroup($from, $rules["tgl_awal"], "tgl_awal", "Tgl. Awal");
?>

<?php 
$from = UI::createTextBox('tgl_akhir',$row['tgl_akhir'],'11','11',$edited,'form-control datetimepicker ',"style='text-align:right; width:100%'");
echo UI::createFormGroup($from, $rules["tgl_akhir"], "tgl_akhir", "Tgl. Akhir");


$from = UI::createUpload("file", $row['file'], "panelbackend/task", $edited, "file");
echo UI::createFormGroup($from, $rules["file"], "file", "Lampiran");
?>
<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>