<div class="row">
	<?php
	if (!$edited && $id > 0) {


		$this->load->helper('form');
		$this->load->helper('om_helper');
		$status = (isset($status)) ? $status : null;
	?>
		<?php
		$arrstatus = $this->Global_model->GetNextStatus($status);
		$nextexist = $this->Global_model->get_next_exist($id, $status);
		if (!$nextexist) {


		?>

			<div class="col-sm-<?php echo (isset($size))?$size:6;?>">
				<div class="alert alert-info alert-dismissable">
					Proses Dokumen
				</div>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">Lanjutkan Dokumen</label>
					<div class="col-sm-8">
						<input type="hidden" name="approval_id" id="approval_id" value="<?php echo (isset($id)) ? $id : null; ?>">
						<?php echo formSelect('approval_status', '', $arrstatus, []); ?>
					</div>
				</div>
				<div class="form-group" style="display:none" id="lampiran_kontrak">
					<label for="" class="col-sm-4 control-label">Surat Penunjukan / Surat Penugasan</label>
					<div class="col-sm-8">
						<?php echo formInputFile('approval_lampiran', '', ['width' => '300px']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">Keterangan</label>
					<div class="col-sm-8">
						<?php echo formInputArea('approval_keterangan', '', ['width' => '300px']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"></label>
					<div class="col-sm-8">
						<?php echo linkToBtn('Submit Lanjutkan', 'class="btn-save btn btn-sm btn-success" onClick="lanjutkanProses()"'); ?>
					</div>
				</div>
			</div>


			<script>
				$(function() {
					$('#approval_status').change(function() {
						var status = $(this).val();
						var status_lampiran = "<?php echo $this->Global_model->STATUS_KONTRAK; ?>";
						if (status == status_lampiran) {
							$('#lampiran_kontrak').show();
						} else {
							$('#lampiran_kontrak').hide();
						}
					});
				});

				function lanjutkanProses() {

					var url = '<?= base_url() ?>om/approval/approval_action';
					var id = $('#approval_id').val();
					var status = $('#approval_status').val();
					var keterangan = $('#approval_keterangan').val();
					var formData = new FormData();
					formData.append('lampiran', $('#approval_lampiran')[0].files[0]);
					formData.append('id', id);
					formData.append('status', status);
					formData.append('keterangan', keterangan);


					$.ajax({
						type: 'POST',
						url: url,
						data: formData,
						// dataType: 'json',
						processData: false,
						contentType: false,
						success: function(data) {
							var data = JSON.parse(data);
							if (data.valid == 1) {
								isi = 'Perubahan berhasil dilakukan.';
							} else {
								isi = data.msg;
								alert(isi);
								return false;
							}

							alert(isi);
							window.location = '<?= base_url() ?>' + data.url;

						}
					});
				}
			</script>
		<?php }
		?>



	<?php
	}
	?>
</div>
<div class="col-sm-<?php echo (isset($size))?$size:6;?>">
	<div class="alert alert-info alert-dismissable">
		Log Dokumen
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Deskripsi</th>
				<th>User</th>
				<th></th>
			</tr>
		</thead>
		<?php
		$datas = $this->Global_model->get_history($id);

		?>
		<tbody>
			<?php
			$arr_status = $this->Global_model->GetStatusArr();
			if(is_array($datas)){

				foreach ($datas as $dt) { ?>
				<tr>
					<td><?php echo $dt['tgl'] ?></td>
					<td><?php echo 'Diproses menjadi ' . $arr_status[$dt['status']] . ' : ' . $dt['deskripsi'] ?></td>
					<td><?php echo $dt['user'] ?></td>
					<td></td>
				</tr>
			<?php } ?>
			<?php
			if ($log_id) {
				
				$datas = $this->Global_model->get_history($log_id, $log_trans);
				foreach ($datas as $dt) { 
					$text = $this->Global_model->formating_history($dt['other_attr'],$dt['status']);
					?>
					<tr>
						<td><?php echo $dt['tgl'] ?></td>
						<td><?php echo 'Data ' . $arr_status[$dt['status']] . ' ' . $dt['deskripsi'].' : '.$text; ?></td>
						<td><?php echo $dt['user'] ?></td>
						<td><?php echo ($dt['lampiran'])?'download':''; ?></td>
					</tr>
			<?php

			}
			}
			} ?>
		</tbody>
	</table>
</div>
