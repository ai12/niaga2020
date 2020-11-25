<div class="row">
	<div class="col-sm-3">
		<?php 
		$editedproyek = ($this->post['act']=='edit_proyek');

		$from = UI::createSelect('id_wilayah_proyek',$wilayaharr,$rowheader['id_wilayah_proyek'],$editedproyek,$class='form-control ',"style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_wilayah_proyek"], "id_wilayah_proyek", "Wilayah Proyek", true);
		?>
	</div>
	<div class="col-sm-3">
		<?php 
		$from = UI::createSelect('id_jenis_ttp',$ttparr,$rowheader['id_jenis_ttp'],$editedproyek,$class='form-control ',"style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_jenis_ttp"], "id_jenis_ttp", "Status Proyek", true);
		?>
	</div>
	<div class="col-sm-5">
		<?php 
		$from = UI::createSelect('id_zona_sppd',$zonaarr,$rowheader['id_zona_sppd'],$editedproyek,$class='form-control ',"style='width:auto; max-width:100%;'");
		echo UI::createFormGroup($from, $rules["id_zona_sppd"], "id_zona_sppd", "Zona SPPD", true);
		?>
	</div>
	<div class="col-sm-1">
		<?php if($editedproyek){ ?>
			<a href="javascript:void(0)" class="waves-effect" onclick="goSubmit('save_proyek')" ><span class="glyphicon glyphicon-floppy-save"></span></a>
		<?php }else{ ?>
			<a href="javascript:void(0)" class="waves-effect" onclick="goSubmit('edit_proyek')" ><span class="glyphicon glyphicon-edit"></span></a>
		<?php } ?>
	</div>
</div>
	<?php 
	$ttotal = 0;
	if($rows[0])
	foreach($rows[0] as $r){
		$is_add_ppn = $r['is_add_ppn'];
	?>
<table class="table table-bordered  table-hover">
	<tr>
		<td colspan="5"><b><a class='black' href="<?=site_url("panelbackend/niaga_komersial/detail/$id_rab/$r[id_niaga_komersial]")?>"><?=strtoupper($r['uraian'])?></a></b></td>
		<td><?=UI::showMenuMode('inlist', $r[$pk])?></td>
	</tr>
	<tr>
		<th>Uraian</th>
		<th width="100px">Jumlah</th>
		<th width="100px">Satuan</th>
		<th width="150px">Harga Satuan</th>
		<th width="150px">Total Harga</th>
		<th width="25px"></th>
	</tr>

		<?php
		#niaga komersial
		$total = 0;
		if($rows[$r['id_niaga_komersial']])
		foreach($rows[$r['id_niaga_komersial']] as $r1){ 
			$is_add_ppn = $r1['is_add_ppn'];
			if(!$r1['vol'])
				continue;

			if($is_add_ppn)
				$r1['nilai_satuan'] = (float)$r1['nilai_satuan']*1.1;
			?>
		<tr>
			<td><?=$r1['uraian']?></td>
			<td align="right">
			<?php if($r1['sumber_satuan']==2 or $r1['sumber_satuan']==3){ ?>
				<a href="<?=site_url('panelbackend/niaga_mandays_komersial/detail/'.$id_rab)?>">
			<?php } ?>
			<?=$r1['vol']?>
			<?php if($r1['sumber_satuan']==2 or $r1['sumber_satuan']==3){ ?>
				</a>
			<?php } ?>
			</td>
			<td><?=$r1['satuan']?></td>
			<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
			<td><?=UI::showMenuMode('inlist', $r1[$pk])?></td>
		</tr>
		<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } ?>

		<?php
		$tqty=0;
		#kompensasi
		if($rowskompensasi[$r['id_niaga_komersial']])
		foreach($rowskompensasi[$r['id_niaga_komersial']] as $r1){ 
			if(!$r1['mandays'])
				continue; 

			if($is_add_ppn)
				$r1['nilai'] = $r1['nilai']*1.1;

			?>
		<tr>
			<td><?=$r1['nama']?></td>
			<td align="right">
			<?php if($r['sumber_nilai']==5){ ?>
				<a href="<?=site_url('panelbackend/niaga_mandays_komersial/detail/'.$id_rab)?>">
			<?php } ?>
			<?=$r1['mandays']?>
			<?php if($r['sumber_nilai']==5){ ?>
				</a>
			<?php } ?>
			</td>
			<td>MD</td>
			<td align="right"><?=rupiah($r1['nilai'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai']*(float)$r1['mandays'])?></td>
			<td></td>
		</tr>
		<?php 
			$tqty+=$r1['mandays'];
			$total+= (float)((float)$r1['nilai']*(float)$r1['mandays']); } ?>

		<?php 
		#rab
		if($rowsrab[$r['id_niaga_komersial']])
		foreach ($rowsrab[$r['id_niaga_komersial']] as $r2) { 
			if($is_add_ppn)
				$r2['nilai_satuan'] = $r2['nilai_satuan']*1.1;

		if($r2['sumber_nilai']=='3'){ ?>
		<tr>
			<td colspan="5"><b><?=$r2['uraian']?></b></td><td></td>
		</tr>
		<?php
		#jasa material
		$jm = $jasa_materialarr[$r2['id_pos_anggaran']][$r2['jasa_material']][$r2['kode_biaya']];
		if($jm)
		foreach($jm as $r3){
			if(!$r3['vol'])
				continue;
			
			if($is_add_ppn)
				$r3['harga_satuan'] = $r3['harga_satuan']*1.1;
			
		?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['nama']?></td>
			<td align="right"><?=$r3['vol']?></td>
			<td><?=$r3['satuan']?></td>
			<td align="right"><?=rupiah($r3['harga_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r3['harga_satuan']*(float)$r3['vol'])?></td>
			<td></td>
		</tr>
		<?php $total+= (float)((float)$r3['harga_satuan']*(float)$r3['vol']); } 
		}elseif($r2['sub']){ ?>

		<tr>
			<td colspan="5"><b><?=$r2['uraian']?></b></td><td></td>
		</tr>
		<?php
		#rab sub
		$rsub = $r2['sub'];
		if($rsub)
		foreach($rsub as $r3){
			if(!$r3['vol'])
				continue;
			
			if($is_add_ppn)
				$r3['nilai_satuan'] = $r3['nilai_satuan']*1.1;
			
		?>

		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['uraian']?></td>
			<td align="right"><?=$r3['vol']?></td>
			<td><?=$r3['satuan']?></td>
			<td align="right"><?=rupiah($r3['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r3['nilai_satuan']*(float)$r3['vol'])?></td>
			<td></td>
		</tr>

		<?php $total+= (float)((float)$r3['nilai_satuan']*(float)$r3['vol']); } }else{ ?>
		<tr>
			<td><?=$r2['uraian']?></td>
			<td align="right"><?=$r2['vol']?></td>
			<td><?=$r2['satuan']?></td>
			<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
			<td></td>
		</tr>
		<?php $total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); } } ?>

		<tr>
			<td align="right"><b></b></td>
			<td align="right"><b><?=($tqty?$tqty:null)?></b></td>
			<td align="right"><b></b></td>
			<td align="right"><b>Total</b></td>
			<td align="right"><b><?=rupiah($total)?></b></td>
			<td><?php if($this->access_role['add'] && $r['sumber_nilai']==1){?><a href="<?=site_url('panelbackend/niaga_komersial/add/'.$id_rab.'/'.$r['id_niaga_komersial'])?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
		</tr>
</table>
<?php 

$ttotal += $total;
if($id_niaga_biaya_produksi_parent){
	$id_niaga_biaya_produksi = $biayaproduksi[$r['id_niaga_komersial']]['id_niaga_biaya_produksi'];
	$record = array();
	$record['id_niaga_biaya_produksi_parent'] = $id_niaga_biaya_produksi_parent;
	$record['uraian'] = $r['uraian'];
	$record['nilai'] = $total;
	$record['sumber_nilai'] = 2;
	$record['id_niaga_proyek'] = $id_niaga_proyek;
	$record['id_niaga_komersial'] = $r['id_niaga_komersial'];
	if($id_niaga_biaya_produksi){
		$this->conn->goUpdate("niaga_biaya_produksi",$record,"id_niaga_biaya_produksi = ".$this->conn->escape($id_niaga_biaya_produksi));
	}else{
		$this->conn->goInsert("niaga_biaya_produksi",$record);
	}
}
} ?>
<table class="table table-bordered  table-hover">
	<tr>
		<td colspan="4" align="right"><b>TOTAL : </b></td>
		<td width="150px" align="right"><b><?=rupiah($ttotal)?></b></td>
		<td width="25px"></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>Biaya Kontigensi ( 5/1000 ) : </b></td>
		<td align="right"><b><?=rupiah($ttotal*5/1000)?></b></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>TOTAL RAB KOMERSIAL : </b></td>
		<td align="right"><b><?=rupiah($ttotal+($ttotal*5/1000))?></b></td>
		<td></td>
	</tr>
</table>
<br/>
<div style="text-align: right;">
<?=UI::getButton("add",null,null,'btn-xs','Tambah komponen')?>
</div>

<style type="text/css">
	.table td, .table th {
    padding: 1px 5px !important;
}
</style>