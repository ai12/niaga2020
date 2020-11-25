<div class="col-sm-6">

<?php 

$from = UI::createSelect('jasa_material',$jasamaterialarr,$row['jasa_material'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["jasa_material"], "jasa_material", "Jasa/Material");

$mtitemarr[''] = 'Kosong';
$from = UI::createSelect('id_item',$mtitemarr,$row['id_item'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["id_item"], "id_item", "Item Harga");

$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Jasa/Material");
?>

<?php 
$from = UI::createTextArea('keterangan',$row['keterangan'],'','',$edited,$class='form-control',"");
echo UI::createFormGroup($from, $rules["keterangan"], "keterangan", "Keterangan");

/*if($row['jasa_material']=='1'){
	$from = UI::createSelect('jenis_jasa',$jenisjasaarr,$row['jenis_jasa'],$edited,$class='form-control ',"style='width:auto; max-width:100%;' onchange='goSubmit(\"set_value\")'");
	echo UI::createFormGroup($from, $rules["jenis_jasa"], "jenis_jasa", "Jenis Jasa");
}*/


$from = UI::createSelect('id_pos_anggaran',$mtposanggaranarr,$row['id_pos_anggaran'],$edited,$class='form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_pos_anggaran"], "id_pos_anggaran", "Pos Anggaran");
?>

<?php 
$from = UI::createTextBox('kode_biaya',$row['kode_biaya'],'20','20',$edited,$class='form-control ',"style='width:100px'");
echo UI::createFormGroup($from, $rules["kode_biaya"], "kode_biaya", "Kode Biaya");
?>

</div>
<div class="col-sm-6">
				

<?php 
/*if($row['jasa_material']=='2' or $row['jasa_material']=='3' or $row['jenis_jasa']=='2'){*/
$from = "<div class='col-sm-5 no-padding no-margin'>".
UI::createTextNumber('vol',$row['vol'],'','',$edited,$class='form-control ',"style='width:100%'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Satuan</label><div class='col-sm-5 no-padding no-margin'>".
UI::createSelect('satuan',$mtuomarr,$row['satuan'],$edited,'form-control ',"style='width:auto; max-width:100%;'")
."</div>";

echo UI::createFormGroup($from, $rules["vol"], "vol", "Vol");

$from = UI::createTextNumber('harga_satuan',$row['harga_satuan'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%' step='any'");
echo UI::createFormGroup($from, $rules["harga_satuan"], "harga_satuan", "Harga Satuan");


$from = "";
if($rows){
	foreach($rows as $r){
		if($r['id_scope_parent']){
			$from .= UI::createCheckBox("id_scope[$r[id_scope]]",$r['id_scope'],$row['id_scope'][$r['id_scope']], $r['equipment'],$edited,$class='iCheck-helper ');
		}else{
			$from .= "<b>".$r['equipment']."</b>";
		}
		$from .= "<br/>";
	}
}
echo UI::createFormGroup($from, $rules["id_scope"], "id_scope", "Scope");
?>


<?php 
$from = UI::createUploadMultiple("file", $row['file'], $page_ctrl, $edited, "file");
echo UI::createFormGroup($from, $rules["file"], "file", "Lampiran");
?>
<?php 
/*}*/
?>
<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>