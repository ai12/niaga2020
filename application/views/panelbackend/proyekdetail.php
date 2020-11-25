<div class="col-sm-6">

	<?php
	$from = UI::createTextArea('nama_proyek', $row['nama_proyek'], '', '', false, $class = 'form-control', "");
	echo UI::createFormGroup($from, $rules["nama_proyek"], "nama_proyek", "Nama Proyek");
	?>

	<?php
	$from = UI::createSelect('id_customer', $mtcustomerarr, $row['id_customer'], false, $class = 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["id_customer"], "id_customer", "Customer");
	?>
	<?php
	$from = UI::createSelect('id_warehouse', $mtmtwarehousearr, $row['id_warehouse'], false, $class = 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["id_warehouse"], "id_warehouse", "Warehouse");
	?>

	<?php
	$from = UI::createTextBox('pic_customer', $row['pic_customer'], '', '', false, 'form-control', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["pic_customer"], "pic_customer", "PIC Customer");
	?>


	<?php
	$from = UI::createTextBox('jabatan_pic_customer', $row['jabatan_pic_customer'], '', '', false, 'form-control', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["jabatan_pic_customer"], "jabatan_pic_customer", "Jabatan PIC");
	?>


	<?php //createCheckBox($nameid,$valuecontrol='',$value='',$label='label',$edit=true,$class='',$add='')
	$from = UI::createCheckBox('is_pln', 1, $row['is_pln'], "PLN ?", false, null, "onclick='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["is_pln"], "is_pln", null);
	?>

	<?php
	if ($row['is_pln']) {
		$from = UI::createTextBox('pic_pln', $row['pic_pln'], '', '', false, 'form-control', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["pic_pln"], "pic_pln", "PIC PLN");

		$from = UI::createTextBox('jabatan_pic_pln', $row['jabatan_pic_pln'], '', '', false, 'form-control', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["jabatan_pic_pln"], "jabatan_pic_pln", "Jabatan");
	}
	?>



</div>
<div class="col-sm-6">

	<?php
	$from = UI::createSelect('id_tipe_proyek', $mttipeproyekarr, $row['id_tipe_proyek'], false, $class = 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["id_tipe_proyek"], "id_tipe_proyek", "Tipe proyek");
	?>


	<?php
	$from = UI::createSelect('id_wilayah_proyek', $wilayaharr, $row['id_wilayah_proyek'], $edited, $class = 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["id_wilayah_proyek"], "id_wilayah_proyek", "Wilayah proyek");
	?>


	<?php
	$from = UI::createSelect('id_zona_sppd', $zonasppdarr, $row['id_zona_sppd'], $edited, $class = 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["id_zona_sppd"], "id_zona_sppd", "Zona SPPD");
	?>

	<?php

	$from = UI::createSelect('id_pic', $mtpegawaiarr, $row['id_pic'], false, $class = 'form-control ', "style='width:100%;'  data-ajax--url=\"" . site_url('panelbackend/ajax/listpegawai') . "\" data-ajax--data-type=\"json\"");
	echo UI::createFormGroup($from, $rules["id_pic"], "id_pic", "Manager Proyek");

	$from = UI::createSelect('id_rendal_proyek', $mtpegawaiarr, $row['id_rendal_proyek'], false, $class = 'form-control ', "style='width:100%;'  data-ajax--url=\"" . site_url('panelbackend/ajax/listpegawai') . "\" data-ajax--data-type=\"json\"");
	echo UI::createFormGroup($from, $rules["id_rendal_proyek"], "id_rendal_proyek", "Rendal Proyek");
	?>

	<?php
	$from = UI::createSelect('id_status_proyek', $mtstatusproyekarr, $row['id_status_proyek'], false, $class = 'form-control ', "style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["id_status_proyek"], "id_status_proyek", "Status");
	?>

	<?php
	$from = UI::createCheckBox('is_close', 1, $row['is_close'], "Proyek Close ?", $edited, null);
	echo UI::createFormGroup($from, $rules["is_close"], "is_close", null);

	if ($row['is_close']) {
		$from = UI::createTextNumber('nilai_realisasi_close', $row['nilai_realisasi_close'], '', '', false);
		echo UI::createFormGroup($from, $rules["nilai_realisasi_close"], "nilai_realisasi_close", "Nilai Realisasi Sebelum CLose");
	}
	?>

	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from);
	?>
</div>

<div class="row">
	<div class="col-sm-12">
		<?php $this->load->view('om/template/_infoWo',['id'=>$row['ref_id']]);?>
	</div>
	<div class="col-sm-12">
		<?php $this->load->view('om/template/_approval', ['id' => $row['ref_id'], 'edited' => $edited, 'status' => 30]); ?>
	</div>
</div>