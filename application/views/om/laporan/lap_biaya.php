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
				Monitoring Biaya </h1>
		</section>
		<section class="content" style="max-width:1800px">
			<div class="box box-default">

				<div class="box-body">


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
								<?php
									$arrPeriode = [];
									$i = 0;
									foreach ($period as $dt) {
										$arrPeriode[$i] = $dt->format("m-Y");
										$i++;
									}
									?>
								<tr>
									<th style="text-align:center;background-color:#ff9600" colspan="<?php echo (3+count($arrPeriode))?>">Realisasi Biaya (d)</th>
									<th style="text-align:center;background-color:#2b982b" colspan="<?php echo (count($arrPeriode))?>">SLA Penagihan (e)</th>
									<th style="text-align:center;background-color:#76c9ff" colspan="<?php echo (count($arrPeriode))?>">SLA Realisasi (f)</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Unit</th>
									<?php
									$arrPeriode = [];
									$i = 0;
									foreach ($period as $dt) {
										echo '<th>' . $dt->format("M Y") . '</th>';
										$arrPeriode[$i] = $dt->format("m-Y");
										$i++;
									}
									?>
									<th>Realisasi Biaya (Rp)</th>
									<?php
									$arrPeriode = [];
									$i = 0;
									foreach ($period as $dt) {
										echo '<th>' . $dt->format("M Y") . '</th>';
										$arrPeriode[$i] = $dt->format("m-Y");
										$i++;
									}
									?>
									<?php
									$arrPeriode = [];
									$i = 0;
									foreach ($period as $dt) {
										echo '<th>' . $dt->format("M Y") . '</th>';
										$arrPeriode[$i] = $dt->format("m-Y");
										$i++;
									}
									?>

								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								unset($units['']);
								unset($units['***']);
								foreach ($units as $key => $value) {
									foreach ($arrPeriode as $k => $dt) {
										$settlement[$k] = $this->Global_model->nilai_settlement($key, $dt);
										$total_kontrak[$k] += $settlement[$k]['nilai_kontrak'];
										$total_tagihan[$k] += $settlement[$k]['nilai_tagihan'];
										$total_terbayar[$k] += $settlement[$k]['nilai_terbayar'];
										$total_biaya[$k] += $settlement[$k]['total_biaya'];
									}
								?>
									<tr>
										<td style="background-color:#76c9ff"><?php echo $no;
											$no++; ?></td>
										<td style="background-color:#76c9ff"><?php echo $value; ?></td>
										<?php
										$total = 0;
										foreach ($arrPeriode as $k => $dt) {
											$total += $settlement[$k]['nilai_biaya'];
											echo '<td nowrap style="text-align:right">Rp.' . number_format($settlement[$k]['nilai_biaya'], 0, '.', ',') . '</td>';
										}
										echo '<td nowrap style="text-align:right;background-color:#76c9ff">Rp.' . number_format($total, 0, '.', ',') . '</td>';
										?>
										<?php
										$total = 0;
										foreach ($arrPeriode as $k => $dt) {
											$total += $settlement[$k]['persen_sla'];
											echo '<td nowrap style="text-align:right">' . number_format($settlement[$k]['persen_sla'], 0, '.', ',') . '%</td>';
										}
										
										?>
										<?php
										$total = 0;
										foreach ($arrPeriode as $k => $dt) {
											$total += $settlement[$k]['persen_sla'];
											$realisasi = ($settlement[$k]['nilai_kontrak']>0)?($settlement[$k]['nilai_terbayar']/$settlement[$k]['nilai_kontrak'])*100:0;
											echo '<td nowrap style="text-align:right">' . number_format(($realisasi), 0, '.', ',') . '%</td>';
										}
										
										?>
									</tr>

								<?php } ?>

								<tr>
									<td style="text-align:right;background-color:#76c9ff"></td><td style="text-align:right;background-color:#76c9ff">Total Periode</td>

									<?php
									$total = 0;
									foreach ($arrPeriode as $k => $dt) {
										$total += $total_biaya[$k];
										echo '<td nowrap style="text-align:right;background-color:#76c9ff">Rp.' . number_format($total_biaya[$k], 0, '.', ',') . '</td>';
									}
									echo '<td nowrap style="text-align:right;background-color:#76c9ff">Rp.' . number_format($total, 0, '.', ',') . '</td>';
									?>
									<?php
									$total = 0;
									foreach ($arrPeriode as $k => $dt) {
										$total += $total_biaya[$k];
										echo '<td nowrap style="text-align:right;background-color:#76c9ff">Rp.' . number_format($total_biaya[$k], 0, '.', ',') . '</td>';
									}
									?>
									<?php
									$total = 0;
									foreach ($arrPeriode as $k => $dt) {
										$total += $total_biaya[$k];
										echo '<td nowrap style="text-align:right;background-color:#76c9ff">Rp.' . number_format($total_biaya[$k], 0, '.', ',') . '</td>';
									}
									?>
								</tr>
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
			filename: "laporan_biaya", //do not include extension
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

		window.location = "<?php echo base_url('panelbackend/laporan_om/biaya') ?>" + '/' + awal + '/' + akhir;
	}

	
</script>
