<div class="col-sm-6">

    <?php
    $from = UI::createTextBox('kode', $row['kode'], '200', '100', $edited, 'form-control ', "style='width:100%'");
    echo UI::createFormGroup($from, $rules["kode"], "kode", "Kode");

    $from = UI::createTextBox('nama', $row['nama'], '200', '100', $edited, 'form-control ', "style='width:100%'");
    echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama");
    ?>
<?php
	$from = UI::createTextArea('keterangan', $row['keterangan'], '', '', $edited, 'form-control', "");
	echo UI::createFormGroup($from, $rules["keterangan"], "keterangan", "Keterangan");
	?>

<div class="col-sm-6">


    <?php
    $from = UI::showButtonMode("save", null, $edited);
    echo UI::createFormGroup($from, null, null, null, true);
    ?>
</div>