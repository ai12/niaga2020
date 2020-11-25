<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content" style="max-width:100%">
			<div class="col-sm-12 no-padding">
				<div class="scrtabs-tab-container" style="visibility: visible;">
					<div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-left" style=""><span class="glyphicon glyphicon-chevron-left"></span></div>
					<div class="scrtabs-tabs-fixed-container" style="width: 1443.6px;">
						<div class="scrtabs-tabs-movable-container" style="width: 1443.6px;">
							<ul class="nav nav-tabs">
								<li class="">
									<a href="#"> <i class="fa fa- "></i> DETAIL KONTRAK </a>
								</li>
								<li class="">
									<a href="#"> <i class="fa fa- "></i> PEKERJAAN KONTRAK </a>
								</li>
								<li class="active">
									<a href="http://localhost:8080/niaga/panelbackend/t_kontrak_pekerjaan/index/2"> <i class="fa fa- "></i> Finishing </a>
								</li>
							</ul>
						</div>
					</div>
					<div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-right" style=""><span class="glyphicon glyphicon-chevron-right"></span></div>
				</div>
			</div>
			<?php
			$data_isi = [];
			$data_isi[] = array('BA Pemeriksaan', 'BA/2020/001', ' Jan 2020', 'BA1.pdf');
			$data_isi[] = array('BA Pemeriksaan', 'BA/2020/002', ' Feb 2020', 'BA2.pdf');
			$data_isi[] = array('BA Serah terima', 'BA/2020/V.001', ' Feb 2020', 'BA2.pdf');

			?>
			<div class="col-sm-12 no-padding">
				<div class="box box-default">
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<div class="box-header with-border">

								<div class="pull-left" style="max-width: 100%px">
									<h4 style="margin: 10px 0px 0px 0px !important; display: inline;">
										Tes KONTRAK </h4>
									<br>
									<small>
										200/2020/PJBS </small>
								</div>
								<div class="pull-right">
									<button type="button" class="btn waves-effect  btn-sm btn-default" onclick="goList()"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
									<script>
										function goList() {
											window.location = "http://localhost:8080/niaga/panelbackend/t_kontrak_pekerjaan/index/2";
										}
									</script>
								</div>
							</div>
							<div style="clear: both;"></div>
							<div class="box-body">


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
														<?php foreach ($data_isi as $dt) { ?>
															<tr>
																<td><?php echo $dt[0]; ?></td>
																<td><?php echo $dt[1] . '/' . rand(1, 99); ?></td>
																<td><?php echo rand(2, 31) . $dt[1]; ?></td>
																<td><?php echo $dt[3]; ?></td>
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
										<tr>
											<td width="10%" style="text-align:right">Unit Kerja</td>
											<td width="40%"></td>
										</tr>
										<tr>
											<td width="10%" style="text-align:right">RKAP/Non RKAP</td>
											<td width="40%">RKAP</td>
										</tr>
										<tr>
											<td width="10%" style="text-align:right">Status Fisik</td>
											<td width="40%">40%</td>
										</tr>
										<tr>
											<td width="10%" style="text-align:right">Status Niaga</td>
											<td width="40%">30%</td>
										</tr>
										<tr>
											<td width="10%" style="text-align:right">Status Proyek</td>
											<td width="40%">35%</td>
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
							</div>
						</div>
					</div>
					<!--       <div class="tab-content">
          <div class="box-header with-border">
            BOQ > EVALUASI > PENETAPAN
          </div>
  </div> -->
				</div>
			</div><!-- /.box -->
			<div style="clear: both;"></div>
		</section>

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
				<table class="table">
					<tr>
						<td width="10%" style="text-align:right">Unit Kerja</td>
						<td width="40%"></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">RKAP/Non RKAP</td>
						<td width="40%">RKAP</td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Fisik</td>
						<td width="40%"><input type="text" class="form-control" /></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Niaga</td>
						<td width="40%"><input type="text" class="form-control" /></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Status Proyek</td>
						<td width="40%"><input type="text" class="form-control" /></td>
					</tr>
					<tr>
						<td width="10%" style="text-align:right">Tahun Proyek</td>
						<td width="40%">2020</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				<button type="button" onCLick="updateForm()" class="btn btn-primary pull-left" id="save"><i class="fa fa-check"></i> Save</button>
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
						<tr>
							<td>1</td>
							<td>01-08-2020</td>
							<td>10%</td>
							<td>5%</td>
							<td>2%k</td>
						</tr>
						<tr>
							<td>2</td>
							<td>15--08-2020</td>
							<td>50%</td>
							<td>50%</td>
							<td>20%k</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->