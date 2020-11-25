<div class="container">
	<form metdod="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-widtd:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Pendapatan Per Unit </h1>
		</section>
		<section class="content" style="max-widtd:1800px">
			<div class="box box-default">

				<div class="box-body">

					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr style="background-color:#76c9ff">
								<th width="10px">
									No.
								</th>
								<th width="150px">
									Unit
								</th>
								<?php
								$bln = ['Nilai Pekerjaan', 'Proses Pemberkasan di Unit', 'Verifiaksi O&M', 'Proses Niaga', 'BAST BOD', 'Masuk Keuangan', 'Verifikasi Tagihan Pelanggan', 'Terbayar', 'Nilai dalam proses', 'Nilai Total'];
								foreach ($bln as $val) { ?>
									<th><?php echo $val; ?></th>
								<?php } ?>

							</tr>

						</thead>
						<tbody>
							<?php
							$no = 1;
							echo 	'<tr ><td  width="10px"  style="background-color:#76c9ff">A.</td><td style="background-color:#76c9ff">BANGKA</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr><td  width="10px"  style="background-color:#76c9ff">B.</td><td style="background-color:#76c9ff">BELITUNG</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr><td  width="10px"  style="background-color:#76c9ff">C.</td><td style="background-color:#76c9ff">TIDORE</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr><td  width="10px"  style="background-color:#76c9ff">D.</td><td style="background-color:#76c9ff">KENDARI</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr><td  width="10px"  style="background-color:#76c9ff">E.</td><td style="background-color:#76c9ff">ROPA</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr><td  width="10px"  style="background-color:#76c9ff">F.</td><td style="background-color:#76c9ff">BOLOK</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr style="background-color:#76c9ff"><td colspan="2" style="background-color:#76c9ff">TOTAL</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	'</tr>';
							echo 	'<tr  style="background-color:#76c9ff"><td colspan="2" style="background-color:#76c9ff">PROSENTASE</td>';
							for ($i = 0; $i <= 9; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(10, 99)) . " %</td>";
								$no++;
							}
							echo	'</tr>';
							?>
						</tbody>
					</table>

				
					

				</div>
			</div><!-- /.box -->
		</section>

		<style type="text/css">
			table.dataTable {
				clear: botd;
				margin-bottom: 6px !important;
				max-widtd: none !important;
			}
		</style>

	</form>
</div>