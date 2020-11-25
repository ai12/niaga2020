<?php

$units = $this->Global_model->get_combo('MT_UNIT', 'TABLE_CODE', 'TABLE_DESC');
$start    = (new DateTime($awal . '-01'))->modify('first day of this month');
$end      = (new DateTime($akhir . '-01'))->modify('first day of next month');
$interval = DateInterval::createFromDateString('1 month');
$period   = new DatePeriod($start, $interval, $end);

$awal_arr  = explode('-', $awal);
$akhir_arr = explode('-', $akhir);

$awal_bln = (is_array($awal_arr)) ? $awal_arr[1] : '';
$awal_thn = (is_array($awal_arr)) ? $awal_arr[0] : '';
$akhir_bln = (is_array($akhir_arr)) ? $akhir_arr[1] : '';
$akhir_thn = (is_array($akhir_arr)) ? $akhir_arr[0] : '';
// foreach ($period as $dt) {
//     echo $dt->format("Y-m") . "<br>\n";
// }
// exit;
?>
<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Monitoring Settlement </h1>
		</section>
		<section class="content" style="max-width:1800px">
			<div class="box box-default">

				<div class="box-body">

					<table>
						<tr>
							<td><select class="form-control" id="awal_bln">
									<option value="01" <?php echo ($awal_bln == '01') ? 'selected="selected"' : ''; ?>>Januari</option>
									<option value="02" <?php echo ($awal_bln == '02') ? 'selected="selected"' : ''; ?>>Februari</option>
									<option value="03" <?php echo ($awal_bln == '03') ? 'selected="selected"' : ''; ?>>Maret</option>
									<option value="04" <?php echo ($awal_bln == '04') ? 'selected="selected"' : ''; ?>>April</option>
									<option value="05" <?php echo ($awal_bln == '05') ? 'selected="selected"' : ''; ?>>Mei</option>
									<option value="06" <?php echo ($awal_bln == '06') ? 'selected="selected"' : ''; ?>>Juni</option>
									<option value="07" <?php echo ($awal_bln == '07') ? 'selected="selected"' : ''; ?>>Juli</option>
									<option value="08" <?php echo ($awal_bln == '08') ? 'selected="selected"' : ''; ?>>Agustus</option>
									<option value="09" <?php echo ($awal_bln == '09') ? 'selected="selected"' : ''; ?>>September</option>
									<option value="10" <?php echo ($awal_bln == '10') ? 'selected="selected"' : ''; ?>>Oktober</option>
									<option value="11" <?php echo ($awal_bln == '11') ? 'selected="selected"' : ''; ?>>Nopember</option>
									<option value="12" <?php echo ($awal_bln == '12') ? 'selected="selected"' : ''; ?>>Desember</option>
								</select>
							</td>
							<td><input type="text" class="form-control" value="<?php echo $awal_thn ?>" id="awal_thn"></td>
							<td>&nbsp;sd&nbsp;</td>
							<td><select class="form-control" id="akhir_bln">
									<option value="01" <?php echo ($akhir_bln == '01') ? 'selected="selected"' : ''; ?>>Januari</option>
									<option value="02" <?php echo ($akhir_bln == '02') ? 'selected="selected"' : ''; ?>>Februari</option>
									<option value="03" <?php echo ($akhir_bln == '03') ? 'selected="selected"' : ''; ?>>Maret</option>
									<option value="04" <?php echo ($akhir_bln == '04') ? 'selected="selected"' : ''; ?>>April</option>
									<option value="05" <?php echo ($akhir_bln == '05') ? 'selected="selected"' : ''; ?>>Mei</option>
									<option value="06" <?php echo ($akhir_bln == '06') ? 'selected="selected"' : ''; ?>>Juni</option>
									<option value="07" <?php echo ($akhir_bln == '07') ? 'selected="selected"' : ''; ?>>Juli</option>
									<option value="08" <?php echo ($akhir_bln == '08') ? 'selected="selected"' : ''; ?>>Agustus</option>
									<option value="09" <?php echo ($akhir_bln == '09') ? 'selected="selected"' : ''; ?>>September</option>
									<option value="10" <?php echo ($akhir_bln == '10') ? 'selected="selected"' : ''; ?>>Oktober</option>
									<option value="11" <?php echo ($akhir_bln == '11') ? 'selected="selected"' : ''; ?>>Nopember</option>
									<option value="12" <?php echo ($akhir_bln == '12') ? 'selected="selected"' : ''; ?>>Desember</option>
								</select>
							</td>
							<td><input type="text" class="form-control" value="<?php echo $akhir_thn ?>" id="akhir_thn"></td>
							<td><button type="button" class="btn btn-success" onClick="update()">View</button></td>
						</tr>
					</table>
					<div style='overflow-x:scroll;overflow-y:hidden;width:100%;'>
						<table class="table table-striped table-hover dataTable">
							<thead>
								<tr>
									<th>
										#
									</th>

									<th>
										Unit
									</th>
									<?php
									foreach ($period as $dt) {
										echo '<th>' . $dt->format("Y M") . '</th>';
									}
									?>
									<th>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								unset($units['']);
								unset($units['***']);
								foreach ($units as $key => $value) {
									echo 	'<tr>';
									echo	"<td>$no</td>";
									echo	"<td>$value</td>";
									foreach ($period as $dt) {
								?>
										<td>
											<table class="table">
												<tr>
													<td style="text-align:right"><a href="#modal" data-toggle="modal" class="config"><?php echo rand(1, 14) ?></a></td>
												</tr>
												<tr>
													<td style="text-align:right">Rp.<?php echo number_format(rand(0, 1000000000)) ?></td>
												</tr>
												<tr>
													<td style="text-align:right"><?php echo rand(0, 100) ?>%</td>
												</tr>
											</table>
										</td>
								<?php
									}
									echo	'<td style="text-align:right">
								<div class="dropdown" style="display:inline">
											<a href="javascript:void(0)" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:#1f91f3;display:inline-block;">
												<span class="glyphicon glyphicon-option-vertical"></span>
											</a>
											<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2" style="min-width: 10px; margin-top:-20px"><li><a href="javascript:void(0)" class="waves-effect " onclick="goEdit(\'13\')"><span class="glyphicon glyphicon-edit"></span> Edit</a> </li>
									<li><a href="javascript:void(0)" class="waves-effect " onclick="goDelete(\'134\')"><span class="glyphicon glyphicon-remove"></span> Delete</a> </li>
									</ul></div>
								</td>';
									echo	'</tr>';
									$no++;
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div><!-- /.box -->
		</section>

		<style type="text/css">
			table.dataTable {
				clear: both;
				margin-bottom: 6px !important;
				max-width: none !important;
			}
		</style>

	</form>
</div>

<script>
	function update() {
		var awal_bln = $('#awal_bln').val();
		var awal_thn = $('#awal_thn').val();
		var akhir_bln = $('#akhir_bln').val();
		var akhir_thn = $('#akhir_thn').val();

		var awal = awal_thn + '-' + awal_bln;
		var akhir = akhir_thn + '-' + akhir_bln;

		window.location = "<?php echo base_url('panelbackend/proto/mon_settlement') ?>" + '/' + awal + '/' + akhir;
	}
</script>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-bookmark"></i> Update Status </h4>
			</div>
			<div class="modal-body" id="modal-body">
				<table class="table">
					<tr><td>Periode</th><td><?php echo date('Y')?></td></tr>
					<tr>	<td>Unit</th><td><?php echo 'Unit 1'?></td></tr>
					<tr>	<td>Status</th><td><select class="form-control">
					<option value='1'>	1 - Proses Pembuatan Laporan</option>
					<option value='2'>	2 - Approval Laporan oleh Tim Pemeriksa Owner (PLN/PJB/IPP) di Site</option>
					<option value='3'>	3 - BAPP PLN/IPP di TTD oleh Wakil Direksi Pekerjaan Owner-Manajer Unit di site</option>
					<option value='4'>	4 - Laporan dan BAPP PLN diterima di PJBS Kantor Pusat</option>
					<option value='5'>	5 - Laporan realisasi biaya ABOP final</option>
					<option value='6'>	6 - Laporan, BAPP dan realisasi biaya diterima & direview Niaga O&M</option>
					<option value='7'>	7 - Proses penerbitan BAPP dengan UJLJ / Customer </option>
					<option value='8'>	8 - Review nilai tagihan, proses BASTP ttd DirOM PJBS</option>
					<option value='9'>	9 - Penerbitan form Permohonan Pembuatan Tagihan/Invoice untuk diserahkan ke Div Keuangan (disertai kelengkapan syarat penagihan)</option>
					<option value='10'>	10 - Proses verifikasi kelengkapan berkas tagihan di Keuangan</option>
					<option value='11'>	11 - Proses pembuatan dan approval dokumen tagihan</option>
					<option value='12'>	12 - Proses penyampaian/ pengiriman dokumen tagihan</option>
					<option value='13'>	13 - Proses verifikasi dokumen tagihan oleh pelanggan</option>
					<option value='14'>	14 - Terbayar</option>
					</select>
					</td></tr>
					<tr>	<td>Nilai</th><td><input type="text" style="text-align:right" class="form-control rupiah" value="<?php echo rand(0,100000000)?>"></td></tr>
					<tr>	<td>Persentase</th><td><input type="text" style="text-align:right" class="form-control" value="<?php echo rand(1,100)?>"></td></tr>
					<tr>	<td>Uraian</th><td><textarea class="form-control"></textarea></td></tr>
					<tr>	<td>Tindak Lanjut</th><td><textarea class="form-control"></textarea></td></tr>
					
				</table>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				<button type="submit" class="btn btn-primary pull-left" id="save"><i class="fa fa-check"></i> Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->