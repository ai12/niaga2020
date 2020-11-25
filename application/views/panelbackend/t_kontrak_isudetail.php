<div class="col-sm-6">
	<?php
	$from = UI::createTextHidden('id_kontrak', $rowheader['id_kontrak']);
	echo $from;
	?>
	<?php 
	$from = UI::createTextBox('tanggal',$row['tanggal'],'11','11',$edited,'form-control datepicker ',"style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tanggal"], "tanggal", "Tanggal");
	?>
	<?php
	$from = UI::createTextArea('nama', $row['nama'], '', '', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["nama"], "nama", "Permasalahan");
	?>
	<?php
	$from = UI::createTextArea('tindak_lanjut', $row['tindak_lanjut'], '', '', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["tindak_lanjut"], "tindak_lanjut", "Tindak_lanjut");
	?>
	<?php 
	$from = UI::createTextBox('target',$row['target'],'11','11',$edited,'form-control datepicker ',"style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["target"], "target", "Target");
	?>
	<?php
	$from = UI::createTextArea('deskripsi', $row['deskripsi'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
	?>
	<?php
	$from = UI::createSelect('status', $statusarr, $row['status'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
	echo UI::createFormGroup($from, $rules["status"], "status", "Status");
	?>
</div>
<div class="col-sm-6">


	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from, null, null, null, true);
	?>
</div>