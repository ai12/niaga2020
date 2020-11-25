<dvi class="pull-left">
<?php 
echo UI::createUploadMultiple("penawaran__".$id_proyek_pekerjaan, $row['penawaran__'.$id_proyek_pekerjaan], $page_ctrl, $this->access_role['edit'], "file");
?>
<br/>
<br/>
</dvi>
<div class="pull-right">
	<br/>
<?php if(!$rows){ ?>
	<button type="button" class="btn btn-primary btn-xs" onclick="goSubmit('generate_penawaran')">Generate Penawaran</button>
<?php }else{ ?>
	<a class="btn btn-primary btn-sm" target="_BLANK" href="<?=site_url("panelbackend/niaga_penawaran/go_print/$id_rab")?>"><span class="glyphicon glyphicon-print"></span> Print</a>
	<a class="btn btn-primary btn-sm" target="_BLANK" href="<?=site_url("panelbackend/niaga_penawaran/go_print/$id_rab/1")?>"><span class="glyphicon glyphicon-print"></span> Print Detail</a>
<?php } ?>
</div>

	<?php if($rows){
	$ttotal = 0;
	if($rows[0])
	foreach($rows[0] as $r){
		$id_parent = $r['id_niaga_penawaran'];
		$is_add_ppn = $r['is_add_ppn'];
		$addjustment = $r['addjustment'];
		$pembulatan = $r['pembulatan'];
	?>
<table class="table table-bordered  table-hover">
	<tr>
		<th style="text-align: left;"><?=strtoupper($r['uraian'])?></th>
		<th width="100px">Jumlah</th>
		<th width="100px">Satuan</th>
		<th width="150px">Harga Satuan</th>
		<th width="150px">Total Harga</th>
		<th width="10px">Addjustment</th>
		<th width="25px"><?=UI::showMenuMode('inlist', $r[$pk])?></th>
	</tr>


		<?php
		$total = 0;
		$tqty = 0;
		#salary
		if($rowssalary[$r['id_niaga_penawaran']])
		foreach($rowssalary[$r['id_niaga_penawaran']] as $r1){ 
			if(!$r1['mandays'])
				continue; 

			if($is_add_ppn)
				$r1['nilai'] = $r1['nilai']*1.1;

			$r1['addjustment'] = $addjustment;
			if($r1['addjustment'])
				$r1['nilai'] = $r1['nilai']+((float)$r1['nilai']*$r1['addjustment']/100);

			$r1['pembulatan'] = $pembulatan;
			if($r1['pembulatan'])
				$r1['nilai'] = bulat($r1['nilai'], $r1['pembulatan']);

			$tqty+=$r1['mandays'];
			?>
		<tr>
			<td><?=$r1['nama']?></td>
			<td align="right">
			<?=$r1['mandays']?>
			</td>
			<td>MD</td>
			<td align="right"><?=rupiah($r1['nilai'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai']*(float)$r1['mandays'])?></td>
			<td align="center"><?=($r1['addjustment']?$r1['addjustment'].'%':'')?></td>
			<td></td>
		</tr>
		<?php $total+= (float)((float)$r1['nilai']*(float)$r1['mandays']); } ?>

		<?php
		#niaga penawaran
		if($rows[$r['id_niaga_penawaran']])
		foreach($rows[$r['id_niaga_penawaran']] as $r1){ 
			$is_add_ppn = $r1['is_add_ppn'];
			$addjustment = $r1['addjustment'];
			$pembulatan = $r1['pembulatan'];
			if(!$r1['vol'])
				continue;

			if($is_add_ppn)
				$r1['nilai_satuan'] = (float)$r1['nilai_satuan']*1.1;

			if($r1['addjustment'])
				$r1['nilai_satuan'] = $r1['nilai_satuan']+((float)$r1['nilai_satuan']*$r1['addjustment']/100);

			if($r1['pembulatan'])
				$r1['nilai_satuan'] = bulat($r1['nilai_satuan'], $r1['pembulatan']);

			if($tqty)
				$tqty+=$r1['vol'];
			?>
		<tr>
			<td><?=$r1['uraian']?></td>
			<td align="right">
				<?=$r1['vol']?>
			</td>
			<td><?=$r1['satuan']?></td>
			<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
			<td align="center"><?=($r1['addjustment']?$r1['addjustment'].'%':'')?></td>
			<td><?=UI::showMenuMode('inlist', $r1[$pk])?></td>
		</tr>
		<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } ?>

		<?php 
		#rab
		if($rowsrab[$r['id_niaga_penawaran']])
		foreach ($rowsrab[$r['id_niaga_penawaran']] as $r2) { 
			if($is_add_ppn)
				$r2['nilai_satuan'] = $r2['nilai_satuan']*1.1;

			$r2['addjustment'] = (float)$addjustment;
			$r2['pembulatan'] = (float)$pembulatan;
			if($r2['addjustment'])
				$r2['nilai_satuan'] = (float)$r2['nilai_satuan']+((float)$r2['nilai_satuan']*$r2['addjustment']/100);

			if($r2['pembulatan'])
				$r2['nilai_satuan'] = bulat($r2['nilai_satuan'], $r2['pembulatan']);

		if($r2['sumber_nilai']=='3'){ ?>
		<tr>
			<td colspan="6"><b><?=$r2['uraian']?></b></td><td></td>
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

			$r3['addjustment'] = $addjustment;
			$r3['pembulatan'] = $pembulatan;
			if($r3['addjustment'])
				$r3['harga_satuan'] = $r3['harga_satuan']+((float)$r3['harga_satuan']*$r3['addjustment']/100);

			if($r3['pembulatan'])
				$r3['harga_satuan'] = bulat($r3['harga_satuan'], $r3['pembulatan']);
			
		?>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['nama']?></td>
			<td align="right"><?=$r3['vol']?></td>
			<td><?=$r3['satuan']?></td>
			<td align="right"><?=rupiah($r3['harga_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r3['harga_satuan']*(float)$r3['vol'])?></td>
			<td align="center"><?=($r3['addjustment']?$r3['addjustment'].'%':'')?></td>
			<td></td>
		</tr>
		<?php $total+= (float)((float)$r3['harga_satuan']*(float)$r3['vol']); } 
		}elseif($r2['sub']){ ?>

		<tr>
			<td colspan="6"><b><?=$r2['uraian']?></b></td><td></td>
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

			$r3['addjustment'] = $addjustment;
			$r3['pembulatan'] = $pembulatan;
			if($r3['addjustment'])
				$r3['nilai_satuan'] = $r3['nilai_satuan']+((float)$r3['nilai_satuan']*$r3['addjustment']/100);

			if($r3['pembulatan'])
				$r3['nilai_satuan'] = bulat($r3['nilai_satuan'], $r3['nilai_satuan']);
		?>

		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['uraian']?></td>
			<td align="right"><?=$r3['vol']?></td>
			<td><?=$r3['satuan']?></td>
			<td align="right"><?=rupiah($r3['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r3['nilai_satuan']*(float)$r3['vol'])?></td>
			<td align="center"><?=($r3['addjustment']?$r3['addjustment'].'%':'')?></td>
			<td></td>
		</tr>

		<?php $total+= (float)((float)$r3['nilai_satuan']*(float)$r3['vol']); } }else{ ?>
		<tr>
			<td><?=$r2['uraian']?></td>
			<td align="right"><?=$r2['vol']?></td>
			<td><?=$r2['satuan']?></td>
			<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
			<td align="center"><?=($r2['addjustment']?$r2['addjustment'].'%':'')?></td>
			<td></td>
		</tr>
		<?php $total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); } } 
		if($this->post['act']=='add' && $id_parent==$this->post['key']){ 
		?>
			<tr>
				<td><input style="width:100%" type="text" name="uraian"/></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol"/></td>
				<td><input style="width:100%" type="text" name="satuan"/></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai_satuan"/></td>
				<td></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment"/></td>
				<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td ></td>
				<td align="right"><b><?=($tqty?$tqty:null)?></b></td>
				<td ></td>
				<td align="right"><b>Total</b></td>
				<td align="right"><b><?=rupiah($total)?></b></td>
				<td align="right"></td>
				<td><?php if($this->access_role['add']){?><a href="javascript:void(0)" onclick="goSubmitValue('add',<?=$id_parent?>)"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
			</tr>
		<?php } ?>
</table>
<?php 

$ttotal += $total;
} ?>
<table class="table table-bordered  table-hover">
	<tr>
		<td colspan="4" align="right"><b>TOTAL : </b></td>
		<td width="150px" align="right"><b><?=rupiah($ttotal)?></b></td>
		<td width="109px"></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>PPN 10% : </b></td>
		<td align="right"><b><?=rupiah($ttotal*10/100)?></b></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>TOTAL RAB KOMERSIAL : </b></td>
		<td align="right"><b><?=rupiah($toootaall = $ttotal+($ttotal*10/100))?></b></td>
		<td></td>
	</tr>
</table>


<hr/>
<b>ANALISA KELAYAKAN HARGA</b>

<?php 
	$t_hpp = $hpp;
	$t_penawaran_ppn = $toootaall;

	if($analisa[2])
	foreach($analisa[2] as $r){
	$no=1; 

	$t_ppn = 0;
	if($r['ppn'])
		$t_ppn = ($t_penawaran_ppn/1.1)*10/100;

	$t_penawaran_pph = $t_penawaran_ppn - $t_ppn;

	$t_pph = 0;
	if($r['pph'])
		$t_pph = $t_penawaran_pph*$r['pph']/100;

	$t_penawaran = $t_penawaran_pph - $t_pph;
	$t_labakotor = $t_penawaran - $t_hpp;

/*	$p_labakotor = $r['profit_margin'];
	if($bebanusaha[$r['id_analisa']])
		foreach($bebanusaha[$r['id_analisa']] as $r1){ 
			$p_labakotor += $r1['nilai'];
	}

	$p_hpp = 100-$p_labakotor;
	$t_penawaran = $t_hpp/($p_hpp/100);
	$t_labakotor = $t_penawaran*($p_labakotor/100);

	$ppn = 0;
	if($r['pph'])
		$t_pph = $t_penawaran*$r['pph']/100;

	$t_penawaran_pph = $t_penawaran+$t_pph;

	if($r['ppn'])
		$t_ppn = $t_penawaran_pph*$r['ppn']/100;

	$t_penawaran_ppn = $t_penawaran_pph+$t_ppn;*/
	$gpm = 0;
?>
<table class="table table-bordered table-hover">
	<tr>
		<th width="40px">NO</th>
		<th>KOMPONEN ANALISA</th>
		<th width="100px">% PH</th>
		<th colspan="2">JUMLAH</th>
	</tr>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Nilai Minimal Kontrak</td>
		<td align="center"></td>
		<td align="right" colspan="2"><b><?=rupiah($t_penawaran_ppn)?></b></td>
	</tr>
	<?php if($r['ppn']){ ?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td>PPN</td>
			<td align="center"><?=$r['ppn']?>%</td>
			<td align="right" colspan="2"><?=rupiah($t_ppn)?></td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>Nilai Minimal Kontrak dikurangi PPN</td>
			<td align="center"></td>
			<td align="right" colspan="2" style="border-top: 2px solid #333;"><?=rupiah($t_penawaran_pph)?></td>
		</tr>
	<?php } ?>
	<?php if($r['pph']){ $gpm+= $r['pph']; ?>
		<?php if($this->post['act']=='edit_pph' && $r['id_analisa']==$this->post['key']){ ?>
			<tr>
				<td align="center"><?=$no++?></td>
				<td>PPH</td>
				<td align="center"><input style="width:100%; text-align: center;" type="number" name="pph" value="<?=$r['pph']?>" /></td>
				<td width="10px" style="padding-top: 5px !important;"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_pph', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				<td align="right"><?=rupiah($t_pph)?></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td align="center"><?=$no++?></td>
				<td>PPH</td>
				<td align="center"><?=$r['pph']?>%</td>
				<td width="10px"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('edit_pph', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-edit"></span></a></td>
				<td align="right" colspan="2"><?=rupiah($t_pph)?></td>
			</tr>
		<?php } ?>
		<tr>
			<td align="center"></td>
			<td>Cash in</td>
			<td align="center"></td>
			<td align="right" colspan="2" style="border-top: 2px solid #333;"><?=rupiah($t_penawaran)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Beban Operasi</td>
		<td align="center"></td>
		<td align="right" colspan="2"><?=rupiah($t_hpp,2)?></td>
	</tr>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Laba Kotor</td>
		<td align="center"></td>
		<td align="right" colspan="2"><?=rupiah($t_labakotor,2)?></td>
	</tr>
	<?php $t_bebanusaha = 0;
	if($bebanusaha[$r['id_analisa']]){ ?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td>Beban Usaha</td>
			<td align="center"></td>
			<td align="right" colspan="2"></td>
		</tr>
		<?php 
		$t_bebanusaha = 0;
		$no1=1; foreach($bebanusaha[$r['id_analisa']] as $r1){ 
			$gpm+= $r1['nilai'];
			$menuarr = array();
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit_beban_usaha', $r1[id_beban_usaha])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete_beban_usaha', $r1[id_beban_usaha])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";

			if($this->post['act']=='edit_beban_usaha' && $this->post['key']==$r1['id_beban_usaha']){ ?>
			<tr>
				<td></td>
				<td><span style="display: inline;"><?=$no-1?>.<?=$no1++?></span> <input style="width:95%; display: inline;" value="<?=$r1['nama']?>" type="text" name="nama" /></td>
				<td align="center"><input style="width:100%; text-align: center;" value="<?=(float)$r1['nilai']?>" type="number" name="nilai" /></td>
				<td align="right"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_edit_beban_usaha', <?=$r1['id_beban_usaha']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				<td align="right"><?=rupiah($t_beban = $t_penawaran*$r1['nilai']/100)?></td>
			</tr>
		<?php }else{ ?>
			<tr>
				<td></td>
				<td><?=$no-1?>.<?=$no1++?> <?=$r1['nama']?></td>
				<td align="center"><?=(float)$r1['nilai']?>%</td>
				<td align="right"><?=UI::showMenu($menuarr)?></td>
				<td align="right"><?=rupiah($t_beban = $t_penawaran*$r1['nilai']/100)?></td>
			</tr>
		<?php } $t_bebanusaha += $t_beban; } ?>
		<?php if($this->post['act']=='add_beban_usaha' && $this->post['key']==$r['id_analisa']){ ?>
		<tr>
			<td></td>
			<td><span style="display: inline;"><?=$no-1?>.<?=$no1++?></span> <input style="width:95%; display: inline;" type="text" name="nama" /></td>
			<td align="center"><input style="width:100%; text-align: center;" type="number" name="nilai" /></td>
			<td align="right"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_add_beban_usaha', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"></td>
		</tr>
		<tr>
			<td></td>
			<td><b>Total Beban Usaha</b></td>
			<td align="center"></td>
			<td align="right" width="10px"></td>
			<td align="right" width="176px" style="border-top: 2px solid #333;"><?=rupiah($t_bebanusaha)?></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td></td>
			<td><b>Total Beban Usaha</b></td>
			<td align="center"></td>
			<td align="right" width="10px"><a href="javascript:void(0)" onclick="goSubmitValue('add_beban_usaha',<?=$r['id_analisa']?>)"><span class="glyphicon glyphicon-plus"></span></a></td>
			<td align="right" width="176px" style="border-top: 2px solid #333;"><?=rupiah($t_bebanusaha)?></td>
		</tr>
	<?php } } ?>
	<tr>
		<td align="center"><?=$no++?></td>
		<td><b>LABA BERSIH</b></td>
		<td align="center"></td>
		<td align="right" colspan="2"><b><?=rupiah($t_lababersih = $t_labakotor-$t_bebanusaha)?></b></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td style="font-size: 18px" align="center"><b>NPM</b></td>
		<td align="right" colspan="2" style="color: green; font-size: 18px"><b><?=round($p_profit = $t_lababersih/$t_penawaran_pph*100,2)?>%</b></td>
	</tr>
	<tr>
		<td colspan="2"></td>
		<td style="font-size: 18px" align="center"><b>GPM</b></td>
		<td align="right" colspan="2" style="color: red; font-size: 18px"><b><?=round($gpm+$p_profit,2)?>%</b></td>
	</tr>
</table>
<?php } ?>
<?php } ?>


<style type="text/css">
	.table td, .table th {
    padding: 1px 5px !important;
}
</style>