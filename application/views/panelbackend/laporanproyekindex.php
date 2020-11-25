
<div class="row">
<div class="col-sm-12">     


<?="<table><tr><td><b>Tahun</b></td><td>".UI::createTextNumber('tahun',$tahun,'4','4',true,'form-control ')."</td><td><button type='button' class='btn btn-success' onclick='$(\"#main_form\").removeAttr(\"target\"); goSubmit(\"show\")' style='width:100px'>Show</button></td></tr></table>";?>
<?php
if($rows){ ?>
<table class="table table-bordered table-hover">
	<thead>
    <tr>
      <?php foreach ($header as $k => $v) { ?>
      <th style="text-align: center">
      	<?=UI::createCheckBox("header[$k]",1,1,$v,true)?>
      </th>
      <?php } ?>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php

    $no=1;
    foreach($rows as $r => $val){

      echo "<tr>";
      foreach($header as $k=>$k1){

        $v = $val[$k];
        if($v==null)
          echo "<td></td>";
        elseif($type_header[$k]){
          if(is_array($type_header[$k])){
            if($list = $type_header[$k]['list']){
              echo "<td style='text-align:center'>".$list[$v]."</td>";
            }
          }else{
            $type = $type_header[$k];
            if($type=='date'){
              echo "<td>".Eng2Ind($v)."</td>";
            }elseif($type=='rupiah'){
              echo "<td>".rupiah($v)."</td>";
            }elseif($type=='persen'){
              echo "<td style='text-align:right'>".($v)."%</td>";
            }else{
              echo "<td>".nl2br($v)."</td>";
            }
          }
        }else{
          echo "<td>".nl2br($v)."</td>";
        }
      }
      echo "<td><input type=\"checkbox\" name=\"rows[$val[id_proyek]]\" value=\"1\" checked/></td>";
      echo "</tr>";
    }
    if(!isset($rows)){
        echo "<tr><td colspan='".(count($header)+1)."'>Data kosong</td></tr>";
    }
  ?>

  </tbody>
</table>
<div style="text-align: right;">
<button type='button' class='btn btn-primary' onclick='$("#main_form").attr("target","_BLANK"); goSubmit("print")' style='width:100px'>Print</button>
</div>
<?php }?>

</div>
</div>
<style type="text/css">
	label{
		padding: 0px !important;
	}
	.table-bordered > thead > tr > th{
		padding: 2px !important;
	}
</style>