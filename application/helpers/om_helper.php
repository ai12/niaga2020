<?php

function up($str)
{
	return strtoupper($str);
}

function required_sign()
{
	return '<span style="color:red">*</span>';
}

function formatRp($number)
{
	return number_format($number, 0, '.', ',');
}

function linkToAdd($link, $label = 'Tambah', $attr = '')
{
	$attr = ($attr == '') ? 'class="btn waves-effect btn-sm btn-primary"' : $attr;
	$btn = "<a href='$link' id='btnAdd' $attr ><span class='glyphicon glyphicon-plus'></span>$label</a>";
	return $btn;
}
function linkToBack($link, $label = 'Back', $attr = '')
{
	$attr = ($attr == '') ? 'class="btn waves-effect btn-sm btn-default"' : $attr;
	$btn = "<a href='$link' id='btnAdd' $attr ><span class='glyphicon glyphicon-arrow-left'></span> $label</a>";
	return $btn;
}

function linkToActionList($id = null, $modul = '')
{
	$btn = ' <div class="btn-group">
				<a href="#" type="button" class="" data-toggle="dropdown">
				<span class="glyphicon glyphicon-option-vertical"></span></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li><a href="' . base_url() . 'om/' . $modul . '/form/' . $id . '"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>
				<li><a href="#" onClick="deleteData(\''.$id.'\')"><span class="glyphicon glyphicon-remove"></span>Delete</a></li>
			</ul>
		</div>';
	return $btn;
}

function linkToBtn($label = 'Simpan', $attr = '')
{
	$attr = ($attr == '') ? 'class="btn-save btn btn-sm btn-success"' : $attr;
	$btn = "<button type='button'  $attr > $label</a>";
	return $btn;
}
function linkToSave($label = 'Simpan', $attr = '')
{
	$attr = ($attr == '') ? 'class="btn-save btn btn-sm btn-success"' : $attr;
	$btn = "<button  id='btnSave' type='submit' $attr ><span class='glyphicon glyphicon-floppy-save'></span> $label</a>";
	return $btn;
}
function linkToReload($label = 'Reload', $attr = '')
{
	$attr = ($attr == '') ? 'class="btn waves-effect btn-sm btn-default"' : $attr;
	$btn = "<button  id='btnReload' type='button' $attr onClick='location.reload()'><span class='glyphicon glyphicon-repeat'></span> $label</a>";
	return $btn;
}

function formInput($name, $value = null, $rw = [], $readonly = false,$class = "")
{
	$width = (isset($rw['width'])) ? $rw['width'] : '300px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . '"';
	if($width == 'auto')
	{
		$attr = '';
	}
	$class= ($class=="")?"form-control":"form-control ".$class;
	$required = ($rw['required'] && !$rw['hidden']) ? 'required="true"' : '';

	if (!$readonly) {

		$inp = "<input type='text' oninvalid=\"this.setCustomValidity('" . $rw['label'] . " tidak boleh kosong')\" oninput=\"setCustomValidity('')\" class='".$class."' id='" . $name . "' name='" . $name . "' value='" . $value . "' $attr $required />";
	} else {
		$inp = ($class=="form-control rupiah")?formatRp($value):$value;
	}
	return $inp;
}
function formInputFile($name, $value = null, $rw = [], $readonly = false,$class = "")
{
	$width = (isset($rw['width'])) ? $rw['width'] : '300px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . '"';
	if($width == 'auto')
	{
		$attr = '';
	}
	$class= ($class=="")?"form-control":"form-control ".$class;
	$required = ($rw['required'] && !$rw['hidden']) ? 'required="true"' : '';

	if (!$readonly) {

		$inp = "<input type='file' oninvalid=\"this.setCustomValidity('" . $rw['label'] . " tidak boleh kosong')\" oninput=\"setCustomValidity('')\" class='".$class."' id='" . $name . "' name='" . $name . "' value='" . $value . "' $attr $required />";
	} else {
		$inp = $value;
	}
	return $inp;
}
function formInputNumber($name, $value = null, $rw = [], $readonly = false,$class="")
{
	$width = (isset($rw['width'])) ? $rw['width'] : '300px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . ';text-align:right"';
	if($width == 'auto')
	{
		$attr = 'style="text-align:right"';
	}
	$class= ($class=="")?"form-control":"form-control ".$class;
	$required = ($rw['required'] && !$rw['hidden']) ? 'required="true"' : '';

	if (!$readonly) {

		$inp = "<input type='number' oninvalid=\"this.setCustomValidity('" . $rw['label'] . " tidak boleh kosong')\" oninput=\"setCustomValidity('')\" class='".$class."' id='" . $name . "' name='" . $name . "' value='" . $value . "' $attr $required />";
	} else {
		$inp = $value;
	}
	return $inp;
}
function formInputDate($name, $value = null, $rw = [], $readonly = false)
{
	$width = (isset($rw['width'])) ? $rw['width'] : '300px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . '"';
	if($width == 'auto')
	{
		$attr = '';
	}
	$required = ($rw['required'] && !$rw['hidden']) ? 'required="true"' : '';

	if (!$readonly) {

		$inp = "<input autocomplete='off' type='text' oninvalid=\"this.setCustomValidity('" . $rw['label'] . " tidak boleh kosong')\" oninput=\"setCustomValidity('')\" class='form-control datepicker' id='" . $name . "' name='" . $name . "' value='" . $value . "' $attr $required />";
	} else {
		$inp = $value;
	}
	return $inp;
}
function formInputArea($name, $value = null, $rw = [], $readonly = false)
{
	$width = (isset($rw['width'])) ? $rw['width'] : '500px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . '"';
	$required = ($rw['required'] && !$rw['hidden']) ? 'required="true"' : '';
	if($width == 'auto')
	{
		$attr = '';
	}
	if (!$readonly) {

		$inp = "<textarea oninvalid=\"this.setCustomValidity('" . $rw['label'] . " tidak boleh kosong')\" oninput=\"setCustomValidity('')\" class='form-control' id='" . $name . "' name='" . $name . "'  $attr $required />$value</textarea>";
	} else {
		$inp = $value;
	}
	return $inp;
}
function formSelect($name, $value = null, $opt = [], $rw = [], $readonly = false, $class="")
{
	$width = (isset($rw['width'])) ? $rw['width'] : '300px';
	$width = (isset($rw['form_width'])) ? $rw['form_width'] : $width;
	$attr = 'style="width:' . $width . '"';
	if($width == 'auto')
	{
		$attr = '';
	}
	$class= ($class=="")?"form-control":"form-control ".$class;
	$required = ($rw['required'] && !$rw['hidden']) ? '' : '';
	if (!$readonly) {
		$inp = form_dropdown($name, $opt, $value, 'oninvalid="this.setCustomValidity(\'' . $rw['label'] . ' harus dipilih \')" oninput="setCustomValidity(\'\')" class="'.$class.'" id="' . $name . '" ' . $attr . ' ' . $required);
	} else {
		$inp = $opt[$value];
	}
	return $inp;
}

function debug($str)
{
	echo '<pre>';
	print_r($str);
}
function get_bulan_all($getBulan=null){
    $bulan=array(
        '01'=>'January',
        '02'=>'February',
        '03'=>'March',
        '04'=>'April',
        '05'=>'May',
        '06'=>'June',
        '07'=>'July',
        '08'=>'August',
        '09'=>'September',
        '10'=>'October',
        '11'=>'November',
        '12'=>'December'
    );
  if($getBulan == null)
    return $bulan;
  else{
    $i = $getBulan;
    if($getBulan < 10) $i = "0".$getBulan;
    return $bulan[$i];
  }
}
function get_bulan_mini($getBulan=null){
    $bulan=array(
        '01'=>'Jan',
        '02'=>'Feb',
        '03'=>'Mar',
        '04'=>'Apr',
        '05'=>'May',
        '06'=>'Jun',
        '07'=>'Jul',
        '08'=>'Aug',
        '09'=>'Sep',
        '10'=>'Oct',
        '11'=>'Nov',
        '12'=>'Dec'
    );
  if($getBulan == null)
    return $bulan;
  else{
    // $i = $getBulan;
    // if($getBulan < 10) $i = "0".$getBulan;
    return $bulan[$getBulan];
  }
}