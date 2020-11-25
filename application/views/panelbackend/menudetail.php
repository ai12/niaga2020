<style type="text/css">
	#sys_group_result{
		/*background: #ccceee;
	    padding: 5px;
	    border-radius: 5px;*/
	    margin-top: 5px;
	}
</style>
<div class="col-sm-6">
<?php
	$from = UI::createSelect('parent_id', $menuarr, $row['parent_id'], $edited, 'form-control ', "style='width:auto; max-width:100%;'");
	echo UI::createFormGroup($from, $rules["parent_id"], "parent_id", "Parent");
	?>
	<?php
	$from = UI::createTextBox('label', $row['label'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["label"], "label", "Label");
	?>
	<?php
	$from = UI::createTextBox('iconcls', $row['iconcls'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["iconcls"], "iconcls", "Iconcls");
	?>
	<?php
	$from = UI::createTextBox('url', $row['url'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["url"], "url", "Url");
	?>
	<?php
	$from = UI::createTextBox('visible', $row['visible'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["visible"], "visible", "Visible");
	?>
	<?php
	$from = UI::createTextBox('state', $row['state'], '200', '100', $edited, 'form-control ', "style='width:100%'");
	echo UI::createFormGroup($from, $rules["state"], "state", "State");
	?>
	<?php
	$from = UI::createTextNumber('sort', $row['sort'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
	echo UI::createFormGroup($from, $rules["sort"], "sort", "Sort");
	?>
	<?php
		$from = UI::showButtonMode("save", null, $edited);
		$form = UI::createFormGroup($from, null, null, null, true);

		$cbgr = "<div class='form-group'>";
		$cbgr .= '<label for="sys_group" class="col-sm-4 control-label">&nbsp;</label>';
		$cbgr .= "<div class='col-sm-8'>$form";
		$cbgr .= "</div>";
		$cbgr .= "</div>";
		echo $cbgr;
	
	?>
</div>
<?php if($mode == 'edit'):?>
<div class="col-sm-6">
	<?php 
		$menu_id = $row['menu_id'];

		if($menu_id)
		{
			// print_r($groupcb);
			$cbgr = "<div class='form-group'>";
			$cbgr .= '<label for="sys_group" class="col-sm-4 control-label">Tambahkan ke group</label>';
			$cbgr .= "<div class='col-sm-8'>";
			$cbgr .= "<select name='sys_group' id='sys_group' class='form-control' onchange='sys_group_change()'>";
			foreach ($groupcb as $gr) {
				$cbgr .= "<option value='$gr[key]'>$gr[val]</option>";
			}
			$cbgr .= "</select>";
			$cbgr .= "<label id='sys_group_result'></label>";
			$cbgr .= "</div>";
			$cbgr .= "</div>";
			$cbgr .= "<div class='form-group'>";
			$cbgr .= '<label for="sys_group_data" class="col-sm-4 control-label">&nbsp;</label>';
			$cbgr .= "<div class='col-sm-8' id='sys_group_data'>";
			$cbgr .= "</div>";
			$cbgr .= "</div>";
			$cbgr .= "<div class='form-group'>";
			$cbgr .= '<label for="sys_group_action" class="col-sm-4 control-label">&nbsp;</label>';
			$cbgr .= "<div class='col-sm-8'>";
			$cbgr .= "<a href='#' class='btn btn-sm btn-success save-group-action' onclick='saveGroupActionClick()'>Save</a>";
			$cbgr .= "<a href='#' class='btn btn-sm btn-danger delete-group-action' onclick='deleteGroupActionClick()'>Delete</a>";
			$cbgr .= "</div>";
			$cbgr .= "</div>";
			echo $cbgr;
		}
	?>

	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		sys_group_change()
	})
	function sys_group_change() {
		var sys_group_id = $("#sys_group").val();
		var menu_id = <?= $row['menu_id']; ?>;
		$.ajax({
			type:'post',
			data:{sys_group_id:sys_group_id,menu_id:menu_id},
			url:"<?=base_url('om/sys_menu/get_group_menu')?>",
			success:function(e){
				var r =eval("("+e+")");
				// if(r)
				$("#sys_group_result").text(r.group)
				if(r.group =='Terdaftar')
				{
					$(".delete-group-action").show()
				}
				else
				{
					$(".delete-group-action").hide()
				}
				$("#sys_group_data").html(r.select)
			}

		})
	}
	function saveGroupActionClick() {
		var sys_group_id = $("#sys_group").val();
		var action_group_id = $("#action_group").val();
		var menu_id = <?= $row['menu_id']; ?>;
		$.ajax({
			type:'post',
			data:{sys_group_id:sys_group_id,menu_id:menu_id,action_group_id:action_group_id},
			url:"<?=base_url('om/sys_menu/store_group_menu')?>",
			success:function(e){
				sys_group_change()
			}
		})
	}
</script>
<?php endif;?>