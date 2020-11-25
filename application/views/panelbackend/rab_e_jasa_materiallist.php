<div style="text-align: right; padding-top: 5px;">
    <?=UI::createExportImport()?>
    
    <div>
    </div>
</div>


  <table class="table table-striped table-hover dataTable">
    <thead>
    <?=UI::showHeader($header, $filter_arr, $list_sort, $list_order)?>
    </thead>
    <tbody>
    <?php

    if($this->post['act']=='add' or $_SESSION[SESSION_APP][$page_ctrl]['list_add']){
        $_SESSION[SESSION_APP][$page_ctrl]['list_add'] = 1;
        $list['rows'][] = array('edited'=>($this->access_role['add1']));
    }

    if($this->post['act']=='edit' or $_SESSION[SESSION_APP][$page_ctrl]['list_edit']){
        $_SESSION[SESSION_APP][$page_ctrl]['list_edit'] = 1;
    }

    $i = $page;
    $edited = false;
    foreach($list['rows'] as $rows){
        if($rows[$pk]==$row[$pk]){
            $rows = $row;
            $rows['edited'] = ($this->access_role['edit']);
        }elseif(!$rows[$pk])
            $rows = $row;

        if($rows['edited'])
            $edited = $rows['edited'];

        echo UI::createTextHidden($pk,$rows[$pk],$rows['edited']);
        $i++;
        echo "<tr>";
        echo "<td>$i</td>";
        foreach($header as $rows1){
            $val = $rows[$rows1['name']];
            $name = $rows1['name'];
            switch ($rows1['type']) {
                case 'number':
                echo "<td align='right'>";
                echo UI::createTextBox($name,$val,'10','10',$rows['edited'],'form-control rupiah',"style='text-align:right'");
                echo "</td>";
                break;
                case 'list':
                echo "<td align='center'>";
                echo UI::createSelect($name,$rows1['value'],$val,$rows['edited'],'form-control select2');
                echo "</td>";
                break;
                default :
                echo "<td>";
                echo UI::createTextBox($name,$val,'','',$rows['edited'],'form-control');
                echo "</td>";
                break;
            }
        }
        echo "<td style='text-align:right; width:65px'>";

        if($rows['edited'] && $this->access_role['save']){
           echo '<button type="button" class="btn btn-sm" onclick="goSubmit(\'list_reset\')" ><span class="glyphicon glyphicon-refresh"></span></button>';
           echo '<button type="button" class="btn-save btn btn-sm btn-success" onclick="goSubmit(\'save\')" ><span class="glyphicon glyphicon-floppy-save"></span></button>';
        }else{
           echo UI::showMenuMode('inlist', $rows[$pk]);
        }

        echo "</td>";
        echo "</tr>";
    }
    if(!count($list['rows'])){
        echo "<tr><td colspan='".(count($header)+2)."'>Data kosong</td></tr>";
    }
    if($this->access_role['add1'] && !$edited){ 
    ?>
        <tr>
            <td colspan="<?=count($header)+1?>"></td>
            <td align="right"><button class="btn btn-sm btn-success" onclick='goSubmit("add")' type='button'>Add</button></td>
        </tr>
    <?php } ?>
    </tbody>
  </table>
  <?=UI::showPaging($paging,$page, $limit_arr,$limit,$list)?>