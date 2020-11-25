<table cellpadding="2" width="100%" class="table-label" border="1">
	<tr>
		<td style="text-align: center;">PT PEMBANGKITAN JAWA BALI SERVICES</td>
	</tr>
	<tr>
		<td style="text-align: center;">RENCANA ANGGARAN BIAYA PROYEK</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td width="65px">NAMA PROYEK</td>
					<td width="10px">:</td>
					<td width="500px"><?=$rowheader['nama_proyek']?></td>
				</tr>
				<tr>
					<td colspan="3"><b><?=$row['kode_biaya']?> : <?=$row['uraian']?></b></td>
				</tr>
			</table>
	</td>
	</tr>
</table>

<?php if ($row['sumber_nilai']=='3') { ?>

	<table cellpadding="2" width="100%" border="1">
		<tr>
			<th width="10px">No.</th>
			<th>SCOPE OF WORK</th>
			<th>VOLUME</th>
			<th>SATUAN</th>
			<th>HARGA SATUAN</th>
			<th>JUMLAH</th>
		</tr>
		<?php 
		$no=1;
		if(count($rowsjasa_material)){
			foreach($rowsjasa_material as $r){ 
				$jumlah = 0;
				?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td><?=$r['nama']?></td>
			<td style="text-align: right;"><?=$r['vol']?></td>
			<td><?=$r['satuan']?></td>
			<td style="text-align: right;"><?=rupiah($r['harga_satuan'],2)?></td>
			<td style="text-align: right;"><?=rupiah($jumlah=$r['total'],2)?></td>
		</tr>

	<?php $total += $jumlah; }?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><b>Jumlah</b></td>
			<td align="right"><?=rupiah($total)?></td>
		</tr>
	<?php }else{ ?>
		<tr><td colspan="5"><i>Belum ada data</i></td></tr>
	<?php } ?>
</table>
<?php }else{ ?>
	<table cellpadding="2" width="100%" border="1">
		<tr>
			<th width="20px" align="center">No.</th>
			<?php if($is_kode_biaya){ ?>
				<th width="30px" align="center">KODE BIAYA</th>
			<?php } ?>
			<?php if($is_satuan){ ?>
				<th width="268.5px" align="center">URAIAN BIAYA</th>
				<th width="50px" align="center">VOLUME</th>
				<th width="50px" align="center">SATUAN</th>
				<th width="80px" align="center">HARGA SATUAN<br/>(Rp)</th>
			<?php }else{ ?>
				<th width="448.5px" align="center">URAIAN BIAYA</th>
			<?php } ?>
			<th width="80px" align="center">JUMLAH<br/>(Rp)</th>
		</tr>
		<?php 
		$mtposanggaranarr[''] = '';
		if(count($rows)){
			$no=1;
			foreach($rows as $r){ 
				$jumlah = 0;
				?>
		<tr>

			<?php if(($is_kode_biaya && $r['kode_biaya']) or !$is_kode_biaya){ ?>
			<td align="center"><?=$no++?></td>
			<?php } else { ?>
			<td align="center"></td>
			<?php } ?>
			<?php if($is_kode_biaya){ ?>
				<td><?=$r['kode_biaya']?></td>
			<?php } ?>
			<td><?=$r['uraian']?></td>
			<?php if($is_satuan){ 
				if(!$r['day'])$r['day']=1;
				?>
				<td style="text-align: center;"><?=((float)$r['vol']*(float)$r['day'])?(float)$r['vol']*(float)$r['day']:''?></td>
				<td style="text-align: center;"><?=$r['satuan']?></td>
			<?php }  if($is_satuan){ ?>
			<td style="text-align: right;"><?php if(empty($parentarr[$r['id_rab_detail']])){ ?> <?=rupiah($r['nilai_satuan'],2)?><?php } ?></td>
			<?php } if(empty($parentarr[$r['id_rab_detail']])){ ?>
			<td style="text-align: right;"><?=rupiah($jumlah=caljumlah($r),2)?></td>
			<?php }else{ ?>
			<td style="text-align: right;"></td>
			<?php } ?>
		</tr>

	<?php $total += $jumlah; }?>
		<tr>
				<td></td>
			<?php if($is_kode_biaya){ ?>
				<td></td>
			<?php } ?>
			<?php if($is_satuan){ ?>
				<td></td>
				<td></td>
				<td></td>
			<?php } ?>
			<td><b>Jumlah</b></td>
			<td align="right"><?=rupiah($total)?></td>
		</tr>
	<?php }else{ ?>
		<tr><td colspan="4"><i>Belum ada data</i></td></tr>
	<?php } ?>
</table>
<?php } ?>
<style type="text/css">
    td{
        padding: 1px !important;
        font-size: 11px !important;
        vertical-align: top !important;
    }
    th{
        padding: 5px !important;
        font-size: 11px !important;
    }
    thead th{
        text-align: center;
        vertical-align: middle !important;
    }
</style>