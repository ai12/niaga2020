<div class="row">

<div class="col-sm-6">

<?php 

$from = UI::createTextArea('nama_pekerjaan',$row['nama_pekerjaan'],'2','',$edited,$class='form-control ');
echo UI::createFormGroup($from, $rules["nama_pekerjaan"], "nama_pekerjaan", "Deskripsi Pekerjaan");
?>

<?php 
$from = "<div class='col-sm-6 no-padding no-margin'>".
UI::createTextBox('no_prk',$row['no_prk'],'200','20',$edited,$class='form-control ',"style='width:200px'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Tgl.</label><div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_prk',$row['tgl_prk'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["no_prk"], "no_prk", "No. PRK");
?>

<?php 
$from = UI::createSelect('id_tipe_pekerjaan',$mttipepekerjaanarr,$row['id_tipe_pekerjaan'],$edited,$class='form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_tipe_pekerjaan"], "id_tipe_pekerjaan", "Tipe Pekerjaan");
?>

<?php 
$from = "<div class='col-sm-6 no-padding no-margin'>".
UI::createTextBox('no_pekerjaan',$row['no_pekerjaan'],'200','20',$edited,$class='form-control ',"style='width:100%'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Tgl.</label><div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_pekerjaan',$row['tgl_pekerjaan'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["no_pekerjaan"], "no_pekerjaan", "No. SP3");
?>

<?php 
$from = "<div class='col-sm-6 no-padding no-margin'>".
UI::createTextBox('no_kontrak',$row['no_kontrak'],'200','20',$edited,$class='form-control ',"style='width:100%'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Tgl.</label><div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_kontrak',$row['tgl_kontrak'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["no_kontrak"], "no_kontrak", "No. Kontrak");
?>		

<?php 
$from = "<div class='col-sm-6 no-padding no-margin'>".
UI::createTextNumber('nilai_hpp',$row['nilai_hpp'],'','',$edited,$class='form-control ',"style='text-align:right; width:200px'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>Tgl.</label><div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_hpp',$row['tgl_hpp'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["nilai_hpp"], "nilai_hpp", "Nilai HPP");
?>

</div>
<div class="col-sm-6">

<?php 
$from = "<div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_mulai_pelaksanaan',$row['tgl_mulai_pelaksanaan'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div><label class='col-sm-2 control-label' style='padding-left: 0px;'>sd</label><div class='col-sm-4 no-padding no-margin'>".
UI::createTextBox('tgl_selesai_pelaksanaan',$row['tgl_selesai_pelaksanaan'],'10','10',$edited,$class='form-control datepicker',"style='width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["tgl_mulai_pelaksanaan"], "tgl_mulai_pelaksanaan", "Tgl. Pekerjaan");
?>

<?php 
$from = "<label class='col-sm-1 control-label' style='padding-left: 0px; '>H-</label><div class='col-sm-2 no-padding no-margin'>".
UI::createTextNumber('hmin',$row['hmin'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%'")
."</div><label class='col-sm-1 control-label' style='padding-left: 2px; '>H</label><div class='col-sm-2 no-padding no-margin'>".
UI::createTextNumber('h',$row['h'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%'")
."</div><label class='col-sm-1 control-label' style='padding-left: 2px; '>H+</label><div class='col-sm-2 no-padding no-margin'>".
UI::createTextNumber('hplus',$row['hplus'],'','',$edited,$class='form-control ',"style='text-align:right; width:100%'")
."</div>";
echo UI::createFormGroup($from, $rules["hmin"], "hmin", "Jumlah Hari");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>

<?php if($edited){ ?>
	<script type="text/javascript">
		$('#tgl_mulai_pelaksanaan').on('dp.change', function(e){
			datediffpelaksanaan();
		});

		$('#tgl_selesai_pelaksanaan').on('dp.change', function(e){
			datediffpelaksanaan();
		});

		$(function(){
			datediffpelaksanaan();
		})

		function datediffpelaksanaan(){
			var start = new Date(Eng2Ind($("#tgl_mulai_pelaksanaan").val())),
		    end   = new Date(Eng2Ind($("#tgl_selesai_pelaksanaan").val())),
		    diff  = new Date(end - start),
		    days  = diff/1000/60/60/24;
		    $("#h").val(days+1);
		}
	</script>
<?php } ?>