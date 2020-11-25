<dvi class="pull-left">
<?php 
echo UI::createUploadMultiple("penawaran__".$id_proyek_pekerjaan, $row['penawaran__'.$id_proyek_pekerjaan], $page_ctrl, $this->access_role['edit'], "file");
?>
<br/>
<br/>
</dvi>
<div class="pull-right">
	<br/>
	<button type="button" onclick="goSubmit('set_recal')" class="btn btn-sm">Refresh</button>
	<a class="btn btn-primary btn-sm" target="_BLANK" href="<?=site_url("panelbackend/rab_penawaran/go_print/$id_rab")?>"><span class="glyphicon glyphicon-print"></span> Print</a>
	<a class="btn btn-primary btn-sm" target="_BLANK" href="<?=site_url("panelbackend/rab_penawaran/go_print/$id_rab/1")?>"><span class="glyphicon glyphicon-print"></span> Print Detail</a>
</div>

	<?php if($rows){
	$noa = 'A';
	$ttotal = 0;
	if($rows[0])
	foreach($rows[0] as $r){
		$total = 0;
		$tqty = 0;
		$id_parent = $r['id_rab_penawaran'];
		$no1 = 1;
	?>
<table class="table table-bordered  table-hover">
	<tr>
		<th width="30px" align='center'><?=$noa++?></th>
		<th colspan="2" style="text-align: left;"><?=strtoupper($r['uraian'])?></th>
		<th width="100px">Jumlah</th>
		<th width="100px">Satuan</th>
		<th width="150px">Harga Satuan</th>
		<th width="150px">Total Harga</th>
		<th width="10px">Addjustment</th>
		<th width="25px"><?=UI::showMenuMode('inlist', $r[$pk])?></th>
	</tr>

		<?php
		#niaga penawaran
		if($rows[$r['id_rab_penawaran']])
		foreach($rows[$r['id_rab_penawaran']] as $r1){ 
			$rasli = $r1;
			$id_parent1 = $r1['id_rab_penawaran'];

			$menuarr = array();
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r1[$pk])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
			$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r1[$pk])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";

			$no2 = 1;

			if(!$r1['is_add_ppn'])
				$r1['is_add_ppn'] = $r['is_add_ppn'];

			if(!strlen($r1['addjustment']))
				$r1['addjustment'] = $r['addjustment'];

			if(!strlen($r1['pembulatan']))
				$r1['pembulatan'] = $r['pembulatan'];

			if($r1['is_add_ppn'])
				$r1['nilai_satuan'] = (float)$r1['nilai_satuan']*1.1;

			if(strlen($r1['addjustment']))
				$r1['nilai_satuan'] = (float)$r1['nilai_satuan']+((float)$r1['nilai_satuan']*$r1['addjustment']/100);

			if(strlen($r1['pembulatan']))
				$r1['nilai_satuan'] = bulat($r1['nilai_satuan'], $r1['pembulatan']);

			$tqty+=(float)$r1['vol'];
			?>
		<tr>
			<?php if($rows[$r1['id_rab_penawaran']]){ ?>
				<?php if($this->post['act']=='edit' && $rasli[$pk]==$this->post['key']){ ?>
					<td align="center"><?=$no1++?></td>
					<td colspan="2"><input style="width:100%" type="text" name="uraian" value="<?=$rasli['uraian']?>"/></td>
					<td align="right"></td>
					<td></td>
					<td align="right"></td>
					<td></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment" value="<?=$rasli['addjustment']?>" /></td>
					<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$rasli[$pk]?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				<?php }else{ ?>
					<td align="center"><?=$no1++?></td>
					<td colspan="2">
						<b>
						<a href="<?=site_url("panelbackend/rab_penawaran/edit/$id_rab/$r1[$pk]")?>"><?=$r1['uraian']?></a>
						</b>
					</td>
					<td align="right"></td>
					<td></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="center"><?=($r1['addjustment']?$r1['addjustment'].'%':'')?></td>
					<td><?=UI::showMenu($menuarr)?></td>
				<?php } ?>
			<?php }else{ ?>
				<?php if($this->post['act']=='edit' && $rasli[$pk]==$this->post['key']){ ?>
					<td align="center"><?=$no1++?></td>
					<td colspan="2"><input style="width:100%" type="text" name="uraian" value="<?=$rasli['uraian']?>"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol" value="<?=$rasli['vol']?>" /></td>
					<td><input style="width:100%" type="text" name="satuan" value="<?=$rasli['satuan']?>"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai_satuan" value="<?=$rasli['nilai_satuan']?>" /></td>
					<td></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment" value="<?=$rasli['addjustment']?>" /></td>
					<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$rasli[$pk]?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				<?php }else{ ?>
					<td align="center"><?=$no1++?></td>
					<td colspan="2">
						<a href="<?=site_url("panelbackend/rab_penawaran/edit/$id_rab/$r1[$pk]")?>"><?=$r1['uraian']?></a>
					</td>
					<td align="right">
						<?=$r1['vol']?>
					</td>
					<td><?=$r1['satuan']?></td>
					<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
					<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
					<td align="center"><?=($r1['addjustment']?$r1['addjustment'].'%':'')?></td>
					<td><?=UI::showMenu($menuarr)?></td>
				<?php } ?>
			<?php } ?>
		</tr>
		<?php if($rows[$r1['id_rab_penawaran']]){ ?>
			<?php
			#niaga penawaran 1
			if($rows[$r1['id_rab_penawaran']])
			foreach($rows[$r1['id_rab_penawaran']] as $r2){ 
				$rasli = $r2;

				$menuarr = array();
				$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r2[$pk])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
				$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r2[$pk])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";

				if(!$r2['is_add_ppn'])
					$r2['is_add_ppn'] = $r1['is_add_ppn'];

				if(!strlen($r2['addjustment']))
					$r2['addjustment'] = $r1['addjustment'];

				if(!strlen($r2['pembulatan']))
					$r2['pembulatan'] = $r1['pembulatan'];

				if($r2['is_add_ppn'])
					$r2['nilai_satuan'] = (float)$r2['nilai_satuan']*1.1;

				if(strlen($r2['addjustment']))
					$r2['nilai_satuan'] = (float)$r2['nilai_satuan']+((float)$r2['nilai_satuan']*$r2['addjustment']/100);

				if(strlen($r2['pembulatan']))
					$r2['nilai_satuan'] = bulat($r2['nilai_satuan'], $r2['pembulatan']);

				$tqty+=(float)$r2['vol'];
				?>
			<tr>
				<?php if($this->post['act']=='edit' && $rasli[$pk]==$this->post['key']){ ?>
					<td></td>
					<td align="center"><?=$no2++?></td>
					<td><input style="width:100%" type="text" name="uraian" value="<?=$rasli['uraian']?>"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol" value="<?=$rasli['vol']?>" /></td>
					<td><input style="width:100%" type="text" name="satuan" value="<?=$rasli['satuan']?>"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai_satuan" value="<?=$rasli['nilai_satuan']?>" /></td>
					<td></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment" value="<?=$rasli['addjustment']?>" /></td>
					<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$rasli[$pk]?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				<?php }else{ ?>
					<td></td>
					<td width="30px" align='center'><?=$no2++?></td>
					<td>
						<a href="<?=site_url("panelbackend/rab_penawaran/edit/$id_rab/$r2[$pk]")?>"><?=$r2['uraian']?></a>
					</td>
					<td align="right">
						<?=$r2['vol']?>
					</td>
					<td><?=$r2['satuan']?></td>
					<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
					<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
					<td align="center"><?=($r2['addjustment']?$r2['addjustment'].'%':'')?></td>
					<td><?=UI::showMenu($menuarr)?></td>
				<?php } ?>
			</tr>
			<?php $total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); } ?>

			<?php
			if($this->post['act']=='add' && $id_parent1==$this->post['key']){ 
			?>
				<tr>
					<td></td>
					<td align="center"><?=$no2++?></td>
					<td><input style="width:100%" type="text" name="uraian"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol"/></td>
					<td><input style="width:100%" type="text" name="satuan"/></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai_satuan"/></td>
					<td></td>
					<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment"/></td>
					<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent1?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
				</tr>
			<?php }else{ ?>
				<tr style="border-bottom:2px solid #ddd">
					<td ></td>
					<td colspan="2" align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
					<td ></td>
					<td align="right"></td>
					<td align="right"></td>
					<td><?php if($this->access_role['add']){?><a href="javascript:void(0)" onclick="goSubmitValue('add',<?=$id_parent1?>)"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
				</tr>
			<?php } ?>

		<?php } ?>
		<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } ?>
		<?php
		if($this->post['act']=='add' && $id_parent==$this->post['key']){ 
		?>
			<tr>
				<td><?=$no1++?></td>
				<td colspan="2"><input style="width:100%" type="text" name="uraian"/></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="vol"/></td>
				<td><input style="width:100%" type="text" name="satuan"/></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="nilai_satuan"/></td>
				<td></td>
				<td align="right"><input style="width:100%; text-align: right;" type="number" name="addjustment"/></td>
				<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			</tr>
		<?php }else{ ?>
			<tr style="border-bottom:2px solid #ddd">
				<td ></td>
				<td colspan="2" align="right"><b>Total</b></td>
				<td align="right"><b><?=($tqty?$tqty:null)?></b></td>
				<td align="right"></td>
				<td ></td>
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
		<td colspan="4" align="right"><b>TOTAL SETELAH PAJAK : </b></td>
		<td align="right"><b><?=rupiah($toootaall = $ttotal+($ttotal*10/100))?></b></td>
		<td></td>
	</tr>
</table>


<hr/>

<div style="float:left">
<b>ANALISA KELAYAKAN HARGA</b>
<br/>
<?php 
	$t_hpp = $hpp;

	if($analisa[2])
	foreach($analisa[2] as $r){

	$t_ppn = 0;
	if($r['ppn'])
		$t_ppn = ($toootaall/1.1)*10/100;

	$t_penawaran_ppn = $toootaall - $t_ppn;

	$t_pph = 0;
	/*if($r['pph'])
		$t_pph = $t_penawaran_ppn*$r['pph']/100;*/
?>
<table class="table table-bordered table-hover" style="width: auto; display:inline-block">
	<tr>
		<td>Rencana PH inc PPN </td>
		<td align="center"></td>
		<td align="right" colspan="2"><b><?=rupiah($toootaall)?></b></td>
	</tr>
	<tr>
		<td>Exc PPn </td>
		<td align="center">10%</td>
		<td align="right" colspan="2"><?=rupiah($t_penawaran_ppn)?></td>
	</tr>

	<tr>
		<td colspan="4" style="background: #333"></td>
	</tr>
	<?php /*if($this->post['act']=='edit_pph' && $r['id_analisa']==$this->post['key']){ ?>
		<tr>
			<td>PPH</td>
			<td align="center"><input style="width:100%; text-align: center;" type="number" name="pph" value="<?=$r['pph']?>" /></td>
			<td width="10px" style="padding-top: 5px !important;"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_pph', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"><?=rupiah($t_pph)?></td>
		</tr>
	<?php }else{ ?>
		<tr>
			<td>PPH</td>
			<td align="center"><?=$r['pph']?>%</td>
			<td width="10px"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('edit_pph', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-edit"></span></a></td>
			<td align="right" colspan="2"><?=rupiah($t_pph)?></td>
		</tr>
	<?php }*/ ?>

	<?php 
	$t_bebanusaha = 0;
	if($bebanusaha[$r['id_analisa']])
	foreach($bebanusaha[$r['id_analisa']] as $r1){ 
		$gpm+= $r1['nilai'];
		$menuarr = array();
		$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit_beban_usaha', $r1[id_beban_usaha])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
		$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete_beban_usaha', $r1[id_beban_usaha])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> ";

		if($this->post['act']=='edit_beban_usaha' && $this->post['key']==$r1['id_beban_usaha']){ ?>
		<tr>
			<td><span style="display: inline;"></span> <input style="width:95%; display: inline;" value="<?=$r1['nama']?>" type="text" name="nama" /></td>
			<td align="center"><input style="width:100%; text-align: center;" value="<?=(float)$r1['nilai']?>" type="number" name="nilai" /></td>
			<td align="right"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_edit_beban_usaha', <?=$r1['id_beban_usaha']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
			<td align="right"><?=rupiah($t_beban = $t_penawaran_ppn*$r1['nilai']/100)?></td>
		</tr>
	<?php }else{ ?>
		<tr>
			<td><?=$r1['nama']?></td>
			<td align="center"><?=(float)$r1['nilai']?>%</td>
			<td align="right"><?=UI::showMenu($menuarr)?></td>
			<td align="right"><?=rupiah($t_beban = $t_penawaran_ppn*$r1['nilai']/100)?></td>
		</tr>
	<?php } $t_bebanusaha += $t_beban; } ?>
	<?php if($this->post['act']=='add_beban_usaha' && $this->post['key']==$r['id_analisa']){ ?>
	<tr>
		<td><input style="width:95%; display: inline;" type="text" name="nama" /></td>
		<td align="center"><input style="width:100%; text-align: center;" type="number" name="nilai" /></td>
		<td align="right"><a href="javascript:void(0)" class="waves-effect" onclick="goSubmitValue('save_add_beban_usaha', <?=$r['id_analisa']?>)" ><span class="glyphicon glyphicon-floppy-save"></span></a></td>
		<td align="right"></td>
	</tr>
	<?php }else{ ?>
	<tr>
		<td></td>
		<td align="center"></td>
		<td align="right" width="10px"><a href="javascript:void(0)" onclick="goSubmitValue('add_beban_usaha',<?=$r['id_analisa']?>)"><span class="glyphicon glyphicon-plus"></span></a></td>
		<td align="right"></td>
	</tr>
	<?php } ?>

	<tr>
		<td colspan="4" style="background: #333"></td>
	</tr>

	<tr>
		<td>Cash Out</td>
		<td align="center"></td>
		<td align="right" colspan="2"><?=rupiah($t_hpp,2)?></td>
	</tr>

	<tr>
		<td colspan="4" style="background: #333"></td>
	</tr>
	<?php
	$t_lababersih = $t_penawaran_ppn-$t_pph-$t_bebanusaha-$t_hpp;
	$t_labakotor = $t_penawaran_ppn-$t_hpp;
	?>
	<tr>
		<td><b>MARGIN</b></td>
		<td align="center"></td>
		<td align="right" colspan="2"><b><?=rupiah($t_lababersih)?></b></td>
	</tr>
	<tr>
		<td style="font-size: 18px"><b>NPM</b></td>
		<td align="center" ></td>
		<td align="right" colspan="2" style="color: green; font-size: 18px"><b><?=round($t_lababersih/$t_penawaran_ppn*100,2)?>%</b></td>
	</tr>
	<tr>
		<td style="font-size: 18px"><b>GPM</b></td>
		<td align="center" ></td>
		<td align="right" colspan="2" style="color: red; font-size: 18px"><b><?=round($t_labakotor/$t_penawaran_ppn*100,2)?>%</b></td>
	</tr>
</table>
<?php } ?>
<?php } ?>
</div>
<div style="float:left; padding: 0px 20px">
<b>TTD</b>
<table class="table-hover table table-bordered">
	<tr>
		<td width="250px" align="center">
			<b>Prepair</b>


<?php 
echo UI::createSelect('prepair',$prepairarr,$rowheader3['prepair'],$this->post['act']=='edit_ttd','form-control',"style='width:100%;' data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\" ".'onchange="goSubmit(\'edit_ttd\')"');
echo UI::createTextBox('prepair_jabatan',$rowheader3['prepair_jabatan'],'','',$this->post['act']=='edit_ttd',$class='form-control ',"style='width:100%; text-align:center'");
?>
		</td>
		<td width="250px" align="center">
			<b>Check</b>
<?php 
echo UI::createSelect('cek',$cekarr,$rowheader3['cek'],$this->post['act']=='edit_ttd','form-control',"style='width:100%;' data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\" ".'onchange="goSubmit(\'edit_ttd\')"');
echo UI::createTextBox('cek_jabatan',$rowheader3['cek_jabatan'],'','',$this->post['act']=='edit_ttd',$class='form-control ',"style='width:100%; text-align:center'");
?>
		</td>
		<td width="250px" align="center">
			<b>Approve</b>
<?php 
echo UI::createSelect('approve',$approvearr,$rowheader3['approve'],$this->post['act']=='edit_ttd','form-control',"style='width:100%;' data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\" data-ajax--data-type=\"json\" ".'onchange="goSubmit(\'edit_ttd\')"');
echo UI::createTextBox('approve_jabatan',$rowheader3['approve_jabatan'],'','',$this->post['act']=='edit_ttd',$class='form-control ',"style='width:100%; text-align:center'");
?>
		</td>
		<td valign="top">
			<?php if($this->access_role['edit']){ ?>
				<?php if($this->post['act']=='edit_ttd'){ ?>
					<a href="javascript:void(0)" class="waves-effect" onclick="goSubmit('save_ttd')"><span class="glyphicon glyphicon-floppy-save"></span></a>
				<?php }else{ ?>
					<a href="javascript:void(0)" class="waves-effect" onclick="goSubmit('edit_ttd')"><span class="glyphicon glyphicon-edit"></span></a>
				<?php } ?>
			<?php } ?>
		</td>
	</tr>
</table>
</div>
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