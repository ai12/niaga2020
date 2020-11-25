<div class="col-sm-6">

    <?php
    $from = UI::createTextBox('table_code', $row['table_code'], '200', '100', $edited, 'form-control ', "style='width:100%'");
    echo UI::createFormGroup($from, $rules["table_code"], "table_code", "Kode");

    $from = UI::createTextBox('table_desc', $row['table_desc'], '200', '100', $edited, 'form-control ', "style='width:100%'");
    echo UI::createFormGroup($from, $rules["table_desc"], "table_desc", "Nama");
    ?>

<?php
		$from = UI::createSelect('table_type', $jenisarr, $row['table_type'], $edited, 'form-control ', "style='width:auto; max-width:190px;'");
		echo UI::createFormGroup($from, $rules["table_type"], "table_type", "Jenis");
		?>

</div>
<div class="col-sm-6">


    <?php
    $from = UI::showButtonMode("save", null, $edited);
    echo UI::createFormGroup($from, null, null, null, true);
    ?>
</div>