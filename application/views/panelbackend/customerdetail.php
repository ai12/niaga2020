<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>

<?php 
$from = UI::createTextBox('pemilik',$row['pemilik'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["pemilik"], "pemilik", "Pemilik");
?>

<?php 
$from = UI::createTextBox('tgl_berdiri',$row['tgl_berdiri'],'10','10',$edited,'form-control datepicker',"style='width:100px'");
echo UI::createFormGroup($from, $rules["tgl_berdiri"], "tgl_berdiri", "Tgl. Berdiri");
?>

<?php 
$from = UI::createTextBox('industri',$row['industri'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["industri"], "industri", "Industri");
?>

<?php 
$from = UI::createSelect('id_kategori',$mtcustomerkategoriarr,$row['id_kategori'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_kategori"], "id_kategori", "Kategori");
?>

<?php 
$from = UI::createSelect('id_type',$mtcustomertypearr,$row['id_type'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["id_type"], "id_type", "Type");
?>

<?php 
$from = UI::createTextBox('website',$row['website'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["website"], "website", "Website");
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
$from = UI::createTextArea('alamat',$row['alamat'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["alamat"], "alamat", "Alamat");
?>

<?php 
$from = UI::createTextBox('kota',$row['kota'],'20','20',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["kota"], "kota", "Kota");
?>

<?php 
$from = UI::createTextBox('kode_pos',$row['kode_pos'],'20','20',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["kode_pos"], "kode_pos", "Kode POS");
?>

<?php 
$from = UI::createTextBox('negara',$row['negara'],'100','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["negara"], "negara", "Negara");
?>

<?php 
$from = UI::createTextArea('deskripsi',$row['deskripsi'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Deskripsi");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>