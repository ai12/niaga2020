<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">

		<?php
		// print_r($id);exit;
		$data_isi = [];
		$data_isi[] = array('BA Pemeriksaan', 'BA/2020/001', ' Jan 2020', 'BA1.pdf');
		$data_isi[] = array('BA Pemeriksaan', 'BA/2020/002', ' Feb 2020', 'BA2.pdf');
		$data_isi[] = array('BA Serah terima', 'BA/2020/V.001', ' Feb 2020', 'BA2.pdf');

		?>


		<div class="col-sm-6">
			<table class="table">
				<tr>
					<td width="40%" colspan="3">
						<div class="alert alert-success">
							Berita Acara
						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr style="background-color:#76c9ff">
									<th>Jenis</th>
									<th>Nomor</th>
									<th>Tgl</th>
									<th colspan="2">Lampiran</th>

								</tr>
							</thead>
							<tbody>
								<?php foreach ($rowdetail as $dt) { ?>
									<tr>
										<td><?php echo $dt['jenis']; ?></td>
										<td><?php echo $dt['nomor']; ?></td>
										<td><?php echo $dt['tanggal'] ?></td>
										<td><?php echo $dt['lampiran']; ?></td>
										<td><a class="btn btn-xs btn-danger"><i class="fa fa-delete"></i>del</a></td>
									<?php } ?>
									</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td width="10%">Tambah Berita Acara</td>
					<td width="10%" style="text-align:right">Jenis </td>
					<td width="40%"><input type="text" class="form-control"></td>
				</tr>
				<tr>
					<td></td>
					<td width="10%" style="text-align:right">Nomor</td>
					<td width="40%"><input type="text" style="width:200px" class="datepicker form-control"></td>
				</tr>
				<tr>
					<td></td>
					<td width="10%" style="text-align:right">Tanggal</td>
					<td width="40%"><input type="text" style="width:200px" class="datepicker form-control"></td>
				</tr>
				<tr>
					<td>Tanggal Dibayar</td>
					<td width="10%" style="text-align:right"></td>
					<td width="40%"><input type="text" style="width:200px" class="datepicker form-control"></td>
				</tr>
			</table>
			<div class="alert alert-success">
				Evaluasi Pekerjaan
			</div>
			<textarea placeholder="isi keluhan" class="form-control" style="height:150px;width:600px;">
				</textarea>
			<br>
			<br>
		</div>
		<div class="col-sm-6">


			<table class="table">
				<!--<tr>
					<td width="10%" style="text-align:right">Unit Kerja</td>
					<td width="40%"></td>
				</tr>
				<tr>
					<td width="10%" style="text-align:right">RKAP/Non RKAP</td>
					<td width="40%">RKAP</td>
				</tr>-->
				<?php $log_lastest = (isset($history[0]))?$history[0]:null;?>
				<tr>
					<td width="10%" style="text-align:right">Status Fisik</td>
					<td width="40%"><?php echo (isset($log_lastest['status_fisik']))?$log_lastest['status_fisik']:0;?>%</td>
				</tr>
				<tr>
					<td width="10%" style="text-align:right">Status Niaga</td>
					<td width="40%"><?php echo (isset($log_lastest['status_niaga']))?$log_lastest['status_niaga']:0;?>%</td>
				</tr>
				<tr>
					<td width="10%" style="text-align:right">Status Proyek</td>
					<td width="40%"><?php echo (isset($log_lastest['status_proyek']))?$log_lastest['status_proyek']:0;?>%</td>
				</tr>
				<tr>
					<td width="10%" style="text-align:right">Tahun Proyek</td>
					<td width="40%">2020</td>
				</tr>
				<tr>
					<td width="10%" style="text-align:right"></td>
					<td width="40%">
						<a href="#modal1" data-toggle="modal" class="btn btn-primary btn-xs">update</a>
						<a href="#modal2" data-toggle="modal" class="btn btn-warning btn-xs">history</a>
					</td>
				</tr>

			</table>
			<br>
			<div class="form-group ">
				<div class="col-sm-12">
					<button type="submit" class="btn-save btn btn-sm btn-success" onclick="goSave()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
					<script>
						function goSave() {
							$("#main_form").submit(function(e) {
								if (e) {
									$(".btn-save").attr("disabled", "disabled");
									$("#act").val('save');
								} else {
									return false;
								}
							});
						}
					</script><button type="submit" class="btn waves-effect btn-sm btn-default" onclick="goBatal('')"><span class="glyphicon glyphicon-repeat"></span> Reload</button>
					<script>
						function goBatal() {
							$("#act").val('reset');
							$("#main_form").submit();
						}
					</script>
					<span style="color:#dd4b39; font-size:11px; display: none" id="info_">

					</span>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>


		<style type="text/css">
			table.dataTable {
				clear: both;
				margin-bottom: 6px;
				max-width: none !important;
			}

			table.table-label {
				font-size: 11px;
				color: #666;
			}
		</style>

	</form>
</div>

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-bookmark"></i> Update Status </h4>
			</div>
			<div class="modal-body" id="modal-body">
			<form id="form_history" method="POST">	
			<table class="table">
					<tr>
						<td width="10%" style="text-align:right">Unit Kerja</td>
						<td width="40%"></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Fisik</td>
						<td width="40%"><input type="text" name="status_fisik" class="form-control" value="<?php echo (isset($log_lastest['status_fisik']))?$log_lastest['status_fisik']:0;?>"/></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Niaga</td>
						<td width="40%"><input type="text"  name="status_niaga" class="form-control" value="<?php echo (isset($log_lastest['status_niaga']))?$log_lastest['status_niaga']:0;?>" /></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Proyek</td>
						<td width="40%"><input type="text"  name="status_proyek" class="form-control" value="<?php echo (isset($log_lastest['status_proyek']))?$log_lastest['status_proyek']:0;?>" /></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Tahun Proyek</td>
						<td width="40%">2020</td>
					</tr>
				</table>
			</form>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				<button type="button" class="btn btn-primary pull-left"  onclick="updateForm()"><i class="fa fa-check"></i> Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-bookmark"></i> History Status </h4>
			</div>
			<div class="modal-body" id="modal-body">
				<table class="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Tgl</th>
							<th>Status Fisik</th>
							<th>Status Niaga</th>
							<th>Status Proyek</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$id = 1;
						foreach($history as $log){
							echo '<tr>';
							echo '<td>'.$id.'</td>';
							echo '<td>'.$log['created_date'].'</td>';
							echo '<td>'.$log['status_fisik'].'%</td>';
							echo '<td>'.$log['status_niaga'].'%</td>';
							echo '<td>'.$log['status_proyek'].'%</td>';
							echo '</tr>';
							$id++;
						}?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<SCRIPT LANGUAGE='JavaScript'>


	function updateForm() {
		var url = '<?= base_url('panelbackend/mon_proyekselesai/update_history/'.$row['id_proyek']) ?>'; // the script where you handle the form input.
		var isi;

		$.ajax({
			type: 'POST',
			url: url,
			data: $('#form_history').serialize(), // serializes the form's elements.
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