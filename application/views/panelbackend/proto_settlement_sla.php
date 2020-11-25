<div class="container">
	<form metdod="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-widtd:1800px; margin-right:auto; margin-left:auto;">
			<h1>
				Monitoring SLA </h1>
		</section>
		<section class="content" style="max-widtd:1800px">
			<div class="box box-default">

				<div class="box-body">

				<table class="table table-striped table-bordered table-hover" id="example1">
								<thead>
									<tr style="background-color:#76c9ff">												
										<th  width="150px">
											Periode
										</th>
										<?php 
											$bln = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGT','SEP','OKT','NOP','DES'];
											for($i=0;$i<=11;$i++){?>
											<th><?php echo $bln[$i].'-20';?></th>
										<?php }?>
										
									</tr>
									
								</thead>
								<tbody>
									<?php 
										$no = 1;
										echo 	'<tr><td style="background-color:#76c9ff">Proyeksi Pendapatan</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(100000,999999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">HPP</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(100000,999999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">L/R (Rp)</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(1000,9999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">GPM (%)</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(10,99))."</td>";											
											$no++;
										}
										echo	'</tr>';
									?>
								</tbody>
							</table>
							
							<table class="table table-striped table-bordered table-hover" id="example1">
								
								<tbody>
									<?php 
										$no = 1;
										echo 	'<tr><td  width="150px" style="background-color:#76c9ff">Realisasi Pendapatan</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(100000,999999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">Realisasi Biaya</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(100000,999999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">L/R (Rp)</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(1000,9999))."</td>";											
											$no++;
										}
										echo	'</tr>';
										echo 	'<tr><td style="background-color:#76c9ff">GPM (%)</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(10,99))."</td>";											
											$no++;
										}
										echo	'</tr>';
									?>
								</tbody>
							</table>
							
							<table class="table table-striped table-bordered table-hover" id="example1">
								
								<tbody>
									<?php 
										$no = 1;
										echo 	'<tr style="background-color:#76c9ff"><td width="150px" style="background-color:#5ade73">SLA</td>';
										for($i=0;$i<=11;$i++){
											echo	"<td style='text-align:right'>".number_format(rand(10,99))."%</td>";											
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