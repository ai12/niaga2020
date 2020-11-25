<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>
<?php
$i=1;
foreach($mtzonasppdarr as $key=>$val){
	$from = UI::createTextBox('nilai_komersial['.$key.']',$row['nilai_komersial'][$key],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
	echo UI::createFormGroup($from, $rules["nilai_komersial[$key]"], "nilai_komersial[$key]", "Zona ".$i);
	$from = UI::createTextBox('nilai['.$key.']',$row['nilai'][$key],'10','10',$edited,'form-control rupiah ',"style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
	echo UI::createFormGroup($from, $rules["nilai[$key]"], "nilai[$key]", "Zona ".$i);
	$i++;
}
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>