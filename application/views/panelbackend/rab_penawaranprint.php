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
	
		$total = 0;
		$no1 = 1;

		$noat = $noa;
	?>
<table class="tableku">
	<tr>
		<th width="30px" style="text-align: center !important;"><?=$noa++?></th>
		<th colspan="6" style="text-align: left;"><?=strtoupper($r['uraian'])?></th>
	</tr>
	<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
		<th style="text-align: left;"></th>
		<th colspan="2" style="text-align: left;">Uraian</th>
		<th width="100px" style="text-align: center !important;">Jumlah</th>
		<th width="100px" style="text-align: center !important;">Satuan</th>
		<th width="150px" style="text-align: center !important;">Harga Satuan</th>
		<th width="150px" style="text-align: center !important;">Total Harga</th>
	</tr>

		<?php
		#niaga penawaran
		if($rows[$r['id_rab_penawaran']])
		foreach($rows[$r['id_rab_penawaran']] as $r1){ 
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
		<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
			<?php if($rows[$r1['id_rab_penawaran']]){ ?>
				<td align="center"><?=$no1++?></td>
				<td colspan="2">
					<b>
					<?=$r1['uraian']?>
					</b>
				</td>
				<td align="right"></td>
				<td></td>
				<td align="right"></td>
				<td align="right"></td>
			<?php }else{ ?>
				<td align="center"><?=$no1++?></td>
				<td colspan="2">
					<?=$r1['uraian']?>
				</td>
				<td align="right">
					<?=$r1['vol']?>
				</td>
				<td><?=$r1['satuan']?></td>
				<td align="right"><?=rupiah($r1['nilai_satuan'])?></td>
				<td align="right"><?=rupiah((float)$r1['nilai_satuan']*(float)$r1['vol'])?></td>
			<?php } ?>
		</tr>
		<?php if($rows[$r1['id_rab_penawaran']]){ ?>
			<?php
			#niaga penawaran 1
			if($rows[$r1['id_rab_penawaran']])
			foreach($rows[$r1['id_rab_penawaran']] as $r2){ 

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
				<tr <?php if(!$is_detail){ ?>style="display: none"<?php } ?>>
					<td></td>
					<td width="30px" align='center'><?=$no2++?></td>
					<td>
						<?=$r2['uraian']?>
					</td>
					<td align="right">
						<?=$r2['vol']?>
					</td>
					<td><?=$r2['satuan']?></td>
					<td align="right"><?=rupiah($r2['nilai_satuan'])?></td>
					<td align="right"><?=rupiah((float)$r2['nilai_satuan']*(float)$r2['vol'])?></td>
				</tr>
			<?php $total+= (float)((float)$r2['nilai_satuan']*(float)$r2['vol']); } ?>
		<?php } ?>
		<?php $total+= (float)((float)$r1['nilai_satuan']*(float)$r1['vol']); } ?>
		<tr>
			<td colspan="6" align="right" style="background-color: #dddddd !important;"><b>JUMLAH ITEM <?=$noat?>:</b></td>
			<td align="right"  width="150px" style="background-color: #dddddd !important;"><b><?=rupiah($total)?></b></td>
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

<br/>
<table width="100%">
	<tr>
		<td align="center"><b>
			Prepair<br/>
			<?=$rowheader3['prepair_nama']?><br/><br/><br/><br/><br/>
			<?=$rowheader3['prepair_jabatan']?>
		</b></td>
		<td align="center"><b>
			Check<br/>
			<?=$rowheader3['cek_nama']?><br/><br/><br/><br/><br/>
			<?=$rowheader3['cek_jabatan']?>
		</b></td>
		<td align="center"><b>
			Approve<br/>
			<?=$rowheader3['approve_nama']?><br/><br/><br/><br/><br/>
			<?=$rowheader3['approve_jabatan']?>
		</b></td>
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