<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>

<?php 
$from = UI::createTextBox('hpp',$row['hpp'],'10','10',$edited,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1'");
echo UI::createFormGroup($from, $rules["hpp"], "hpp", "Nilai HPP");
?>
<?php 
$from = UI::createTextBox('proposal_penawaran',$row['proposal_penawaran'],'10','10',$edited,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1'");
echo UI::createFormGroup($from, $rules["proposal_penawaran"], "proposal_penawaran", "Proposal Penawaran");
?>
<?php 
$from = UI::createTextBox('standar_produksi',$row['standar_produksi'],'10','10',$edited,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1'");
echo UI::createFormGroup($from, $rules["standar_produksi"], "standar_produksi", "Standar Produksi");
?>
<?php 
$from = UI::createTextArea('deskripsi',$row['deskripsi'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
?>



</div>
<div class="col-sm-6">
				

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>