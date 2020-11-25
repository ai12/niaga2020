<div class="col-sm-6">
	<div class="form-group">
		<label for="group_id" class="col-sm-4 control-label">Group</label>
		<div class="col-sm-8">
			<select class="form-control" name="group_id" id="group_id">
				<?php 
					foreach ($optParents as $parent) 
					{
						//echo "<optgroup label='$parent[group_name]'>";
						foreach ($optDetails as $detail) {
							if($parent['id'] == $detail['parent_id'])
							{
								echo "<option value='$detail[id]'>$detail[group_name]</option>";
							}
						}
						//echo "</optgroup>";
					}
				?>
			</select>
		</div>
	</div>
<?php 
$from = UI::createTextBox('nama',$row['nama'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Uraian");
?>

<?php 
$from = UI::createTextBox('vol',$row['vol'],'10','10',$edited,'form-control',"style='text-align:right; width:190px'");
echo UI::createFormGroup($from, null, "vol", "Vol");
?>

<?php 
$from = UI::createTextBox('satuan',$row['satuan'],'10','10',$edited,'form-control',"style='text-align:right; width:190px'");
echo UI::createFormGroup($from, null, "satuan", "Satuan");
?>

<?php 
$from = UI::createTextNumber('hrg_satuan', $row['hrg_satuan'], '200', '100', $edited, 'form-control ', "style='text-align:right; width:190px' min='0' max='10000000000' step='1'");
echo UI::createFormGroup($from, null, "hrg_satuan", "Harga Satuan");
?>

<?php 

$uuid = $row['id'] ? $row['id'] : uuid();
?>
<input type="hidden" name="id" value="<?=$uuid?>">

</div>
<div class="col-sm-6">
                

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
</div>