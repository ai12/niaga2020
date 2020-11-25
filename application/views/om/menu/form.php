<div class="row">	
<div class="col-sm-6">
	<?php 
	//debug($label_setting);
	foreach($label_setting as $k=>$rw){
		?>
		<div class="form-group" <?php echo (isset($rw['hidden']))?'style="display:none"':'';?>>
			<label for="id_proposal" class="col-sm-4 control-label"><?php echo $rw['label'] ?> <?php echo ($rw['required']==true)?required_sign():'';?></label>
			<div class="col-sm-8">
			<?php if (!isset($rw['value'])) { 
				
				?>
				<?php 
					echo formInput($k,$row[$k],$rw, $readonly);?>
			<?php }else{
					echo formSelect($k,$row[$k],$rw['value'],$rw , $readonly);
			 }?>
			</div>
		</div>
		<?php
	}?>
</div>
</div>