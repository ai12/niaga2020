<ol class="breadcrumb">
  <li><a href="<?=site_url("panelbackend/rab_a_detail/index/$id_rab")?>">RAB</a></li>
  <?php
  foreach($breadcrumb as $k=>$v){
  	echo '<li><a href="'.site_url("panelbackend/rab_a_detail/detail/$id_rab/$k").'">'.$v.'</a></li>';
  }
  ?>
</ol>

<div class="col-sm-6">
<?php 
$from = UI::createTextBox('uraian',$row['uraian'],'200','100',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["uraian"], "uraian", "Uraian",false,3);
?>


<?php 

$from = UI::createTextBox('no_prk',$row['no_prk'],'20','20',$edited,$class='form-control ',"style='width:200px' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["no_prk"], "no_prk", "No. PRK",false,3);

$from = UI::createSelect('sumber_nilai',$sumbernilaiarr,$row['sumber_nilai'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["sumber_nilai"], "sumber_nilai", "Sumber Nilai",false,3);

if($row['sumber_nilai']=='2'){
	$mtitemarr[''] = 'Kosong';
	$from = UI::createSelect('id_item',$mtitemarr,$row['id_item'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["id_item"], "id_item", "Item Harga",false,3);
	$from = UI::createTextNumber('nilai_satuan',$row['nilai_satuan'],'','',false,$class='form-control ',"style='text-align:right; width:200px' step='any'");
	$from .= "<hr/>";
	echo UI::createFormGroup($from, $rules["nilai_satuan"], "nilai_satuan", "Nilai Satuan",false,3);

}elseif($row['sumber_nilai']=='4'){
	$from = UI::createTextNumber('nilai_satuan',$row['nilai_satuan'],'','',$edited,$class='form-control ',"style='text-align:right; width:200px' step='any'");
	$from .= "<hr/>";
	echo UI::createFormGroup($from, $rules["nilai_satuan"], "nilai_satuan", "Nilai Satuan",false,3);

}elseif($row['sumber_nilai']=='7' or $row['sumber_nilai']=='6' or $row['sumber_nilai']=='8'){
	$from = UI::createTextNumber('nilai_satuan',$row['nilai_satuan'],'','',$edited,$class='form-control ',"style='text-align:right; width:200px' step='any' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["nilai_satuan"], "nilai_satuan", "Nilai Kontrak",false,3);

	$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:100px' step='any' readonly");
	echo UI::createFormGroup($from, $rules["vol"], "vol", "%",false,3);

	$from = UI::createTextNumber('vol',(float)$row['vol']*(float)$row['nilai_satuan'],'','',false,$class='form-control ',"style='text-align:right; width:100px' step='any'");
	echo UI::createFormGroup($from, null, null, "Nilai Asuransi",false,3);

}elseif($row['sumber_nilai']=='5'){
	$from = UI::createCheckBox('is_ppn',1,$row['is_ppn'], "Memakai PPn",$edited,$class='iCheck-helper ',"onclick='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["is_ppn"], "is_ppn",null,false,3);
	$from = UI::createTextNumber('nilai_satuan',$row['nilai_satuan'],'','',false,$class='form-control ',"style='text-align:right; width:200px' step='any'");
	$from .= "<hr/>";
	echo UI::createFormGroup($from, $rules["nilai_satuan"], "nilai_satuan", "Nilai Satuan",false,3);

}elseif($row['sumber_nilai']<>'2'){

	$from = UI::createTextBox('kode_biaya',$row['kode_biaya'],'20','20',$edited,$class='form-control ',"style='width:200px' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["kode_biaya"], "kode_biaya", "Kode Biaya",false,3);

	$from = UI::createSelect('id_pos_anggaran',$mtposanggaranarr,$row['id_pos_anggaran'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["id_pos_anggaran"], "id_pos_anggaran", "Pos Anggaran",false,3);
if($row['sumber_nilai']=='3'){
	$from = UI::createSelect('jasa_material',$jasamaterialarr,$row['jasa_material'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["jasa_material"], "jasa_material", "Jasa/Material",false,3);

	$from = "<table class='table'><thead><tr><th>#</th><th>Scope Of Work</th><th  style='text-align:right'>Vol</th><th>Satuan</th><th  style='text-align:right'>Harga Satuan</th><th style='text-align:right'>Total</th></tr></thead>";
	$no=1;
	foreach($rowsjasa_material as $r){
		$from .= "<tr>
			<td>".$no++."</td>
			<td>".$r['nama']."</td>
			<td style='text-align:right'>".$r['vol']."</td>
			<td>".$r['satuan']."</td>
			<td style='text-align:right'>".rupiah($r['harga_satuan'],2)."</td>
			<td style='text-align:right'>".rupiah($r['total'],2)."</td>
		</tr>";
	}
	if($row['is_ppn']){
		$from .= "<tr>
			<td colspan='5' style='text-align:right'>Sub Total</td>
			<td style='text-align:right'>".rupiah(((float)$row['nilai_satuan']*10/11),2)."</td>
		</tr>";
	}
	$from .= "<tr>
		<td colspan='5' style='text-align:right'>Total</td>
		<td style='text-align:right'>".rupiah($row['nilai_satuan'],2)."</td>
	</tr>";
	echo $from .= "</table>";
}

	$from = UI::createCheckBox('is_ppn',1,$row['is_ppn'], "Memakai PPn",$edited,$class='iCheck-helper ',"onclick='goSubmit(\"set_value\")'");
	$from .= "<hr/>";
	echo UI::createFormGroup($from, $rules["is_ppn"], "is_ppn",null,false,3);
}
?>

<?php 
if($row['sumber_nilai']<>'6' && $row['sumber_nilai']<>'7' && $row['sumber_nilai']<>'8' && $row['sumber_nilai']<>'1'){
	$from = UI::createSelect('sumber_satuan',$sumbersatuanarr,$row['sumber_satuan'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["sumber_satuan"], "sumber_satuan", "Jenis Satuan",false,3);

	if($row['sumber_satuan']=='1'){

		$from = "<div class='col-sm-5 no-padding no-margin'>".
		UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'")
		."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Satuan</label><div class='col-sm-5 no-padding no-margin'>".
		UI::createSelect('satuan',$mtuomarr,$row['satuan'],$edited,'form-control ',"style='width:auto; max-width:100%;'")
		."</div>";
		echo UI::createFormGroup($from, $rules["satuan"], "satuan", "Vol",false,3);

	}

	if($row['sumber_satuan']=='2' or $row['sumber_satuan']=='3'){
		$from = "";
		foreach ($mtsumberpegawaiarr as $key => $value) {
			if($i)
				$from .= "<br/>";

			$from .= UI::createCheckBox("id_sumber_pegawai[$key]",$key,$row['id_sumber_pegawai'][$key],$value,$edited,'',"onclick='goSubmit(\"set_value\")'");
			$i++;
		}
		echo UI::createFormGroup($from, $rules["id_sumber_pegawai"], "id_sumber_pegawai", "Sumber Pegawai",false,3);

		$from = "";
		foreach ($jabatanarr as $key => $value) {
			if($i)
				$from .= "<br/>";

			$from .= UI::createCheckBox("id_jabatan_proyek[$key]",$key,$row['id_jabatan_proyek'][$key],$value,$edited,'',"onclick='goSubmit(\"set_value\")'");
			$i++;
		}
		echo UI::createFormGroup($from, $rules["id_jabatan_proyek[]"], "id_jabatan_proyek[]", "Jabatan Proyek",false,3);

		if($row['sumber_satuan']=='2'){

			$from = UI::createSelect('jenis_mandays',$jenismandaysarr,$row['jenis_mandays'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
			echo UI::createFormGroup($from, $rules["jenis_mandays"], "jenis_mandays", "Jenis Mandays",false,3);

			if($row['jenis_mandays']==1 or $row['jenis_mandays']===null){

				$from = "<div class='col-sm-3 no-padding no-margin'>".
				UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'")
				."</div><label class='col-sm-1 control-label' style='padding-left: 0px;'>Day</label><div class='col-sm-3 no-padding no-margin'>".
				UI::createTextNumber('day',($row['day']===null?1:$row['day']),'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'")
				."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Satuan</label><div class='col-sm-3 no-padding no-margin'>".
				UI::createTextBox('satuan',($row['satuan']===null?'MD':$row['satuan']),'20','20',$edited,$class='form-control ',"style='width:100%'")
				."</div>";
				echo UI::createFormGroup($from, $rules["vol"], "vol", "Man",false,3);
			}else{

				$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'");
				echo UI::createFormGroup($from, $rules["vol"], "vol", "Mandays",false,3);
			}
		}else{
			$from = UI::createTextNumber('pembagi',$row['pembagi'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any' onchange='goSubmit(\"set_value\")'");
			echo UI::createFormGroup($from, $rules["pembagi"], "pembagi", "Per Unit",false,3);
			$from = UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='text-align:right; width:80px' step='any'");
			echo UI::createFormGroup($from, $rules["vol"], "vol", "Unit Day",false,3);
		}
	}
}else{

}
?>
</div>
<div class="col-sm-6">

<?php 
$from = UI::createTextArea('keterangan',$row['keterangan'],'','',$edited,$class='form-control',"");
echo UI::createFormGroup($from, $rules["keterangan"], "keterangan", "Keterangan",false,3);

?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from,null,null,null,false,3);
?>
</div>