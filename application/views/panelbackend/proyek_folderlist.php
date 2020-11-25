<ol class="breadcrumb" style="margin: -15px -15px 0px -15px;">
  <li><a href="<?=site_url("panelbackend/proyek_folder/index/$id_proyek")?>">MAIN</a></li>
  <?php
  foreach($breadcrumb as $k=>$r){
  	if($k<count($breadcrumb)-1)
  		echo '<li><a href="'.site_url("panelbackend/proyek_folder/index/$id_proyek/$r[id_proyek_folder]").'">'.$r['nama'].'</a></li>';
  }
  if($breadcrumb){
  ?>
	  <li><?=$r['nama']?></li>
	<?php } ?>
</ol>
<div style="clear: both;"></div>
<div class="row">
<table class="table table-hover">
	<?php 
	foreach($rows as  $r){
	if($r['id_proyek_folder']==$this->post['key'] && $this->post['act']=='edit'){ ?>
		<tr>
			<td><input type='text' name="nama" style='width:100%' value="<?=$r['nama']?>"/></td>
			<td align="right" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_edit',<?=$r['id_proyek_folder']?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
		</tr>
	<?php 
	}else{ 
	$menuarr = array();
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('edit', $r[id_proyek_folder])\" ><span class=\"glyphicon glyphicon-edit\"></span> Edit</a> </li> ";
	$menuarr[] = " <li><a href=\"javascript:void(0)\" class=\"waves-effect\" onclick=\"goSubmitValue('delete', $r[id_proyek_folder])\" ><span class=\"glyphicon glyphicon-remove\"></span> Delete</a> </li> "
	?>
	<tr>
		<td><a href="<?=site_url('panelbackend/proyek_folder/index/'.$r['id_proyek'].'/'.$r['id_proyek_folder'])?>"><?=nl2br($r['nama'])?></a></td>
		<td align="right" width="1px"><?=UI::showMenu($menuarr)?></td>
	</tr>
	<?php }
	} if($id_proyek_folder){ ?>
		<tr>
			<td colspan="2">
			<?=UI::createUploadMultiple("file_".$id_proyek.'_'.$id_proyek_folder, $rowsfile, $page_ctrl, $this->access_role['edit']);?>
			</td>
		</tr>
	<?php } 
	if($this->post['act']=='add' && $id_parent==$this->post['key']){ 
	?>
	<tr>
		<td><input name="nama" style='width:100%' type="text" /></td></td>
		<td align="right" width="1px" style="padding-top: 5px !important;"><a href="javascript::void(0)" onclick="goSubmitValue('save_add',<?=$id_parent?>)"><span class="glyphicon glyphicon-floppy-save"></span></a></td>
	</tr>
	<?php }else{ ?>
	<tr>
		<td align="right"></td>
		<td align="right" width="1px"><a href="javascript:void(0)" onclick="goSubmitValue('add')"><span class="glyphicon glyphicon-plus"></span></a></td>
	</tr>
	<?php } ?>
</table>
</div>