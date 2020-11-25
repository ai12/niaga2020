<dvi class="pull-left">
<?php 
echo UI::createUploadMultiple("scope__".$id_proyek_pekerjaan, $row['scope__'.$id_proyek_pekerjaan], $page_ctrl, $this->access_role['edit'], "file");
?>
</dvi>
<div>
<div style="text-align: right;">
    <?=UI::createExportImport()?>
    <div style="margin-top: -30px !important; margin-bottom: 5px;">
<?=UI::getButton('delete_all', null, null, 'btn-sm')?>
    </div>
</div>
</div>
<table class="table table-hover table-stripped">
    <thead>
        <tr>
            <th>Equipment</th>
            <th>Sub Equipment</th>
            <th>Detail SOW</th>
            <th>Jasa/Material</th>
            <th>PIC</th>
            <th>Term Of Condition</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list['rows'] as $row){ ?>
        <tr>
            <td><?=$row['equipment'];?></td>
            <td><?=$row['sub_equipment']?></td>
            <td><?=$row['detail_sow']?></td>
            <td>
                <?php 
                $temp = array();
                if($rowsjasamaterial[$row['id_scope']]){
                    foreach($rowsjasamaterial[$row['id_scope']] as $k=>$v){
                        $temp[] = $v;
                    }

                    echo implode("<br/>", $temp);
                }
                ?>
            </td>
            <td><?=$row['pic']?></td>
            <td><?=$row['term_of_condition']?></td>
            <td style='text-align:right'><?=UI::showMenuMode('inlist', $row[$pk])?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
  <?=UI::showPaging($paging,$page, $limit_arr,$limit,$list)?>