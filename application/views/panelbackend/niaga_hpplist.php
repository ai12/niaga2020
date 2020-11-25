<table class="table table-bordered  table-hover">
	<tr>
		<th width="40px">A</th>
		<th style="text-align:left !important">RAB EVALUASI</th>
		<th width="200px">JUMLAH</th>
	</tr>
	<?php
	$id_parent = $header['RAB EVALUASI']['id_niaga_biaya_produksi'];
	$no=1;
	$total = 0;
	if($isi[$id_parent]['2'])
	foreach($isi[$id_parent]['2'] as $r){ ?>
	<tr>
		<td align="center"><?=$no++?></td>
		<td><?=$r['uraian']?></td>
		<td align="right"><?=rupiah($r['nilai'])?></td>
	</tr>
	<?php $total += (float)$r['nilai'];
	} 
	$ttotal = 0;
	if($isi[$id_parent]['4']){ ?>
	<tr>
		<td colspan="2" align="right">Total : </td>
		<td align="right"><?=rupiah($total)?></td>
	</tr>
	<?php 
	foreach($isi[$id_parent]['4'] as $r){ ?>
	<tr>
		<td colspan="2" align="right"><?=$r['uraian']?> (<?=(float)$r['nilai']?>) : </td>
		<td align="right"><?=rupiah($r['nilai']*$total)?></td>
	</tr>
	<?php $ttotal += $r['nilai']*$total;}} ?>
	<tr>
		<td colspan="2" align="right"><b>TOTAL RAB EVALUASI : </b></td>
		<td align="right"><?=rupiah($total_rab_evaluasi = $total+$ttotal)?></td>
	</tr>
</table>
<table class="table table-bordered  table-hover">
	<tr>
		<th width="40px">B</th>
		<th style="text-align:left !important">OTHER COST</th>
		<th>KETERANGAN</th>
		<th width="76px">%</th>
		<th width="100px">% STD</th>
		<th colspan="2">JUMLAH</th>
	</tr>
	<?php
	$id_parent = $header['OTHER COST']['id_niaga_biaya_produksi'];
	$no=1;
	$total = 0;
	if($isi[$id_parent]['1'])
	foreach($isi[$id_parent]['1'] as $r){ 
		$id_parent = $r['id_niaga_biaya_produksi'];
	?>


		<tr>
			<td><b><?=$no++?></b></td>
			<td><b><?=$r['uraian']?></b></td>
			<td colspan="5"></td>
		</tr>

		<?php
		$noa = 'a';
		if($isi[$id_parent]['5'])
		foreach($isi[$id_parent]['5'] as $r){ 
			$menuarr = array();
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";
		?>

			<?php if($r['id_niaga_biaya_produksi']==$this->post['key'] && $this->post['act']=='edit'){ ?>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;<?=$noa++?></td>
					<td><input style="width:100%" type="text" name="uraian" value="<?=$r['uraian']?>"/></td>
					<td><input style="width:100%" type="text" name="keterangan" value="<?=$r['keterangan']?>"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai" value="<?=(float)$r['nilai']?>"/></td>
					<td align="center"><input style="width:100%; text-align: center;" type="text" name="std" value="<?=$r['std']?>"/></td>
					<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$r['id_niaga_biaya_produksi']?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
					<td align="right"><?=rupiah((float)$r['nilai']/100*(float)$total_rab_evaluasi)?></td>
				</tr>
			<?php }else{ ?>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;<?=$noa++?></td>
					<td><?=$r['uraian']?></td>
					<td><?=$r['keterangan']?></td>
					<td align="right"><?=$r['nilai']?>%</td>
					<td align="center"><?=$r['std']?></td>
					<td align="right"><?=UI::showMenu($menuarr)?></td>
					<td align="right"><?=rupiah((float)$r['nilai']/100*(float)$total_rab_evaluasi)?></td>
				</tr>
			<?php } ?>


			<?php $total += (float)$r['nilai']/100*(float)$total_rab_evaluasi;
		}
		if($this->post['act']=='add' && $id_parent==$this->post['key']){ 
		?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$noa++?></td>
			<td><input style="width:100%" type="text" name="uraian"/></td>
			<td><input style="width:100%" type="text" name="keterangan"/></td>
			<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai"/></td>
			<td align="center"><input style="width:100%; text-align: center;" type="text" name="std"/></td>
			<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td colspan="5"></td>
			<td width="10px"><a href="javascript:void(0)" onclick="goSubmitValue('add',<?=$id_parent?>)"><span class="glyphicon glyphicon-plus"></span></a></td>
			<td  width="176px"></td>
		</tr>
		<?php
		}
	} 
	$ttotal = 0;
	if($isi[$id_parent]['4']){ ?>
	<tr>
		<td colspan="6" align="right">Total : </td>
		<td align="right"><?=rupiah($total)?></td>
	</tr>
	<?php 
	foreach($isi[$id_parent]['4'] as $r){ ?>
	<tr>
		<td colspan="6" align="right"><?=$r['uraian']?> (<?=(float)$r['nilai']?>) : </td>
		<td align="right"><?=rupiah($r['nilai']*$total)?></td>
	</tr>
	<?php $ttotal += $r['nilai']*$total;} } ?>
	<tr>
		<td colspan="5" align="right"><b>TOTAL OTHER COST : </b></td>
		<td align="right" colspan="2"><?=rupiah($total_other = $total+$ttotal)?></td>
	</tr>
</table>
<table class="table table-bordered  table-hover">
	<tr>
		<th width="40px">C</th>
		<th  style="text-align:left !important">SALARY PERSONIL PJBS</th>
		<th width="100px">JUMLAH</th>
		<th width="100px">SATUAN</th>
		<th width="200px">HARGA SATUAN</th>
		<th colspan="2">JUMLAH</th>
	</tr>
	<?php
	$id_parent = $header['SALARY PERSONIL PJBS']['id_niaga_biaya_produksi'];
	$no=1;
	$total = 0;
	if($isi[$id_parent]['3'])
	foreach($isi[$id_parent]['3'] as $r){ 
	$menuarr = array();
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";
	?>
	<?php if($r['id_niaga_biaya_produksi']==$this->post['key'] && $this->post['act']=='edit'){ ?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$no++?></td>
			<td><input style="width:100%" type="text" name="uraian" value="<?=$r['uraian']?>"/></td>
			<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol" value="<?=(float)$r['vol']?>"/></td>
			<td><input style="width:100%" type="text" name="satuan" value="<?=$r['satuan']?>"/></td>
			<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai" value="<?=(float)$r['nilai']?>"/></td>
			<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$r['id_niaga_biaya_produksi']?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"><?=rupiah((float)$r['nilai']*(float)$r['vol'])?></td>
		</tr>
	<?php }else{ ?>
	<tr>
		<td  align="center"><?=$no++?></td>
		<td><?=$r['uraian']?></td>
		<td align="right"><?=$r['vol']?></td>
		<td align="center"><?=$r['satuan']?></td>
		<td align="right"><?=rupiah($r['nilai'])?></td>
		<td align="right" width="1px"><?=UI::showMenu($menuarr)?></td>
		<td align="right" width="175px"><?=rupiah((float)$r['nilai']*(float)$r['vol'])?></td>
	</tr>
	<?php } $total += (float)$r['nilai']*(float)$r['vol'];
	} 

	if($isi[$id_parent]['5'])
	foreach($isi[$id_parent]['5'] as $r){ 
	$menuarr = array();
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r[id_niaga_biaya_produksi])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";
	?>
	<?php if($r['id_niaga_biaya_produksi']==$this->post['key'] && $this->post['act']=='edit'){ ?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$no++?></td>
			<td><input style="width:100%" type="text" name="uraian" value="<?=$r['uraian']?>"/></td>
			<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol" value="<?=(float)$r['vol']?>"/></td>
			<td><input style="width:100%" type="text" name="satuan" value="<?=$r['satuan']?>"/></td>
			<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai" value="<?=(float)$r['nilai']?>"/></td>
			<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$r['id_niaga_biaya_produksi']?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"><?=rupiah((float)$r['nilai']*(float)$r['vol'])?></td>
		</tr>
	<?php }else{ ?>
	<tr>
		<td  align="center"><?=$no++?></td>
		<td><?=$r['uraian']?></td>
		<td align="right"><?=$r['vol']?></td>
		<td align="center"><?=$r['satuan']?></td>
		<td align="right"><?=rupiah($r['nilai'])?></td>
		<td align="right" width="1px"><?=UI::showMenu($menuarr)?></td>
		<td align="right" width="175px"><?=rupiah((float)$r['nilai']*(float)$r['vol'])?></td>
	</tr>
	<?php } $total += (float)$r['nilai']*(float)$r['vol'];
	} 

	if($this->post['act']=='add' && $id_parent==$this->post['key']){ 
	?>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;<?=$no++?></td>
		<td><input style="width:100%" type="text" name="uraian"/></td>
		<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol"/></td>
		<td><input style="width:100%" type="text" name="satuan"/></td>
		<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai"/></td>
		<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
		<td align="right"></td>
	</tr>
	<?php }else{ ?>
	<tr>
		<td colspan="5" align="right"><b>TOTAL SALARY PERSONIL PJBS : </b></td>
		<td align="right" width="1px"><a href="javascript:void(0)" onclick="goSubmitValue('add',<?=$id_parent?>)"><span class="glyphicon glyphicon-plus"></span></a></td>
		<td align="right"><?=rupiah($total_personil = $total+$ttotal)?></td>
	</tr>
	<?php } ?>
</table>
<table class="table table-bordered  table-hover">
	<tr>
		<th width="40px"></th>
		<th colspan="2" style="text-align:left !important">TOTAL BIAYA PRODUKSI</th>
	</tr>
	<tr>
		<td width="40px" align="center">A</td>
		<td>RAB EVALUASI</td>
		<td align="right" width="200px"><?=rupiah($total_rab_evaluasi)?></td>
	</tr>
	<tr>
		<td width="40px" align="center">B</td>
		<td>OTHER COST</td>
		<td align="right"><?=rupiah($total_other)?></td>
	</tr>
	<tr>
		<td width="40px" align="center">C</td>
		<td>SALARY PERSONIL</td>
		<td align="right"><?=rupiah($total_personil)?></td>
	</tr>
	<tr>
		<td align="right" colspan="2"><b>TOTAL CASH OUT :</b></td>
		<td align="right"><?=rupiah($t_hpp=$total_rab_evaluasi+$total_other+$total_personil)?></td>
		<?php
		$this->conn->goUpdate("niaga_proyek",array("hpp"=>$t_hpp),"id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek));
		?>
	</tr>
</table>
<style type="text/css">
	.table td, .table th {
    padding: 1px 5px !important;
}
</style>

<script type="text/javascript">
	<?php if($this->post['act']=='add' or $this->post['act']=='edit'){ ?>
$(document).keyup(function(e) {    
    if (e.keyCode == 27) {
        window.history.back();
    }
});
	<?php } ?>
</script>