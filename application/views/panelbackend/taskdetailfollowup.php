<div style="clear: both;">
<div class="col-sm-6">

<?php 
$from = UI::createTextArea('nama',$row['nama'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Kegiatan");
?>
<?php 
$from = UI::createSelect('id_customer',$customerarr,$row['id_customer'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listcustomer')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_customer"], "id_customer", "Customer");
?>

</div>
<div class="col-sm-6">
</div>
</div>
<div style="clear: both;">
<hr/>
<div class="col-sm-6">
				

<?php 
$from = UI::createTextArea('nama_follow_up',$row['nama_follow_up'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["nama_follow_up"], "nama_follow_up", "Follow UP");
?>

<?php 
$from = UI::createSelect('id_tipe_follow_up',$mttipekegiatantaskarr,$row['id_tipe_follow_up'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_tipe_follow_up"], "id_tipe_follow_up", "Tipe Follow Up");
?>

<?php 
$from = UI::createTextBox('lokasi_follow_up',$row['lokasi_follow_up'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["lokasi_follow_up"], "lokasi_follow_up", "Lokasi Follow UP");
?>

<?php 
$from = UI::createSelect('id_pegawai_follow_up',$pegawaiarr,$row['id_pegawai_follow_up'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_pegawai_follow_up"], "id_pegawai_follow_up", "Pegawai Follow UP");
?>
</div>
<div class="col-sm-6">
<?php 
$from = UI::createTextArea('catatan_follow_up',$row['catatan_follow_up'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["catatan_follow_up"], "catatan_follow_up", "Catatan Follow UP");
?>

<?php 
$from = UI::createTextBox('tgl_awal_follow_up',$row['tgl_awal_follow_up'],'11','11',$edited,'form-control datetimepicker ',"style='text-align:right; width:100%'");
echo UI::createFormGroup($from, $rules["tgl_awal_follow_up"], "tgl_awal_follow_up", "Tgl. Awal Follow UP");
?>

<?php 
$from = UI::createTextBox('tgl_akhir_follow_up',$row['tgl_akhir_follow_up'],'11','11',$edited,'form-control datetimepicker ',"style='text-align:right; width:100%'");
echo UI::createFormGroup($from, $rules["tgl_akhir_follow_up"], "tgl_akhir_follow_up", "Tgl. Akhir Follow UP");

$from = UI::createUpload("ffu", $row['ffu'], $page_ctrl, $edited, "ffu");
echo UI::createFormGroup($from, $rules["ffu"], "ffu", "Lampiran");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>
</div>