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
    <?php
    $menubtn = UI::showButtonMode($mode, $row[$pk]);
    if($menubtn or $layout_header){
    ?>
      <div class="box-header with-border">
        <?php if($layout_header){ ?>
        <div class="pull-left">
          <?=$layout_header?>
        </div>
        <?php } ?>
        <div class="pull-right">
            
        </div>
      </div>
    <?php } ?>
    <div class="box-body">

      <?php  if(is_array($_SESSION[SESSION_APP]['loginas']) && count($_SESSION[SESSION_APP]['loginas'])){ ?>
      <div class="alert alert-warning">
          Anda sedang mengakses user lain. <a href="<?=base_url("panelbackend/home/loginasback")?>" class="alert-link">Kembali</a>.
      </div>
      <?php }?>

      <?=FlashMsg()?>
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