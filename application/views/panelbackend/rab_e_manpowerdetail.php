<div class="col-sm-3">

<?php 
$from = UI::createSelect('id_team_proyek',$mtteamproyekarr,$row['id_team_proyek'],$edited,$class='form-control ',"style='width:100%;'");
echo UI::createFormGroup($from, $rules["id_team_proyek"], "id_team_proyek", "Team Proyek", true);
?>

</div>
<div class="col-sm-3">

<?php 
$from = UI::createSelect('id_jabatan_proyek',$mtjabatanproyekarr,$row['id_jabatan_proyek'],$edited,$class='form-control ',"style='width:100%;'");
echo UI::createFormGroup($from, $rules["id_jabatan_proyek"], "id_jabatan_proyek", "Jabatan Proyek", true);
?>

</div>
<div class="col-sm-3">

<?php 
$from = UI::createSelect('id_sumber_pegawai',$mtsumberpegawaiarr,$row['id_sumber_pegawai'],$edited,$class='form-control ',"style='width:100%;'");
echo UI::createFormGroup($from, $rules["id_sumber_pegawai"], "id_sumber_pegawai", "Sumber Pegawai", true);
?>

</div>
<div class="col-sm-3">

<?php 
$from = UI::createTextNumber('jumlah',$row['jumlah'],'','',$edited,$class='form-control ',"style='display:inline;text-align:right; width:100px' min='0' onchange='goSubmit(\"set_value\")'");
echo UI::createFormGroup($from, $rules["jumlah"], "jumlah", "Jumlah Tenaga Kerja", true);
?>

</div>
<div class="col-sm-12">
				

<?php 
$from = "";
$h=$rowheader1['hmin'];
while($h){
	$k = $h;
	if($k>16)
		$k = 16;

	$from .= "<table class='table table-bordered'><tr>";
	$n=$h;
	for($i=$k; $i>0; $i--){
		$from .= "<th style='text-align:center'>H-".$h."</th>";
		$h--;
	}

	$from .= "</tr><tr>";

	for($i=$k; $i>0; $i--){
		$from .= "<td>".UI::createTextNumber('day[hmin'.$n.']',$row['day']['hmin'.$n],'','',$edited,$class='form-control ',"style='display:inline;text-align:right; width:55px' min='0' max='$row[jumlah]'")."</td>";
		$n--;
	}

	$from .= "</tr></table>";
}
echo UI::createFormGroup($from, $rules["hmin"], "hmin", "Man Days", true);
?>


<?php 
$from = "";
$h=$rowheader1['h'];
$n=1;
$m=1;
while($h){
	$k = $h;
	if($k>16)
		$k = 16;

	$from .= "<table class='table table-bordered'><tr>";
	for($i=1; $i<=$k; $i++){
		$h--;
		$from .= "<th style='text-align:center'>H".$n++."</th>";
	}

	$from .= "</tr><tr>";

	for($i=1; $i<=$k; $i++){
		$jum = $row['day']['h'.$m];
		if(!$jum && !$row['id_manpower'])
			$jum = $row['jumlah'];

		$from .= "<td>".UI::createTextNumber('day[h'.$m.']',$jum,'','',$edited,$class='form-control ',"style='display:inline;text-align:right; width:55px' min='0' max='$row[jumlah]'")."</td>";

		$m++;
	}

	$from .= "</tr></table>";
}

echo UI::createFormGroup($from, $rules["h"], "h", "", true);
?>

<?php 
$from = "";
$h=$rowheader1['hplus'];
$n=1;
$m=1;
while($h){
	$k = $h;
	if($k>16)
		$k = 16;

	$from .= "<table class='table table-bordered'><tr>";
	for($i=1; $i<=$k; $i++){
		$h--;
		$from .= "<th style='text-align:center'>H+".$n++."</th>";
	}

	$from .= "</tr><tr>";

	for($i=1; $i<=$k; $i++)
		$from .= "<td>".UI::createTextNumber('day[hplus'.$m.']',$row['day']['hplus'.$m++],'','',$edited,$class='form-control ',"style='display:inline;text-align:right; width:55px' min='0' max='$row[jumlah]'")."</td>";

	$from .= "</tr></table>";
}
echo UI::createFormGroup($from, $rules["hplus"], "hplus", "", true);
?>

<?php 
echo UI::showButtonMode("save", null, $edited);
?>
</div>

<style type="text/css">
	.table{
		width: auto !important; 
	}
	.table td, .table th{
		padding: 0px !important;
	}
</style>