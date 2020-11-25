<div class="col-sm-6">
<?php 
$from = UI::createUploadMultiple("file___".$id_proyek, $row["file___".$id_proyek], $page_ctrl, $edited, "file___".$id_proyek,"$id_proyek/");
echo UI::createFormGroup($from, $rules["file___".$id_proyek], "file___".$id_proyek, "Berkas Proyek");
?>
</div>

<div class="col-sm-6">
<?php 
if($row['id_proyek_pekerjaan']){
$from = UI::createUploadMultiple("file___".$id_proyek."___".$row['id_proyek_pekerjaan'], $row["file___".$id_proyek."___".$row['id_proyek_pekerjaan']], $page_ctrl, $edited, "file___".$id_proyek."___".$row['id_proyek_pekerjaan']);
echo UI::createFormGroup($from, $rules["file___".$id_proyek."___".$row['id_proyek_pekerjaan']], "file___".$id_proyek."___".$row['id_proyek_pekerjaan'], "Berkas Pekerjaan");
}
?>
</div>