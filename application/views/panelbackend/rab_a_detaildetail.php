<ol class="breadcrumb" style="margin-bottom: 0px">
  <li><a href="<?=site_url("panelbackend/rab_a_detail/index/$id_rab")?>">RAB</a></li>
  <?php
  foreach($breadcrumb as $k=>$v){
  	echo '<li><a href="'.site_url("panelbackend/rab_a_detail/detail/$id_rab/$k").'">'.$v.'</a></li>';
  }
  ?>
  <li><?=$row['uraian']?></li>
</ol>
<div style="clear: both;"></div>
<?php if(count($rows) && $row['sumber_nilai']==1){ 
$id_rab_detail_parent = $r['id_rab_detail_parent'];
$rowparent[$row['id_rab_detail']] = $row;
	?>
	<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width="10px">No.</th>
			<?php if($is_kode_biaya){ ?>
				<th width="10px">KODE BIAYA</th>
			<?php } ?>
			<th>URAIAN BIAYA</th>
			<?php if($is_satuan){ ?>
				<th width="80px">VOLUME</th>
				<th width="120px">SATUAN</th>
				<th width="150px">HARGA SATUAN</th>
			<?php } ?>
			<th width="200px">JUMLAH</th>
			<th width="1px"></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$mtposanggaranarr[''] = '';
		if(count($rows)){
			$no=1;
			foreach($rows as $r){ 
				?>
		<tr>

			<?php if($r[$pk]==$this->post['key'] && $this->post['act']=='edit'){ ?>

				<?php if(($is_kode_biaya && $r['kode_biaya']) or !$is_kode_biaya){ ?>
				<td align="center"><?=$no++?></td>
				<?php } else { ?>
				<td align="center"></td>
				<?php } ?>
				<?php if($is_kode_biaya){ ?>
					<td><?=$r['kode_biaya']?></td>
				<?php } ?>
				<td><input style="width:100%" type="text" name="uraian" value="<?=str_replace(array("<b>","</b>"),"",$r['uraian'])?>"/></td>
				<?php if($is_satuan){ 
					if(!$r['day'])$r['day']=1;
					?>
					<td style="text-align: center;">
						<input style="width:100%; text-align: right;" type="number" name="vol" value="<?=(float)$r['vol']?>"/>
					</td>
					<td style="text-align: center;">
						<input style="width:100%" type="text" name="satuan" value="<?=str_replace(array("<b>","</b>"),"",$r['satuan'])?>"/>
					</td>
				<?php }  if($is_satuan){ ?>
				<td style="text-align: right;">
					<input style="width:100%; text-align: right;" type="number" name="nilai_satuan" value="<?=(float)$r['nilai_satuan']?>"/>
				</td>
				<?php } ?>
				<td style="text-align: right;"><?=rupiah($jumlah=caljumlah($r),2)?></td>
				<td width="1px"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$r[$pk]?>)"><span class="glyphicon glyphicon-floppy-save"></span></a><a href=""><span class="glyphicon glyphicon-refresh"></span></a></td>

			<?php }else{ ?>

				<?php if(($is_kode_biaya && $r['kode_biaya']) or !$is_kode_biaya){ ?>
				<td align="center"><?=$no++?></td>
				<?php } else { ?>
				<td align="center"></td>
				<?php } ?>
				<?php if($is_kode_biaya){ ?>
					<td><?=$r['kode_biaya']?></td>
				<?php } ?>
				<td><a href='<?=site_url("panelbackend/rab_a_detail/detail/$id_rab/$r[id_rab_detail]")?>'><?=$r['uraian']?></a></td>
				<?php if($is_satuan){ 
					if(!$r['day'])$r['day']=1;
					?>
					<td style="text-align: center;"><?=((float)$r['vol']*(float)$r['day'])?(float)$r['vol']*(float)$r['day']:''?></td>
					<td style="text-align: center;"><?=$r['satuan']?></td>
				<?php }  if($is_satuan){ ?>
				<td style="text-align: right;"><?=rupiah($r['nilai_satuan'],2)?></td>
				<?php } ?>
				<td style="text-align: right;"><?=rupiah($jumlah=caljumlah($r),2)?></td>
				<td width="1px"><?php
				$add = array();
				if($r['sumber_nilai']==1){
					$add = array('<li><a href="'.site_url("panelbackend/rab_rab_detail/add/$id_rab/$r[$pk]").'" class="waves-effect "><span class="glyphicon glyphicon-share"></span> Add Sub</a> </li>');
				}if($r['sumber_nilai']==4){
					$add = array(
						" <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r[$pk])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ",
						" <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r[$pk])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> "
					);
				}
				echo UI::showMenuMode('inlist', $r[$pk]."/".$r['id_rab_detail_parent'],false,'','',null,null,$add);
				?></td>
			<?php } ?>
		</tr>

	<?php }?>
	<?php }else{ ?>
		<tr><td colspan="4"><i>Belum ada data</i></td></tr>
	<?php } if(!$this->post['act']){ ?>
	<tr>
		<?php if($is_satuan){ ?>
			<td colspan="5" align="center"><b>TOTAL</b></td>
		<?php }else{ ?>
			<td colspan="3" align="center"><b>TOTAL</b></td>
		<?php } ?>
		<td align="right"><b><?=rupiah(caljumlah($row))?></b></td>
		<td><a href="javascript:void(0)" onclick="goSubmitValue('add',<?=$row[$pk]?>)"><span class="glyphicon glyphicon-plus"></span></a></td>
	</tr>

	<?php } if($this->post['act']=='add'){ ?>
	<tr>
		<?php if(($is_kode_biaya && $r['kode_biaya']) or !$is_kode_biaya){ ?>
		<td align="center"><?=$no++?></td>
		<?php } else { ?>
		<td align="center"></td>
		<?php } ?>
		<?php if($is_kode_biaya){ ?>
			<td><?=$r['kode_biaya']?></td>
		<?php } ?>
		<td><input style="width:100%" type="text" name="uraian"/></td>
		<?php if($is_satuan){ 
			if(!$r['day'])$r['day']=1;
			?>
			<td style="text-align: center;">
				<input style="width:100%; text-align: right;" type="number" name="vol"/>
			</td>
			<td style="text-align: center;">
				<input style="width:100%" type="text" name="satuan"/>
			</td>
		<?php }  if($is_satuan){ ?>
		<td style="text-align: right;">
			<input style="width:100%; text-align: right;" type="number" name="nilai_satuan"/>
		</td>
		<?php } ?>
		<td style="text-align: right;"></td>
		<td width="1px"><a href="javascript::void(0)" onclick="goSubmitValue('save_add')"><span class="glyphicon glyphicon-floppy-save"></span></a><a href=""><span class="glyphicon glyphicon-refresh"></span></a></td>
	</tr>
	<?php } ?>
	</tbody>
</table>

<?php }elseif ($row['sumber_nilai']=='3') { ?>

	<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width="10px">No.</th>
			<th>JASA/MATERIAL</th>
			<th>VOLUME</th>
			<th>SATUAN</th>
			<th>HARGA SATUAN</th>
			<th>JUMLAH</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no=1;
		if(count($rowsjasa_material)){
			foreach($rowsjasa_material as $r){ 
				?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td><?=$r['nama']?></td>
			<td style="text-align: right;"><?=$r['vol']?></td>
			<td><?=$r['satuan']?></td>
			<td style="text-align: right;"><?=rupiah($r['harga_satuan'],2)?></td>
			<td style="text-align: right;"><?=rupiah($jumlah=$r['total'],2)?></td>
		</tr>

	<?php }?>
	<?php }else{ ?>
		<tr><td colspan="6"><i>Belum ada data, silahkan tambahkan di jasa material</i></td></tr>
	<?php } ?>
	<tr>
		<td colspan="5" align="center"><b>TOTAL</b></td>
		<td align="right"><b><?=rupiah(caljumlah($row))?></b></td>
	</tr>
	</tbody>
</table>
<?php } ?>
<style type="text/css">
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
		    padding: 5px !important;
		}
	.pfile{
		display: inline !important;  
	}
</style>