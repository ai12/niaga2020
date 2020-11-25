<div class="col-sm-6">
<?php
	$from = UI::createTextHidden('id_kontrak', $rowheader['id_kontrak']);
	echo $from;
	?>
	<?php
	$nama = ($parent!='')?$parent:$row['nama'];
	$readonly = ($parent!='')?false:$edited;
	$from = UI::createTextBox('nama',urldecode($nama), '200', '100', $readonly, 'form-control ', "style='width:80%' ");
    echo UI::createFormGroup($from, $rules["nama"], "nama", "Tahapan Kontrak");
    if(!$readonly){
        echo '<input type="hidden" name="nama" value="'.$nama.'">';
    }
	?>
	<?php
	$from = UI::createTextBox('item_kontrak', $row['item_kontrak'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["item_kontrak"], "item_kontrak", "Item Kontrak");
	?>
	<?php
	$from = UI::createTextNumber('jml_personil', $row['jml_personil'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1' onChange='hitungUlang()'");
	echo UI::createFormGroup($from, $rules["jml_personil"], "jml_personil", "Jml Item");
	?>
	<?php 
	$from = UI::createTextBox('satuan', $row['satuan'], '200', '100', $edited, 'form-control ', "style='width:30%'");
	echo UI::createFormGroup($from, $rules["satuan"], "satuan", "Satuan");
	?>
	<?php 
	$from = UI::createTextBox('harga_personil',$row['harga_personil'],'10','10',$edited,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1' onChange='hitungUlang()'");
	echo UI::createFormGroup($from, $rules["harga_personil"], "harga_personil", "Harga Satuan");
	?>
	<?php 
	$from = UI::createTextBox('harga_kontrak',$row['harga_kontrak'],'10','10',false,'form-control rupiah',"style='text-align:right; width:190px' min='0' step='1' ");
	echo UI::createFormGroup($from, $rules["harga_kontrak"], "harga_kontrak", "Total Nilai Satuan");
	?>

	<?php
	// $from = UI::createUpload("cara_penagihan", $row['cara_penagihan'], "panelbackend/t_negosiasi", $edited, "cara_penagihan");
	// echo UI::createFormGroup($from, $rules["cara_penagihan"], "cara_penagihan", "SLA");	
	?>
	<?php
	$from = UI::createUpload("file", $row['file'], "panelbackend/t_kontrak_nilai", $readonly, "file");
	echo UI::createFormGroup($from, $rules["file"], "lampiran", "SLA");	
	?>
	<?php
	$from = UI::createTextArea('deskripsi', $row['deskripsi'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["deskripsi"], "deskripsi", "Catatan");
	?>
	<?php
	$from = UI::createSelect('status', $statusarr, $row['status'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
	echo UI::createFormGroup($from, $rules["status"], "status", "Status");
	?>
</div>
<div class="col-sm-6">


	<?php
	$from = UI::showButtonMode("save", null, $edited);
	echo UI::createFormGroup($from, null, null, null, true);
	?>
</div>
<script>
	function hitungUlang()
	{
		
		var jml = $('#jml_personil').val();
		var harga_satuan = $('#harga_personil').val();
	

		var total_satuan = jml*parseInt(harga_satuan);
		$('#info_harga_kontrak').text(total_satuan);
	}
</script>