<div class="col-sm-6">
<?php
	$from = UI::createTextHidden('id_kontrak_proyek', $rowheader['id_kontrak_proyek']);
	echo $from;
	?>
	<?php
	$from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
	?>
	<?php
	$from = UI::createTextBox('perusahaan', $row['perusahaan'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["perusahaan"], "perusahaan", "Perusahaan");
	?>
	<?php 
	$from = UI::createTextBox('nilai',$row['nilai'],'10','10',$edited,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["nilai"], "nilai", "Nilai Pekerjaan");
	?>
	<?php 
	$from = UI::createTextBox('tgl',$row['tgl'],'11','11',$edited,'form-control datepicker ',"style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl"], "tgl", "Tgl. Pekerjaan");
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