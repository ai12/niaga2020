<br/>
<div>
<div class="col-sm-4">
<?php 
if($row['uraian_parent']){ ?>
<b><u><?=$row['uraian_parent']?></u></b><br/><br/>
<?php unset($sumbernilaiarr['1']); } 
if($row['sumber_nilai']==3)
	unset($sumbersatuanarr[4]);
?>
<?php 
$from = UI::createTextArea('uraian',$row['uraian'],'','',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["uraian"], "uraian", "Uraian",true);
$from = UI::createSelect('sumber_nilai',$sumbernilaiarr,$row['sumber_nilai'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["sumber_nilai"], "sumber_nilai", "Sumber Harga",true);
?>

<?php 
if($row['sumber_nilai']<>'1'){

	if($row['sumber_nilai']<>'5'){
		if($row['sumber_nilai']=='2'){
			$from = UI::createSelect('id_harga_sppd',$hargaarr,$row['id_harga_sppd'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
			echo UI::createFormGroup($from, $rules["id_harga_sppd"], "id_harga_sppd", "Jenis SPPD",true);
		}

		if(($row['sumber_nilai']<>'3' or $row['sumber_satuan']<>'4') or $row['id_niaga_komersial_parent']){
			$addstr = "";
			if($row['sumber_nilai']=='3')
				$addstr = "readonly";

			$from = UI::createTextNumber('nilai_satuan',$row['nilai_satuan'],'','',$edited,$class='form-control ',"style='text-align:right; width:200px' step='any' $addstr");
			echo UI::createFormGroup($from, $rules["nilai_satuan"], "nilai_satuan", "Harga Satuan",true);
		}

		$from = UI::createSelect('sumber_satuan',$sumbersatuanarr,$row['sumber_satuan'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
		echo UI::createFormGroup($from, $rules["sumber_satuan"], "sumber_satuan", "Sumber Volume",true);
	}

	if($row['sumber_satuan']=='2' or $row['sumber_satuan']=='3'){
		$from = "";
		foreach ($mtsumberpegawaiarr as $key => $value) {
			if($i)
				$from .= "<br/>";

			$from .= UI::createCheckBox("id_sumber_pegawai[$key]",$key,$row['id_sumber_pegawai'][$key],$value,$edited,'',"onclick='goSubmit(\"set_value\")'");
			$i++;
		}
		echo UI::createFormGroup($from, $rules["id_sumber_pegawai"], "id_sumber_pegawai", "Sumber Pegawai",true);

		$from = "";
		foreach ($jabatanarr as $key => $value) {
			$from .= UI::createCheckBox("id_jabatan_proyek[$key]",$key,$row['id_jabatan_proyek'][$key],$value,$edited,'',"onclick='goSubmit(\"set_value\")'");
			if($i)
				$from .= "<br/>";
			$i++;
		}
		echo UI::createFormGroup($from, $rules["id_jabatan_proyek[]"], "id_jabatan_proyek[]", "Jabatan Proyek",true);

		if($row['sumber_satuan']=='2'){

			$from = UI::createSelect('jenis_mandays',$jenismandaysarr,$row['jenis_mandays'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
			echo UI::createFormGroup($from, $rules["jenis_mandays"], "jenis_mandays", "Jenis Mandays",true);

			if($row['jenis_mandays']==1 or $row['jenis_mandays']===null){

				echo "<div class='col-sm-4 no-padding no-margin'>";
				$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'");
				echo UI::createFormGroup($from, $rules["vol"], "vol", "Man",true);
				echo "</div>";
				echo "<div class='col-sm-4 no-padding no-margin'>";
				$from = UI::createTextNumber('day',($row['day']===null?1:$row['day']),'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'");
				echo UI::createFormGroup($from, $rules["day"], "day", "Day",true);
				echo "</div>";
				echo "<div class='col-sm-4 no-padding no-margin'>";
				$from = UI::createTextBox('satuan',($row['satuan']===null?'MD':$row['satuan']),'20','20',$edited,$class='form-control ',"style='width:100%'");
				echo UI::createFormGroup($from, $rules["satuan"], "satuan", "Satuan",true);
				echo "</div>";
			}else{

				$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'");
				echo UI::createFormGroup($from, $rules["vol"], "vol", "Mandays",true);
			}
		}else{
			$from = UI::createTextNumber('pembagi',$row['pembagi'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any' onchange='goSubmit(\"set_value\")'");
			echo UI::createFormGroup($from, $rules["pembagi"], "pembagi", "Per Unit",true);
			$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'");
			echo UI::createFormGroup($from, $rules["vol"], "vol", "Unit Day",true);
		}
	}elseif($row['sumber_nilai']=='5'){
		$from = "";
		foreach ($mtsumberpegawaiarr as $key => $value) {
			if($i)
				$from .= "<br/>";

			$from .= UI::createCheckBox("id_sumber_pegawai[$key]",$key,$row['id_sumber_pegawai'][$key],$value,$edited,'',"onclick='goSubmit(\"set_value\")'");
			$i++;
		}
		echo UI::createFormGroup($from, $rules["id_sumber_pegawai"], "id_sumber_pegawai", "Sumber Pegawai",true);
	}elseif(($row['sumber_nilai']<>'3' or $row['sumber_satuan']<>'4') or $row['id_niaga_komersial_parent']){
		$addstr = "";
		if($row['sumber_satuan']=='4'){
			$addstr = "readonly";
			if(!$row['satuan'])
				$row['satuan'] = 'Lot';
		}
		echo "<div class='col-xs-6 no-padding no-margin'>";
		$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any' $addstr");
		echo UI::createFormGroup($from, $rules["vol"], "vol", "Volume",true);
		echo "</div><div class='col-xs-6 no-padding no-margin'>";
		$from = UI::createTextBox('satuan',$row['satuan'],'20','20',$edited,$class='form-control ',"style='width:100%'");
		echo UI::createFormGroup($from, $rules["satuan"], "satuan", "Satuan",true);
		echo "</div>";
		echo "<div style='clear:both'>";
		echo "</div>";
	}
}
/*if($row['sumber_nilai']<>'1'){
	$from = UI::createCheckBox("is_add_ppn",1,$row['is_add_ppn'],null,$edited);
	echo UI::createFormGroup($from, $rules["is_add_ppn"], "is_add_ppn", "Tambah PPN",true);
}*/
$from = UI::createTextNumber('addjustment',$row['addjustment'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'");
echo UI::createFormGroup($from, $rules["addjustment"], "addjustment", "Addjustment",true);
$from = UI::createTextNumber('pembulatan',$row['pembulatan'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'")."<small>Jumlah digit 0 dari belakang</small>";
echo UI::createFormGroup($from, $rules["pembulatan"], "pembulatan", "Pembulatan",true);
?>
</div>
<div class="col-sm-8">

<?php 
if($row['sumber_satuan']=='4' or $row['sumber_nilai']=='3'){

	if(!is_array($row['id_rab_detail']))
		$row['id_rab_detail'] = array($row['id_rab_detail']=>$row['id_rab_detail']);

	echo "<b>RAB RESPLAN :</b><br/>";
	echo "<table class='table table-hover  tree-table' id='tbrab'>";
	foreach ($rowsrab as $r) {

		echo "<tr data-tt-id='$r[id_rab_detail]' data-tt-parent-id='$r[id_rab_detail_parent]'><td>";

		if($r['sumber_nilai']==1 or !$r['sumber_nilai']){
			echo $r['uraian'];
			echo "</td><td></td><td></td>";
		}
		elseif($row['sumber_satuan']=='4'){
			echo UI::createCheckBox("id_rab_detail[".$r['id_rab_detail']."]",$r['id_rab_detail'],$row['id_rab_detail'][$r['id_rab_detail']],$r['uraian'],$edited,'','onclick="calrab('.$r['id_rab_detail'].')"',false);

			if(($r['vol'] && $r['nilai_satuan']) or $r['sumber_nilai']=='3')
				echo "</td><td style='text-align:right' data-vol='{$r['vol']}' class='vol'>".$r['vol']."&nbsp;".$r['satuan']."</td><td style='text-align:right' data-nilai='{$r['nilai_satuan']}' class='nilai_satuan'>".rupiah($r['nilai_satuan'])."</td>";
			else
				echo "</td><td data-vol='0' class='vol'></td><td data-nilai='0' class='nilai_satuan'></td>";
		}
		elseif($row['sumber_nilai']=='3'){
			echo '<label for="id_rab_detail'.$r['id_rab_detail'].'"><input type="radio" name="id_rab_detail" id="id_rab_detail'.$r['id_rab_detail'].'" value="'.$r['id_rab_detail'].'"'.($row['id_rab_detail'][$r['id_rab_detail']] ? ' checked' : '').' onclick="calrab('.$r['id_rab_detail'].')">&nbsp;';
			echo "<span style='font-weight:normal !important'>".$r['uraian']."</span>".'</label>';

			if(($r['vol'] && $r['nilai_satuan']) or $r['sumber_nilai']=='3')
				echo "</td><td style='text-align:right' data-vol='{$r['vol']}' class='vol'>".$r['vol']."&nbsp;".$r['satuan']."</td><td style='text-align:right' data-nilai='{$r['nilai_satuan']}' class='nilai_satuan'>".rupiah($r['nilai_satuan'])."</td>";
			else
				echo "</td><td data-vol='0' class='vol'></td><td data-nilai='0' class='nilai_satuan'></td>";
		}
		echo "</tr>";

		$jm = $jasa_materialarr[$r['id_pos_anggaran']][$r['jasa_material']][$r['kode_biaya']];
		if($r['sumber_nilai']=='3' and $jm){
			foreach($jm as $r1){
				echo "<tr data-tt-id='$r[id_rab_detail]$r1[id_jasa_material]' data-tt-parent-id='$r[id_rab_detail]'><td>";
				echo $r1['nama'];
				echo "</td><td style='text-align:right' data-vol='{$r['vol']}' class='vol'>".$r1['vol']."&nbsp;".$r1['satuan']."</td><td style='text-align:right' data-nilai='{$r1['harga_satuan']}' class='nilai_satuan'>".rupiah($r1['harga_satuan'])."</td>";
				echo "</td></tr>";
			}
		}
	}

echo "</table><br/><br/>";
$rabparentarr = array();
if($rowsrab)
foreach($rowsrab as $r){
	$rabparentarr[$r['id_rab_detail']] = $r['id_rab_detail_parent'];
}
?>
<link href="<?=base_url()?>assets/css/jquery.treetable.theme.default.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/jquery.treetable.css" rel="stylesheet">
<script src="<?=base_url()?>assets/js/jquery.treetable.js"></script>
<script type="text/javascript">
	$(function(){
		$('.tree-table').treetable('collapseAll');

		<?php 
		if(is_array($row['id_rab_detail']))
		foreach($row['id_rab_detail'] as $k=>$id){
			$l = true;
			while($l){ 
			if($rabparentarr[$id]){
				$id = $rabparentarr[$id]; 
			?>
				var el = $("tr[data-tt-id*='<?=$id?>'] a[title*='Expand']");
				if(el!=undefined)
					el.click();
			<?php
				} else
					$l = false;
			} 
		}?>
	});

	function calrab(id){
		<?php 
		if($row['id_niaga_komersial_parent'] && $row['sumber_satuan']=='4' && $row['sumber_nilai']=='3'){ ?>

			var vol = 0;
			var nilai = 0;

			$("#tbrab input:checked").parents("tr").each(function(){
				var v = $(this).children("td.vol").attr("data-vol");
				var n = $(this).children("td.nilai_satuan").attr("data-nilai");
				v = parseFloat(v);
				if(v){
					vol += v;

					n = parseFloat(n);
					if(n){
						nilai += n*v;
					}
				}
			});

			$('#vol').val(vol);
			$('#nilai_satuan').val(nilai/vol);

		<?php }else{
		if($row['sumber_satuan']=='4' && $row['sumber_nilai']!='3'){ ?>
			var vol = 0;

			$("#tbrab input:checked").parents("tr").each(function(){
				var t = $(this).children("td.vol").attr("data-vol");
				if(t)
					vol += parseFloat(t);
			});

			$('#vol').val(vol);
		<?php } ?>

		<?php if($row['sumber_nilai']=='3' && $row['sumber_satuan']!='4'){ ?>
			var nilai_satuan = $("tr[data-tt-id*='"+id+"'] td.nilai_satuan").attr("data-nilai");

			$('#nilai_satuan').val(nilai_satuan);
		<?php } } ?>
	}
</script>
<?php
}

echo UI::showButtonMode("save", null, $edited);
?>
</div>
</div>