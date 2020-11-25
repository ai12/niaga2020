<?php
// print_r($rw);
if (!isset($rw['value'])) {
	if ($rw['type'] == 'text') {
		echo formInputArea($k, $row[$k], $rw, $readonly);
	} elseif ($rw['type'] == 'number') {
		$class = (isset($rw['class']))?$rw['class']:'';
		echo formInputNumber($k, $row[$k], $rw, $readonly,$class);
	} elseif ($rw['type'] == 'date') {
		echo formInputDate($k, $row[$k], $rw, $readonly);
	} else {
		$class = (isset($rw['class']))?$rw['class']:'';
		echo formInput($k, $row[$k], $rw, $readonly,$class);
	}
} else {
	$class = (isset($rw['class']))?$rw['class']:'';
	echo formSelect($k, $row[$k], $rw['value'], $rw, $readonly,$class);
}
