<div class="col-sm-6">

	<?php
	$from = UI::createTextHidden('ref_id', $ref_id);
	echo $from;
	?>
	<?php
	$from = UI::createTextBox('nomor', $row['nomor'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["nomor"], "nomor", "Nomor Dokumen");
	?>
	<?php
	$from = UI::createSelect('jenis', $jenisarr, $row['jenis'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
	echo UI::createFormGroup($from, $rules["jenis"], "jenis", "Jenis Dokumen");
	?>
	<?php
	// $from = UI::createUpload("path", $row['path'], "panelbackend/task", $edited, "path");
	// echo UI::createFormGroup($from, $rules["path"], "path", "Lampiran");
	?>
	<?php
	$from = UI::createUpload("file", $row['file'], "panelbackend/t_proposal", $edited, "file");
	echo UI::createFormGroup($from, $rules["file"], "lampiran", "SLA");	
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