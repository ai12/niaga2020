<div class="col-sm-6">
	<div style="display:none">
		<?php
		$from = UI::createSelect('id_customer', $customerarr, $row['id_customer'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_customer"], "id_customer", "Pelanggan");
		?>
		<?php
		$from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
		?>
		<?php
		$from = UI::createSelect('jenis_rkap', $jenisrkaparr, $row['jenis_rkap'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
		echo UI::createFormGroup($from, $rules["jenis_rkap"], "jenis_rkap", "Jenis RKAP");
		?>
		<?php
		$from = UI::createSelect('jenis', $jenisarr, $row['jenis'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
		echo UI::createFormGroup($from, $rules["jenis"], "jenis", "Jenis");
		?>
		<?php
		$from = UI::createSelect('status', $statusarr, $row['status'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
		echo UI::createFormGroup($from, $rules["status"], "status", "Status");
		?>
	</div>
	<?php
	$from = UI::createTextBox('jangka_waktu', $row['jangka_waktu'], '10', '10', $edited, 'form-control', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["jangka_waktu"], "jangka_waktu", "Jangka Waktu (hari)");
	?>
	<?php
		$from = UI::createTextBox('no_kontrak', $row['no_kontrak'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["no_kontrak"], "no_kontrak", "Nomor Kontrak");
		?>
	<?php
		$from = UI::createTextBox('prk_inti', $row['prk_inti'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["prk_inti"], "prk_inti", "PRK Inti");
		?>
	<?php
	$from = UI::createTextBox('tgl_awal', $row['tgl_awal'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl_awal"], "tgl_awal", "Tgl. Awal Kontrak");
	?>
	<?php
	$from = UI::createTextBox('tgl_akhir', $row['tgl_akhir'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["tgl_akhir"], "tgl_akhir", "Tgl. Akhir Kontrak");
	?>
	<div class="form-group">
		<label for="file1" class="col-sm-4 control-label">
			Surat Kontrak
		</label>
		<div class="col-sm-8"><div class="files"><a href="<?= base_url('uploads/kontrak'); ?>/<?=$row['file_kontrak']?>" target="_blank"><?=$row['file_kontrak']?></a></div>
	</div>
	</div>
	<?php
	$from = UI::createTextArea('lingkup', $row['lingkup'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["lingkup"], "lingkup", "Scope / Lingkup");
	?>
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
	$from = UI::createUpload("file5", $row['file5'], "panelbackend/t_proposal", $edited, "file5");
	echo UI::createFormGroup($from, $rules["file5"], "file5", "BA nego");
	?>
	<?php
	$from = UI::createUpload("file4", $row['file4'], "panelbackend/t_proposal", $edited, "file4");
	echo UI::createFormGroup($from, $rules["file4"], "file4", "Lampiran HPP");
	?>
	<?php
	$from = UI::createTextArea('deskripsi', $row['deskripsi'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
	?>

</div>
<div class="col-sm-6">

	<?php
	$this->load->view('om/template/_infoWo', ['id' => $row['ref_id']]); ?>
	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from, null, null, null, true);
	?>
</div>

<div class="row">
	<div class="col-sm-12">
		<?php $this->load->view('om/template/_approval', ['id' => $row['ref_id'], 'edited' => $edited, 'status' => $this->Global_model->STATUS_KONTRAK]); ?>
	</div>
</div>