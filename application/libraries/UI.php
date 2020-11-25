<?php
class UI {

	private $auth = array();

	public static function FormGroup($array=array()){
		return self::createFormGroup($array['form'],$array['rule'],$array['name'],$array['label'],$array['onlyone'],$array['sm_label'], $array['edited']);
	}

	public static function createFormGroup($form=null, $rule=null, $name=null, $label=null, $onlyone=false, $sm_label=4, $edited=true){

		if(!$form)
			return;

		if($onlyone){

		if($edited && $rule)
			$form_error = form_error($name);

			$ret= '
<div class="form-group '.(($form_error)?'has-error':'').'">';
if($label){
$ret .= '
	<label for="'.$name.'" class="col-sm-12" >
		'.$label;
		if(strstr($rule['rules'],'required')!==false && $edited){
			$ret .= '&nbsp;<span style="color:#dd4b39">*</span>';
		}

		$ret .= '
	</label>';
}
	$ret .= '
	<div class="col-sm-12">
		'.$form.'
		<span style="color:#dd4b39; font-size:11px; '.(($form_error)?'':'display: none').'" id="info_'.$name.'">
		'.$form_error.'
		</span>
	</div>
</div>';
			return $ret;
		}

		$sm_form = 12 - $sm_label;
		if(!$rule['rules']){

		$ret= '
<div class="form-group">
	<label for="'.$name.'" class="col-sm-'.$sm_label.' control-label">
		'.$label.'
	</label>
	<div class="col-sm-'.$sm_form.'">'.$form.'
	</div>
</div>';
		return $ret;

		}

		if($edited)
			$form_error = form_error($name);

		$ret= '
<div class="form-group '.(($form_error)?'has-error':'').'">
	<label for="'.$name.'" class="col-sm-'.$sm_label.' control-label">
		'.$label;
		if(strstr($rule['rules'],'required')!==false && $edited){
			$ret .= '&nbsp;<span style="color:#dd4b39">*</span>';
		}

		$ret .= '
	</label>
	<div class="col-sm-'.$sm_form.'">'.$form;
			$ret .= '
			<span style="color:#dd4b39; font-size:11px; '.(($form_error)?'':'display: none').'" id="info_'.$name.'">
			'.$form_error.'
			</span>';
		$ret .= '
	</div>
</div>';
		return $ret;
	}

	public static function createFormGroupUpload($form=null, $rule=null, $name=null, $label=null, $onlyone=false, $sm_label=4, $edited=true){

		if(!$form)
			return;

		if($onlyone){

		if($edited && $rule)
			$form_error = form_error($name);

			$ret= '
<div class="form-group '.(($form_error)?'has-error':'').'" style="margin-top:-15px">';
if($label){
$ret .= '
	<label for="'.$name.'" class="col-sm-12" >
		'.$label;

		$ret .= '
	</label>';
}
	$ret .= '
	<div class="col-sm-12">
		'.$form;

	if(strstr($rule['rules'],'required')!==false && $edited){
		$ret .= '&nbsp;<span style="color:#dd4b39">*</span>';
	}

	$ret .= '
		<span style="color:#dd4b39; font-size:11px; '.(($form_error)?'':'display: none').'" id="info_'.$name.'">
		'.$form_error.'
		</span>
	</div>
</div>';
			return $ret;
		}

		$sm_form = 12 - $sm_label;
		if(!$rule['rules']){

		$ret= '
<div class="form-group" style="margin-top:-15px">
	<label for="'.$name.'" class="col-sm-'.$sm_label.' control-label">
		'.$label.'
	</label>
	<div class="col-sm-'.$sm_form.'">';
		$ret .= $form;
		$ret .= '
	</div>
</div>';
		return $ret;

		}

		if($edited)
			$form_error = form_error($name);

		$ret= '
<div class="form-group '.(($form_error)?'has-error':'').'" style="margin-top:-15px">
	<label for="'.$name.'" class="col-sm-'.$sm_label.' control-label">
		'.$label;

		$ret .= '
	</label>
	<div class="col-sm-'.$sm_form.'">'.$form;
		if(strstr($rule['rules'],'required')!==false && $edited){
			$ret .= '&nbsp;<span style="color:#dd4b39">*</span>';
		}
			$ret .= '
			<span style="color:#dd4b39; font-size:11px; '.(($form_error)?'':'display: none').'" id="info_'.$name.'">
			'.$form_error.'
			</span>';
		$ret .= '
	</div>
</div>';
		return $ret;
	}

	public static function createFormGroupPlain($form=null, $rule=null, $name=null, $label=null, $onlyone=false, $edited=true){

		if(!$form)
			return;

		if($onlyone){

			$ret= '
<div class="form-group">
	<div class="col-sm-input">
	'.$form.'
	</div>
</div>';
			return $ret;
		}

		if(!$rule['rules']){

		$ret= '
<div class="form-group">
	<label for="'.$name.'" class="col-sm control-label">
		'.$label.'
	</label>
	<div class="col-sm-input">'.$form.'
	</div>
</div>';
		return $ret;

		}

		if($edited)
			$form_error = form_error($name);

		$ret= '
<div class="form-group '.(($form_error)?'has-error':'').'">
	<label for="'.$name.'" class="col-sm control-label">
		'.$label;
		if(strstr($rule['rules'],'required')!==false && $edited){
			$ret .= '&nbsp;<span style="color:#dd4b39">*</span>';
		}

		$ret .= '
	</label>
	<div class="col-sm-input">'.$form;
			$ret .= '
			<span style="color:#dd4b39; font-size:11px; '.(($form_error)?'':'display: none').'" id="info_'.$name.'">
			'.$form_error.'
			</span>';
		$ret .= '
	</div>
</div>';
		return $ret;
	}

	public static function createTextArea($nameid,$value='',$rows='',$cols='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
        if($value)
        	$class .= " blank-form ";

		if(!empty($edit)) {
			$ta = '<textarea wrap="soft" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $ta .= ' class="'.$class.'"';
			if($rows != '') $ta .= ' rows="'.$rows.'"';
			if($cols != '') $ta .= ' cols="'.$cols.'"';
			if($add != '') $ta .= ' '.$add;
			$ta .= '>';
			if($value != '') $ta .= $value;
			$ta .= '</textarea>';
		}
		else if($value == '')
			$ta = '<i style="color:#aaa" class="read_detail">-</i>';
		else
			$ta = "<div class='read_detail'>".nl2br($value)."</div>";

		return $ta;
	}


	public static function createTextEditor($nameid,$value='',$rows='',$cols='',$edit=true,$class='form-control contents',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$ta = '<textarea wrap="soft" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $ta .= ' class="'.$class.'"';
			if($rows != '') $ta .= ' rows="'.$rows.'"';
			if($cols != '') $ta .= ' cols="'.$cols.'"';
			if($add != '') $ta .= ' '.$add;
			$ta .= '>';
			if($value != '') $ta .= $value;
			$ta .= '</textarea>';
		}
		else if($value == '')
			$ta = '<i style="color:#aaa" class="read_detail">-</i>';
		else
			$ta = "<div class='read_detail'>".($value)."</div>";

		return $ta;
	}

	// membuat textbox
	public static function TextBox($arr=array()) {

		return self::createTextBox($arr['name'],$arr['value'],$arr['maxlength'],$arr['size'],$arr['edited'],$arr['class'],$arr['add']);
	}

	// membuat textbox
	public static function createTextBox($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
        if($value)
        	$class .= " blank-form ";

		if(!empty($edit)) {
			$tb = '<input autocomplete="off" type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';
		else{
			$class = str_replace('form-control', '', $class);
			if(strstr($class, "datepicker")!==false){
				$class = str_replace("datepicker", "", $class);
				$tb = "<div class='$class read_detail'>".Eng2Ind($value,false)."</div>";
			}
			else
				$tb = "<div class='$class read_detail'>".$value."</div>";
		}

		return $tb;
	}

	// membuat textbox
	public static function createTextBoxPlain($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
        if($value)
        	$class .= " blank-form ";

		if(!empty($edit)) {
			$tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '';
		else{
			$class = str_replace('form-control', '', $class);
			if(strstr($class, "datepicker")!==false)
				$tb = Eng2Ind($value);
			else
				$tb = $value;
		}

		return $tb;
	}

	// membuat texthidden
	public static function createTextHidden($nameid,$value='',$edit=true, $add='') {

		if(!empty($edit)) {
			$tb = '<input type="hidden" name="'.$nameid.'" id="'.$nameid.'"';
			if($value !== '') $tb .= ' value="'.$value.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}

		return $tb;
	}

	// membuat textbox
	public static function createTextDate($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';
        if($value)
        	$class .= " blank-form ";

		if(!empty($edit)) {
			$tb = '<input type="text" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			$tb .= ' class="datepicker '.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';
		else
			$tb = "<div class='read_detail'>".Eng2Ind($value)."</div>";

		return $tb;
	}

	// membuat textbox
	public static function createAutoComplate($nameid,$value=array(),$url,$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input autocomplete="off" type="text" name="name'.$nameid.'" id="name'.$nameid.'"';
			if($value['label'] != '') $tb .= ' value="'.$value['label'].'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';

			$tb .= '<input type="hidden" name="'.$nameid.'" id="'.$nameid.'"';
			if($value['id']) $tb .= ' value="'.$value['id'].'"';
			$tb .='/>';

			$tb .= '<script>
			$(function(){
				$("#'.$nameid.'").autocomplete("'.base_url($url).'");
			});
			</script>';
		}
		else if($value['label'] == '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';
		else
			$tb = "<div class='read_detail'>".$value['label']."</div>";


		return $tb;
	}

	// membuat textbox 'file',$row['nama_file'], base_url("panelbackend/preview_file/$row[id_buku]"), base_url("panelbackend/delete_file/$row[id_buku]"), $edited, false, 'form-control'

	public static function InputFile($array=array()){
		$default = array(
			"edit"=>false,
			"ispreview"=>false,
			"class"=>"form-control",
			"add"=>"style=\"width:auto\"",
		);
		foreach ($default as $key => $value) {
			if($array[$key]===null)
				$array[$key] = $value;
		}
		return self::createInputFile($array['nameid'], $array['nama_file'], $array['url_preview'], $array['url_delete'], $array['edit'], $array['ispreview'], $array['class'], $array['add'], $array['extarr']);
	}
	public static function createInputFile($nameid, $nama_file='', $url_preview='', $url_delete='', $edit=true, $ispreview=false, $class='form-control', $add='style="width:auto"', $extarr=array()) {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit) && (!$nama_file or !$url_delete)) {
			$accept = "";
			$tb = '';
			if(count($extarr)){
				$accept = 'accept="'.implode(', ', $extarr).'"';
				$tb .= '<span class="label label-info">.'.implode(', .', $extarr).'</span>';
			}
			$tb .= '<input type="file" name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= $accept;
			$tb .= '>';
		}
		else if($nama_file == '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';



		if($ispreview && $url_preview && $nama_file){
			$tb .= "<img src='$url_preview'/>";
		}
		if($nama_file){
		$tb .= "<div style='clear:both'></div>";
		if(!$ispreview){
			if($url_preview){
				$tb .= "<a target='_blank' href='$url_preview'>$nama_file</a> ";
			}else{
				$tb .= "$nama_file&nbsp; ";
			}
		}
		if(!empty($edit) && $nama_file && $url_delete) {
			$tb .= "<a href='$url_delete'><span class='glyphicon glyphicon-remove' style='color:red'></span></a> ";
		}
		$tb .= "<div style='clear:both'></div>";
		}
		return $tb;
	}

	public static function createMultipleFile($nameid, $files=array(),$ctrl=false, $edit=true){
		$ci = get_instance();
		$configfile = $ci->config->item("file_upload_config");
		$tb = "";

		$extstr = $configfile['allowed_types'];
		$max = (round($configfile['max_size']/1000))." Mb";

		if(is_array($files)){
			foreach ($files as $k=>$v) {
				if($edit)
					$tb .= " <a href='javascript:void(0);' onclick=\"delFile".$nameid."('".$k."')\"><span class='glyphicon glyphicon-remove' style='color:red'></span></a> ";

				$tb .= "<a target='_blank' href='".site_url("$ctrl/open_file/$k")."'>$v</a> <br/>";
			}
		}

		if($edit){
			$accept = 'accept="'.str_replace("|", ", " , $extstr).'"';
			$tb .= "<div id='multiplefile".$nameid."'><div>";
			$tb .= '<span class="label label-info">.'.str_replace("|", ", " , $extstr).'</span><br/>Max : '.$max."<br/>";
			$tb .= "<input $accept style='display:inline' class='multiplefile".$nameid."0' type='file' name='".$nameid."[]' id='".$nameid."[]'/></div></div>";
			$tb .= "<a href='javascript:void(0);' onclick='addFile".$nameid."()' class='btn btn-success btn-xs'>ADD FILE</a>";
			$tb .= '<script>
			var imultiple'.$nameid.' = 0;
			function addFile'.$nameid.'(){
				imultiple'.$nameid.'++;
				$(\'#multiplefile'.$nameid.'\').append(\'<div class="multiplefile'.$nameid.'\'+imultiple'.$nameid.'+\'"><input style="display:inline"  type="file" name="'.$nameid.'[]" id="'.$nameid.'[]"/> <a href="javascript:void(0);" onclick="$('."\'.multiplefile".$nameid."'+imultiple".$nameid."+'\'".').remove()" class="btn btn-success btn-xs">X</a></div>\');
			}

			function delFile'.$nameid.'(id){
				if(confirm("Apakah Anda akan menghapus ?")){
					$("#key").val(id);
					goSubmit("delete_file");
				}

			}
			</script>';
		}

		return $tb;
	}

	// membuat textbox
	public static function createTextNumber($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='', $is_rupiah=true) {
        //if (empty($class))
        //    $class = 'control_style';
        //    
      /*  if(strstr("style",$add)===false)
        	$add = 'style="text-align:right"';*/
        if($value)
        	$class .= " blank-form ";

		if(!empty($edit)) {
			$tb = '<input type="number" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value === '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';
		else{
			if($is_rupiah)
				$tb = "<div class='read_detail'>".rupiah($value)."</div>";
			else
				$tb = "<div class='read_detail'>".($value)."</div>";

		}

		return $tb;
	}

	// membuat textbox
	public static function createTextNumberPlain($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='', $is_rupiah=true) {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="number" style="text-align:right" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value === '')
			$tb = '';
		else{
			if($is_rupiah)
				$tb = rupiah($value);
			else
				$tb = ($value);

		}

		return $tb;
	}

	// membuat textbox
	public static function createTextPassword($nameid,$value='',$maxlength='',$size='',$edit=true,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		if(!empty($edit)) {
			$tb = '<input type="password" name="'.$nameid.'" id="'.$nameid.'"';
			if($value != '') $tb .= ' value="'.$value.'"';
			if($class != '') $tb .= ' class="'.$class.'"';
			if($maxlength != '') $tb .= ' maxlength="'.$maxlength.'"';
			if($size != '') $tb .= ' size="'.$size.'"';
			if($add != '') $tb .= ' '.$add;
			$tb .= '>';
		}
		else if($value == '')
			$tb = '<i style="color:#aaa" class="read_detail">-</i>';
		else
			$tb = "<div class='read_detail'>".$value."</div>";

		return $tb;
	}

	// membuat combo box
	public static function createSelect($nameid,$arrval='',$value='',$edit=true,$class='form-control',$add='',$emptyrow=false) {

        if($value)
        	$class .= " blank-form ";

		if(!$edit)
			$arrval[''] = '<i>-</i>';

		$style = 'style="width:100%"';

		if(strstr($add,'style')!==false)
			$style = '';

		if(!empty($edit)) {
			if($nameid=='list_limit')
				$slc = '<select style="width:auto" data-placeholder="Pilih..." tabindex="2" name="'.$nameid.'" id="'.$nameid.'"';
			else
				$slc = '<select '.$style.' data-placeholder="Pilih..." tabindex="2" name="'.$nameid.'" id="'.$nameid.'"';
			$slc .= ' class="'.(($class != '')?$class:'').'"';
			if($add != '') $slc .= ' '.$add;
			$slc .= ">\n";
			if($emptyrow)
				$slc .= '<option></option>'."\n";
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
					$slc .= $val.'</option>'."\n";
				}
			}
			$slc .= '</select>';
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$slc = "<div class='read_detail'>".$val."</div>";
						break;
					}
				}
			}
			if(!($slc))
				$slc = '&nbsp;';
		}

		return $slc;
	}

		// membuat combo box
		public static function createSelectMultiple($nameid,$arrval='',$arrvalue=array(),$edit=true,$class='form-control',$add='',$emptyrow=false) {
	        if($arrvalue)
	        	$class .= " blank-form ";

			if(!is_array($arrvalue))$arrvalue = array($arrvalue);
			if(!empty($edit)) {
				$slc = '
				<select tabindex="4" multiple name="'.$nameid.'" id="'.$nameid.'"';
				$slc .= ' class="chosen-select '.(($class != '')?$class:'').'"';
				if($add != '') $slc .= ' '.$add;
				$slc .= ">\n";
				if($emptyrow)
					$slc .= '<option></option>'."\n";
				if(is_array($arrval)) {
					foreach($arrval as $key => $val) {
						$slc .= '<option value="'.$key.'"'.(in_array($key,$arrvalue) ? ' selected' : '').'>';
						$slc .= $val.'</option>'."\n";
					}
				}
				$slc .= '</select>';
			}
			else {
				$value_d = array();
				if(is_array($arrval)) {
					foreach($arrval as $key => $val) {
						if(in_array($key,$arrvalue)) {
							$value_d[] = $val;
						}
					}
				}
				$slc .= "<div class='read_detail'>".implode(', ', $value_d)."</div>";
				if(!count($slc))
					$slc = '&nbsp;';
			}

			return $slc;
		}
			// membuat combo box
			public static function createSelectMultipleAutocomplate($nameid,$arrval='',$arrvalue=array(),$edit=true,$class='form-control',$add='',$emptyrow=false) {
		        if($value)
		        	$class .= " blank-form ";

				if(!is_array($arrvalue))$arrvalue = array($arrvalue);
				if(!empty($edit)) {
					$slc = '<select  data-ajax--data-type="json" tabindex="4" multiple name="'.$nameid.'" id="'.$nameid.'"';
					$slc .= ' class="chosen-select '.(($class != '')?$class:'').'"';
					if($add != '') $slc .= ' '.$add;
					$slc .= ">\n";
					if($emptyrow)
						$slc .= '<option></option>'."\n";
					if(is_array($arrval)) {
						foreach($arrval as $key => $val) {
							$slc .= '<option value="'.$key.'"'.(in_array($key,$arrvalue) ? ' selected' : '').'>';
							$slc .= $val.'</option>'."\n";
						}
					}
					$slc .= '</select>';
				}
				else {
					$value_d = array();
					if(is_array($arrval)) {
						foreach($arrval as $key => $val) {
							if(in_array($key,$arrvalue)) {
								$value_d[] = $val;
							}
						}
					}
					$slc .= "<div class='read_detail'>".implode(', ', $value_d)."</div>";
					if(!count($slc))
						$slc = '&nbsp;';
				}

				return $slc;
			}

	// membuat combo box
	public static function createSelectKategori($nameid,$arrval='',$value='',$edit=true,$class='form-control',$add='',$emptyrow=false) {
        if($value)
        	$class .= " blank-form ";
        
		if(!empty($edit)) {
			$slc = '<select name="'.$nameid.'" id="'.$nameid.'"';
			if($class != '') $slc .= ' class="'.$class.'"';
			if($add != '') $slc .= ' '.$add;
			$slc .= ">\n";
			if($emptyrow)
				$slc .= '<option></option>'."\n";
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$slc .= '<option value="'.$key.'"'.(!strcasecmp($value,$key) ? ' selected' : '').'>';
					$slc .= $val.'</option>'."\n";
				}
			}
			$slc .= '</select>';
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$slc = $val;
						break;
					}
				}
			}
			if(!count($slc))
				$slc = '&nbsp;';
		}

		return $slc;
	}

	// membuat textbox
	public static function createCheckBox($nameid,$valuecontrol='',$value='',$label='label',$edit=true,$class='',$add='', $is_bold=true) {
        //if (empty($class))
        //    $class = 'control_style';


		$tb = '<input type="checkbox" name="'.$nameid.'" id="'.$nameid.'"';
		if($valuecontrol != '') {
			$tb .= ' value="'.$valuecontrol.'"';
			if ($value == $valuecontrol)
				$tb .= ' checked ';
		}
		if($class != '') $tb .= ' class="'.$class.'"';
		if($add != '') $tb .= ' '.$add;
		if(!$edit)
			$tb .= ' disabled ';
		$tb .= '>';

		$tb .= "<label for='$nameid' style='margin: 0px;
    padding: 0px 10px;'>";

	    if($is_bold)
	    	$tb .= "<b>$label</b>";
	    else
	    	$tb .= "<span style='font-weight:normal !important'>$label</span>";

    	$tb .= "</label>";

		return $tb;
	}

	// membuat radio button
	public static function createRadio($nameid,$arrval='',$value='',$edit=true,$br=false,$class='form-control',$add='') {
        //if (empty($class))
        //    $class = 'control_style';

		$radio = '';

		if(!empty($edit)) {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					$radio .= '<input type="radio" class="'.$class.'" name="'.$nameid.'" id="'.$nameid.'_'.$key.'" value="'.$key.'"'.(!strcasecmp($value,$key) ? ' checked' : '').' '.$add.'>';
					$radio .= ' <label for="'.$nameid.'_'.$key.'"> '.$val.'</label>'.($br ? '<br>' : '&nbsp;&nbsp;')."\n";
				}
			}
		}
		else {
			if(is_array($arrval)) {
				foreach($arrval as $key => $val) {
					if(!strcasecmp($value,$key)) {
						$radio = "<span class='read_detail'>".$val."</span>";
						break;
					}
				}
			}
		}

		return $radio;
	}

	public static function showPaging($paging, $page, $limit_arr, $limit, $list){
		if(!$list['total'])
			return;

		$batas_atas = $page+1;
		$batas_bawah = $batas_atas+($limit-1);
		if($batas_bawah>$list['total']){
			$batas_bawah = $list['total'];
		}
		?>
		<div class="col-sm-5 no-margin no-padding" style="margin-bottom: 0px; font-size: 11px;">
			<div class="dataTables_info dataTables_length">
				Perhalaman
				<?php
				foreach($limit_arr as $k=>$v){$limit_arr1[$v]=$v;}
				echo self::createSelect('list_limit',$limit_arr1,$limit, true, 'form-control input-sm', 'onchange="goLimit()"');
				?>
				Menampilkan <?=$batas_atas?> sampai <?=$batas_bawah?> dari total <?=$list['total']?> data

			</div>
		</div>
		<div class="col-sm-7 no-margin no-padding" style="margin-bottom: 0px; margin-top: 5px !important; font-size: 11px;">
			<div class="dataTables_paginate paging_simple_numbers">
	  			<ul class="pagination">
					<?=$paging?>
				</ul>
			</div>
		</div>

		<script>
		    function goLimit(){
		        $("#act").val('list_limit');
		        $("#main_form").submit();
		    }

		</script>
		<?php
	}

	public static function showHeader($header, $filter_arr, $list_sort, $list_order, $is_filter=true, $is_sort = true, $is_no = true){

		$ci = get_instance();
		if($is_filter){
	?>
	      <tr>
	      	<?php if($is_no){ ?>
	        <td></td>
	        <?php } ?>
	        <?php foreach($header as $rows){
	        	if($rows['field']){
	        		$rows['name'] = $rows['field'];
	        	}
	        	$edited = true;
	        	if($rows['filter']===false){
	        		$edited = $rows['filter'];
	        		$filter_arr[$rows['name']] = '&nbsp';
	        	}
	        	switch ($rows['type']) {
	        		case 'list':
	        			echo "<td style='width:$rows[width];'>".self::createSelect("list_search_filter[".$rows['name']."]",$rows['value'],$filter_arr[$rows['name']],$edited,'form-control',"style='width:100%;'")."</td>";
	        			break;

	        		case 'date':
	        			echo "<td></td>";
	            		//echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'polos':
	        			echo "<td></td>";
	            		//echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'image':
	        			echo "<td></td>";
	            		//echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'datetime':
	        			echo "<td></td>";
	            		//echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datetimepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'number':
	            		echo "<td style='position:relative;width:$rows[width];'>".self::createTextNumber("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='width:100%;'")."</td>";
	        			break;

	        		default:
	            		echo "<td style='width:$rows[width];'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='width:100%;'")."</td>";
	        			break;
	        	}
	        }
	        ?>
	        <td style='text-align:right; width:10px'>
	        <!-- <button type="submit" class='btn btn-default btn-sm' title="Filter">
			<span class="glyphicon glyphicon-search"></span>
	        </button> -->
	        <button type="button" class="btn waves-effect btn-sm btn-default" onclick="goReset()" title="Reset">
	        <span class="glyphicon glyphicon-refresh"></span>
	        </button>  	       
	        </td>
	      </tr>
	      <?php }
	      if($is_sort){
	      ?>
	      <tr>
	      	<?php if($is_no){ ?>
	        <th style="width:10px">#</th>
	        <?php } ?>
	        <input type='hidden' name='list_sort' id='list_sort'>
	        <input type='hidden' name='list_order' id='list_order'>
	        <?php foreach($header as $rows){
	        	if($rows['type']=='list' or $rows['type']=='implodelist' or $rows['type']=='polos'){
		        	   echo "<th style='width:$rows[width]'>$rows[label]</th>";
		        }else{
		        	$align = "text-align:center;";
	        		if($rows['type']=='number'){
		        	   $align = "text-align:right;";
		        	}
		        	$add_label = $rows['add_label'];

		            if($list_sort==$rows['name']){
		                if(trim($list_order)=='asc'){
		                    $order = 'desc';
		                }else{
		                    $order = 'asc';
		                }

		               if($add_label){
		               echo "<th style='$align width:$rows[width];' class='sorting_".$order."' > $add_label <a href='javascript:void(0)' onclick=\"goSort('{$rows['name']}','$order')\" style='color:#fff;text-decoration:none'>$rows[label]</a> </th>";
			           }else{
		               echo "<th style='$align width:$rows[width]; cursor:pointer;' class='sorting_".$order."' onclick=\"goSort('{$rows['name']}','$order')\">$rows[label]</th>";
			           }
		            }else{
		               if($add_label){
		        	   echo "<th style='$align width:$rows[width];' class='sorting'> $add_label <a href='javascript:void(0)' onclick=\"goSort('{$rows['name']}','asc')\"style='color:#fff;text-decoration:none'>$rows[label]</a></th>";
		        		}else{
		        	   echo "<th style='$align width:$rows[width]; cursor:pointer;' class='sorting' onclick=\"goSort('{$rows['name']}','asc')\">$rows[label]</th>";
		        		}
		            }
		        }
	        }
	        ?>
	        <th></th>
	      </tr>
	      <?php }else{ ?>
	      <tr>
	      	<?php if($is_no){ ?>
	        <th style="width:10px">#</th>
	        <?php } ?>
	        <?php foreach($header as $rows){
        	   echo "<th style='width:$rows[width]'>$rows[label]</th>";
	        }
	        ?>
	        <th></th>
	      </tr>
	      <?php } ?>

	      <?php if($is_sort or $is_filter){ ?>
	    <script>
		    $(function(){
		        $("#main_form").submit(function(){
		            if($("#act").val()==''){
		                goSearch();
		            }
		        });
		    });

		    function goSort(name, order){
		        $("#list_sort").val(name);
		        $("#list_order").val(order);
		        $("#act").val('list_sort');
		        $("#main_form").submit();
		    }

		    function goSearch(){
		        $("#act").val('list_search');
		        $("#main_form").submit();
		    }

			function goReset(){
				$("#act").val('list_reset');
				$("#main_form").submit();
			}
			$("#main_form select[name^='list_search_filter'], #main_form input[name^='list_search']").not("#list_limit").change(function(){
			    $("#main_form").submit();
			});
	    </script>
    <?php
    	}
	}

	public static function showHeaderTree($header, $filter_arr, $list_sort, $list_order, $is_filter=true){

		$ci = get_instance();
		if($is_filter){
	?>
	      <tr>
	        <?php foreach($header as $rows){
	        	if($rows['field']){
	        		$rows['name'] = $rows['field'];
	        	}
	        	$edited = true;
	        	if($rows['filter']===false){
	        		$edited = $rows['filter'];
	        		$filter_arr[$rows['name']] = '&nbsp';
	        	}
	        	switch ($rows['type']) {
	        		case 'list':
	        			echo "<td style='width:$rows[width];'><div class='form-group'>".self::createSelect("list_search_filter[".$rows['name']."]",$rows['value'],$filter_arr[$rows['name']],$edited,'form-control',"style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'date':
	            		echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'datetime':
	            		echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datetimepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		case 'number':
	            		echo "<td style='position:relative;width:$rows[width];'><div class='form-group'>".self::createTextNumber("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control',"style='max-width:$rows[width];'")."</div></td>";
	        			break;

	        		default:
	            		echo "<td style='width:$rows[width];'><div class='form-group'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</div></td>";
	        			break;
	        	}
	        }
	        ?>
	        <td style='text-align:left; width:150px'>
	        <button type="submit" class='btn btn-primary btn-xs'>
			<span class="glyphicon glyphicon-search"></span>
	        Filter
	        </button>
	        <?=self::getButton('reset',null, $add, "btn-xs")?>
	        </td>
	      </tr>
	      <?php }?>
	      <tr>
	        <input type='hidden' name='list_sort' id='list_sort'>
	        <input type='hidden' name='list_order' id='list_order'>
	        <?php foreach($header as $rows){
	        	if($rows['type']=='list' or $rows['type']=='implodelist'){
		        	   echo "<th style='max-width:$rows[width]'>$rows[label]</th>";
		        }else{
	        		if($rows['type']=='number'){
		        	   $align = "text-align:right;";
		        	}

		            if($list_sort==$rows['name']){
		                if(trim($list_order)=='asc'){
		                    $order = 'desc';
		                }else{
		                    $order = 'asc';
		                }
		               echo "<th style='$align max-width:$rows[width]; cursor:pointer;' class='sorting_".$order."' onclick=\"goSort('{$rows['name']}','$order')\">$rows[label]</th>";
		            }else{
		        	   echo "<th style='$align max-width:$rows[width]; cursor:pointer;' class='sorting' onclick=\"goSort('{$rows['name']}','asc')\">$rows[label]</th>";
		            }
		        }
	        }
	        ?>
	        <th></th>
	      </tr>
	    <script>
		    $(function(){
		        $("#main_form").submit(function(){
		            if($("#act").val()==''){
		                goSearch();
		            }
		        });
		    });

		    function goSort(name, order){
		        $("#list_sort").val(name);
		        $("#list_order").val(order);
		        $("#act").val('list_sort');
		        $("#main_form").submit();
		    }

		    function goSearch(){
		        $("#act").val('list_search');
		        $("#main_form").submit();
		    }
	    </script>
    <?php
	}

	public static function showHeaderFix($headerrows, $filter_arr, $list_sort, $list_order, &$header){
		$ci = get_instance();
		if(!$headerrows['rows']){
			$headerrows['rows'] = array($headerrows);
		}
	      ?>
        <?php
        foreach($headerrows['rows'] as $k=>$head){
        	echo "<tr style='background:#fff'>";
        	if($k==0){
        		echo "<th style='vertical-align:middle;width:20px' rowspan='".count($headerrows['rows'])."'>No</th>";
        	}
	        foreach($head as $rows){

	        	$add = $rows['add'];

	        	if($rows['align'])
	        	   $align = "text-align:{$rows['align']};";

	        	$width = "";
	        	if($rows['width'])
	        	   $width = "width:{$rows['width']};";

	        	if($rows['type']=='head' && !$rows['colspan']){
	        		continue;
	        	}

	        	$rowspan = '';
	        	if($rows['rowspan'])
	        		$rowspan = "rowspan='{$rows['rowspan']}'";

	        	$colspan = '';
	        	if($rows['colspan'])
	        		$colspan = "colspan='{$rows['colspan']}'";

	        	if($rows['type']=='list' or $rows['type']=='head' or $rows['type']=='implodelist' or $rows['nofilter'])
	        	   echo "<th $add $colspan $rowspan style='vertical-align: middle;$width $align'>$rows[label]</th>";
		        else{

		        	$align = $row['align'];

	        		if($rows['type']=='number')
		        	   $align = "text-align:right;";

		            if($list_sort==$rows['name']){
		                if(trim($list_order)=='asc')
		                    $order = 'desc';
		                else
		                    $order = 'asc';

		               echo "<th $add $colspan $rowspan style='vertical-align: middle;$width $align cursor:pointer;' class='sorting_".$order."' onclick=\"goSort('{$rows['name']}','$order')\">$rows[label]</th>";
		            }else
		        	   echo "<th $add $colspan $rowspan style='vertical-align: middle;$width $align cursor:pointer;' class='sorting' onclick=\"goSort('{$rows['name']}','asc')\">$rows[label]</th>";
		        }
	        }
	        echo "</tr>";
	    }
	    $i=0;
        foreach($headerrows['rows'][$i] as $rows){
        	if($rows['type']!=='head')
        		$header[] = $rows;
        	else{
        		$i++;
        		if($headerrows['rows'][$i])
        			foreach ($headerrows['rows'][$i] as $rs) {
        			$header[] = $rs;
        		}
        	}
        }
        ?>

	      <tr class="filter-table"  style='background:#fff'>
	        <td></td>
	        <?php foreach($header as $rows){
	        	if($rows['nofilter']){
            		echo "<td style='position:relative;width:$rows[width];'></td>";
	        	}else{
		        	if($rows['field']){
		        		$rows['name'] = str_replace(".", "_____", $rows['field']);
		        	}
		        	$edited = true;
		        	if($rows['filter']===false){
		        		$edited = $rows['filter'];
		        		$filter_arr[$rows['name']] = '&nbsp';
		        	}
		        	switch ($rows['type']) {
		        		case 'list':
		        			echo "<td style='width:$rows[width];'>".self::createSelect("list_search_filter[".$rows['name']."]",$rows['value'],$filter_arr[$rows['name']],$edited,'form-control',"style='width:$rows[width];'")."</td>";
		        			break;

		        		case 'date':
		            		//echo "<td style='position:relative;width:$rows[width];'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</td>";
		            		echo "<td style='position:relative;width:$rows[width];'></td>";
		        			break;

		        		case 'datetime':
		            		echo "<td style='position:relative;width:$rows[width];'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control datetimepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</td>";
		        			break;

		        		case 'implodelist':
		            		echo "<td style='position:relative;width:$rows[width];'></td>";
		        			break;

		        		case 'number':
		            		echo "<td style='position:relative;width:$rows[width];'>".self::createTextNumber("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</td>";
		        			break;

		        		default:
		            		echo "<td style='width:$rows[width];'>".self::createTextBox("list_search[".$rows['name']."]",$filter_arr[$rows['name']],'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'")."</td>";
		        			break;
		        	}
		        }
	        }
	        ?>
	        </tr>

        <input type='hidden' name='list_sort' id='list_sort'>
        <input type='hidden' name='list_order' id='list_order'>
	    <script>
		    $(function(){
		        $("#main_form").submit(function(){
		            if($("#act").val()==''){
		                goSearch();
		            }
		        });
		    });

		    function goSort(name, order){
		        $("#list_sort").val(name);
		        $("#list_order").val(order);
		        $("#act").val('list_sort');
		        $("#main_form").submit();
		    }

		    function goSearch(){
		        $("#act").val('list_search');
		        $("#main_form").submit();
		    }
	    </script>
    <?php
	}

	public static function showButtonMode($mode, $key=null, $edited=false, $add='', $class='btn-sm', $access_role=null, $page_escape=null) {

		$ci = get_instance();

		if(!$access_role)
			$access_role = $ci->access_role;

		$str = '';
		if(is_array($ci->addbuttons) && count($ci->addbuttons) && $mode!='save'){
			foreach ($ci->addbuttons as $k => $value) {
				$str .= self::getButton($value,$key, $add, $class, false, false, $access_role, $page_escape);
			}
		}

		if(is_array($ci->buttons) && count($ci->buttons) && $mode!='save'){
			foreach ($ci->buttons as $k => $value) {
				$str .= self::getButton($value,$key, $add, $class, false, false, $access_role, $page_escape);
			}
			return $str;
		}

		if(strstr($mode,"|")!==false){
			$modearr = explode("|", $mode);

			if(count($modearr)){
				$str = "";
				foreach ($modearr as $v) {
					$str .= self::getButton($v, $key, $add, $class, false, false, $access_role, $page_escape);
				}
				return $str;
			}
		}

		if ($mode === 'lst' || $mode === 'index' || $mode === 'daftar') {
			$str .= self::getButton('add',null, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if($mode == 'edit_detail'){

			if($edited)
				$str .= "";
			else
				$str .= self::getButton('edit', $key, $add, $class, false, false, $access_role, $page_escape);

			return $str;
		}

		if ($mode === 'oneedit'){

			$str .= self::getButton('detail', $key, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'onedetail'){

			$str .= self::getButton('edit', $key, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'import'){

			$str .= self::getButton('import', $key, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'edit') {
			//$str .= self::getButton('save');
			//$str .= self::getButton('batal', $key);

			$str .= self::getButton('lst',null, $add, $class, false, false, $access_role, $page_escape);/*
			$str .= self::getButton('add',null, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('delete', $key, $add, $class, false, false, $access_role, $page_escape);*/
			return $str;
		}

		if ($mode === 'add') {
			//$str .= self::getButton('save');
			$str .= self::getButton('lst',null, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'detail') {
			$str .= self::getButton('lst',null, $add, $class, false, false, $access_role, $page_escape);/*
			$str .= self::getButton('add',null, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('edit', $key, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('delete', $key, $add, $class, false, false, $access_role, $page_escape);*/
			return $str;
		}

		if ($mode === 'save' && $edited) {
			$str .= self::getButton('save',null, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('batal', $key, $add, $class, false, false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'save_back' && $edited) {
			$str .= self::getButton('save',null, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('lst', $key, $add, $class, 'Back', false, $access_role, $page_escape);
			return $str;
		}

		if ($mode === 'save_detail' && $edited) {
			$str .= self::getButton('save',null, $add, $class, false, false, $access_role, $page_escape);
			$str .= self::getButton('detail', $key, $add, $class, 'Detail', false, $access_role, $page_escape);
			return $str;
		}

		if($mode == 'blank'){
			return $str;
		}
	}

	public static function Button($array=array()){

		$default = array(
			"key"=>null,
			"add"=>'',
			"class"=>'btn-sm',
			"label"=>false,
			"action"=>false,
			"access_role"=>false,
			"page_escape"=>false,
		);
		foreach ($default as $key => $value) {
			if($array[$key]===null)
				$array[$key] = $value;
		}

		return self::getButton($array['id'], $array['key'], $array['add'], $array['class'], $array['label'], $array['action'], $array['access_role'], $array['page_escape']);
	}

	public static function getButton($id, $key=null, $add='', $class='', $label=false, $action=false, $access_role=null, $page_escape=null) {

		$ci = get_instance();

		if(!$page_escape)
			$page_escape = array_values($ci->page_escape);

		if(!$access_role)
			$access_role = $ci->access_role;

		$tempid = $id;

		if($id=='detail')
			$tempid = 'index';

		if(
			$ci->private == true
			&&
			!$access_role[$id]
			&&
			!in_array($ci->page_ctrl, $page_escape)
			&&
			!$ci->is_super_admin
			&&
			!in_array($id, $ci->addbuttons)
		){
			return false;
		}

		if(!$access_role[$id])
			return false;

		if($ci->data['add_param']){
			$add_param = '/'.$ci->data['add_param'];
		}


		if ($id === 'add') {
			return ' <button type="button" '.$add.' class="btn waves-effect '.$class.' btn-primary" onclick="'.($action?$action:'goAdd()').'" ><span class="glyphicon glyphicon-plus"></span> '.($label?$label:'Add New').'</button> '.(!$action?'
			<script>
		    function goAdd(){
		        window.location = "'.base_url($ci->page_ctrl."/add".$add_param).'";
		    }
		    </script>':'');
		}

		if ($id === 'import') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-primary" onclick="'.($action?$action:'goImport()').'" ><span class="glyphicon glyphicon-import"></span> '.($label?$label:'Import').'</button>'.(!$action?'
			<script>
		    function goImport(){
		        window.location = "'.base_url($ci->page_ctrl."/import".$add_param).'";
		    }
		    </script>':'');
		}

		if ($id === 'edit' && $key) {
			return ' <button type="button" '.$add.' class="btn waves-effect '.$class.' btn-warning" onclick="'.($action?$action:'goEdit(\''.$key.'\')').'" ><span class="glyphicon glyphicon-edit"></span> '.(($label!==false)?$label:'Edit').'</button> '.(!$action?'
			<script>
		    function goEdit(id){
		        window.location = "'.base_url($ci->page_ctrl."/edit".$add_param).'/"+id;
		    }
		    </script>':'');
		}

		if ($id === 'detail' && $key) {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-warning" onclick="'.($action?$action:'goDetail(\''.$key.'\')').'" ><span class="glyphicon glyphicon-eye-open"></span> '.($label?$label:'Detail').'</button> '.(!$action?'
			<script>
		    function goDetail(id){
		        window.location = "'.base_url($ci->page_ctrl."/detail".$add_param).'/"+id;
		    }
		    </script>':'');
		}

		if ($id === 'delete' && $key) {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-danger" onclick="'.($action?$action:'goDelete(\''.$key.'\')').'" ><span class="glyphicon glyphicon-remove"></span> '.($label!==false?$label:'Delete').'</button> '.(!$action?'
			<script>
		    function goDelete(id){
		        if(confirm("Apakah Anda yakin akan menghapus ?")){
		            window.location = "'.base_url($ci->page_ctrl."/delete".$add_param).'/"+id;
		        }
		    }
		    </script>':'');
		}

		if ($id === 'delete_all') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-danger" onclick="'.($action?$action:'goDeleteAll()').'" ><span class="glyphicon glyphicon-remove"></span> '.($label!==false?$label:'Delete All').'</button> '.(!$action?'
			<script>
		    function goDeleteAll(){
		        if(confirm("Apakah Anda yakin akan menghapus semua data ?")){
		            window.location = "'.base_url($ci->page_ctrl."/delete_all".$add_param).'";
		        }
		    }
		    </script>':'');
		}

		if ($id === 'lst' || $id === 'index') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-default" onclick="'.($action?$action:'goList()').'" ><span class="glyphicon glyphicon-arrow-left"></span> '.($label?$label:'Back').'</button>  '.(!$action?'
			<script>
			function goList(){
			window.location = "'.base_url($ci->page_ctrl."/index".$add_param).'";
			}
			</script>':'');
		}

		if ($id === 'save') {
			return '<button type="submit" class="btn-save btn '.$class.' btn-success" onclick="'.($action?$action:'goSave()').'" ><span class="glyphicon glyphicon-floppy-save"></span> '.($label?$label:'Save').'</button>'.(!$action?'
			<script>
			function goSave(){
				$("#main_form").submit(function(e){
					if(e){
						$(".btn-save").attr("disabled","disabled");
				      	$("#act").val(\'save\');
					}else{
						return false;
					}
				});
			}
			</script>':'');
		}

		if ($id === 'batal') {
			return '<button type="submit" class="btn waves-effect '.$class.' btn-default" onclick="'.($action?$action:'goBatal(\''.$key.'\')').'" ><span class="glyphicon glyphicon-repeat"></span> '.($label?$label:'Reload').'</button> '.(!$action?'
			<script>
			function goBatal(){
				$("#act").val(\'reset\');
				$("#main_form").submit();
			}
			</script>':'');
		}

		if ($id === 'print') {
			return '<button type="button" class="btn waves-effect '.$class.' btn-primary" onclick="'.($action?$action:'goPrint(\''.$key.'\')').'" ><span class="glyphicon glyphicon-print"></span> '.($label?$label:'Print').'</button> '.(!$action?'
			<script>
			function goPrint(){
		        $("#act").val("list_search");
				window.open("'.base_url($ci->page_ctrl."/go_print".$add_param).'/?"+$("#main_form").serialize(),"_blank");
			}
			</script>':'');
		}

		if ($id === 'expportexcel') {
			return '<script src="'.base_url().'assets/js/excellentexport.min.js"></script>
			&nbsp;<a download="export-excel.xls" class="btn waves-effect btn-sm btn-primary" href="#" onclick="return ExcellentExport.excel(this, \'table-export\', \'Export Excel\',\'filter-table\');"><i class="glyphicon glyphicon-export"></i> Excel</a>&nbsp;';
		}

		if ($id === 'reset') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-default" onclick="'.($action?$action:'goReset()').'" ><span class="glyphicon glyphicon-refresh"></span> '.($label?$label:'Reset').'</button>  '.(!$action?'
			<script>
			function goReset(){
				$("#act").val(\'list_reset\');
				$("#main_form").submit();
			}
			</script>':'');
		}

		if ($id === 'applyfilter') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-warning" onclick="'.($action?$action:'goSearch()').'" ><span class="glyphicon glyphicon-search"></span>'.($label?$label:'Terapkan Filter').'</button>  '.(!$action?'
			<script>
		    function goSearch(){
		        jQuery("#act").val("list_search");
		        jQuery("#main_form").submit();
		    }
			</script>':'');
		}

		if ($id === 'filter') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-warning" onclick="'.($action?$action:'goSearch()').'" ><span class="glyphicon glyphicon-search"></span> '.($label?$label:'Filter').'</button>  '.(!$action?'
			<script>
		    function goSearch(){
		        jQuery("#act").val("list_filter");
		        jQuery("#main_form").submit();
		    }
			</script>':'');
		}

	}

	private static function startMenu($xs = false){
		$str = '<div class="dropdown" style="display:inline">';
		if($xs){
		$str .= '
					<a href="javascript:void(0)" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:#1f91f3;display:inline-block;">';
		}else{
		$str .= '
					<a href="javascript:void(0)" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:#1f91f3;padding: 5px;line-height:1.5;display:inline-block;">';
		}
		$str .= '
						<span class="glyphicon glyphicon-option-vertical"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2" style="min-width: 10px; margin-top:-20px">';

		return $str;
	}

	public static function showMenu($addmenu=array(), $xs=true){
		if(!$addmenu)
			return;

		$str = self::startMenu($xs);

		if(is_array($addmenu) && count($addmenu)){
			foreach($addmenu as $k=>$v){
				$str .= $v;
			}
		}

		$str .= '</ul></div>';
		
		return $str;
	}

	public static function showBack($mode, $key=null, $edited=false, $add='', $class='', $access_role=null, $page_escape=null){

		switch($mode){
			case 'edit':
				return self::getButton('lst',null, $add, $class.' btn-sm', false, false, $access_role, $page_escape);
			break;
			case 'add':
				return self::getButton('lst',null, $add, $class.' btn-sm', false, false, $access_role, $page_escape);
			break;
			case 'detail':
				return self::getButton('lst',null, $add, $class.' btn-sm', false, false, $access_role, $page_escape);
			break;
		}
		
		return '';
	}

	public static function showMenuMode($mode, $key=null, $edited=false, $add='', $class='', $access_role=null, $page_escape=null, $addmenu=array()) {

		$ci = get_instance();

		if(!$access_role)
			$access_role = $ci->access_role;

		$str = self::startMenu($mode=='inlist');

		if(is_array($ci->addbuttons) && count($ci->addbuttons) && $mode!='save'){
			foreach ($ci->addbuttons as $k => $value) {
				$str .= self::getMenu($value,$key, $add, $class, false, false, $access_role, $page_escape);
			}
		}

		if(is_array($ci->buttons) && count($ci->buttons) && $mode!='save'){
			foreach ($ci->buttons as $k => $value) {
				$str .= self::getMenu($value,$key, $add, $class, false, false, $access_role, $page_escape);
			}

			$str .= '</ul></div>';
			
			return $str;
		}

		if(is_array($addmenu) && count($addmenu)){
			foreach($addmenu as $k=>$v){
				$str .= $v;
			}
		}

		if(strstr($mode,"|")!==false){
			$modearr = explode("|", $mode);

			if(count($modearr)){
				$str = "";
				foreach ($modearr as $v) {
					$str .= self::getMenu($v, $key, $add, $class, false, false, $access_role, $page_escape);
				}

				$str .= '</ul></div>';
				
				return $str;
			}
		}

		switch($mode){
			case 'inlist':
				$str .= self::getMenu('edit', $key, $add, $class, false, false, $access_role, $page_escape);
				$str .= self::getMenu('delete', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'lst':
			case 'index':
				$str = self::getButton('add',null, $add, $class, false, false, $access_role, $page_escape);
				return $str .= self::getButton('print',null, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'edit_detail':
				if($edited)
					$str .= "";
				else
					$str .= self::getMenu('edit', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'oneedit':
				$str .= self::getMenu('detail', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'onedetail':
				$str .= self::getMenu('edit', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'import':
				$str .= self::getMenu('import', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'edit':
				$str .= self::getMenu('add',null, $add, $class, false, false, $access_role, $page_escape);
				$str .= self::getMenu('delete', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'add':
				return '';
			break;
			case 'detail':
				$str .= self::getMenu('add',null, $add, $class, false, false, $access_role, $page_escape);
				$str .= self::getMenu('edit', $key, $add, $class, false, false, $access_role, $page_escape);
				$str .= self::getMenu('delete', $key, $add, $class, false, false, $access_role, $page_escape);
			break;
			case 'blank':
				return '';
			break;
		}

		$str .= '</ul></div>';
		
		return $str;
	}

	public static function getMenu($id, $key=null, $add='', $class='', $label=false, $action=false, $access_role=null, $page_escape=null) {

		$ci = get_instance();

		if(!$page_escape)
			$page_escape = array_values($ci->page_escape);

		if(!$access_role)
			$access_role = $ci->access_role;

		$tempid = $id;

		if($id=='detail')
			$tempid = 'index';

		if(
			$ci->private == true
			&&
			!$access_role[$id]
			&&
			!in_array($ci->page_ctrl, $page_escape)
			&&
			!$ci->is_super_admin
			&&
			!in_array($id, $ci->addbuttons)
		){
			return false;
		}

		if(!$access_role[$id])
			return false;

		if($ci->data['add_param']){
			$add_param = '/'.$ci->data['add_param'];
		}


		if ($id === 'add') {
			return ' <li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goAdd()').'" ><span class="glyphicon glyphicon-plus"></span> '.($label?$label:'Add New').'</a> </li> '.(!$action?'
			<script>
		    function goAdd(){
		        window.location = "'.base_url($ci->page_ctrl."/add".$add_param).'";
		    }
		    </script>':'');
		}

		if ($id === 'import') {
			return '<button type="button" '.$add.' class="btn waves-effect '.$class.' btn-primary" onclick="'.($action?$action:'goImport()').'" ><span class="glyphicon glyphicon-import"></span> '.($label?$label:'Import').'</a> </li>'.(!$action?'
			<script>
		    function goImport(){
		        window.location = "'.base_url($ci->page_ctrl."/import".$add_param).'";
		    }
		    </script>':'');
		}

		if ($id === 'edit' && $key) {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goEdit(\''.$key.'\')').'" ><span class="glyphicon glyphicon-edit"></span> '.(($label!==false)?$label:'Edit').'</a> </li>'.(!$action?'
			<script>
		    function goEdit(id){
		        window.location = "'.base_url($ci->page_ctrl."/edit".$add_param).'/"+id;
		    }
		    </script>':'');
		}

		if ($id === 'detail' && $key) {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goDetail(\''.$key.'\')').'" ><span class="glyphicon glyphicon-eye-open"></span> '.($label?$label:'Detail').'</a> </li> '.(!$action?'
			<script>
		    function goDetail(id){
		        window.location = "'.base_url($ci->page_ctrl."/detail".$add_param).'/"+id;
		    }
		    </script>':'');
		}

		if ($id === 'delete' && $key) {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goDelete(\''.$key.'\')').'" ><span class="glyphicon glyphicon-remove"></span> '.($label!==false?$label:'Delete').'</a> </li>'.(!$action?'
			<script>
		    function goDelete(id){
		        if(confirm("Apakah Anda yakin akan menghapus ?")){
		            window.location = "'.base_url($ci->page_ctrl."/delete".$add_param).'/"+id;
		        }
		    }
		    </script>':'');
		}

		if ($id === 'lst' || $id === 'index') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goList()').'" ><span class="glyphicon glyphicon-arrow-left"></span> '.($label?$label:'Back').'</a> </li>  '.(!$action?'
			<script>
			function goList(){
			window.location = "'.base_url($ci->page_ctrl."/index".$add_param).'";
			}
			</script>':'');
		}

		if ($id === 'save') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goSave()').'" ><span class="glyphicon glyphicon-floppy-save"></span> '.($label?$label:'Save').'</a> </li>'.(!$action?'
			<script>
			function goSave(){
				$("#main_form").submit(function(e){
					if(e){
						$(".btn-save").attr("disabled","disabled");
				      	$("#act").val(\'save\');
					}else{
						return false;
					}
				});
			}
			</script>':'');
		}

		if ($id === 'batal') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goBatal(\''.$key.'\')').'" ><span class="glyphicon glyphicon-repeat"></span> '.($label?$label:'Reload').'</a> </li>'.(!$action?'
			<script>
			function goBatal(){
				$("#act").val(\'reset\');
				$("#main_form").submit();
			}
			</script>':'');
		}

		if ($id === 'print') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goPrint(\''.$key.'\')').'" ><span class="glyphicon glyphicon-print"></span> '.($label?$label:'Print').'</a> </li> '.(!$action?'
			<script>
			function goPrint(){
		        $("#act").val("list_search");
				window.open("'.base_url($ci->page_ctrl."/go_print".$add_param).'/?"+$("#main_form").serialize(),"_blank");
			}
			</script>':'');
		}

		if ($id === 'expportexcel') {
			return '<script src="'.base_url().'assets/js/excellentexport.min.js"></script>
			&nbsp;<a download="export-excel.xls" class="btn waves-effect btn-sm btn-primary" href="#" onclick="return ExcellentExport.excel(this, \'table-export\', \'Export Excel\',\'filter-table\');"><i class="glyphicon glyphicon-export"></i> Excel</a>&nbsp;';
		}

		if ($id === 'reset') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goReset()').'" ><span class="glyphicon glyphicon-refresh"></span> '.($label?$label:'Reset').'</a> </li>  '.(!$action?'
			<script>
			function goReset(){
				$("#act").val(\'list_reset\');
				$("#main_form").submit();
			}
			</script>':'');
		}

		if ($id === 'applyfilter') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goSearch()').'" ><span class="glyphicon glyphicon-search"></span>'.($label?$label:'Terapkan Filter').'</a> </li>  '.(!$action?'
			<script>
		    function goSearch(){
		        jQuery("#act").val("list_search");
		        jQuery("#main_form").submit();
		    }
			</script>':'');
		}

		if ($id === 'filter') {
			return '<li><a href="javascript:void(0)" '.$add.' class="waves-effect '.$class.'" onclick="'.($action?$action:'goSearch()').'" ><span class="glyphicon glyphicon-search"></span> '.($label?$label:'Filter').'</a> </li> '.(!$action?'
			<script>
		    function goSearch(){
		        jQuery("#act").val("list_filter");
		        jQuery("#main_form").submit();
		    }
			</script>':'');
		}

	}

    function token_page(){
    	$ci = get_instance();
		$token_page = substr(md5(microtime()),rand(0,26),5);
		$ci->session->SetPage('_token',$token_page);
		return $token_page;
    }

    public static function createForm($rows=array()){

		if($rows['field']){
		$rows['name'] = $rows['field'];
		}
		$edited = true;

		if(!$rows['width'])
			$rows['width'] = "400px";

		switch ($rows['type']) {
		case 'list':
		  $form = self::createSelect("list_search_filter[".$rows['name']."]",$rows['value'],null,$edited,'form-control',"style='max-width:$rows[width];'");
		  break;

		case 'date':
		  $form = self::createTextBox("list_search[".$rows['name']."]",null,'','',$edited,'form-control datepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'");
		  break;

		case 'datetime':
		  $form = self::createTextBox("list_search[".$rows['name']."]",null,'','',$edited,'form-control datetimepicker','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'");
		  break;

		case 'number':
		  $form = self::createTextNumber("list_search[".$rows['name']."]",null,'','',$edited,'form-control',"style='max-width:$rows[width];'");
		  break;

		default:
		  $form = self::createTextBox("list_search[".$rows['name']."]",null,'','',$edited,'form-control','placeholder="Search '.$rows['label'].'..." '."style='max-width:$rows[width];'");
		  break;
		}

		return $form;
    }

	public static function createUploadMultiple($nameid, $value, $page_ctrl, $edit=false, $label="Select files...", $add_param=null){
		$label="Select files...";
		if($edit){
			$ta = '<div id="'.$nameid.'progress" class="progress" style="display:none">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>';
		}
		$ta .= '<div id="'.$nameid.'files" class="files read_detail">';

		if($value['name']){
			foreach($value['name'] as $k=>$v){
				if(!@$value['id'][$k])
					continue;

				$k = $value['id'][$k];

				$ta .= "<p class='".$nameid.$k." pfile'><a target='_BLANK' href='".site_url($page_ctrl."/open_file/".$add_param.$k)."'>$v</a> ";

				if($edit)
					$ta .= "<a href='javascript:void(0)' class='btn btn-danger btn-xs' onclick='remove$nameid($k)'>x</a>";

				$ta .= "</p>";

				if($edit){
					$ta .= "<input type='hidden' class='".$nameid.$k."' name='".$nameid."[id][]' value='".$k."'/>";
					$ta .= "<input type='hidden' class='".$nameid.$k."' name='".$nameid."[name][]' value='".$v."'/>";
				}
			}
		}

		$ta .= '</div>';

		if($edit){
			$ci = get_instance();
			$configfile = $ci->config->item("file_upload_config");

			$extstr = $configfile['allowed_types'];
			$max = (round($configfile['max_size']/1000))." Mb";

			$ta .= '<div id="'.$nameid.'errors" style="color:red"></div>';
			$ta .= '<span class="label label-upload">Ext : '.str_replace("|", ",", $extstr).'</span> &nbsp;&nbsp;&nbsp;';
			$ta .= '<span class="label label-upload">Max : '.$max.'</span>';

			$ta .= '<br/><span class="btn btn-upload fileinput-button">
		        <i class="glyphicon glyphicon-upload"></i>
		        <span>'.$label.'</span>
		        <input id="'.$nameid.'upload" name="'.$nameid.'upload" type="file" multiple>
		    </span>';
		}

		if($edit){
			$ta .= "<script>$(function () {
    			'use strict';
			    $('#".$nameid."upload').fileupload({
			        url: \"".site_url($page_ctrl."/upload_file")."\",
			        dataType: 'json',
			        done: function (e, data) {

			            if(data.result.file){
			            	var file = data.result.file;
			                $('<p class=\"".$nameid."'+file.id+' pfile\"><a target=\"_BLANK\" href=\"".site_url($page_ctrl."/open_file")."/'+file.id+'\">'+file.name+'</a> <a href=\"javascript:void(0)\" class=\"btn btn-danger btn-xs\" onclick=\"remove$nameid('+file.id+')\">x</a></p>').appendTo('#".$nameid."files');
			                $('<input type=\"hidden\" class=\"".$nameid."'+file.id+'\" name=\"".$nameid."[id][]\" value=\"'+file.id+'\"><input type=\"hidden\" class=\"".$nameid."'+file.id+'\" name=\"".$nameid."[name][]\" value=\"'+file.name+'\">').appendTo('#".$nameid."files');
				        }

			            if(data.result.error){
			            	var error = data.result.error;
			                $('<p onclick=\"$(this).remove()\">'+error+'</p>').appendTo('#".$nameid."errors');
				        }

			            $('#".$nameid."progress').hide();
			        },
			        progressall: function (e, data) {
			            $('#".$nameid."progress').show();
			            var progress = parseInt(data.loaded / data.total * 100, 10);
			            $('#".$nameid."progress .progress-bar').css(
			                'width',
			                progress + '%'
			            );
			        },
			        fail: function(a, data){
	                	$('<p onclick=\"$(this).remove()\">'+data.errorThrown+'</p>').appendTo('#".$nameid."errors');
			            $('#".$nameid."progress').hide();
			        }
			    }).prop('disabled', !$.support.fileInput)
			        .parent().addClass($.support.fileInput ? undefined : 'disabled');
			});
			function remove$nameid(id){
				if(confirm('Yakin akan menghapus file ini ?')){
					$.ajax({
				        url: \"".site_url($page_ctrl."/delete_file/$add_param")."\",
				        data:{id:id,name:'$nameid'},
				        dataType: 'json',
				        type: 'post',
				        success:function(data){
				        	if(data.success)
				        		$('.$nameid'+id).remove();
				        	else
			                	$('<p onclick=\"$(this).remove()\">'+data.error+'</p>').appendTo('#".$nameid."errors');

				        },
				        error:function(err){
		                	$('<p onclick=\"$(this).remove()\">'+err.statusText+'</p>').appendTo('#".$nameid."errors');
				        }
					});
				}
			}
			</script>";
		}

		return $ta;
	}

	public static function createUpload($nameid, $value, $page_ctrl, $edit=false, $label="Select files...", $add_param=null, $allowed_types=null){
		$label="Select files...";
		$nameid1 = str_replace(array("[","]"),"",$nameid);
		
		if($edit){
			$ta = '<div id="'.$nameid1.'progress" class="progress" style="display:none">
		        <div class="progress-bar progress-bar-success"></div>
		    </div>';
		}
		$ta .= '<div id="'.$nameid1.'files" class="files">';

		if($value['name']){

			$k = $value['id'];
			$v = $value['name'];

			$ta .= "<p class='".$nameid1.$k." pfile'><a target='_BLANK' href='".site_url($page_ctrl."/open_file/".$add_param.$k)."'>$v</a> ";

			if($edit)
				$ta .= "<a href='javascript:void(0)' class='btn btn-danger btn-xs' onclick='remove$nameid1($k)'>x</a>";

			$ta .= "</p>";

			if($edit){
				$ta .= "<input type='hidden' class='".$nameid1.$k."' name='".$nameid."[id]' value='".$k."'/>";
				$ta .= "<input type='hidden' class='".$nameid1.$k."' name='".$nameid."[name]' value='".$v."'/>";
			}
		}

		$ta .= '</div>';

		if($edit){
			$ci = get_instance();
			$configfile = $ci->config->item("file_upload_config");

			if($allowed_types)
				$extstr = $allowed_types;
			else
				$extstr = $configfile['allowed_types'];
			
			$max = (round($configfile['max_size']/1000))." Mb";

			$ta .= '<div id="'.$nameid1.'errors" style="color:red"></div>';
			$ta .= '<div id="btn'.$nameid1.'"';

			if($value['name']){
				$ta .= " style='display:none' ";
			}

			$ta .= '><span class="label label-upload">Ext : '.str_replace("|", ",", $extstr).'</span> &nbsp;&nbsp;&nbsp;';
			$ta .= '<span class="label label-upload">Max : '.$max.'</span>';

			$ta .= '<br/><span class="btn btn-upload fileinput-button">
		        <i class="glyphicon glyphicon-upload"></i>
		        <span>'.$label.'</span>
		        <input id="'.$nameid1.'upload" name="'.$nameid1.'upload" type="file">
		    </span></div>';
		}

		if($edit){
			
			$add = null;
			if($ci->data['row'][$ci->pk])
				$add = "/".$ci->data['row'][$ci->pk];

			$ta .= "<script>
				$(function () {";

			if($value['name']){
				$ta .= "$('#btn".$nameid1."').hide();";
			}

			$ta .="
    			'use strict';
			    $('#".$nameid1."upload').fileupload({
			        url: \"".site_url($page_ctrl."/upload_file".$add)."\",
			        dataType: 'json',
			        done: function (e, data) {
			        	$('#".$nameid1."errors').html('');
			            if(data.result.file){
		        			$('#btn".$nameid1."').hide();
			            	var file = data.result.file;
			                $('<p class=\"".$nameid1."'+file.id+' pfile\"><a target=\"_BLANK\" href=\"".site_url($page_ctrl."/open_file")."/'+file.id+'\">'+file.name+'</a> <a href=\"javascript:void(0)\" class=\"btn btn-danger btn-xs\" onclick=\"remove$nameid1('+file.id+')\">x</a></p>').appendTo('#".$nameid1."files');
			                $('<input type=\"hidden\" class=\"".$nameid1."'+file.id+'\" name=\"".$nameid."[id]\" value=\"'+file.id+'\"><input type=\"hidden\" class=\"".$nameid1."'+file.id+'\" name=\"".$nameid."[name]\" value=\"'+file.name+'\">').appendTo('#".$nameid1."files');
				        }

			            if(data.result.error){
		        			$('#btn".$nameid1."').show();
			            	var error = data.result.error;
			                $('<p onclick=\"$(this).remove()\">'+error+'</p>').appendTo('#".$nameid1."errors');
				        }

			            $('#".$nameid1."progress').hide();
			        },
			        progressall: function (e, data) {
			            $('#".$nameid1."progress').show();
			            var progress = parseInt(data.loaded / data.total * 100, 10);
			            $('#".$nameid1."progress .progress-bar').css(
			                'width',
			                progress + '%'
			            );
		        		$('#btn".$nameid1."').hide();
			        },
			        fail: function(a, data){
			        	$('#".$nameid1."errors').html('');
	                	$('<p onclick=\"$(this).remove()\">'+data.errorThrown+'</p>').appendTo('#".$nameid1."errors');
			            $('#".$nameid1."progress').hide();
		        		$('#btn".$nameid1."').show();
			        }
			    }).prop('disabled', !$.support.fileInput)
			        .parent().addClass($.support.fileInput ? undefined : 'disabled');
			});";

		$ta .= "
			function remove$nameid1(id){
				if(confirm('Yakin akan menghapus file ini ?')){
					$.ajax({
				        url: \"".site_url($page_ctrl."/delete_file/$add_param")."\",
				        data:{id:id,name:'$nameid1'},
				        dataType: 'json',
				        type: 'post',
				        success:function(data){
			        		$('#".$nameid1."errors').html('');
				        	if(data.success){
				        		$('.$nameid1'+id).remove();
				        		$('#btn".$nameid1."').show();
				        	}
				        	else{
			                	$('<p onclick=\"$(this).remove()\">'+data.error+'</p>').appendTo('#".$nameid1."errors');
				        		$('#btn".$nameid1."').hide();
				        	}

				        },
				        error:function(err){
			        		$('#".$nameid1."errors').html('');
			        		$('#btn".$nameid1."').hide();
		                	$('<p onclick=\"$(this).remove()\">'+err.statusText+'</p>').appendTo('#".$nameid1."errors');
				        }
					});
				}
			}
			</script>";
		}

		return $ta;
	}

	public static function createExportImport($nameid="import", $value=null, $page_ctrl=null, $edit=true, $id_detail=null, $more_info=null){
		$nameid1 = str_replace(array("[","]"),"",$nameid);

		$ci = get_instance();

		if(!$page_ctrl)
			 $page_ctrl = $ci->page_ctrl;

		if(!$ci->access_role['add'] && !$ci->access_role['import_list'])
			return;

		if($ci->data['add_param'])
			$add = "/".$ci->data['add_param'];

        $header = $ci->HeaderExport();

		$pk = $ci->model->pk;

		if($ci->modeldetail->pk){
			$add .= "/".$ci->data['row'][$pk];
			$pk = $ci->modeldetail->pk;
		}

		if($id_detail)
			$add .= "/".$id_detail;
		
		$ta = '<div id="'.$nameid1.'progress" class="progress" style="display:none">
	        <div class="progress-bar progress-bar-success"> Loading .... </div>
	    </div>';

		$ta .= '<div id="'.$nameid1.'errors" style="color:red; text-align:left"></div>';

		$ta .= '<div id="btn'.$nameid1.'">
		<button style="padding: 0px;line-height: 0;font-size: 24px;" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal'.$nameid1.'">
<i class="glyphicon glyphicon-info-sign"></i>
</button>

<div class="modal fade" id="myModal'.$nameid1.'" tabindex="-1" role="dialog" aria-labelledby="myModal'.$nameid1.'Label" style="text-align:left">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModal'.$nameid1.'Label">Petunjuk Import</h4>
      </div>
      <div class="modal-body">
        <ul>
        	<li>Download template dengan cara export data.</li><li>Jangan merubah urutan atau menghapus kolom.</li>';

        	if($pk)
        		$ta .= '<li>Jika data baru, kolom <b>'.$pk.'</b> silahkan dikosongi.</li>';

        	$ta .= $more_info;
        	
        	foreach($header as $r){
        		if($r['required']){
        			$ta .= "<li>$r[name] wajib diisi.</li>";
        		}
        		if($r['type']=='list'){
        			$ta .= "<li>$r[name] harus diisi dengan kode berikut:<br/>";
        			$temparr = array();
        			unset($r['value']['']);
        			if($r['value'])
        				foreach($r['value'] as $k=>$v){
        				$temparr[] = "$k : $v";
        			}
        			$ta .= implode("<br/>", $temparr);
        			$ta .= "</li>";

        		}
        		if($r['type']=='listinverst'){
        			$ta .= "<li>$r[name] harus diisi dengan kode berikut:<br/>";
        			$temparr = array();
        			unset($r['value']['']);
        			if($r['value'])
        				foreach($r['value'] as $k=>$v){
        				$temparr[] = "- $v";
        			}
        			$ta .= implode("<br/>", $temparr);
        			$ta .= "</li>";

        		}
        	}
       	$ta .='
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
      </div>
    </div>
  </div>
</div>
		
		<button class="btn btn-export fileinput-button" type="button" onclick="window.location=\''.site_url($page_ctrl."/export_list".$add).'\'">
	        <i class="glyphicon glyphicon-download"></i>
		Export
		</button>
		<span class="btn btn-import fileinput-button">
	        <i class="glyphicon glyphicon-upload"></i>
	        <span>Import Data</span>
	        <input id="'.$nameid1.'upload" name="'.$nameid1.'upload" type="file">
	    </span></div>';

		$ta .= "<script>
			$(function () {
			'use strict';
		    $('#".$nameid1."upload').fileupload({
		        url: \"".site_url($page_ctrl."/import_list".$add)."\",
		        dataType: 'json',
		        done: function (e, data) {
		        	$('#".$nameid1."errors').html('');
		            if(data.result.success){
	        			$('#btn".$nameid1."').hide();
		            	window.location='';
			        }

		            if(data.result.error){
	        			$('#btn".$nameid1."').show();
		            	var error = data.result.error;
		                $('<p onclick=\"$(this).remove()\">'+error+'</p>').appendTo('#".$nameid1."errors');
			        }

		            $('#".$nameid1."progress').hide();
		        },
		        progressall: function (e, data) {
		            $('#".$nameid1."progress').show();
		            var progress = parseInt(data.loaded / data.total * 100, 10);
		            $('#".$nameid1."progress .progress-bar').css(
		                'width',
		                progress + '%'
		            );
	        		$('#btn".$nameid1."').hide();
		        },
		        fail: function(a, data){
		        	$('#".$nameid1."errors').html('');
                	$('<p onclick=\"$(this).remove()\">'+data.errorThrown+'</p>').appendTo('#".$nameid1."errors');
		            $('#".$nameid1."progress').hide();
	        		$('#btn".$nameid1."').show();
		        }
		    }).prop('disabled', !$.support.fileInput)
		        .parent().addClass($.support.fileInput ? undefined : 'disabled');
		});
		</script><div style='clear:both;margin-bottom:5px' class='clear-fix'></div>";

		return $ta;
	}	
}