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
$arrPeriode = [];
$i = 0;
foreach ($period as $dt) {
	echo '<th>' . $dt->format("M Y") . '</th>';
	$arrPeriode[$i] = $dt->format("m-Y");
	$i++;
}
?>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Monitoring Bruto </h1>
		</section>
		<section class="content" style="max-width:1800px">
			<div class="box box-default">

				<div class="box-body">


					<table>
						<tr>
							<?php $arrBln = $this->Global_model->arrBulan(); ?>
							<?php $arrSlaColor = $this->Global_model->arrSlaColor(); ?>
							<?php $arrSlaPic = $this->Global_model->arrSlaPic(); ?>
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
								<button type="button" class="btn btn-primary" onclick="print2()">
									Print
								</button>
							</td>
						</tr>
					</table>
					<br>
					<div class="row" id="printable">
						<?php foreach ($arrbruto as $idjenis => $row) {
						?>
							<div class="col-md-6">
								<!--BEGIN TABS-->
								<table class="table table-striped table-bordered table-hover" id="example1">
									<tdead>
										<tr>
											<td colspan="5" style="text-align:center">
												<?php echo $row; ?>
											</td>
										</tr>
										<tr>
											<th>
												Status
											</th>
											<th>
												JML BULAN
											</th>
											<th>
												NILAI TAGIHAN
											</th>
											<th>
												PIC
											</th>
											<th>
												TOTAL
											</th>

										</tr>

									</tdead>
									<tbody>
										<?php $arrSla = $this->Global_model->arrSla(); ?>
										<?php
										$total = 0;
										foreach ($arrSla as $k => $sla) {
											$nilai_set = $this->Global_model->nilai_settlement_by_status($k, 2, $idjenis, $arrPeriode);
										?>
											<tr style="background-color:<?php echo $arrSlaColor[$k] ?>">
												<td>
													<?php echo $k; ?>
												</td>
												<td style="text-align:right">
													<?php echo number_format($nilai_set['jumlah'], 0, '.', ',')  ?>
												</td>
												<td style="text-align:right">
													<?php echo number_format($nilai_set['tagihan'], 0, '.', ',') ?>
												</td>
												<td>
													<?php echo $arrSlaPic[$k] ?>
												</td>
												<td style="text-align:right">
													<?php echo number_format($nilai_set['total'], 0, '.', ',');
													$total += $nilai_set['total'] ?>
												</td>

											</tr>
										<?php } ?>
										<tr style="">
											<td colspan="4">
												Data Mulai bulan <?php echo $arrBln[$awal_bln] . ' ' . $awal_thn ?>
											</td>
											<td style="text-align:right">
												<?php echo number_format($total, 0, '.', ','); ?>
											</td>

										</tr>
									</tbody>
								</table>

							</div>
						<?php
						} ?>


					</div>


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
	function print2() {

		// $("#table_settlement").table2excel({
		// 	// exclude CSS class
		// 	name: "Worksheet Name",
		// 	filename: "Settlement", //do not include extension
		// 	fileext: ".xlsX" // file extension
		// });

		window.print();
	}

	function update() {
		var awal_bln = $('#awal_bln').val();
		var awal_thn = $('#awal_thn').val();
		var akhir_bln = $('#akhir_bln').val();
		var akhir_thn = $('#akhir_thn').val();

		var awal = awal_thn + '-' + awal_bln;
		var akhir = akhir_thn + '-' + akhir_bln;

		window.location = "<?php echo base_url('panelbackend/mon_settlement/bruto') ?>" + '/' + awal + '/' + akhir;
	}

	function openModal(url) {
		$.ajax({
			type: "GET",
			url: url,
			success: function(e) {
				$("#modal-body").html(e);
				$('#mymodal').modal('show');
			}
		});
	}

	function openModal2(url) {
		$.ajax({
			type: "GET",
			url: url,
			success: function(e) {
				$("#modal-body2").html(e);
				$('#mymodal2').modal('show');
			}
		});
	}
</script>

<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-bookmark"></i> Update Status </h4>
			</div>
			<div class="modal-body" id="modal-body">

			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
				<button type="button" onCLick="updateForm()" class="btn btn-primary pull-left" id="save"><i class="fa fa-check"></i> Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="mymodal2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-bookmark"></i> History Unit </h4>
			</div>
			<div class="modal-body" id="modal-body2">

			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->