<div class="col-sm-6">
	<table class="table">
		<tr>
			<td class="col-md-4">Unit Kerja </td>
			<td class="col-md-8"><input name="UNIT_KERJA" id="UNIT_KERJA" class="form-control" value="<?= $det_kontrak->unit_kerja ?>"></td>
		</tr>
		<tr>
			<td>RKAP/Non RKAP </td>
			<td>
				<select class="form-control" name="RKAP" id="RKAP">
					<option value="rkap" <?= $det_kontrak->rkap == 'rkap' ? "selected=''" : "" ?>>RKAP</option>
					<option value="nonrkap" <?= $det_kontrak->rkap == 'nonrkap' ? "selected=''" : "" ?>>NON RKAP</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Fisik </td>
			<td>
				<select class="form-control" name="STATUS_FISIK" id="STATUS_FISIK">
					<?php foreach ($this->config->item('status_fisik') as $key => $value) : ?>
						<option value="<?= $key ?>" <?= $det_kontrak->status_fisik == $key ? "selected=''" : "" ?>><?= $value ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Niaga </td>
			<td>
				<select class="form-control" name="STATUS_NIAGA" id="STATUS_NIAGA">
					<?php foreach ($this->config->item('status_niaga') as $key => $value) : ?>
						<option value="<?= $key ?>" <?= $det_kontrak->status_niaga == $key ? "selected=''" : "" ?>><?= $value ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Proyek </td>
			<td class="col-md-2">
				<select class="form-control" name="STATUS_PROYEK" id="STATUS_PROYEK">
					<option value="1" <?= $det_kontrak->status_proyek == 1 ? "selected=''" : "" ?>>OPEN</option>
					<option value="2" <?= $det_kontrak->status_proyek == 2 ? "selected=''" : "" ?>>CLOSE</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Status Settlement </td>
			<td class="col-md-2">
				<select class="form-control" name="STATUS_SETTLEMENT" id="STATUS_SETTLEMENT">
					<option value="" <?= $det_kontrak->status_proyek == '' ? "selected=''" : "" ?>></option>
					<option value="1" <?= $det_kontrak->status_proyek == 1 ? "selected=''" : "" ?>>PENGAJUAN INVOICE</option>
					<option value="2" <?= $det_kontrak->status_proyek == 2 ? "selected=''" : "" ?>>TERBAYAR</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Tahun Proyek </td>
			<td class="col-md-2"><input name="TAHUN_PROYEK" id="TAHUN_PROYEK" class="form-control" value="<?= $det_kontrak->tahun_proyek ?>"></td>
		</tr>
		<tr>
			<td>No. PRK INTI </td>
			<td class="col-md-2"><input name="NO_PRK" id="NO_PRK" class="form-control" value="<?= $det_kontrak->no_prk ?>"></td>
		</tr>
		<tr>
			<td colspan="2">
				<button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="saveDetail()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
			</td>
		</tr>
	</table>
	<div class="row">

			<div class="col-sm-12">
				<?php $this->load->view('om/template/_approval', ['id' => $row['ref_id'], 'edited' => $edited, 'status' => 30, 'size'=> 12]); ?>
			</div>
		</div>
</div>
<div class="col-sm-6">

	<div class="col-sm-12">
		<?php $this->load->view('om/template/_infoWo', ['id' => $row['ref_id']]); ?>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama", false, 3);
		?>
	</div>
	<div class="col-sm-7">
	</div>
	<br>
	<!--<div class="row">
	<div class="col-sm-12">
		<h5>Detail Kontrak</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('kontrak_no', $row['kontrak_no'], '200', '100', $edited, 'form-control ', "style='width:290px'");
		echo UI::createFormGroup($from, $rules["kontrak_no"], "kontrak_no", "No. Kontrak", false, 3);
		?>
		<?php
		$from = UI::createTextBox('kontrak_tgl', $row['kontrak_tgl'], '11', '11', $edited, 'form-control datepicker', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["kontrak_tgl"], "kontrak_tgl", "Tgl Kontrak", false, 3);
		?>
	</div>
	<div class="col-sm-4">
		<?php
		$from = UI::createTextBox('kontrak_nilai', $row['kontrak_nilai'], '200', '100', $edited, 'form-control rupiah', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
		echo UI::createFormGroup($from, $rules["kontrak_nilai"], "kontrak_nilai", "Nilai Kontrak", false, 3);
		?>
		<?php
		$from = UI::createTextNumber('durasi', $row['durasi'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:90px' min='0' max='10000000000' step='1'");
		echo UI::createFormGroup($from, $rules["durasi"], "durasi", "Durasi", false, 3);
		?>
	</div>
	<div class="col-sm-7">
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-12">
		<h5>Tanggal Pelaksanaan</h5>
	</div>
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('rencana_tgl_mulai', $row['rencana_tgl_mulai'], '11', '11', $edited, 'form-control datepicker', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["rencana_tgl_mulai"], "rencana_tgl_mulai", "Rencana Tgl Mulai", false, 3);
		?>
		<?php
		$from = UI::createTextBox('rencana_tgl_selesai', $row['rencana_tgl_selesai'], '11', '11', $edited, 'form-control datepicker', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["rencana_tgl_selesai"], "rencana_tgl_selesai", "Rencana Tgl Selesai", false, 3);
		?>
	</div>
	<div class="col-sm-4">
		<?php
		$from = UI::createTextBox('tgl_mulai', $row['tgl_mulai'], '11', '11', $edited, 'form-control datepicker', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["tgl_mulai"], "tgl_mulai", "Tgl Mulai", false, 3);
		?>
		<?php
		$from = UI::createTextBox('tgl_selesai', $row['tgl_selesai'], '11', '11', $edited, 'form-control datepicker', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["tgl_selesai"], "tgl_selesai", "Tgl Selesai", false, 3);
		?>
	</div>
	<div class="col-sm-7">
	</div>
</div>
<div class="row">
	<div class="col-sm-5">
		<?php
		$from = UI::createTextBox('tipe_pekerjaan', $row['tipe_pekerjaan'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["tipe_pekerjaan"], "tipe_pekerjaan", "Tipe Pekerjaan", false, 3);
		?>
		<?php
		$from = UI::createTextBox('manager', $row['manager'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["manager"], "manager", "Manager", false, 3);
		?>
		<?php
		$from = UI::createTextNumber('jml_personil', $row['jml_personil'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:90px' min='0' max='10000000000' step='1'");
		echo UI::createFormGroup($from, $rules["jml_personil"], "jml_personil", "Jml Personil", false, 3);
		?>

	</div>
	<div class="col-sm-4">
		<?php
		$from = UI::createTextBox('no_prk', $row['no_prk'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		echo UI::createFormGroup($from, $rules["no_prk"], "no_prk", "No PRK", false, 3);
		?>
		<?php
		$from = UI::createTextBox('tgl_prk', $row['tgl_prk'], '11', '11', $edited, 'form-control datepicker	', "style='width:50%'");
		echo UI::createFormGroup($from, $rules["tgl_prk"], "tgl_prk", "Tgl PRK", false, 3);
		?>
	</div>
	<div class="col-sm-7">
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-5">
		<?php
		$from = UI::createTextNumber('progres_fisik', $row['progres_fisik'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
		echo UI::createFormGroup($from, $rules["progres_fisik"], "progres_fisik", "Progres Fisik (%)", false, 3);
		?>
		<?php
		$from = UI::createTextNumber('progres_laporan', $row['progres_laporan'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
		echo UI::createFormGroup($from, $rules["progres_laporan"], "progres_laporan", "Progres Laporan  (%)", false, 3);
		?>

	</div>
	<div class="col-sm-7">
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-5">
		<?php
		$from = UI::createTextArea('kendala', $row['kendala'], '', '', $edited, 'form-control', "");
		echo UI::createFormGroup($from, $rules["kendala"], "kendala", "Kendala dan Tindak Lanjut", false, 3);
		?>
		<?php
		//$from = UI::createTextBox('deskripsi', $row['deskripsi'], '200', '100', $edited, 'form-control ', "style='width:100%'");
		//echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Deskripsi",false, 3);
		?>
		<?php
		//$from = UI::createTextNumber('status', $row['status'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
		//echo UI::createFormGroup($from, $rules["status"], "status", "Status",false, 3);
		?>
		<?php
		$from = UI::showButtonMode("save", null, $edited);
		echo UI::createFormGroup($from, null, null, null, false, 3);
		?>

	</div>
	<div class="col-sm-7">
	</div>
</div>
-->

</div>

<script type="text/javascript">
	function saveDetail() {
		var UNIT_KERJA = $("#UNIT_KERJA").val();
		var RKAP = $("#RKAP").val();
		var STATUS_FISIK = $("#STATUS_FISIK").val();
		var STATUS_NIAGA = $("#STATUS_NIAGA").val();
		var STATUS_PROYEK = $("#STATUS_PROYEK").val();
		var TAHUN_PROYEK = $("#TAHUN_PROYEK").val();
		var NO_PRK = $("#NO_PRK").val();
		var STATUS_SETTLEMENT = $("#STATUS_SETTLEMENT").val();
		var KONTRAKPROYEK_ID = <?= $this->uri->segment(4) ?>;

		$.ajax({
			type: 'POST',
			url: "<?= base_url('om/mon_settelment_proyek/save_detail') ?>",
			data: {
				UNIT_KERJA: UNIT_KERJA,
				RKAP: RKAP,
				STATUS_FISIK: STATUS_FISIK,
				STATUS_NIAGA: STATUS_NIAGA,
				STATUS_PROYEK: STATUS_PROYEK,
				STATUS_SETTLEMENT: STATUS_SETTLEMENT,
				TAHUN_PROYEK: TAHUN_PROYEK,
				KONTRAKPROYEK_ID: KONTRAKPROYEK_ID,
				NO_PRK: NO_PRK,
			},
			success: function(e) {
				alert(e)
			}
		})
	}
</script>