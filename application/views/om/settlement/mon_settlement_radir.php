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
				Laporan Radir </h1>
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
						<table id="table_settlement" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-hover dataTable">
							<thead>
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
									<th>Rp/Bln<br>(M)</th>
									<th>Tagihan<br>Blm Terbayar</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								unset($units['']);
								unset($units['***']);
								foreach ($units as $key => $value) {
                                    $total_terbayar_unit = 0;
                                    $nilai_tagihan_unit = 0;
                                    $total_kontrak_unit = 0;
									foreach ($arrPeriode as $k => $dt) {
										$settlement[$k] = $this->Global_model->nilai_settlement($key, $dt);
										$total_kontrak[$k] += $settlement[$k]['nilai_kontrak'];
										$total_tagihan[$k] += $settlement[$k]['nilai_tagihan'];
										$total_terbayar[$k] += $settlement[$k]['nilai_terbayar'];
										$total_biaya[$k] += $settlement[$k]['nilai_biaya'];
                                        $total_hpp[$k] += $settlement[$k]['nilai_hpp'];
                                        
                                        $total_terbayar_unit += $settlement[$k]['nilai_terbayar'];
                                        $total_tagihan_unit += $settlement[$k]['nilai_tagihan'];
                                        $total_kontrak_unit += $settlement[$k]['nilai_kontrak'];
									}
								?>
									<tr>
										<td><?php echo $no;
														$no++; ?></td>
										<td><?php echo $value; ?></td>
										<?php foreach ($arrPeriode as $k => $dt) {
											$slaVal = $settlement[$k]['status'];
											$slaColor = $arrSlaColor[$slaVal];
											echo '<td nowrap style="background-color:' . $slaColor . ';text-color:black;text-align:right"><a style="color:white" href="#" onClick="openModal(\'' . base_url('panelbackend/mon_settlement/nilai/' . $key . '/' . $dt) . '\')">' . $slaVal . '</a></td>';
											// echo '<td nowrap style="text-align:right">'.$settlement[$k]['status'].'</td>';
										} ?>
										<td><?php echo round($total_terbayar_unit/(count($arrPeriode)*1000000000),2); ?></td>
										<td><?php echo round(($total_kontrak_unit-$total_terbayar_unit)/(count($arrPeriode)*1000000000),2); ?></td>
									</tr>
								
								<?php } ?>

								<tr>
										<td rowspan="0" colspan="2">Total Periode</td>
										<?php foreach ($arrPeriode as $k => $dt) {
											$slaVal = $settlement[$k]['status'];
											$slaColor = $arrSlaColor[$slaVal];
											echo '<td nowrap></td>';
											// echo '<td nowrap style="text-align:right">'.$settlement[$k]['status'].'</td>';
										} ?>
										<td><?php //echo $this->Global_model->uraian_settlement($key, 1); ?></td>
										<td><?php //echo $this->Global_model->uraian_settlement($key, 2); ?></td>

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
			filename: "Laporan Radir", //do not include extension
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

		window.location = "<?php echo base_url('panelbackend/mon_settlement/radir') ?>" + '/' + awal + '/' + akhir;
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