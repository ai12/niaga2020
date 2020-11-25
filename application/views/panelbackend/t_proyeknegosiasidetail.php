<div class="col-sm-6">
	<?php
	$from = UI::createTextBox('kesepakatan_harga', $row['kesepakatan_harga'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["kesepakatan_harga"], "kesepakatan_harga", "Kesepakatan Harga (Rp)");
	?>
	<?php
	$from = UI::createTextBox('hpp', $row['hpp'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["hpp"], "hpp", "HPP (Rp)");
	?>
	<?php
	$from = UI::createTextBox('lr', $row['lr'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["lr"], "lr", "LR (Rp)");
	?>
	<?php
	$from = UI::createTextBox('gpm', $row['gpm'], '2', '2', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["gpm"], "gpm", "GPM (%)");
	?>
	<?php
	$from = UI::createTextBox('npm', $row['npm'], '2', '2', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["npm"], "npm", "NPM (%)");
	?>

	<div style="display:none">
		<?php
		$from = UI::createSelect('id_proposal', $proposalarr, $row['id_proposal'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_proposal"], "id_proposal", "Proposal");
		?>
		<?php
		$from = UI::createTextBox('judul_nego', $row['judul_nego'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["judul_nego"], "judul_nego", "Judul nego");
		?>
	</div>
	<?php
	// $from = UI::createTextBox('ba_nego', $row['ba_nego'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	// echo UI::createFormGroup($from, $rules["ba_nego"], "ba_nego", "Ba nego");
	// $from = UI::createUpload("ba_nego", $row['ba_nego'], "panelbackend/t_negosiasi", $edited, "ba_nego");
	// echo UI::createFormGroup($from, $rules["ba_nego"], "ba_nego", "BA Nego");
	?>
	<?php
	$from = UI::createUpload("file", $row['file'], "panelbackend/t_proposal", $edited, "file");
	echo UI::createFormGroup($from, $rules["file"], "ba_nego", "BA Nego");	
	?>
	<?php
	$from = UI::createTextArea('deskripsi', $row['deskripsi'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
	?>
	<?php
	// $from = UI::createSelect('status', $statusarr, $row['status'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
	// echo UI::createFormGroup($from, $rules["status"], "status", "Status");
	?>
</div>
<div class="col-sm-5">
	<?php $this->load->view('om/template/_infoWo', ['id' => $row['ref_id']]); ?>
	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from, null, null, null, true);
	?>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php $this->load->view('om/template/_approval', ['id' => $row['ref_id'], 'edited' => $edited, 'status' => $this->Global_model->STATUS_NEGOSIASI]); ?>
	</div>
</div>