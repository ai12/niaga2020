      <div class="content-wrapper">

        <section class="content wow ">
          <div class="row main-content">
            <div class="col-sm-12">
              <div class="box">


                <div class="box-header with-border">
                  <h3 class="box-title">
                    
                    <span class='fa fa-print'></span>  
                    <?=$page_title?>
                    <?php if($sub_page_title){ ?> <small><?=$sub_page_title?></small> <?php }?>
                  </h3>
                </div>


                <div class="box-body">

                  <?php  if(($_SESSION[SESSION_APP]['loginas'])){ ?>
                  <div class="alert alert-warning">
                      Anda sedang mengakses user lain. <a href="<?=base_url("panelbackend/home/loginasback")?>" class="alert-link">Kembali</a>.
                  </div>
                  <?php }?>

                  <?=FlashMsg()?>
                  <?php echo $content1;?>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>