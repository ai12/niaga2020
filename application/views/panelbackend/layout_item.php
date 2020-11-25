<section class="content-header" <?=($width?"style='max-width:$width; margin-right:auto; margin-left:auto;'":"")?>>
<?php if($page_title){ ?>
  <h1>
      <?=$page_title?>
      <?php if($sub_page_title){ ?> <small><?=$sub_page_title?></small> <?php }?>
  </h1>
<?php } ?>
</section>
<section class="content" <?=($width?"style='max-width:$width'":"")?>>
  <div class="box box-default">
    <div class="box-header with-border">      
      <div class="pull-left">
            <div class="dropdown pull-left" style="margin-top: 7px;">
              <a class="dropdown-toggle" href="javascrit:void(0)" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                <span class="glyphicon glyphicon-option-vertical"></span>
              </a>
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?=site_url("panelbackend/mt_spec_item/add")?>">Add</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?=site_url("panelbackend/mt_spec_item/edit/".$rowheader1['id_spec_item'])?>">Edit</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="deleteHps()">Delete</a></li>
              </ul>
              <script type="text/javascript">
                function deleteHps(){
                  if(confirm('Apakah Anda akan menghapus HPS ini ?'))
                    window.location = "<?=site_url("panelbackend/mt_spec_item/delete/".$rowheader1['id_spec_item'])?>";
                  else
                    return false;
                }
              </script>
            </div>

            &nbsp; &nbsp; <a href="<?=site_url("panelbackend/mt_spec_item/index")?>" class="btn btn-default btn-sm">Daftar Item</a>
      </div>
      <div class="pull-right">
          <?php echo UI::showButtonMode($mode, $row[$pk])?>
      </div>
    </div>
    <div class="box-body">

      <?php  if(($_SESSION[SESSION_APP]['loginas'])){ ?>
      <div class="alert alert-warning">
          Anda sedang mengakses user lain. <a href="<?=base_url("panelbackend/home/loginasback")?>" class="alert-link">Kembali</a>.
      </div>
      <?php }?>

      <?=FlashMsg()?>

<div class="col-sm-12 no-padding">

<?php 
$from = UI::createTextBox('nama',$rowheader1['nama'],'200','100',$editedheader,$class='form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["nama"], "nama", "Nama Item",false, 2);
?>
</div>

      <?php echo $content1;?>
      <div style="clear: both;"></div>

    </div>
    <?php if($layout_footer){ ?>
    <div class="box-footer with-border">
        <?=$layout_footer?>
    </div>
    <?php } ?>
  </div><!-- /.box -->
</section>

<style type="text/css">
    table.dataTable {
    clear: both;
    margin-bottom: 6px !important;
    max-width: none !important;
}
</style>