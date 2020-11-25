<div class="row">
	<div class="col-sm-12">
		<h5>Informasi Keluhan Pelanggan</h5>
	</div>
	<div class="col-sm-5">

		<?php
		$from = UI::createTextBox('tanggal', $row['tanggal'], '10', '10', $edited, 'form-control datepicker', "style='width:190px'");
		echo UI::createFormGroup($from, $rules["tanggal"], "tanggal", "Tanggal", false, 3);
		?>

		<?php
		$from = UI::createTextBox('nama_orang', $row['nama_orang'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["nama_orang"], "nama_orang", "Nama Orang", false, 3);
		?>

		<?php
		$from = UI::createTextBox('jabatan', $row['jabatan'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["jabatan"], "jabatan", "Jabatan", false, 3);
		?>

		<?php
		$from = UI::createTextBox('email', $row['email'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["email"], "email", "Email", false, 3);
		?>

	</div>
	<div class="col-sm-7">



		<?php
		$from = UI::createTextArea('isi', $row['isi'], '6', '', $edited, 'form-control', "");
		echo UI::createFormGroup($from, $rules["isi"], "isi", "ISI", false, 2);
		?>

		<?php
		/*$from = UI::createSelect('id_status_keluhan',$mtstatuskeluhanarr,$row['id_status_keluhan'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_status_keluhan"], "id_status_keluhan", "Status Keluhan");*/
		?>

	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h5>DISTRIBUSI KELUHAN</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('tgl_distribusi', $row['tgl_distribusi'], '10', '10', $edited, 'form-control datepicker', "style='width:190px'");
		echo UI::createFormGroup($from, $rules["tgl_distribusi"], "tgl_distribusi", "Tgl. Distribusi", false, 3);
		?>

		<?php
		if (!$rowheader['id_proyek']) {
			$from = UI::createSelect('id_proyek', $proyekarr, $row['id_proyek'], $edited, $class = 'form-control ', "style='width:100%;'  data-ajax--url=\"" . site_url('panelbackend/ajax/listproyek') . "\" data-ajax--data-type=\"json\"");
			echo UI::createFormGroup($from, $rules["id_proyek"], "id_proyek", "Proyek", false, 3);
		}
		?>

		<?php
		$from = UI::createSelect('id_kategori_keluhan', $mtkategoriarr, $row['id_kategori_keluhan'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_kategori_keluhan"], "id_kategori_keluhan", "Kategori", false, 3);
		?>

		<?php
		$from = UI::createSelect('id_urgensi', $mturgensiarr, $row['id_urgensi'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_urgensi"], "id_urgensi", "Urgensi", false, 3);
		?>

		<?php
		$from = UI::createSelect('pic', $picarr, $row['pic'], $edited, $class = 'form-control ', "style='width:100%;'  data-ajax--url=\"" . site_url('panelbackend/ajax/listpegawai') . "\" data-ajax--data-type=\"json\"");
		echo UI::createFormGroup($from, $rules["pic"], "pic", "Pic", false, 3);
		?>

	</div>
	<div class="col-sm-7">
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h5>ACTION PLAN</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('tgl_action_plan', $row['tgl_action_plan'], '10', '10', $edited, 'form-control datepicker', "style='width:190px'");
		echo UI::createFormGroup($from, $rules["tgl_action_plan"], "tgl_action_plan", "Tgl. Action Plan", false, 3);
		?>
		<?php
		$from = UI::createTextArea('action_plan', $row['action_plan'], '', '', $edited, 'form-control', "");
		echo UI::createFormGroup($from, $rules["action_plan"], "action_plan", "Action Plan", false, 3);
		?>
		<?php
		$from = UI::createTextBox('target', $row['target'], '', '', $edited, 'form-control', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["target"], "target", "Target", false, 3);
		?>

	</div>
	<div class="col-sm-7">
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h5>ACTION PLAN REPORT</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('tgl_action_plan_report', $row['tgl_action_plan_report'], '10', '10', $edited, 'form-control datepicker', "style='width:190px'");
		echo UI::createFormGroup($from, $rules["tgl_action_plan_report"], "tgl_action_plan_report", "Tgl. Action Plan Report", false, 3);
		?>
		<?php
		$from = UI::createTextArea('action_plan_report', $row['action_plan_report'], '6', '', $edited, 'form-control', "");
		echo UI::createFormGroup($from, $rules["action_plan_report"], "action_plan_report", "Action Plan Report", false, 3);
		?>
	</div>
	<div class="col-sm-7">
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h5>CLOSE KELUHAN</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('tgl_close', $row['tgl_close'], '10', '10', $edited, 'form-control datepicker', "style='width:190px'");
		echo UI::createFormGroup($from, $rules["tgl_close"], "tgl_close", "Tgl. Close", false, 3);
		?>
		<?php
		$from = UI::createTextArea('catatan', $row['catatan'], '', '', $edited, 'form-control', "");
		echo UI::createFormGroup($from, $rules["catatan"], "catatan", "Action Plan Report", false, 3);
		?>

		<?php
		$from = UI::showButtonMode("save", null, $edited);
		echo UI::createFormGroup($from, null, null, null, false, 3);
		?>

	</div>
	<div class="col-sm-7">
	</div>
</div>