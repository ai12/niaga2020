<div class="container">
	<form metdod="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Laporan Laba </h1>
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
									Unit
								</th>
								<?php
								$bln = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGT', 'SEP', 'OKT', 'NOP', 'DES'];
								 ?>
								<th>L/R (Rp) <br> Perencanaan <br> (f = a - c )</th>
								<th>GPM (Rp) <br> (g = f / a )</th>
								<th>L/R (Rp) <br> Realisasi <br> (h)</th>
								<th>GPM (Rp) <br> (j = h/b )</th>
							</tr>

						</thead>
						<tbody>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BANKA</td>';							
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BELITUNG</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">TIDORE</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">KENDARI</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">ROPA</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr><td style="background-color:#76c9ff">BOLOK</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
							<?php
							$no = 1;
							echo 	'<tr style="background-color:#76c9ff"><td width="150px" style="background-color:#5ade73">TOTAL</td>';
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(100000, 999999)) . "</td>";
							echo	"<td style='text-align:right'>" . number_format(rand(50, 100)) . "</td>";
							echo	'</tr>';

							?>
						</tbody>
					</table>
					<br>
					
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