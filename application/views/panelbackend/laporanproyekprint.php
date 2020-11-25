
<script src="<?php echo base_url()?>assets/template/backend/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/template/backend/plugins/bootstrap/js/bootstrap.js"></script>
<table class="tableku1" id="export" border="1" style="border: 0px;">
  <thead style="border: 0px;">
  <tr  style="border: 0px;">
    <td style="border: 0px;"></td>
    <td style="border: 0px;">
    <img src="<?=base_url()?>assets/img/logo.jpg" width="70px">
    </td>
    <td colspan="<?=(@count($this->data['rows'][0])-2)?>" style="border: 0px;">
    <b>
    <b>
    <h4 style="font-weight: bold;">
    <?=$this->config->item("company_name")?>
    </h4>
    </b>
    <small>
    <?=$this->config->item("company_address")?>
    </small>
    </b>
    </td>
  </tr>
  <tr>
    <td style="border: 0px;"  colspan="<?=(@count($this->data['rows'][0]))?>">
      <table border="0" width="100%">
        <tr style="border-top:1px solid #555;border-bottom:1px solid #555;">
          <td width="1%" style="border: 0px;"></td>
          <td width="29%" align="left" style="border: 0px;"><small><b>Telepon : <?=$this->config->item("company_telp")?></b></small></td>
          <td width="30%" align="center" style="border: 0px;"><small><b>Faksimile : <?=$this->config->item("company_fax")?></b></small></td>
          <td width="30%" align="right" style="border: 0px;"><small><b>Email : <?=$this->config->item("company_email")?></b></small></td>
        </tr>
      </table>
      <br/>
    </td>
  </tr>
    <tr>
      <th class="bg-blue" style="color:#fff; background-color: blue;">No</th>
      <?php foreach ($paramheader as $k1 => $k) { ?>
      <th class="bg-blue" style="color:#fff; background-color: blue;"><?=$header[$k]?></th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
  <?php

    $no=1;
    foreach($rows as $r => $val){
      if(!$this->post['rows'][$val['id_proyek']])
        continue;

      echo "<tr>";
      echo "<td>".($no++)."</td>";
      foreach($paramheader as $k1=>$k){

        $v = $val[$k];
        if($v==null)
          echo "<td></td>";
        elseif($type_header[$k]){
          if(is_array($type_header[$k])){
            if($list = $type_header[$k]['list']){
              echo "<td>".$list[$v]."</td>";
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
      echo "</tr>";
    }
    if(!isset($rows)){
        echo "<tr><td colspan='".(count($paramheader)+1)."'>Data kosong</td></tr>";
    }
  ?>

  </tbody>
</table>