<!-- <div class="table-responsive"><canvas id="omega" style="height:20vw; width:100%"></canvas>
</div> -->


<style type="text/css">
    .table td, .table th {
        font-size: 11px;
        padding: 3px !important;
    }
        table.dataTable {
    clear: both;
    margin-bottom: 0px !important;
    max-width: none !important;
}
</style>
<table class="table table-bordered" id="fixedcolumns">
    <thead>
        <tr>
            <th rowspan="2" style="width:120px">TEAM PROYEK</th>
            <th rowspan="2" style="width:120px">JABATAN PROYEK</th>
            <th rowspan="2" style="width: 5px">QTY</th>
            <th colspan="<?=$rowheader1['hmin']+$rowheader1['h']+$rowheader1['hplus']?>">QTY</th>
            <th rowspan="2">TOTAL WORK</th>
            <th rowspan="2">MAX</th>
            <th rowspan="2" style="width:120px">SUMBER PEGAWAI</th>
        </tr>
        <tr>
            <?php
            $labels = array();
            for($i=$rowheader1['hmin']; $i>0; $i--){
                echo "<th>H-$i</th>";
                $labels[] = 'H-'.$i;
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['h']; $i++){
                echo "<th>$i</th>";
                $labels[] = $i;
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['hplus']; $i++){
                echo "<th>H+$i</th>";
                $labels[] = 'H+'.$i;
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        $jj=array();
        $tot_max = array();
        $tot_jum = array();
        $jabatanarr = array();
        foreach($rows as $row){ ?>
        <tr>
            <td><?=$mtteamproyekarr[$row['id_team_proyek']]?></td>
            <td><?=$mtjabatanproyekarr[$row['id_jabatan_proyek']]?></td>
            <td style='text-align:center'><?=$row['jumlah']?></td>

            <?php
            $jabatanarr[$row['id_jabatan_proyek']] = $mtjabatanproyekarr[$row['id_jabatan_proyek']];

            $jum = 0;
            $max = 0;
            for($i=$rowheader1['hmin']; $i>0; $i--){
                $j = $rowdays[$row['id_manpower']]['hmin'.$i];
                $jj['hmin'.$i]+=$j;

                echo "<td style='text-align:center'>$j</td>";
                $jum+=$j;
                if($j>$max)
                    $max = $j;
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['h']; $i++){
                $j = $rowdays[$row['id_manpower']]['h'.$i];
                $jj['h'.$i]+=$j;
                
                echo "<td style='text-align:center'>$j</td>";
                $jum+=$j;
                if($j>$max)
                    $max = $j;
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['hplus']; $i++){
                $j = $rowdays[$row['id_manpower']]['hplus'.$i];
                $jj['hplus'.$i]+=$j;

                echo "<td style='text-align:center'>$j</td>";
                $jum+=$j;
                if($j>$max)
                    $max = $j;
            }
            ?>

            <td style='text-align:center'><?=$jum?></td>
            <td style='text-align:center'><?=$max?></td>
            <?php
            $tot_jum[$row['id_sumber_pegawai']]+=$jum;
            $tot_max[$row['id_sumber_pegawai']]+=$max;
            $tot_jabatan[$row['id_sumber_pegawai']][$row['id_jabatan_proyek']]+=$jum;
            $tjum+=$jum;
            $tmax+=$max;
            ?>
            <td style='text-align:center'><?=$mtsumberpegawaiarr[$row['id_sumber_pegawai']]?></a></td></td>
        </tr>
        <?php } ?>

        <tr>
            <td></td>
            <td></td>
            <td></td>

            <?php
            $jum = 0;
            $max = 0;
            $datas = array();
            for($i=$rowheader1['hmin']; $i>0; $i--){
                $j = $jj['hmin'.$i];
                $datas[] = $j;
                echo "<td style='text-align:center'>$j</td>";
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['h']; $i++){
                $j = $jj['h'.$i];
                $datas[] = $j;
                echo "<td style='text-align:center'>$j</td>";
            }
            ?>

            <?php
            for($i=1; $i<=$rowheader1['hplus']; $i++){
                $j = $jj['hplus'.$i];
                $datas[] = $j;
                echo "<td style='text-align:center'>$j</td>";
            }
            ?>

            <td style='text-align:center'><?=$tjum?></td>
            <td style='text-align:center'><?=$tmax?></td>
            <td></td>
        </tr>
    </tbody>
</table>
<br/>
<?=UI::getButton("add",null,null,'btn-sm')?>
<div style="display: inline-block; width: 300px; text-align: right;">
<?=UI::createExportImport()?>
</div>
<?=UI::getButton('delete_all', null, null, 'btn-sm')?>
<br/>
<br/>
<table  align="right" class="table table-bordered">
    <tr>
        <th>Sumber Pegawai</th>
        <th style="padding: 0px 20px;text-align:center">Total Mandays</th>
        <th style="padding: 0px 20px;text-align:center">Total Maksimal</th>
        <?php foreach($jabatanarr as $k=>$v){ ?>
            <th style="padding: 0px 20px;text-align:center"><?=$v?></th>
        <?php } ?>
    </tr>
<?php
foreach($tot_jum as $k=>$v){
    echo "<tr><td>".$mtsumberpegawaiarr[$k]."</td><td align='right' style='padding: 0px 20px'>".$v."</td><td align='right' style='padding: 0px 20px'>".$tot_max[$k]."</td>";
    $totm+=$tot_max[$k];
    $tott+=$v;
    foreach($jabatanarr as $k1=>$v1){
        echo "<td align='right' style='padding: 0px 20px'>".$tot_jabatan[$k][$k1]."</td>";
        $totj[$k1]+=$tot_jabatan[$k][$k1];
    }
    echo "</tr>";
}

echo "<tr><td><b>TOTAL</b></td><td align='right' style='padding: 0px 20px'><b>".$tott."</b></td><td align='right' style='padding: 0px 20px'><b>".$totm."</b></td>";
foreach($jabatanarr as $k1=>$v1){
    echo "<td align='right' style='padding: 0px 20px'><b>".$totj[$k1]."</b></td>";
}
echo "</tr>";
?>
</table>

<link href="<?=base_url()?>assets/css/fixedColumns.dataTables.min.css" rel="stylesheet">
<script src="<?=site_url("assets/template/backend/plugins/chartjs/Chart.bundle.js")?>"></script>
<script src="<?=site_url("assets/template/backend/plugins/chartjs/utils.js")?>"></script>
<script src="<?=site_url("assets/js/jquery.dataTables.min.js")?>"></script>
<script src="<?=site_url("assets/js/dataTables.fixedColumns.min.js")?>"></script>



<script type="text/javascript">
<?php if(count($datas)>15){ ?>
$(document).ready(function() {
var table = $('#fixedcolumns').DataTable( {
    scrollY:        "300px",
    scrollX:        true,
    scrollCollapse: true,
    paging:         false,
    ordering: false,
    searching:false,
    info:false,
    fixedColumns:   {
        leftColumns: 3,
    }
} );
} );
<?php } ?>
    var COLORS = [
        '#4dc9f6',
        '#f67019',
        '#f53794',
        '#537bc4',
        '#acc236',
        '#166a8f',
        '#00a950',
        '#58595b',
        '#8549ba'
    ];

    window.onload = function() {
        var ctx = document.getElementById('omega').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'line',
            data: {
                satuan:'',
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    lineTension: 0,
                    data:<?php echo json_encode($datas); ?>,
                    backgroundColor: COLORS[0],
                    borderColor: COLORS[0]
                }],
            },
            options: {
                bezierCurve : false,
                legend: {
                    display: false
                },
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback: function(value, index, values) {
                                return value.toString();
                            }
                        },
                        gridLines: {
                            display:false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display:false
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var label = data.datasets[0].data[tooltipItem.index]+data.satuan;
                            return label;
                        }
                    }
                }
            }
        });
    }
</script>