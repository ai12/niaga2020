<table class="table table-hover tree-table">
	<thead>
		<tr>
			<th width="60px" style="text-align: center;">No.</th>
			<th width="70px">KODE</th>
			<th style="text-align: left !important;">URAIAN BIAYA</th>
			<th width="120px" style="text-align: right !important;">ANGGARAN</th>
			<th width="1px"></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$mtposanggaranarr[''] = '';
		$total = 0;
		$no=1;
		if(count($rows)){
			foreach($rows as $r){ 
				if($r['level']>2 && !$r['id_pos_anggaran'])
					continue;
			?>
		<tr data-tt-id='<?=$r['id_rab_detail']?>' data-tt-parent-id='<?=$r['id_rab_detail_parent']?>'>
			<td align="center">
				<b><?php if($r['level']<=1){echo $no++;} ?></b>
			</td>
			<td>
				<?php if($r['id_pos_anggaran']){
					echo $r['kode_biaya'];
				}else{ ?>
					<?=$r['kode_biaya']?>
				<?php } ?>
			</td>
			<td><a href='<?=site_url("panelbackend/rab_a_detail/detail/$id_rab/$r[id_rab_detail]")?>'>
					<?=$r['uraian']?>
			</a></td>
			<td style="text-align: right;">
				<?php 
				if(!$r['id_rab_detail_parent'])
					$total+=(float)$r['nilai_satuan'];
				
				if($r['id_pos_anggaran']){ 
					?>
					<?=rupiah($jumlah=$r['nilai_satuan'],2)?>
				<?php } ?>
					</td>
			<td><?php
			$add = array();
			if($r['sumber_nilai']==1){
				$add = array('<li><a href="'.site_url("panelbackend/rab_rab_detail/add/$id_rab/$r[$pk]").'" class="waves-effect "><span class="glyphicon glyphicon-share"></span> Add Sub</a> </li>');
			}
			echo UI::showMenuMode('inlist', $r[$pk],false,'','',null,null,$add);
			?></td>
		</tr>
	<?php } ?>
	<tr><td colspan="3" style="text-align: right;"><b>JUMLAH</b></td><td style="text-align: right;"><?=rupiah($total)?></td></tr>
<?php }else{ ?>
		<tr><td colspan="6"><i>Belum ada data</i></td></tr>
	<?php } ?>
	</tbody>
</table>
<style type="text/css">
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
		    padding: 5px 10px !important;
		}
</style>

<link href="<?=base_url()?>assets/css/jquery.treetable.theme.default.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/jquery.treetable.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/jquery.treetable.js"></script>