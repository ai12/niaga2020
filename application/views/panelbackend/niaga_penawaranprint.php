<?php
if($width)
	$width_page = $width;
?>
<div id="container" class="container">
<div class="notshow">
	<center>
		<?php if($excel!==false){ ?>
		<a download="<?=$exp=str_replace(array('"',"'"), "", $page_title)?>.xls" class="btn btn-sm btn-primary" href="#" onclick="return ExcellentExport.excel(this, 'datatable', '<?=$exp?>');">
		<span class="glyphicon glyphicon-th"></span> Excel</a>
	    &nbsp;
	    <?php }?>
		<a class="btn btn-sm btn-primary" onclick="window.print()">
		<span class="glyphicon glyphicon-print"></span>
		Print
		</a>
		<br/>
		<br/>
	</center>
</div>
<div id="datatable">

	<div class="header">
	<table border="1" style="padding: 0px; margin: 0px;" width="100%">
		<tr>
			<td rowspan="2" width="100px" style="text-align: center;vertical-align: middle;">
				<img src="<?=base_url()?>assets/img/logo.jpg" width="70px">
			</td>
			<td style="background-color: #337ab7 !important; text-align: center; vertical-align: middle;color:#fff !important; font-weight: bold;">PENAWARAN HARGA</td>
			<td rowspan="2" width="100px">
				
			</td>
		</tr>
		<tr>
			<td  style="text-align: center; vertical-align: middle;font-weight: bold;"><?=strtoupper($rowheader['nama_proyek'])?></td>
		</tr>
	</table>
	</div>

<br/>
<b style="font-size: 12px;">I. IDENTITAS PERMINTAAN</b>
<table width="100%">
	<tr>
		<td width="200px">NO. WORK ORDER</td>
		<td width="1px">:</td>
		<td></td>
	</tr>
	<tr>
		<td>NAMA PEKERJAAN</td>
		<td width="1px">:</td>
		<td><?=$rowheader['nama_proyek']?></td>
	</tr>
	<tr>
		<td>NAMA PELANGGAN</td>
		<td width="1px">:</td>
		<td><?=$rowheader['pemberi_pekerjaan']?></td>
	</tr>
	<tr>
		<td>NO. SURAT PERMINTAAN</td>
		<td width="1px">:</td>
		<td></td>
	</tr>
	<tr>
		<td>TGL. SURAT PERMINTAAN</td>
		<td width="1px">:</td>
		<td></td>
	</tr>
	<tr>
		<td>LOKASI PROYEK</td>
		<td width="1px">:</td>
		<td><?=$rowheader['lokasi']?></td>
	</tr>
	<tr>
		<td>WILAYAH PROYEK</td>
		<td width="1px">:</td>
		<td><?=$wilayaharr[$rowheader['id_wilayah_proyek']]?></td>
	</tr>
</table>
<br/>
<b style="font-size: 12px;">II. DETAIL PERMINTAAN</b>
	<?php 
	$noa = 'A';
	$ttotal = 0;
	if($rows[0])
	foreach($rows[0] as $r){
		$is_add_ppn = $r['is_add_ppn'];
		$addjustment = $r['addjustment'];
		$pembulatan = $r['pembulatan'];
	?>
<table class="tableku">
	<tr>
		<td colspan="5"><b><?=$noa?>. <?=strtoupper($r['uraian'])?></b></td>
	</tr>
	<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
		<th>Uraian</th>
		<th width="100px">Jumlah</th>
		<th width="100px">Satuan</th>
		<th width="150px">Harga Satuan</th>
		<th width="150px">Total Harga</th>
	</tr>


		<?php
		$total = 0;
		#salary
		if($rowssalary[$r['id_niaga_penawaran']])
		foreach($rowssalary[$r['id_niaga_penawaran']] as $r1){ 
			if(!$r1['mandays'])
				continue; 

			if($is_add_ppn)
				$r1['nilai'] = $r1['nilai']*1.1;

			$r1['addjustment'] = $addjustment;
			$r1['pembulatan'] = $pembulatan;
			if($r1['addjustment'])
				$r1['nilai'] = $r1['nilai']+((float)$r1['nilai']*$r1['addjustment']/100);
			
			if($r1['pembulatan'])
				$r1['nilai'] = bulat($r1['nilai'],$r1['pembulatan']);
			?>
		<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
			<td><?=$r1['nama']?></td>
			<td align="right">
			<?php if($r['sumber_nilai']==5){ ?>
			<?php } ?>
			<?=$r1['mandays']?>
			<?php if($r['sumber_nilai']==5){ ?>
			<?php } ?>
			</td>
			<td>MD</td>
			<td align="right"><?=rupiah($r1['nilai'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai']*(float)$r1['mandays'])?></td>
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
				$r1['nilai_satuan'] = bulat($r1['nilai_satuan'],$r1['pembulatan']);
			?>
		<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
			<td><?=$r1['uraian']?></td>
			<td align="right">
			<?php if($r1['sumber_satuan']==2 or $r1['sumber_satuan']==3){ ?>
			<?php } ?>
			<?=$r1['vol']?>
			<?php if($r1['sumber_satuan']==2 or $r1['sumber_satuan']==3){ ?>
			<?php } ?>
			</td>
			<td><?=$r1['satuan']?></td>
			<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
		</tr>
		<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } ?>

		<?php 
		#rab
		if($rowsrab[$r['id_niaga_penawaran']])
		foreach ($rowsrab[$r['id_niaga_penawaran']] as $r2) { 
			$stotal = 0;
			if($is_add_ppn)
				$r2['nilai_satuan'] = $r2['nilai_satuan']*1.1;

			$r2['addjustment'] = (float)$addjustment;
			$r2['pembulatan'] = (float)$pembulatan;
			if($r2['addjustment'])
				$r2['nilai_satuan'] = (float)$r2['nilai_satuan']+((float)$r2['nilai_satuan']*$r2['addjustment']/100);
			
			if($r2['pembulatan'])
				$r2['nilai_satuan'] = bulat($r2['nilai_satuan'],$r2['pembulatan']);

		if($r2['sumber_nilai']=='3'){ 

		$jm = $jasa_materialarr[$r2['id_pos_anggaran']][$r2['jasa_material']][$r2['kode_biaya']];

		if(!$jm && !$r2['sub'])
			continue;
		?>
		<?php if(!($r2['jasa_material']!='1' && ($r2['kode_biaya']=='E109' or $r2['kode_biaya']=='E103'))){ ?>
		<tr>
			<td colspan="5"><?=$r2['uraian']?></td>
		</tr>
		<?php
		}
		#jasa material
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
				$r3['harga_satuan'] = bulat($r3['harga_satuan'],$r3['pembulatan']);
			
		?>
		<tr <?php if($r2['jasa_material']!='1' && ($r2['kode_biaya']=='E109' or $r2['kode_biaya']=='E103')){ ?> <?php if(!$is_detail){ ?>style="display: none"<?php } ?> <?php } ?>>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['nama']?></td>
			<td width="50px" align="right"><?=$r3['vol']?></td>
			<td width="50px"><?=$r3['satuan']?></td>
			<td align="right" width="150px"><?=rupiah($r3['harga_satuan'])?></td>
			<td align="right" width="150px"><?=rupiah((float)$r3['harga_satuan']*(float)$r3['vol'])?></td>
		</tr>
		<?php 
		$total+= (float)((float)$r3['harga_satuan']*(float)$r3['vol']); 
		$stotal+= (float)((float)$r3['harga_satuan']*(float)$r3['vol']); 
		} 
		}elseif($r2['sub']){ ?>

		<tr>
			<td colspan="5"><b><?=$r2['uraian']?></b></td>
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
				$r3['nilai_satuan'] = bulat($r3['nilai_satuan'],$r3['pembulatan']);
			
		?>

		<tr>
			<td>&nbsp;&nbsp;&nbsp;<?=$r3['uraian']?></td>
			<td align="right"><?=$r3['vol']?></td>
			<td><?=$r3['satuan']?></td>
			<td align="right"><?=rupiah($r3['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r3['nilai_satuan']*(float)$r3['vol'])?></td>
		</tr>

		<?php 
		$total+= (float)((float)$r3['nilai_satuan']*(float)$r3['vol']); 
		$stotal+= (float)((float)$r3['nilai_satuan']*(float)$r3['vol']); 
		} }else{ ?>
		<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
			<td><?=$r2['uraian']?></td>
			<td align="right"><?=$r2['vol']?></td>
			<td><?=$r2['satuan']?></td>
			<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
			<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
		</tr>

		<?php 
		$total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); 
		$stotal+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); 
		} ?>


		<?php if(($r2['jasa_material']!='1' && $jm) && ($r2['kode_biaya']=='E109' or $r2['kode_biaya']=='E103')){ ?>
			<tr>
				<td><?=$r2['uraian']?></td>
				<td align="right">1</td>
				<td>Lot</td>
				<td align="right"><?=rupiah($stotal)?></td>
				<td align="right"><?=rupiah($stotal)?></td>
			</tr>
		<?php } ?>

		<?php } ?>


		<tr>
			<td colspan="4" align="right" style="background-color: #dddddd !important;"><b>Jumlah item <?=$noa++?>: </b></td>
			<td align="right" width="150px" style="background-color: #dddddd !important;"><b><?=rupiah($total)?></b></td>
		</tr>
</table>
<?php 
$ttotal += $total;
} ?>
<table class="tableku">
	<tr>
		<td rowspan="3" style="font-size: 14px; font-weight: bold; vertical-align: middle;">
			<center>
				<u><i>Terbilang:</i></u><br/>
				<?=ucfirst(trim(strtolower(terbilang($ttotal*1.1))))?> rupiah
			</center>
		</td>
		<td width="350px" align="right" style="background-color: #dddddd !important;"><b>TOTAL : </b></td>
		<td width="150px" align="right" style="background-color: #dddddd !important;"><b><?=rupiah($ttotal)?></b></td>
	</tr>
	<tr>
		<td align="right" style="background-color: #dddddd !important;"><b>PPN 10% : </b></td>
		<td align="right" style="background-color: #dddddd !important;"><b><?=rupiah($ttotal*10/100)?></b></td>
	</tr>
	<tr>
		<td align="right" style="background-color: #dddddd !important;"><b>TOTAL RAB KOMERSIAL : </b></td>
		<td align="right" style="background-color: #dddddd !important;"><b><?=rupiah($toootaall = $ttotal+($ttotal*10/100))?></b></td>
	</tr>
</table>

</div>
</div>
<?php if(!$this->post[date('Ymd')]){ ?>
<script src="<?php echo base_url()?>assets/js/excellentexport.min.js"></script>
<style>
		.notshow{
			margin-top: 10px;
		}
	@media print{
		.notshow{
			display: none;
		}
		body{
			margin: 0px;
			padding: 10px 5px;
		}
		html{
			margin:0px;
			padding:0px;
		}
	}
#container{
	width: 100%;
    font-size:14px;
    font-family:Arial, Helvetica, sans-serif;
}
td,th{
    padding: 3px;
    font-size: 12px;
    vertical-align:text-center;
}
.h4, .h5, .h6, h4, h5, h6, hr {
    margin-top: 5px;
    margin-bottom: 5px;
}
.tableku {
    width:100%;
    border:1px solid #555;
}
.tableku td{border: 1px solid #555;
    padding: 0px 3px;
	vertical-align: top;
}
.tableku thead th{
	border:1px solid #555;
	border-bottom:2px  solid #555;
	padding:0px 3px;
}
.tableku th{
	border:1px solid #555;
	padding:0px 3px;
}
.tableku thead, .tableku1 thead{
	border:1px solid #555;
	page-break-before: always;
}
hr{
	border-color:#555;
}
.tableku1 {
    margin-top: 10px;
    width:100%;
    border:1px solid #555;
}
.tableku1 td{
    border:1px solid #555;
	padding:3px 5px;   
	vertical-align: top;
}
.tableku1 thead th{
	border:1px solid #555;
	border-bottom:2px  solid #555;
	padding:3px 5px;    
	text-align: center;
}
.tableku1 th{
	border:1px solid #555;
	padding:0px 3px;
	text-align: center;
}

</style>
<?php } ?>