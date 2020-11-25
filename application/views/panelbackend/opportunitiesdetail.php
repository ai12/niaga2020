<div class="col-sm-6">

<?php 
$from = UI::createTextArea('nama',$row['nama'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>
<?php 
$from = UI::createSelect('id_customer',$customerarr,$row['id_customer'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listcustomer')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_customer"], "id_customer", "Customer");
?>

<?php 
$from = UI::createSelect('id_jenis_opportunities',$mtjenisopportunitiesarr,$row['id_jenis_opportunities'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_jenis_opportunities"], "id_jenis_opportunities", "Jenis Opportunities");
?>

<?php 
$from = UI::createSelect('id_tipe_opportunities',$mttypeopportunitiesarr,$row['id_tipe_opportunities'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_tipe_opportunities"], "id_tipe_opportunities", "Tipe Opportunities");
?>

<?php 
$from = UI::createTextNumber('tahun_rencana',$row['tahun_rencana'],'10','10',$edited,'form-control ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, $rules["tahun_rencana"], "tahun_rencana", "Tahun Rencana");
?>

<?php 
$from = UI::createTextBox('tanggal',$row['tanggal'],'10','10',$edited,'form-control datepicker',"style='width:190px'");
echo UI::createFormGroup($from, $rules["tanggal"], "tanggal", "Tanggal");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::createSelect('id_pic',$picarr,$row['id_pic'],$edited,$class='form-control ',"style='width:100%;'");
// $from = UI::createSelect('id_pic',$picarr,$row['id_pic'],$edited,$class='form-control ',"style='width:100%;'  data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\"");
echo UI::createFormGroup($from, $rules["id_pic"], "id_pic", "PIC");
?>

<?php 
$from = UI::createTextBox('perkiraan_nilai_kontrak',$row['perkiraan_nilai_kontrak'],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, $rules["perkiraan_nilai_kontrak"], "perkiraan_nilai_kontrak", "Perkiraan Nilai Kontrak");
?>

<?php 
$from = UI::createSelect('status',$statusarr,$row['status'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["status"], "status", "Status");
?>

<?php 
$from = UI::createTextArea('keterangan',$row['keterangan'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["keterangan"], "keterangan", "Keterangan");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>