<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>

<?php 
$from = UI::createTextBox('posisi',$row['posisi'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["posisi"], "posisi", "Posisi");
?>

<?php 
$from = UI::createSelect('id_status',$mtcustomerstatusarr,$row['id_status'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_status"], "id_status", "Status");
?>

<?php 
$from = UI::createTextBox('tgl_lahir',$row['tgl_lahir'],'10','10',$edited,'form-control datepicker',"style='width:190px'");
echo UI::createFormGroup($from, $rules["tgl_lahir"], "tgl_lahir", "Tgl. Lahir");
?>

<?php 
$from = UI::createTextArea('alamat',$row['alamat'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["alamat"], "alamat", "Alamat");
?>

<?php 
$from = UI::createTextBox('telephone_1',$row['telephone_1'],'20','20',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["telephone_1"], "telephone_1", "Telephone 1");
?>

<?php 
$from = UI::createTextBox('telephone_2',$row['telephone_2'],'20','20',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["telephone_2"], "telephone_2", "Telephone 2");
?>

</div>
<div class="col-sm-6">
				

<?php 
$from = UI::createTextBox('fax',$row['fax'],'20','20',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["fax"], "fax", "FAX");
?>

<?php 
$from = UI::createTextBox('email_1',$row['email_1'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["email_1"], "email_1", "Email 1");
?>

<?php 
$from = UI::createTextBox('email_2',$row['email_2'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["email_2"], "email_2", "Email 2");
?>

<?php 
$from = UI::createTextBox('instagram',$row['instagram'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["instagram"], "instagram", "Instagram");
?>

<?php 
$from = UI::createTextBox('facebook',$row['facebook'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["facebook"], "facebook", "Facebook");
?>

<?php 
$from = UI::createTextBox('twitter',$row['twitter'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["twitter"], "twitter", "Twitter");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>