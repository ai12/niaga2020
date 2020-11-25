<?php if($id > 0){?>
<style>
.table-borderless > tbody > tr > td,
.table-borderless > tbody > tr > th,
.table-borderless > tfoot > tr > td,
.table-borderless > tfoot > tr > th,
.table-borderless > thead > tr > td,
.table-borderless > thead > tr > th {
    border: none;
}
.table {
    border-collapse: separate;
    border-spacing:0 10px;
}
</style>
<?php
$this->load->helper('om_helper');
$detail = $this->Global_model->get_detail($id); 
$detail_customer = $this->Global_model->get_detail($detail['id_customer'],'customer','id_customer');
$detail_wo = $this->Global_model->getJenisArr('jenis_wo');
$detail_rkap = $this->Global_model->getJenisArr('jenis_rkap');
?>
<table class="table table-borderless" style="width:90%">
	<tbody>
		<tr>
			<td width="100px" style="text-align:right;font-weight:bold;">Kode WO :</td>
			<td> <?php echo $detail['kode_wo'] ?></td>
		</tr>
		<tr>
			<td width="100px" style="text-align:right;font-weight:bold;">Jenis :</td>
			<td> <?php echo $detail_wo[$detail['jenis']] ?></td>
		</tr>
		<tr>
			<td width="100px" style="text-align:right;font-weight:bold;">Jenis Rkap :</td>
			<td> <?php echo $detail_rkap[$detail['jenis_rkap']] ?></td>
		</tr>
		<tr>
			<td style="text-align:right;font-weight:bold;"> Customer :</td>
			<td> <?php echo $detail_customer['nama'] ?></td>
		</tr>
		<tr>
			<td style="text-align:right;font-weight:bold;">Deskripsi :</td>
			<td> <?php echo $detail['nama'] ?></td>
		</tr>
		<tr>
			<td style="text-align:right;font-weight:bold;">Estimasi Nilai Pekerjaan:</td>
			<td> <?php echo formatRp($detail['nilai']) ?></td>
		</tr>
	</tbody>
</table>
<br>
<?php }?>