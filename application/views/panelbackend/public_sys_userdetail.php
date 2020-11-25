<div class="col-sm-6">

<?php 
$form = UI::createSelect('nid',$nidarr,$row['nid'],$edited,$class='form-control select2',"style='width:100%' data-ajax--data-type=\"json\" data-ajax--url=\"".site_url('panelbackend/ajax/listpegawai')."\"");
echo UI::createFormGroup($form, null, "nid", "Pegawai");
?>

<?php 
$from = UI::createTextBox('username',$row['username'],'100','100',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["username"], "username", "Username");
?>

<?php 
$from = UI::createSelect('group_id',$publicsysgrouparr,$row['group_id'],$edited,$class='form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["group_id"], "group_id", "Group ID");
?>

<?php 
$from = UI::createTextBox('name',$row['name'],'200','100',$edited,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["name"], "name", "Name");
?>

<?php 
if(!$row[$this->pk] && !isset($row['is_active'])){
	$row['is_active'] = 1;
}
$from = UI::createCheckBox('is_active',1,$row['is_active'],null,$edited,$class='iCheck-helper ',"style='margin:10px 0px'");
echo UI::createFormGroup($from, $rules["is_active"], "is_active", "Active");
?>

</div>
<div class="col-sm-6">
			

<?php if($edited){?>
<?php if($row[$this->pk]){ ?>
<?php 
$from = "Kosongkan password apabila Anda tidak ingin merubahnya.";
echo UI::createFormGroup($from, null, null, "");
?>
<?php } ?>
<?php 
$from = UI::createTextPassword('password','','','',$edited,$class='form-control ');
echo UI::createFormGroup($from, $rules["password"], "password", "Password");
?>
<?php 
$from = UI::createTextPassword('confirmpassword','','','',$edited,$class='form-control');
echo UI::createFormGroup($from, $rules["confirmpassword"], "confirmpassword", "Confirm Password");
?>
<?php }?>


<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from);
?>
</div>

<?php if($edited){ ?>
<script type="text/javascript">
	$("#nid").on("select2:select", function (e) {
		$("#username").val($("#nid").val());
		$("#name").val($("#nid option:selected").text());
	});
</script>
<?php } ?>