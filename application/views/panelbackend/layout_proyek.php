<section class="content" <?=($width?"style='max-width:$width'":"")?>>
    <div class="col-sm-12 no-padding">
      <?=$this->auth->GetTabProyek($rowheader['id_proyek'], $rowheader1['id_proyek_pekerjaan'], $id_rab, $rowheader2['is_final']);?>
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
            <div class="pull-left" style="max-width: <?=$width-90?>px">
              <h4 style="margin: 10px 0px 0px 0px !important; display: inline;">
                <?=$rowheader['nama_proyek']?>
              </h4>
              <br/>
                <small>
                  <?php if($rowheader1['nama_pekerjaan']) {
                    echo $rowheader1['nama_pekerjaan']."<br/>";
                  } ?>
                  CUSTOMER : <?=$rowheader['pemberi_pekerjaan']?>
                </small>
            </div>
            <?php }else{ ?>
            <div class="pull-left">
              <?php echo UI::showBack($mode)?>
            </div>
            <?php } ?>
            <div class="pull-right">
                <?php 
                if(!$no_menu){
                  if($row['id_rab_detail'] && !is_array($row['id_rab_detail'])){
                    if($row['sumber_nilai']==1){
                      $add = array('<li><a href="'.site_url("panelbackend/rab_detail/add/$id_rab/$row[$pk]").'" class="waves-effect "><span class="glyphicon glyphicon-share"></span> Add Sub</a> </li>');
                    }
                    echo UI::showMenuMode($mode, ($row[$pk]?$row[$pk]:$rowheader['id_proyek']),false,'','',null,null,$add);
                  }else{
                    if(!$no_header && $this->access_role['index']){
                      echo UI::showBack($mode);
                    }
                    echo UI::showMenuMode($mode, ($row[$pk]?$row[$pk]:$rowheader['id_proyek']));
                    echo $add_menu;
                  }
                }
                ?>
            </div>
          </div>
          <div style="clear: both;"></div>
          <div class="box-body">


              <?php echo $content1;?>
              <div style="clear: both;"></div>
          </div>
        </div>
      </div>
<!--       <div class="tab-content">
          <div class="box-header with-border">
            BOQ > EVALUASI > PENETAPAN
          </div>
  </div> -->
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