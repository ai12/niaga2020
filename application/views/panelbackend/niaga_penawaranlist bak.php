
<?php 
if($rows){ ?>
<div style="text-align: right; margin-bottom: 5px; margin-top:-10px;">
	<button type="button" onclick="goSubmit('generate_penawaran')" class="btn btn-sm btn-primary">Regenerate Penawaran</button>
</div>
<?php
if($rows[0])
foreach($rows[0] as $r){ ?>
<table class="table table-bordered">
	<tr>
		<td colspan="6"><b><a class='black' href="<?=site_url("panelbackend/niaga_penawaran/detail/$id_rab/$r[id_niaga_penawaran]")?>"><?=strtoupper($r['uraian'])?></a></b></td>
		<td><?=UI::showMenuMode('inlist', $r[$pk])?></td>
	</tr>
	<tr>
		<th>Urian</th>
		<th width="100px">Jumlah</th>
		<th width="100px">Satuan</th>
		<th width="150px">Harga Satuan</th>
		<th width="150px">Total Harga</th>
		<th width="50px">% Adjustment</th>
		<th width="20px"></th>
	</tr>

	<?php
	$total = 0;
	if($rows[$r['id_niaga_penawaran']])
	foreach($rows[$r['id_niaga_penawaran']] as $r1){ 
	if($rows[$r1['id_niaga_penawaran']]){ ?>
	<tr>
		<td><b><?=$r1['uraian']?></b></td>
		<td align="right"></td>
		<td></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>
		<td><?=UI::showMenuMode('inlist', $r1[$pk])?></td>
	</tr>
	<?php foreach($rows[$r1['id_niaga_penawaran']] as $r2){ ?>
	<tr>
		<td><?=$r2['uraian']?></td>
		<td align="right"><?=$r2['vol']?></td>
		<td><?=$r2['satuan']?></td>
		<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
		<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
		<td align="right"><?=rupiah($r2['addjustment'])?></td>
		<td><?=UI::showMenuMode('inlist', $r2[$pk])?></td>
	</tr>
	<?php $total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); } }else{ ?>
	<tr>
		<td><?=$r1['uraian']?></td>
		<td align="right"><?=$r1['vol']?></td>
		<td><?=$r1['satuan']?></td>
		<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
		<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
		<td align="right"><?=rupiah($r1['addjustment'])?></td>
		<td><?=UI::showMenuMode('inlist', $r1[$pk])?></td>
	</tr>
	<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } } ?>

	<tr>
		<td colspan="4" align="right"><b>Sub total : </b></td>
		<td align="right"><b><?=rupiah($total)?></b></td>
		<td align="right"></td>
		<td><?php if($this->access_role['add']){?><a href="<?=site_url('panelbackend/niaga_penawaran/add/'.$id_rab.'/'.$r['id_niaga_penawaran'])?>"><span class="glyphicon glyphicon-plus"></span></a><?php } ?></td>
	</tr>
</table>
<?php 
$ttotal += $total; } ?>
<table class="table table-bordered">
	<tr>
		<td colspan="4" align="right"><b>TOTAL : </b></td>
		<td width="150px" align="right"><b><?=rupiah($ttotal)?></b></td>
		<td width="101px"></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>PPn (10%) : </b></td>
		<td align="right"><b><?=rupiah($ttotal*0.1)?></b></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="4" align="right"><b>TOTAL SETELAH PAJAK : </b></td>
		<td align="right"><b><?=rupiah($ttotal*1.1)?></b></td>
		<td></td>
	</tr>
</table>
<hr/>
<b>ANALISA KELAYAKAN HARGA</b>
<?php 
if($analisa[2])
foreach($analisa[2] as $r){ $no=1; ?>
<table class="table table-bordered">
	<tr>
		<th width="40px">NO</th>
		<th>KOMPONEN RKAP</th>
		<th width="100px">% RKAP</th>
		<th width="200px">JUMLAH</th>	
	</tr>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Nilai Minimal Kontrak</td>
		<td align="center"></td>
		<td align="right"><?=rupiah($r['nilai'])?></td>
	</tr>
	<?php if($r['ppn']){ ?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td>PPN</td>
			<td align="center"><?=$r['ppn']?>%</td>
			<td align="right"><?=rupiah($r['nilai']*$r['ppn']/100)?></td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>Nilai Minimal Kontrak dikurangi PPN</td>
			<td align="center"></td>
			<td align="right" style="border-top: 2px solid #333;"><?=rupiah($r['nilai']=$r['nilai']-($r['nilai']*$r['ppn']/100))?></td>
		</tr>
	<?php } ?>
	<?php if($r['pph']){ ?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td>PPH</td>
			<td align="center"><?=$r['pph']?>%</td>
			<td align="right"><?=($r['nilai']*$r['pph']/100)?></td>
		</tr>
		<tr>
			<td align="center"></td>
			<td>Cash in</td>
			<td align="center"></td>
			<td align="right" style="border-top: 2px solid #333;"><?=$r['nilai']=$r['nilai']-($r['nilai']*$r['pph']/100)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Beban Operasi</td>
		<td align="center"><?php 
		$prosen_beban_operasi = $hpp/$r['nilai']*100;
		$laba = $r['nilai'] - $hpp;
		$prosen_laba = $laba/$r['nilai']*100;
		echo round($prosen_beban_operasi).'%';
		?></td>
		<td align="right"><?=rupiah($hpp,2)?></td>
	</tr>
	<tr>
		<td align="center"><?=$no++?></td>
		<td>Laba Kotor</td>
		<td align="center"><?=round($prosen_laba,2)?>%</td>
		<td align="right"><?=rupiah($laba)?></td>
	</tr>
	<?php $total_beban_usaha = 0;
	if($bebanusaha[$r['id_analisa']]){ ?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td>Beban Usaha</td>
			<td align="center"></td>
			<td align="right"></td>
		</tr>
		<?php 
		$total_beban_usaha = 0;
		$no1=1; foreach($bebanusaha[$r['id_analisa']] as $r1){ ?>
			<tr>
				<td></td>
				<td><?=$no-1?>.<?=$no1++?> <?=$r1['nama']?></td>
				<td align="center"><?=(float)$r1['nilai']?>%</td>
				<td align="right"><?=rupiah($r['nilai']*$r1['nilai']/100)?></td>
			</tr>
		<?php $total_beban_usaha += ($r['nilai']*$r1['nilai']/100); } ?>
		<tr>
			<td></td>
			<td><b>Total Beban Usaha</b></td>
			<td align="center"></td>
			<td align="right" style="border-top: 2px solid #333;"><?=rupiah($total_beban_usaha)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td align="center"><?=$no++?></td>
		<td ><b>LABA BERSIH</b></td>
		<td align="center"><?=$r['profit_margin']?>%</td>
		<td align="right"><?=rupiah($laba_bersih = $laba-$total_beban_usaha)?></td>
	</tr>
	<tr>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="right"><?=round($presenlaba = $laba_bersih/$r['nilai']*100,2)?>%</td>
	</tr>
	<tr>
		<td colspan="2"><center><b></b></center></td>
		<td><center><b>MAX NEGO</b></center></td>
		<td><center><b><?=round($presenlaba-$r['profit_margin'],2)?>%</b></center></td>
	</tr>
	<tr>
		<td colspan="4" style="padding: 20px !important; font-size: 20px">
		<center>
			<b>
			<?php if($presenlaba<$aturan['max_nego']){
				echo "<span style='color:red'>PROYEK TIDAK LAYAK</span>";
			}elseif($presenlaba<$aturan['max_nego']+$aturan['layak']){
				echo "<span style='color:yellow'>PROYEK LAYAK DENGAN CATATAN</span>";
			}else{
				echo "<span style='color:green'>PROYEK SANGAT LAYAK</span>";
			}
			?>
			</b>
		</center>
		</td>
	</tr>
</table>
<?php } }else{ ?>
<center>
	<button type="button" onclick="goSubmit('generate_penawaran')" class="btn btn-lg btn-primary">Generate Penawaran</button>
</center>
<?php } ?>
<style type="text/css">
	.table td, .table th {
    padding: 1px 5px !important;
}
</style>