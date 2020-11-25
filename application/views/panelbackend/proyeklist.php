<section class="content-header" <?=($width?"style='max-width:$width; margin-right:auto; margin-left:auto;'":"")?>>

        <h1 style="float: left">
        <?=$page_title?>
        <?=$layout_header?>
        </h1>
      <div class="pull-right">
          <button type="button" class="btn btn-warning" onclick="if(confirm('Apakah Anda akan melakukan sinkronisasi ?')){goSubmit('go_sync')}">
            <i class="glyphicon glyphicon-refresh"></i>
            Update From Promis
            </button>
      </div>
      <div style="clear: both;"></div>
</section>
<section class="content" <?=($width?"style='max-width:$width'":"")?>>
  <div class="box box-default">
    <div class="box-body">
  <table class="table table-striped table-hover dataTable">
    <thead>
    <?=UI::showHeader($header, $filter_arr, $list_sort, $list_order)?>
    </thead>
    <tbody>
    <?php
    $i = $page;
    foreach($list['rows'] as $rows){
        $i++;
        echo "<tr style='background:".trim($warnarr[$rows['id_status_proyek']])."35;'>";
        echo "<td>$i</td>";
        foreach($header as $rows1){
            $val = $rows[$rows1['name']];
            if($rows1['name']=='nama_proyek'){
                echo "<td><a href='".($url=base_url($page_ctrl."/detail/$rows[$pk]"))."'>$val</a></td>";   
            }elseif($rows1['name']=='isi'){
                echo "<td>".ReadMore($val,$url)."</td>";
            }else{
                switch ($rows1['type']) {
                    case 'list':
                        echo "<td>".$rows1["value"][$val]."</td>";
                        break;
                    case 'number':
                        echo "<td style='text-align:right'>".rupiah($val)."</td>";
                    break;
                    case 'date':
                        echo "<td>".($val)."</td>";
                        break;
                    case 'datetime':
                        echo "<td>".Eng2Ind($val)."</td>";
                        break;
                    default :
                        echo "<td>$val</td>";
                        break;
                }
            }
        }
        echo "<td style='text-align:right'>
        ".UI::showMenuMode('inlist', $rows[$pk])."
        </td>";
        echo "</tr>";
    }
    if(!count($list['rows'])){
        echo "<tr><td colspan='".(count($header)+2)."'>Data kosong</td></tr>";
    }
    ?>
    </tbody>
  </table>
  <?=UI::showPaging($paging,$page, $limit_arr,$limit,$list)?>

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