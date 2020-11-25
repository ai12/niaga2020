<div class="container">
	<form metdod="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Laporan Biaya </h1>
		</section>
		<section class="content" style="max-width:1800px">
			<div class="box box-default">

				<div class="box-body">
					<div class="alert alert-warning alert-dismissable">
						REALISASI BIAYA (d)
					</div>
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr style="background-color:#76c9ff">
								<th width="150px">
									Periode
								</th>
								<?php
								$bln = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGT', 'SEP', 'OKT', 'NOP', 'DES'];
								for ($i = 0; $i <= 11; $i++) { ?>
									<th><?php echo $bln[$i]; ?></th>
								<?php } ?>
								<th>Realisasi <br> Biaya (Rp)</th>
							</tr>

						</thead>
						<tbody>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BANKA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BELITUNG</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">TIDORE</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">KENDARI</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">ROPA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BOLOK</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr style="background-color:#76c9ff"><td width="150px" style="background-color:#5ade73">TOTAL</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
								$no++;
							}
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	'</tr>';

							?>
						</tbody>
					</table>
					<br>
					<div class="alert alert-success alert-dismissable">
						SLA Penagihan (e)
					</div>
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr style="background-color:#76c9ff">
								<th width="150px">
									Periode
								</th>
								<?php
								$bln = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGT', 'SEP', 'OKT', 'NOP', 'DES'];
								for ($i = 0; $i <= 11; $i++) { ?>
									<th><?php echo $bln[$i]; ?></th>
								<?php } ?>
								
							</tr>

						</thead>
						<tbody>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BANKA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BELITUNG</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">TIDORE</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">KENDARI</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">ROPA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BOLOK</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr style="background-color:#76c9ff"><td width="150px" style="background-color:#5ade73">TOTAL</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
						</tbody>
					</table>

					<br>
					<div class="alert alert-success alert-dismissable">
						SLA Realisasi (f)
					</div>
					<table class="table table-striped table-bordered table-hover" id="example1">
						<thead>
							<tr style="background-color:#76c9ff">
								<th width="150px">
									Periode
								</th>
								<?php
								$bln = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGT', 'SEP', 'OKT', 'NOP', 'DES'];
								for ($i = 0; $i <= 11; $i++) { ?>
									<th><?php echo $bln[$i]; ?></th>
								<?php } ?>
								
							</tr>

						</thead>
						<tbody>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BANKA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BELITUNG</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">TIDORE</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">KENDARI</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">ROPA</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BOLOK</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr style="background-color:#76c9ff"><td width="150px" style="background-color:#5ade73">TOTAL</td>';
							for ($i = 0; $i <= 11; $i++) {
								echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "%</td>";
								$no++;
							}echo	'</tr>';

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
				max-width: none !important;
			}
		</style>

	</form>
</div>