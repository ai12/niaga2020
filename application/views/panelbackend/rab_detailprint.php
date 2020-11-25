<table cellpadding="2" width="100%" class="table-label" border="1">
	<tr>
		<td style="text-align: center;">PT PEMBANGKITAN JAWA BALI SERVICES</td>
	</tr>
	<tr>
		<td style="text-align: center;">RENCANA ANGGARAN BIAYA PROYEK</td>
	</tr>
	<tr>
		<td>
			<table cellpadding="2">
				<tr>
					<td width="120px">CUSTOMER</td>
					<td width="10px">:</td>
					<td width="445px">PT Pembangkitan Jawa Bali Services</td>
				</tr>
				<tr>
					<td>NAMA PROYEK</td>
					<td>:</td>
					<td><?=$rowheader['nama_proyek']?></td>
				</tr>
				<tr>
					<td>NO. KONTRAK/TANGGAL</td>
					<td>:</td>
					<td><?=$rowheader1['no_kontrak']?>/<?=$rowheader1['tgl_kontrak']?></td>
				</tr>
				<tr>
					<td>NO. SP3/TANGGAL</td>
					<td>:</td>
					<td><?=$rowheader1['no_pekerjaan']?>/<?=$rowheader1['tgl_pekerjaan']?></td>
				</tr>
				<tr>
					<td>NILAI HPP</td>
					<td>:</td>
					<td><?=rupiah($rowheader1['nilai_hpp'])?></td>
				</tr>
				<tr>
					<td>NOMOR PRK INTI</td>
					<td>:</td>
					<td><?=$rowheader1['no_prk']?></td>
				</tr>
				<tr>
					<td>RENCANA PELAKSANAAN</td>
					<td>:</td>
					<td><?=Eng2Ind($rowheader['tgl_rencana_mulai'])?>s/d<?=Eng2Ind($rowheader['tgl_rencana_selesai'])?></td>
				</tr>
				<tr>
					<td>MANAGER PROYEK</td>
					<td>:</td>
					<td><?=$rowheader['nama_pic']?></td>
				</tr>
			</table>
	</td>
	</tr>
</table>
<table cellpadding="2" width="100%" class="table-label" border="1">
		<tr>
			<th width="20px" align="center">No.</th>
			<th width="30px" align="center">KODE BIAYA</th>
			<th width="302px" align="center">URAIAN BIAYA</th>
			<th width="80px" align="center">JUMLAH ANGGARAN</th>
			<th width="50px" align="center">POS ANGGARAN</th>
			<th align="center">KETERANGAN</th>
		</tr>
		<?php 
		$mtposanggaranarr[''] = '';
		$total = 0;
		$no=1;
		if(count($rows)){
			foreach($rows as $r){ 
				if($r['level']>2 && !$r['id_pos_anggaran'])
					continue;
			?>
		<tr>
			<td align="center">
				<b><?php if($r['level']<=1){echo $no++;} ?></b>
			</td>
			<td align="center">
				<?php if($r['id_pos_anggaran']){
					echo $r['kode_biaya'];
				}else{ ?>
					<?=$r['kode_biaya']?>
				<?php } ?>
			</td>
			<td><?=$r['uraian']?></td>
			<td style="text-align: right;">
				<?php if($r['id_pos_anggaran']){ 
					$total+=(float)$r['nilai_satuan'];
					?>
					<?=rupiah($jumlah=$r['nilai_satuan'],2)?>
				<?php } ?>
					</td>
			<td style="text-align: center;">

					<?=$mtposanggaranarr[$r['id_pos_anggaran']]?>
					</td>
			<td><?=$r['keterangan']?></td>
		</tr>
	<?php } ?>
	<tr><td colspan="3" style="text-align: right;"><b>JUMLAH</b></td><td style="text-align: right;"><?=rupiah($total)?></td><td></td><td><?=rupiah($totalrealisasi)?></td></tr>
<?php }else{ ?>
		<tr><td colspan="6"><i>Belum ada data</i></td></tr>
	<?php } ?>
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="6">
			CATATAN :<br/>
			1. Proyeksi Laba (%)<br/>
			2. Bukan Laporan Akuntansi<br/>
			2. Seluruh biaya termasuk pajak. (PPn dan PPh)
		</td></tr>
		<tr><td colspan="6">

<table cellpadding="2" width="100%">
    <tr>
        <td width="33%" align="center" valign="top"><br/>
            Mengetahui,<br/><br/><br/><br/><br/><br/><br/>
            (<?=$ttdarr[0]['nama']?>)<br/>
            <?=$ttdarr[0]['jabatan']?>
        </td> 
        <td width="33%" align="center" valign="top"><br/><br/><br/><br/><br/><br/><br/><br/>
            (<?=$ttdarr[1]['nama']?>)<br/>
            <?=$ttdarr[1]['jabatan']?>
        </td> 
        <td  valign="top" align="center"><br/>
            Sidoarjo,<?=Eng2Ind(date('d-m-Y'))?><br/><br/><br/><br/><br/><br/><br/>
            (<?=$ttdarr[2]['nama']?>)<br/>
            <?=$ttdarr[2]['jabatan']?>
        </td>
    </tr>
</table>
		</td></tr>
</table>

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