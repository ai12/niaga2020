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
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:1800px; margin-right:auto; margin-left:auto;">
			<h1>
			Laporan Laba/Rugi </h1>
		</section>
		<section class="content" style="max-width:1800px">
			<div class="box box-default">

				<div class="box-body">

				<div class="alert alert-warning alert-dismissable">
						Laporan Laba Rugi
					</div>
					<table>
						<tr>
							<?php $arrBln = $this->Global_model->arrBulan(); ?>
							<?php $arrSlaColor = $this->Global_model->arrSlaColor(); ?>
							<td><select class="form-control" id="awal_bln">
									<?php foreach ($arrBln as $k => $bln) {
									?>
										<option value="<?php echo $k; ?>" <?php echo ($awal_bln == $k) ? 'selected="selected"' : ''; ?>><?php echo $bln ?></option>
									<?php
									} ?>
								</select>
							</td>
							<td><input type="text" class="form-control" value="<?php echo $awal_thn ?>" id="awal_thn"></td>
							<td>&nbsp;sd&nbsp;</td>
							<td><select class="form-control" id="akhir_bln">
									<?php foreach ($arrBln as $k => $bln) {
									?>
										<option value="<?php echo $k; ?>" <?php echo ($akhir_bln == $k) ? 'selected="selected"' : ''; ?>><?php echo $bln ?></option>
									<?php
									} ?>

								</select>
							</td>
							<td><input type="text" class="form-control" value="<?php echo $akhir_thn ?>" id="akhir_thn"></td>
							<td><button type="button" class="btn btn-success" onClick="update()">View</button>
								<button type="button" class="btn btn-primary" onclick="print()">
									Export Excel
								</button>
							</td>
						</tr>
					</table>
					<br>
					<div style='overflow-x:scroll;overflow-y:hidden;width:100%;'>
						<table id="table_settlement" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-striped dataTable">
							<thead>
								<tr style="background-color:#76c9ff">
									<th width="10px">
										No.
									</th>
									<th width="150px">
										Unit
									</th>
									<?php
									$bln = ['L/R (Rp)<br>Perencanaan<br>(f = a - c )', 'GPM (%)<br>(g = f / a )', 'L/R (Rp)<br>Realisasi<br>(h)', 'GPM (%)<br>(j = h/b )'];
									foreach ($bln as $val) { ?>
										<th><?php echo $val; ?></th>
									<?php } ?>

								</tr>

							</thead>
							<tbody>
								<?php
								$no = 1;
								unset($units['']);
								unset($units['***']);
								foreach ($units as $key => $value) {
									$nilai_unit = $this->Global_model->nilai_settlement_by_unit($key);
									echo 	'<tr ><td  width="10px"  style="background-color:#76c9ff">' . $no . '</td><td style="background-color:#76c9ff">' . $value . '</td>';
									echo	"<td style='text-align:right'>" . number_format($nilai_unit['pekerjaan']-$nilai_unit['hpp']) . "</td>";
									echo	"<td style='text-align:right'>" . number_format($nilai_unit['pemberkasan_unit']) . "</td>";
									echo	"<td style='text-align:right'>" . number_format($nilai_unit['verifikasi_om']) . "</td>";
									echo	"<td style='text-align:right'>" . number_format($nilai_unit['proses_niaga']) . "</td>";
									
									$no++;
									echo	'</tr>';

									$total['pekerjaan'] += $nilai_unit['pekerjaan'];
									$total['pemberkasan_unit'] += $nilai_unit['pemberkasan_unit'];
									$total['verifikasi_om'] += $nilai_unit['verifikasi_om'];
									$total['proses_niaga'] += $nilai_unit['proses_niaga'];
									
								}

								echo	'</tr>';
								echo 	'<tr style="background-color:#76c9ff"><td style="background-color:#76c9ff"></td ><td style="background-color:#76c9ff">TOTAL</td>';
								echo	"<td style='text-align:right'>" . number_format($total['pekerjaan']) . "</td>";
								echo	"<td style='text-align:right'>" . number_format($total['pemberkasan_unit']) . "</td>";
								echo	"<td style='text-align:right'>" . number_format($total['verifikasi_om']) . "</td>";
								echo	"<td style='text-align:right'>" . number_format($total['proses_niaga']) . "</td>";
								
								echo	'</tr>';

								echo 	'<tr  style="background-color:#76c9ff"><td style="background-color:#76c9ff"></td ><td style="background-color:#76c9ff">PROSENTASE</td>';
								echo	($total['total']>0)?"<td style='text-align:right'>" . number_format($total['pekerjaan'] / $total['total'] * 100) . "</td>":"<td style='text-align:right'>0</td>";
								echo	($total['total']>0)?"<td style='text-align:right'>" . number_format($total['pemberkasan_unit'] / $total['total'] * 100) . "</td>":"<td style='text-align:right'>0</td>";
								echo	($total['total']>0)?"<td style='text-align:right'>" . number_format($total['verifikasi_om'] / $total['total'] * 100) . "</td>":"<td style='text-align:right'>0</td>";
								echo	($total['total']>0)?"<td style='text-align:right'>" . number_format($total['proses_niaga'] / $total['total'] * 100) . "</td>":"<td style='text-align:right'>0</td>";
								
								echo	'</tr>';
								?>
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
	function print() {

		$("#table_settlement").table2excel({
			// exclude CSS class
			name: "Worksheet Name",
			filename: "laporan_labarugi", //do not include extension
			fileext: ".xlsX" // file extension
		});

	}

	function update() {
		var awal_bln = $('#awal_bln').val();
		var awal_thn = $('#awal_thn').val();
		var akhir_bln = $('#akhir_bln').val();
		var akhir_thn = $('#akhir_thn').val();

		var awal = awal_thn + '-' + awal_bln;
		var akhir = akhir_thn + '-' + akhir_bln;

		window.location = "<?php echo base_url('panelbackend/laporan_om/lap_lr') ?>" + '/' + awal + '/' + akhir;
	}
</script>