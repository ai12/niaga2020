<div class="col-sm-6">

	<?php
	// $from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	// echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
	?>

	<?php
	$from = UI::createTextBox('hpp', $row['hpp'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["hpp"], "hpp", "HPP (Rp)");
	?>
	<?php
	$from = UI::createTextBox('proposal_penawaran', $row['proposal_penawaran'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["proposal_penawaran"], "proposal_penawaran", "Harga Penawaran (Rp) incl. PPN");
	?>
	<?php
	$from = UI::createTextBox('standar_produksi', $row['standar_produksi'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["standar_produksi"], "standar_produksi", "L/R (Rp)");
	?>
	<?php
	$from = UI::createTextBox('gpm', $row['gpm'], '3', '3', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["gpm"], "gpm", "GPM (%)");
	?>
	<?php
	$from = UI::createTextBox('npm', $row['npm'], '3', '3', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	echo UI::createFormGroup($from, $rules["npm"], "npm", "NPM (%)");
	?>
	<?php
	// $from = UI::createTextBox('payback_periode', $row['payback_periode'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	// echo UI::createFormGroup($from, $rules["payback_periode"], "payback_periode", "Payback Periode");
	?>
	<?php
	// $from = UI::createTextBox('irr', $row['irr'], '3', '3', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	// echo UI::createFormGroup($from, $rules["irr"], "irr", "IRR (%)");
	?>
	<?php
	// $from = UI::createTextBox('npv', $row['npv'], '10', '10', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' step='1'");
	// echo UI::createFormGroup($from, $rules["npv"], "npv", "NPV (Rp)");
	?>
	<?php
	// $from = UI::createUpload("lampiran", $row['lampiran'], "panelbackend/t_proposal", $edited, "lampiran");
	// echo UI::createFormGroup($from, $rules["lampiran"], "lampiran", "Lampiran Proposal");	
	?>
	<?php
	$from = UI::createTextBox('raise_date', $row['raise_date'], '11', '11', $edited, 'form-control datepicker ', "style='text-align:right; width:50%'");
	echo UI::createFormGroup($from, $rules["raise_date"], "raise_date", "Raised Date");
	?>
	<?php
	$from = UI::createUpload("file", $row['file'], "panelbackend/t_proyekproposal", $edited, "file");
	echo UI::createFormGroup($from, $rules["file"], "lampiran", "Lampiran Proposal");	
	?>
	<?php
	$from = UI::createTextArea('deskripsi', $row['deskripsi'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
	?>



</div>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-12">
			<?php $this->load->view('om/template/_infoWo', ['id' => $row['ref_id']]); ?>
			<?php
			$from = UI::showButtonMode("save", null, $edited);
			echo UI::createFormGroup($from, null, null, null, true);
			?>
		</div>
		
	</div>
</div>


<div class="row">
<div class="col-sm-12">
			<?php $this->load->view('om/template/_approval', ['id' => $row['ref_id'], 'edited' => $edited, 'status'=>$this->Global_model->STATUS_PROPOSAL,'log_trans'=>'HIS_PROPOSAL_PROYEK','log_id'=>$row['id_proposal']]); ?>
		</div>
</div>