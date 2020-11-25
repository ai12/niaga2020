<section class="content" <?=($width?"style='max-width:$width'":"")?>>
    <div class="col-sm-12">
    <div class="col-sm-12 no-padding">
  <div class="box box-default">
          <div class="box-header with-border">
            <?php 
        $atas = $this->conn->GetArray("select * from t_simrab where id = '$_SESSION[simrab_id]'");
        echo $atas[0]['nama_pekerjaan'];
      ?>
      <br>
      <small><?=$atas[0]['keterangan'];?></small>
  </div>    
  </div>    
      
    </div>
    <div class="col-sm-12 no-padding">
      <?=$this->auth->GetTabSimRab();?>
    </div>
    <div class="col-sm-12 no-padding">
  <div class="box box-default">
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box-header with-border">
            <?php  if(($_SESSION[SESSION_APP]['loginas'])){ ?>
            <div class="alert alert-warning">
                Anda sedang mengakses user lain. <a href="<?=base_url("panelbackend/home/loginasback")?>" class="alert-link">Kembali</a>.
            </div>
            <?php }?>

            <?=FlashMsg()?>
            <?php if(!$no_header){ ?>
            
            <?php }else{ ?>
            <div class="pull-left">
              <?php echo UI::showBack($mode)?>
            </div>
            <?php } ?>
            <div class="pull-right">
              <!-- Under Maintenance -->
              <a class="btn waves-effect btn-sm btn-primary" href="<?=site_url("panelbackend/".$this->uri->segment(2)."/add/")?>"><span class="glyphicon glyphicon-plus"></span> Add New</a>
            </div>
          </div>
          <div style="clear: both;"></div>
          <div class="box-body">


              <?php echo $content1;?>
              <div style="clear: both;"></div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.box -->
    <div style="clear: both;"></div>
</section>

<style type="text/css">
    table.dataTable {
    clear: both;
    margin-bottom: 6px;
    max-width: none !important;
}
table.table-label{
  font-size: 11px;
  color: #666;
}
</style>