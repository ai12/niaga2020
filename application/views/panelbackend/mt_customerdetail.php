<div class="col-sm-6">

<?php 
/*$from = UI::createTextBox('cust_no',$row['cust_no'],'24','24',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["cust_no"], "cust_no", "Cust NO");
?>

<?php 
$from = UI::createTextBox('cust_status',$row['cust_status'],'4','4',$edited,'form-control ',"style='width:40px'");
echo UI::createFormGroup($from, $rules["cust_status"], "cust_status", "Cust Status");*/
?>

<?php 
$from = UI::createTextBox('nama',$row['nama'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama Pelanggan");
?>

<?php 
$from = UI::createTextBox('inv_addr_1',$row['inv_addr_1'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_addr_1"], "inv_addr_1", "Alamat Kantor 1");
?>

<?php 
$from = UI::createTextBox('inv_addr_2',$row['inv_addr_2'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_addr_2"], "inv_addr_2", "Alamat Kantor 2");
?>

<?php 
$from = UI::createTextBox('inv_addr_3',$row['inv_addr_3'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_addr_3"], "inv_addr_3", "Alamat Kantor 3");
?>

<?php 
$from = UI::createTextBox('inv_zip',$row['inv_zip'],'40','40',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_zip"], "inv_zip", "Kode Pos Kantor");
?>

<?php 
$from = UI::createTextBox('inv_phone',$row['inv_phone'],'64','64',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_phone"], "inv_phone", "Nomor Kontak Kantor");
?>

<?php 
$from = UI::createTextBox('inv_contact',$row['inv_contact'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_contact"], "inv_contact", "Nama Kontak Kantor");
?>

<?php 
$from = UI::createTextBox('inv_state',$row['inv_state'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["inv_state"], "inv_state", "Propinsi");
?>

<?php 
$from = UI::createTextBox('inv_fax_no',$row['inv_fax_no'],'64','64',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_fax_no"], "inv_fax_no", "Nomor Fax");
?>

<?php 
$from = UI::createTextArea('email_address',$row['email_address'],'','',$edited,'form-control',"");
echo UI::createFormGroup($from, $rules["email_address"], "email_address", "Alamat Email");
?>

<?php 
/*$from = UI::createTextBox('inv_tlx_name',$row['inv_tlx_name'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_tlx_name"], "inv_tlx_name", "INV TLX Name");
?>

<?php 
$from = UI::createTextBox('inv_tlx_no',$row['inv_tlx_no'],'88','88',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["inv_tlx_no"], "inv_tlx_no", "INV TLX NO");*/
?>

<?php 
/*$from = UI::createTextBox('deliv_tlx_name',$row['deliv_tlx_name'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_tlx_name"], "deliv_tlx_name", "Deliv TLX Name");
?>

<?php 
$from = UI::createTextBox('deliv_tlx_no',$row['deliv_tlx_no'],'88','88',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_tlx_no"], "deliv_tlx_no", "Deliv TLX NO");*/
?>

</div>
<div class="col-sm-6">

<?php 
$from = UI::createTextBox('deliv_name',$row['deliv_name'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_name"], "deliv_name", "Nama Tujuan Pengiriman");
?>

<?php 
$from = UI::createTextBox('deliv_addr_1',$row['deliv_addr_1'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_addr_1"], "deliv_addr_1", "Alamat Pengiriman 1");
?>

<?php 
$from = UI::createTextBox('deliv_addr_2',$row['deliv_addr_2'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_addr_2"], "deliv_addr_2", "Alamat Pengiriman 2");
?>

<?php 
$from = UI::createTextBox('deliv_addr_3',$row['deliv_addr_3'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_addr_3"], "deliv_addr_3", "Alamat Pengiriman 3");
?>

<?php 
$from = UI::createTextBox('deliv_zip',$row['deliv_zip'],'40','40',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_zip"], "deliv_zip", "Kode Pos Pengiriman");
?>

<?php 
$from = UI::createTextBox('deliv_phone',$row['deliv_phone'],'64','64',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_phone"], "deliv_phone", "Nomor Kontak Pengiriman");
?>

<?php 
$from = UI::createTextBox('deliv_contact',$row['deliv_contact'],'128','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_contact"], "deliv_contact", "Nama Kontak Pengiriman");
?>

<?php 
$from = UI::createTextBox('deliv_state',$row['deliv_state'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["deliv_state"], "deliv_state", "Propinsi Pengiriman");
?>
				

<?php 
$from = UI::createTextBox('deliv_fax_no',$row['deliv_fax_no'],'64','64',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["deliv_fax_no"], "deliv_fax_no", "Nomor Fax Pengiriman");
?>

<?php /*
$from = UI::createTextBox('cust_typex1',$row['cust_typex1'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex1"], "cust_typex1", "Cust Typex1");
?>

<?php 
$from = UI::createTextBox('cust_typex2',$row['cust_typex2'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex2"], "cust_typex2", "Cust Typex2");
?>

<?php 
$from = UI::createTextBox('cust_typex3',$row['cust_typex3'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex3"], "cust_typex3", "Cust Typex3");
?>

<?php 
$from = UI::createTextBox('cust_typex4',$row['cust_typex4'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex4"], "cust_typex4", "Cust Typex4");
?>

<?php 
$from = UI::createTextBox('cust_typex5',$row['cust_typex5'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex5"], "cust_typex5", "Cust Typex5");
?>

<?php 
$from = UI::createTextBox('cust_typex6',$row['cust_typex6'],'8','8',$edited,'form-control ',"style='width:80px'");
echo UI::createFormGroup($from, $rules["cust_typex6"], "cust_typex6", "Cust Typex6");
?>

<?php 
$from = UI::createTextBox('currency_type',$row['currency_type'],'16','16',$edited,'form-control ',"style='width:160px'");
echo UI::createFormGroup($from, $rules["currency_type"], "currency_type", "Currency Type");
?>

<?php 
$from = UI::createTextBox('country_code',$row['country_code'],'12','12',$edited,'form-control ',"style='width:120px'");
echo UI::createFormGroup($from, $rules["country_code"], "country_code", "Country Code");
?>

<?php 
$from = UI::createTextBox('linked_cust_no',$row['linked_cust_no'],'24','24',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["linked_cust_no"], "linked_cust_no", "Linked Cust NO");
?>

<?php 
$from = UI::createTextBox('linked_supp_no',$row['linked_supp_no'],'24','24',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["linked_supp_no"], "linked_supp_no", "Linked Supp NO");
?>

<?php 
$from = UI::createTextBox('cash_dstrct_code',$row['cash_dstrct_code'],'16','16',$edited,'form-control ',"style='width:160px'");
echo UI::createFormGroup($from, $rules["cash_dstrct_code"], "cash_dstrct_code", "Cash Dstrct Code");*/
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>