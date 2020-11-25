<ol class="breadcrumb">
  <li><a href="<?=site_url("panelbackend/rab_detail/index/$id_rab")?>">RAB</a></li>
  <?php
  foreach($breadcrumb as $k=>$v){
  	echo '<li><a href="'.site_url("panelbackend/rab_detail/detail/$id_rab/$k").'">'.$v.'</a></li>';
  }
  ?>
  <li><?=$row['uraian']?></li>
</ol>
<div class="row">
<div class="col-sm-12">
<?php
echo "<h4>$row[uraian]</h4>";
?>
<hr/>
</div>
</div>
<div class="row">
<div class="col-sm-7">

<?php 

echo "<h5 class='no-margin'>";
$jumlahnilai = caljumlah($row, true);
echo rupiah($jumlahnilai)." &nbsp;&nbsp;&nbsp; REALISASI : ".rupiah($row['nilai_realisasi'])."</h5><br/>";

if(!$row['keterangan'])
	$row['keterangan'] = '<i>kosong</i>';

$from = UI::createTextArea('keterangan',$row['keterangan'],'','',$edited,$class='form-control',"");
echo UI::createFormGroup($from, $rules["keterangan"], "keterangan", "Keterangan",true,3);


if(is_array($row['files']) && count($row['files'])){
$from = UI::createUploadMultiple("files", $row['files'], $page_ctrl, $edited, "files");
echo UI::createFormGroup($from, $rules["files"], "files", "Lampiran", true, 3);
}
?>
</div>
<div class="col-sm-5" style="text-align: right;">
	<?php $persen=($jumlahnilai?((float)$row['nilai_realisasi']/(float)$jumlahnilai*100):0);?>
	<div class="progress lg no-margin" title="<?=round($persen,2)?>%">
    <div class="progress-bar <?=($persen>100?"progress-bar-red":(($presen==100)?"progress-bar-blue":"progress-bar-green"))?>" style="width: <?=round($persen,2)?>%;"><?=round($persen,2)?>%</div>
  </div>
 
</div>
</div>
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
				<th>VOLUME</th>
				<th>SATUAN</th>
				<th>HARGA SATUAN</th>
			<?php } ?>
			<th>JUMLAH</th>
			<th>REALISASI</th>
			<th>PROGRESS</th>
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

			<?php if(($is_kode_biaya && $r['kode_biaya']) or !$is_kode_biaya){ ?>
			<td align="center"><?=$no++?></td>
			<?php } else { ?>
			<td align="center"></td>
			<?php } ?>
			<?php if($is_kode_biaya){ ?>
				<td><?=$r['kode_biaya']?></td>
			<?php } ?>
			<td><a href='<?=site_url("panelbackend/rab_detail/detail/$id_rab/$r[id_rab_detail]")?>'><?=$r['uraian']?></a></td>
			<?php if($is_satuan){ 
				if(!$r['day'])$r['day']=1;
				?>
				<td style="text-align: center;"><?=((float)$r['vol']*(float)$r['day'])?(float)$r['vol']*(float)$r['day']:''?></td>
				<td style="text-align: center;"><?=$r['satuan']?></td>
			<?php }  if($is_satuan){ ?>
			<td style="text-align: right;"><?=rupiah($r['nilai_satuan'],2)?></td>
			<?php } ?>
			<td style="text-align: right;"><?=rupiah($jumlah=caljumlah($r),2)?></td>
			<td style="text-align: right;"><?=rupiah($r['nilai_realisasi'],2)?></td>
			<td>
				<?php $prosen=($jumlah?((float)$r['nilai_realisasi']/(float)$jumlah*100):0);?>
				<div class="progress" title="<?=round($prosen,2)?>%">
                        <div class="progress-bar <?=($prosen>100?"progress-bar-red":(($prosen==100)?"progress-bar-blue":"progress-bar-green"))?>" style="width: <?=round($prosen,2)?>%;"><?=round($prosen,2)?>%</div>
                      </div></td>
			<td><?php
			$add = array();
			if($r['sumber_nilai']==1){
				$add = array('<li><a href="'.site_url("panelbackend/rab_detail/add/$id_rab/$r[$pk]").'" class="waves-effect "><span class="glyphicon glyphicon-share"></span> Add Sub</a> </li>');
			}else{
				$add = array('<li><a href="'.site_url("panelbackend/rab_realisasi/add/$r[$pk]").'" class="waves-effect "><span class="glyphicon glyphicon-check"></span> Realisasi</a> </li>');
			}
			echo UI::showMenuMode('inlist', $r[$pk]."/".$r['id_rab_detail_parent'],false,'','',null,null,$add);
			?></td>
		</tr>

	<?php }?>
	<?php }else{ ?>
		<tr><td colspan="6"><i>Belum ada data</i></td></tr>
	<?php } ?>
	</tbody>
</table>

<?php }elseif ($row['sumber_nilai']=='3') { ?>

	<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width="10px">No.</th>
			<th>SCOPE OF WORK</th>
			<th>VOLUME</th>
			<th>SATUAN</th>
			<th>HARGA SATUAN</th>
			<th>JUMLAH</th>
			<th>REALISASI</th>
			<th>PROGRESS</th>
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
			<td style="text-align: right;">
				<?php 
				if(is_array($rowsrealisasi[$r['id_jasa_material']]) && count($rowsrealisasi[$r['id_jasa_material']])){ ?>
				<?='<a href="'.site_url("panelbackend/rab_realisasi/add/$row[$pk]/$r[id_jasa_material]").'" class="btn btn-xs btn-info waves-effect "><span class="glyphicon glyphicon-check"></span> Tambah Realisasi</a>'?>
				<table class="table table-hover table-bordered" style="margin-bottom: 5px; margin-top: 5px;">
					<thead>
						<tr>
							<th width="10px">No.</th>
							<th width="130px">TGL</th>
							<th>NILAI SATUAN</th>
							<th>VOL</th>
							<th>SATUAN</th>
							<th>TOTAL NILAI</th>
							<th>KETERANGAN</th>
							<th>LAMPIRAN</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no=1;
						$total = 0;
						foreach($rowsrealisasi[$r['id_jasa_material']] as $r1){ 
							$total+=$r1['nilai'];
								?>
						<tr>
							<td align="center"><?=$no++?></td>
							<td><?=($r1['tgl'])?></td>
							<td><?=rupiah($r1['nilai_satuan'])?></td>
							<td><?=$r1['vol']?></td>
							<td><?=$r1['satuan']?></td>
							<td style="text-align: right;"><a href="<?=site_url("panelbackend/rab_realisasi/edit/$row[id_rab_detail]/$r1[id_realisasi]")?>"><?=rupiah($r1['nilai'],2)?></a></td>
							<td><?=$r1['keterangan']?></td>
							<td>
								<?php if($filerealisasi[$r1['id_realisasi']]){
									$arr=array();
									foreach($filerealisasi[$r1['id_realisasi']] as $r2){
										$arr[]="<a href='".site_url("panelbackend/rab_realisasi/open_file/$r2[id]")."' target='_BLANK'>$r2[name]</a>";
									}

									echo implode("<br/>", $arr);
								}?>
							</td>

						</tr>

					<?php }?>
						<tr>
							<td align="center" colspan="5">TOTAL</td>
							<td style="text-align: right;"><?=rupiah($total,2)?></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			<?php } ?>
			</td>
			<?php $prosen = ($jumlah?((float)$r['nilai_realisasi']/(float)$jumlah*100):0);?>
			<td><div class="progress" title="<?=round($prosen,2)?> %">
                <div class="progress-bar <?=($prosen>100?"progress-bar-red":(($prosen==100)?"progress-bar-blue":"progress-bar-green"))?>" style="width:<?=round($prosen,2)?>%;"><?=round($prosen,2)?>%</div>
              </div></td>
		</tr>

	<?php }?>
	<?php }else{ ?>
		<tr><td colspan="7"><i>Belum ada data</i></td></tr>
	<?php } ?>
	</tbody>
</table>
<?php }

if($row['sumber_nilai']<>1 && isset($rowsrealisasi1)){ 
if($row['sumber_nilai']==3){ ?>
	<BR/>
	<h5><b>REALISASI DILUAR PERENCANAAN</b></h5>
<?php }else{ ?>
	<BR/>
	<h5><b>REALISASI</b></h5>
<?php } ?>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width="10px">No.</th>
			<th>NAMA</th>
			<th width="130px">TGL</th>
			<th>NILAI SATUAN</th>
			<th>VOL</th>
			<th>SATUAN</th>
			<th>TOTAL NILAI</th>
			<th>KETERANGAN</th>
			<th>LAMPIRAN</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$no=1;
		$total = 0;
		if(count($rowsrealisasi1)){
			foreach($rowsrealisasi1 as $r){ 
				$total+=$r['nilai'];
				?>
		<tr>
			<td align="center"><?=$no++?></td>
			<td><?=$r['nama']?></td>
			<td><?=Eng2Ind($r['tgl'])?></td>
			<td><?=rupiah($r['nilai_satuan'])?></td>
			<td><?=$r['vol']?></td>
			<td><?=$r['satuan']?></td>
			<td style="text-align: right;"><a href="<?=site_url("panelbackend/rab_realisasi/edit/$row[id_rab_detail]/$r[id_realisasi]")?>"><?=rupiah($r['nilai'],2)?></a></td>
			<td><?=$r['keterangan']?></td>
			<td>
				<?php if($filerealisasi[$r['id_realisasi']]){
					$arr=array();
					foreach($filerealisasi[$r['id_realisasi']] as $r1){
						$arr[]="<a href='".site_url("panelbackend/rab_realisasi/open_file/$r1[id]")."' target='_BLANK'>$r1[name]</a>";
					}

					echo implode("<br/>", $arr);
				}?>
			</td>

		</tr>

	<?php }?>
		<tr>
			<td align="center" colspan="6">TOTAL</td>
			<td style="text-align: right;"><?=rupiah($total,2)?></td>
			<td></td>
			<td>
			</td>

		</tr>
	<?php }else{ ?>
		<tr><td colspan="6"><i>Belum ada data</i></td></tr>
	<?php } ?>
	</tbody>
</table>
<?php 
}
if($row['sumber_nilai']!=1){
	echo '<div style="text-align:right"><br/><a href="'.site_url("panelbackend/rab_realisasi/add/$row[$pk]").'" class="btn btn-sm btn-info waves-effect "><span class="glyphicon glyphicon-check"></span> Tambah Realisasi</a></div>';
} ?>
<div style="clear: both;"></div>
<br/>
<?php if($row['sumber_nilai']==1 or $row['sumber_nilai']==3){ if($row['sumber_nilai']<>3){ ?>
<?=UI::getButton("add",null,null,'btn-sm', "Add Sub")?>


<script type="text/javascript">
	function goAdd(){
		        window.location = "<?=base_url("panelbackend/rab_detail/add/$id_rab/$row[id_rab_detail]")?>";
		    }
</script>
<?php } ?>

<div style="float: right;">
	<a target='_BLANK' href="<?=site_url("panelbackend/rab_detail/go_print_detail/$id_rab/$row[id_rab_detail]")?>"><span class="glyphicon glyphicon-print"></span> Print</a>
</div>
<?php } ?>

<style type="text/css">
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
		    padding: 5px !important;
		}
	.pfile{
		display: inline !important;  
	}
</style>