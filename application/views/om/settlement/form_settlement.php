<form id='isi'>
	<table class="table">
		<tr>
			<td style="text-align: right;">Periode</th>
			<td><?php echo $settlement['periode'] ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">Unit</th>
			<td><?php
				$arrunit = $this->Global_model->get_combo('MT_UNIT', 'TABLE_CODE', 'TABLE_DESC');
				echo $arrunit[$settlement['unit_id']] ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">Status</th>
			<td><select class="form-control select2" name="status">
					<?php $arrSla = $this->Global_model->arrSla(); ?>
					<?php foreach ($arrSla as $k => $sla) {
					?>
						<option value="<?php echo $k; ?>" <?php echo ($settlement['status'] == $k) ? 'selected="selected"' : ''; ?>><?php echo $sla ?></option>
					<?php
					} ?>

				</select>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Nilai Kontrak</th>
			<td><input style="width:200px;text-align:right" type="text" name="nilai_kontrak" class="form-control rupiah" value="<?php echo $settlement['nilai_kontrak'] ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Nilai Tagihan</th>
			<td><input style="width:200px;text-align:right" type="text" name="nilai_tagihan" class="form-control rupiah" value="<?php echo $settlement['nilai_tagihan'] ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Nilai Terbayar</th>
			<td><input style="width:200px;text-align:right" type="text" name="nilai_terbayar" class="form-control rupiah" value="<?php echo $settlement['nilai_terbayar'] ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Nilai Biaya</th>
			<td><input style="width:200px;text-align:right" type="text" name="nilai_biaya" class="form-control rupiah" value="<?php echo $settlement['nilai_biaya'] ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Nilai HPP</th>
			<td><input style="width:200px;text-align:right" type="text" name="nilai_hpp" class="form-control rupiah" value="<?php echo ($settlement['nilai_hpp']>0)?$settlement['nilai_hpp']:0; ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;" nowrap>Prosentase SLA</th>
			<td><input style="width:100px;text-align:right" type="text" name="persen_sla" class="form-control" value="<?php echo $settlement['persen_sla'] ?>"></td>
		</tr>
		<tr>
			<td style="text-align: right;">Uraian</th>
			<td><textarea name="uraian" class="form-control"><?php echo $settlement['uraian'] ?></textarea></td>
		</tr>
		<tr>
			<td style="text-align: right;">Tindak Lanjut</th>
			<td><textarea name="tindak_lanjut" class="form-control"><?php echo $settlement['tindak_lanjut'] ?></textarea></td>
		</tr>

	</table>

	<input type='hidden' name='row_id' value='<?php echo $settlement['id'] ?>'>
	<input type='hidden' name='periode' value='<?php echo $settlement['periode'] ?>'>
	<input type='hidden' name='unit_id' value='<?php echo $settlement['unit_id'] ?>'>


</form>
<SCRIPT LANGUAGE='JavaScript'>
	$(function() {
		$(".rupiah").autoNumeric('init', {
			aSep: '.',
			aDec: ','
		});
	})

	function updateForm() {
		var url = '<?= base_url('panelbackend/mon_settlement/nilai_update') ?>'; // the script where you handle the form input.
		var isi;

		$.ajax({
			type: 'POST',
			url: url,
			data: $('#isi').serialize(), // serializes the form's elements.
			success: function(data) {
				if (data == 1) {
					isi = 'Perubahan berhasil dilakukan.';
				} else if (data == 0) {

					isi = 'Perubahan Gagal dilakukan.';
					alert(isi);
					return false;

				} else {
					isi = data;
					alert(isi);
					return false;
				}

				alert(isi);
				//getData();
				location.reload();

			}
		});

		return false; // avoid to execute the actual submit of the form.
	}
</SCRIPT>