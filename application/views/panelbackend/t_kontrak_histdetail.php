<div class="col-sm-6">
	<?php
	$from = UI::createTextHidden('id_kontrak', $rowheader['id_kontrak']);
	echo $from;
	?>
	<?php
	$from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:80%'");
	echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
	?>
	<?php
	$from = UI::createTextBox('no_pihak1', $row['no_pihak1'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["no_pihak1"], "no_pihak1", "No Pihak 1");
	?>
	<?php
	$from = UI::createTextBox('no_pihak2', $row['no_pihak2'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["no_pihak2"], "no_pihak2", "No Pihak 2");
	?>
	<?php
	$from = UI::createTextBox('tgl_kontrak', $row['tgl_kontrak'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl_kontrak"], "tgl_kontrak", "Tgl. Kontrak");
	?>
	<?php
	$from = UI::createTextBox('tgl_mulai', $row['tgl_mulai'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl_mulai"], "tgl_mulai", "Tgl. Mulai");
	?>
	<?php
	$from = UI::createTextBox('tgl_selesai', $row['tgl_selesai'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl_selesai"], "tgl_selesai", "Tgl. Selesai");
	?>
	<?php
	$from = UI::createTextBox('hpp', $row['hpp'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["hpp"], "hpp", "HPP (Rp)");
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
	$from = UI::createUpload("file1", $row['file1'], "panelbackend/t_proposal", $edited, "file1");
	echo UI::createFormGroup($from, $rules["file1"], "file1", "Surat permohonan amandemen / Variation order");	
	?>
	<?php
	$from = UI::createUpload("file2", $row['file2'], "panelbackend/t_proposal", $edited, "file2");
	echo UI::createFormGroup($from, $rules["file2"], "file2", "Notulen Rapat");	
	?>
	<?php
	$from = UI::createUpload("file3", $row['file3'], "panelbackend/t_proposal", $edited, "file3");
	echo UI::createFormGroup($from, $rules["file3"], "file3", "Penawaran harga / Proposal");	
	?>
	<?php
	$from = UI::createUpload("file4", $row['file4'], "panelbackend/t_proposal", $edited, "file4");
	echo UI::createFormGroup($from, $rules["file4"], "file4", "Lampiran HPP");	
	?>
	<?php
	$from = UI::createUpload("file5", $row['file5'], "panelbackend/t_proposal", $edited, "file5");
	echo UI::createFormGroup($from, $rules["file5"], "file5", "BA nego");	
	?>
	<?php
	$from = UI::createUpload("file6", $row['file6'], "panelbackend/t_proposal", $edited, "file6");
	echo UI::createFormGroup($from, $rules["file6"], "file6", "Lain-lain");	
	?>
	<?php
	// $from = UI::createUpload("surat_permohonan", $row['surat_permohonan'], "panelbackend/t_negosiasi", $edited, "surat_permohonan");
	// echo UI::createFormGroup($from, $rules["surat_permohonan"], "surat_permohonan", "Surat permohonan amandemen / Variation order");
	?>
	<?php
	// $from = UI::createUpload("notulen_rapat", $row['notulen_rapat'], "panelbackend/t_negosiasi", $edited, "notulen_rapat");
	// echo UI::createFormGroup($from, $rules["notulen_rapat"], "notulen_rapat", "Notulen Rapat");
	?>
	<?php
	// $from = UI::createUpload("penawaran_harga", $row['penawaran_harga'], "panelbackend/t_negosiasi", $edited, "penawaran_harga");
	// echo UI::createFormGroup($from, $rules["penawaran_harga"], "penawaran_harga", "Penawaran harga / Proposal");
	?>
	<?php
	// $from = UI::createUpload("hpp_lampiran", $row['hpp_lampiran'], "panelbackend/t_negosiasi", $edited, "hpp_lampiran");
	// echo UI::createFormGroup($from, $rules["hpp_lampiran"], "hpp_lampiran", "Lampiran HPP");
	?>
	<?php
	// $from = UI::createUpload("ba_nego", $row['ba_nego'], "panelbackend/t_negosiasi", $edited, "ba_nego");
	// echo UI::createFormGroup($from, $rules["ba_nego"], "ba_nego", "BA nego");
	?>
	
	<?php
	// $from = UI::createUpload("amandemen", $row['amandemen'], "panelbackend/t_negosiasi", $edited, "amandemen");
	// echo UI::createFormGroup($from, $rules["amandemen"], "amandemen", "Amandemen kontrak / Variation order");
	?>
	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from, null, null, null, true);
	?>
</div>