<div class="col-sm-6">

<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',false,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
?>

<?php 
$from = UI::createUpload("file", $row['file'], $page_ctrl, $edited, "file");
echo UI::createFormGroup($from, $rules["file"], "file", "Template");
?>

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>
<div class="col-sm-6">
<?php
echo  "<b>Agar bisa mengambil data dari aplikasi silahkan tambahkan variabel berikut :</b> <table class='table table-hover'>";
if($row['id_template_doc']=='1'){
	echo  '<tr><td>${tgl_penunjukan}</td><td>untuk mengambil tanggal penunjukan saja tanpa bulan dan tahun</td></tr>';
	echo  '<tr><td>${bln_penunjukan}</td><td>untuk mengambil bulan penunjukan saja tanpa tanggal dan tahun</td></tr>';
	echo  '<tr><td>${no_urut}</td><td>untuk mengambil urutan nomor penunjukan</td></tr>';
	echo  '<tr><td>${abjad}</td><td>untuk mengambil urutan penerbitan surat penunjukan PM jika dalam satu hari lebih dari satu surat yang diterbitkan</td></tr>';
	echo  '<tr><td>${tahun_penunjukan}</td><td>untuk mengambil tahun penunjukan saja tanpa tanggal dan bulan</td></tr>';
	echo  '<tr><td>${nama_pm}</td><td>untuk mengambil nama PM</td></tr>';
	echo  '<tr><td>${nid_pm}</td><td>untuk mengambil NID PM</td></tr>';
	echo  '<tr><td>${jabatan_pm}</td><td>untuk mengambil jabatan PM</td></tr>';
	echo  '<tr><td>${nama_proyek}</td><td>untuk mengambil nama proyek</td></tr>';
	echo  '<tr><td>${nama_customer}</td><td>untuk mengambil nama customer</td></tr>';
	echo  '<tr><td>${lokasi}</td><td>untuk mengambil lokasi proyek</td></tr>';
	echo  '<tr><td>${tgl_mulai}</td><td>untuk mengambil tanggal rencana mulai</td></tr>';
	echo  '<tr><td>${tgl_selesai}</td><td>untuk mengambil tanggal rencana selesai</td></tr>';
	echo  '<tr><td>${tanggal}</td><td>untuk mengambil tanggal penunjukan</td></tr>';
}
if($row['id_template_doc']=='2'){
	echo  '<tr><td>${nama_proyek}</td><td>untuk mengambil nama proyek</td></tr>';
	echo  '<tr><td>${nama_pekerjaan}</td><td>untuk mengambil nama pekerjaan</td></tr>';
	echo  '<tr><td>${nama_pm}</td><td>untuk mengambil nama PM</td></tr>';
	echo  '<tr><td>${nid_pm}</td><td>untuk mengambil NID PM</td></tr>';
	echo  '<tr><td>${jabatan_pm}</td><td>untuk mengambil jabatan PM</td></tr>';
	echo  '<tr><td>${nama_customer}</td><td>untuk mengambil nama customer</td></tr>';
	echo  '<tr><td>${lokasi}</td><td>untuk mengambil lokasi proyek</td></tr>';
	echo  '<tr><td>${tgl_pekerjaan}</td><td>untuk mengambil tanggal pekerjaan</td></tr>';
	echo  '<tr><td>${no_prk}</td><td>untuk mengambil nomor PRK</td></tr>';
}
if($row['id_template_doc']=='3'){
	echo  '<tr><td>${nama_proyek}</td><td>untuk mengambil nama proyek</td></tr>';
	echo  '<tr><td>${nama_pekerjaan}</td><td>untuk mengambil nama pekerjaan</td></tr>';
	echo  '<tr><td>${nama_pm}</td><td>untuk mengambil nama PM</td></tr>';
	echo  '<tr><td>${nid_pm}</td><td>untuk mengambil NID PM</td></tr>';
	echo  '<tr><td>${jabatan_pm}</td><td>untuk mengambil jabatan PM</td></tr>';
	echo  '<tr><td>${nama_customer}</td><td>untuk mengambil nama customer</td></tr>';
	echo  '<tr><td>${lokasi}</td><td>untuk mengambil lokasi proyek</td></tr>';
	echo  '<tr><td>${tgl_mulai}</td><td>untuk mengambil tanggal rencana mulai</td></tr>';
	echo  '<tr><td>${tgl_selesai}</td><td>untuk mengambil tanggal rencana selesai</td></tr>';
	echo  '<tr><td>${tgl_pekerjaan}</td><td>untuk mengambil tanggal pekerjaan</td></tr>';
}
if($row['id_template_doc']=='4'){
	echo  '<tr><td>${no_spmk}</td><td>untuk mengambil nomor SPMK</td></tr>';
	echo  '<tr><td>${tanggal}</td><td>untuk mengambil tanggal saat ini</td></tr>';
	echo  '<tr><td>${nama_suplier}</td><td>untuk mengambil nama suplier</td></tr>';
	echo  '<tr><td>${nama_proyek}</td><td>untuk mengambil nama proyek</td></tr>';
	echo  '<tr><td>${tgl_mulai}</td><td>untuk mengambil tanggal mulai</td></tr>';
	echo  '<tr><td>${nama_pekerjaan}</td><td>untuk mengambil nama pekerjaan</td></tr>';
	echo  '<tr><td>${no_spk}</td><td>untuk mengambil nomor spk</td></tr>';
	echo  '<tr><td>${tgl_spk}</td><td>untuk mengambil tanggal spk</td></tr>';
	echo  '<tr><td>${tgl_mulai}</td><td>untuk mengambil tanggal mulai pekerjaan</td></tr>';
	echo  '<tr><td>${nama_pm}</td><td>untuk mengambil nama PM</td></tr>';
}
echo "</table>";
?>
</div>