
  <table class="table table-striped table-hover dataTable">
    <thead>
    <?=UI::showHeader($header, $filter_arr, $list_sort, $list_order)?>
    </thead>
    <tbody>
    <?php
    $i = $page;
    foreach($list['rows'] as $rows){
    	$i++;
    	echo "<tr>";
    	echo "<td>$i</td>";
    	foreach($header as $rows1){
    		$val = $rows[$rows1['name']];
            if($rows1['name']=='nama_pekerjaan'){
                echo "<td><a href='".($url=base_url($page_ctrl."/detail/$rows[id_proyek]/$rows[$pk]"))."'>$val</a></td>";   
            }elseif($rows1['name']=='isi'){
                echo "<td>".ReadMore($val,$url)."</td>";
            }elseif($rows1['name']=='nilai_hpp'){
				echo "<td style='text-align:right'>".rupiah($val,$url)."</td>";
			}elseif($rows1['name']=='progress'){
                echo "<td>";
                ?>

            <div class="progress" title="<?=round($val,2)?> %">
                <div class="progress-bar <?=($val>100?"progress-bar-red":(($val==100)?"progress-bar-blue":"progress-bar-green"))?>" style="width: <?=round($val,2)?>%;"><?=round($val,2)?>%</div>
              </div>

                <?php
                echo "</td>";
            }else{
                switch ($rows1['type']) {
                    case 'list':
                        echo "<td>".$rows1["value"][$val]."</td>";
                        break;
                    case 'number':
                        echo "<td style='text-align:right'>$val</td>";
                    break;
                    case 'date':
                        if($rows1['name']=='tgl_mulai_pelaksanaan'){
                            echo "<td>".Eng2Ind($val,false)." sd ".Eng2Ind($rows['tgl_selesai_pelaksanaan'],false)."</td>";
                        }elseif($rows1['name']=='tgl_mulai_rab'){
                            echo "<td>".Eng2Ind($val,false).(($rows['tgl_selesai_rab'])?" sd ".Eng2Ind($rows['tgl_selesai_rab'],false):"")."</td>";
                        }else
                            echo "<td>".Eng2Ind($val,false)."</td>";

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