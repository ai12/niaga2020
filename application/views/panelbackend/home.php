<section class="content-header" <?=($width?"style='max-width:$width; margin-right:auto; margin-left:auto;'":"")?>>
  <h1>
  Dashboard <?="Tahun ".UI::createTextNumber('tahun',$tahun,'','',true,'form-control',"style='text-align:left; width: 90px; display: inline; font-size: 24px;' step='any' onchange='goSubmit(\"set_tahun\")'")?>
  </h1>
</section>
<section class="content">
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    
    <section class="col-lg-12 connectedSortable ui-sortable">
      <div class="box box-success">
        <div class="box-header">
          <i class="glyphicon glyphicon-record" style="font-size: inherit;"></i>
          <b>TARGET RKAP PROJECT &nbsp;&nbsp;&nbsp;</b>
          <div style="display:inline; float: right;">
            <div style="display: inline"><div style="background-color: #1b8ae2; width: 20px; display: inline-block;">&nbsp;</div> Target</div>
            <div style="display: inline"><div style="background-color: #e68434; width: 20px; display: inline-block;">&nbsp;</div> Niaga</div>
            <div style="display: inline"><div style="background-color: #e63434; width: 20px; display: inline-block;">&nbsp;</div> Keuangan</div>
          </div>
        </div>
        <div class="slimScrollDiv" style="padding: 10px">
          <div id="chartdivproject" style="width: 100%; height: 150px;"></div>
          <?php
          $target = $row[$tahun]['PR']['target'];
          $actual_proj = $row[$tahun]['PR']['actual_proj'];
          if(!$target)
          $persen_proj = 0;
          else
          $persen_proj = $actual_proj/$target*100;
          $actual_keu = $row[$tahun]['PR']['actual_keu'];
          if(!$target)
          $persen_keu = 0;
          else
          $persen_keu = $actual_keu/$target*100;
          ?>
          <br/>
          
          <table width="100%">
            <tr>
              <td colspan="2"><b>Total Niaga</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-bottom: 10px;" class="progress" title="<?=round($persen_proj,2)?>%">
                  <div class="progress-bar progress-bar-green" style="width: <?=$persen_proj?>%;"><?=round($persen_proj,2)?>%</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2"><b>Total Keuangan</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-bottom: 10px;" class="progress" title="<?=round($persen_keu,2)?>%">
                  <div class="progress-bar progress-bar-green" style="width: <?=$persen_keu?>%;"><?=round($persen_keu,2)?>%</div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <small>NIAGA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=rupiah($actual_proj)?></small><BR/>
                <small>KEUANGAN : <?=rupiah($actual_keu)?></small>
              </td>
              <td align="right"><small>TARGET : <?=rupiah($target)?></small></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="box box-success">
        <div class="box-header">
          <i class="glyphicon glyphicon-record" style="font-size: inherit;"></i>
          <b>TARGET RKAP OM &nbsp;&nbsp;&nbsp;</b>
          <div style="display:inline; float: right;">
            <div style="display: inline"><div style="background-color: #1b8ae2; width: 20px; display: inline-block;">&nbsp;</div> Target</div>
            <div style="display: inline"><div style="background-color: #e68434; width: 20px; display: inline-block;">&nbsp;</div> Niaga</div>
            <div style="display: inline"><div style="background-color: #e63434; width: 20px; display: inline-block;">&nbsp;</div> Keuangan</div>
          </div>
        </div>
        <div class="slimScrollDiv" style="padding: 10px">
          <div id="chartdivom" style="width: 100%; height: 150px;"></div>
          <?php
          $target = $row[$tahun]['OM']['target'];
          $actual_proj = $row[$tahun]['OM']['actual_proj'];
          if(!$target)
          $persen_proj = 0;
          else
          $persen_proj = $actual_proj/$target*100;
          $actual_keu = $row[$tahun]['OM']['actual_keu'];
          if(!$target)
          $persen_keu = 0;
          else
          $persen_keu = $actual_keu/$target*100;
          ?>
          <br/>
          
          <table width="100%">
            <tr>
              <td colspan="2"><b>Total Niaga</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-bottom: 10px;" class="progress" title="<?=round($persen_proj,2)?>%">
                  <div class="progress-bar progress-bar-green" style="width: <?=$persen_proj?>%;"><?=round($persen_proj,2)?>%</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2"><b>Total Keuangan</b></td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-bottom: 10px;" class="progress" title="<?=round($persen_keu,2)?>%">
                  <div class="progress-bar progress-bar-green" style="width: <?=$persen_keu?>%;"><?=round($persen_keu,2)?>%</div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <small>NIAGA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <?=rupiah($actual_proj)?></small><BR/>
                <small>KEUANGAN : <?=rupiah($actual_keu)?></small>
              </td>
              <td align="right"><small>TARGET : <?=rupiah($target)?></small></td>
            </tr>
          </table>
        </div>
      </div>
      </section><!-- right col -->
      </div><!-- /.row (main row) -->
    </section>

    <section class="col-lg-4 connectedSortable ui-sortable">
      <div class="box box-success">
        <div class="box-header">
          <i class="glyphicon glyphicon-calendar" style="font-size: inherit;"></i>
          <b>EVENTS</b>
        </div>
        <div id='calendar' style="height: 300px"></div>
      </div>
    </section>
    <section class="col-lg-4 connectedSortable ui-sortable">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#status" aria-controls="status" role="tab" data-toggle="tab">Status Keluhan</a></li>
        <li role="presentation"><a href="#kategori" aria-controls="kategori" role="tab" data-toggle="tab">Kategori  Keluhan</a></li>
      </ul>
      <div class="box box-success">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="status">
            <b style="padding: 0px 10px; text-transform: uppercase;">Status Keluhan</b>
              <div id="chartstatuskeluhan" style="width: 100%; height: 250px;"></div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="kategori">
            <b style="padding: 0px 10px; text-transform: uppercase;">Kategori  Keluhan</b>
              <div id="chartkategoriskeluhan" style="width: 100%; height: 250px;"></div>
          </div>
        </div>
      </div>
    </section>
    <section class="col-lg-4 connectedSortable ui-sortable">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#jenis_opp" aria-controls="jenis_opp" role="tab" data-toggle="tab">Jenis Opportunities</a></li>
        <li role="presentation"><a href="#tipe_opp" aria-controls="tipe_opp" role="tab" data-toggle="tab">Tipe  Opportunities</a></li>
        <li role="presentation"><a href="#status_opp" aria-controls="status_opp" role="tab" data-toggle="tab">Status Opportunities</a></li>
      </ul>
      <div class="box box-success">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="jenis_opp">
            <b style="padding: 0px 10px; text-transform: uppercase;">Jenis Opportunities</b>
              <div id="chartjenisopp" style="width: 100%; height: 250px;"></div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="tipe_opp">
            <b style="padding: 0px 10px; text-transform: uppercase;">Tipe Opportunities</b>
              <div id="charttipeopp" style="width: 100%; height: 250px;"></div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="status_opp">
            <b style="padding: 0px 10px; text-transform: uppercase;">Status Opportunities</b>
              <div id="chartstatusopp" style="width: 100%; height: 250px;"></div>
          </div>
        </div>
      </div>
    </section>
    <script src="<?php echo base_url()?>assets/js/chart/amcharts.js"></script>
    <script src="<?php echo base_url()?>assets/js/chart/pie.js"></script>
    <script src="<?php echo base_url()?>assets/js/chart/serial.js"></script>
    <script src="<?php echo base_url()?>assets/js/chart/export.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/chart/light.js"></script>
    <link href='<?php echo base_url()?>assets/js/fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/js/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/js/fullcalendar/packages/timegrid/main.css' rel='stylesheet' />
    <link href='<?php echo base_url()?>assets/js/fullcalendar/packages/list/main.css' rel='stylesheet' />
    <script src='<?php echo base_url()?>assets/js/fullcalendar/packages/core/main.js'></script>
    <script src='<?php echo base_url()?>assets/js/fullcalendar/packages/interaction/main.js'></script>
    <script src='<?php echo base_url()?>assets/js/fullcalendar/packages/daygrid/main.js'></script>
    <script src='<?php echo base_url()?>assets/js/fullcalendar/packages/timegrid/main.js'></script>
    <script src='<?php echo base_url()?>assets/js/fullcalendar/packages/list/main.js'></script>
    <script src='<?php echo base_url()?>assets/js/popper.min.js'></script>
    <script src='<?php echo base_url()?>assets/js/tooltip.min.js'></script>
    <script>
    var chart = AmCharts.makeChart( "chartstatuskeluhan", {
      "type": "pie",
      "labelsEnabled":false,
  		"legend":{
  			"position":"right",
  		},
      "theme": "light",
      "dataProvider": <?=json_encode($statuskeluhan)?>,
      "valueField": "value",
      "titleField": "label",
      "startEffect": "elastic", 
      "outlineAlpha": 0,
      "depth3D": 15,
      "angle": 30,
      "export": {
        "enabled": false
      }
    } );
    chart.addListener("clickSlice", function(e){
      window.location = "<?=site_url("panelbackend/keluhan?act=list_search&list_search_filter[id_kategori_keluhan]=&list_search_filter[status]=")?>"+e.dataItem.value;
    });
    var chart = AmCharts.makeChart( "chartkategoriskeluhan", {
      "type": "pie",
      "labelsEnabled":false,
		"legend":{
			"position":"right",
		},
      "theme": "light",
      "dataProvider": <?=json_encode($kategorikeluhan)?>,
      "valueField": "value",
      "titleField": "label",
      "startEffect": "elastic",
      "outlineAlpha": 0,
      "depth3D": 15,
      "angle": 30,
      "export": {
        "enabled": false
      }
    } );
    chart.addListener("clickSlice", function(e){
      window.location = "<?=site_url("panelbackend/keluhan?act=list_search&list_search_filter[status]=&list_search_filter[id_kategori_keluhan]=")?>"+e.dataItem.value;
    });

    var chart = AmCharts.makeChart( "chartjenisopp", {
      "type": "pie",
      "labelsEnabled":false,
		"legend":{
			"position":"right",
		},
      "theme": "light",
      "dataProvider": <?=json_encode($jenisopp)?>,
      "valueField": "value",
      "titleField": "label",
      "startEffect": "elastic",
      "outlineAlpha": 0,
      "depth3D": 15,
      "angle": 30,
      "export": {
        "enabled": false
      }
    } );
    chart.addListener("clickSlice", function(e){
      window.location = "<?=site_url("panelbackend/opportunities?act=list_search&list_search_filter[status]=&list_search_filter[id_tipe_opportunities]=&list_search_filter[id_jenis_opportunities]=")?>"+e.dataItem.value;
    });

    var chart = AmCharts.makeChart( "charttipeopp", {
      "type": "pie",
      "labelsEnabled":false,
		"legend":{
			"position":"right",
		},
      "theme": "light",
      "dataProvider": <?=json_encode($tipeopp)?>,
      "valueField": "value",
      "titleField": "label",
      "startEffect": "elastic",
      "outlineAlpha": 0,
      "depth3D": 15,
      "angle": 30,
      "export": {
        "enabled": false
      }
    } );
    chart.addListener("clickSlice", function(e){
      window.location = "<?=site_url("panelbackend/opportunities?act=list_search&list_search_filter[status]=&list_search_filter[id_jenis_opportunities]=&list_search_filter[id_tipe_opportunities]=")?>"+e.dataItem.value;
    });

    var chart = AmCharts.makeChart( "chartstatusopp", {
      "type": "pie",
      "labelsEnabled":false,

		"legend":{
			"position":"right",
		},
      "theme": "light",
      "dataProvider": <?=json_encode($statusopp)?>,
      "valueField": "value",
      "titleField": "label",
      "startEffect": "elastic",
      "outlineAlpha": 0,
      "depth3D": 15,
      "angle": 30,
      "export": {
        "enabled": false
      }
    } );
    chart.addListener("clickSlice", function(e){
      window.location = "<?=site_url("panelbackend/opportunities?act=list_search&list_search_filter[id_jenis_opportunities]=&list_search_filter[id_tipe_opportunities]=&list_search_filter[status]=")?>"+e.dataItem.value;
    });
    
    var chart = AmCharts.makeChart( "chartdivproject", {
    "type": "serial",
    "addClassNames": true,
    "theme": "light",
    "autoMargins": false,
    "marginLeft": 30,
    "marginRight": 8,
    "marginTop": 10,
    "marginBottom": 26,
    "depth3D": 10,
    "angle": 50,
    /* "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
    },*/
    "dataProvider": <?=json_encode($grafik['PR'])?>,
    "valueAxes": [ {
    "axisAlpha": 0,
    "position": "left",
    } ],
    "startDuration": 1,
    "graphs": [ {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#1174c3','#2196f3'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Target",
    "valueField": "target",
    "dashLengthField": "dashLengthColumn"
    }, {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#d06e12','#f9973a'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Bapp Niaga",
    "valueField": "actual_proj",
    "dashLengthField": "dashLengthColumn"
    }, {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#ff0000','#e63434'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Penerimaan Keuangan",
    "valueField": "actual_keu",
    "dashLengthField": "dashLengthColumn"
    } ],
    "categoryField": "full_period",
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0,
    "gridThickness": 0
    },
    "export": {
    "enabled": false
    }
    } );
    
    var chart = AmCharts.makeChart( "chartdivom", {
    "type": "serial",
    "addClassNames": true,
    "theme": "light",
    "autoMargins": false,
    "marginLeft": 30,
    "marginRight": 8,
    "marginTop": 10,
    "marginBottom": 26,
    "depth3D": 10,
    "angle": 50,
    /* "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
    },*/
    "dataProvider": <?=json_encode($grafik['OM'])?>,
    "valueAxes": [ {
    "axisAlpha": 0,
    "position": "left",
    } ],
    "startDuration": 1,
    "graphs": [ {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#1174c3','#2196f3'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Target",
    "valueField": "target",
    "dashLengthField": "dashLengthColumn"
    }, {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#d06e12','#f9973a'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Bapp Niaga",
    "valueField": "actual_proj",
    "dashLengthField": "dashLengthColumn"
    }, {
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "alphaField": "alpha",
    "fillColors":['#ff0000','#e63434'],
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "lineAlpha": 0.1,
    "type": "column",
    "title": "Penerimaan Keuangan",
    "valueField": "actual_keu",
    "dashLengthField": "dashLengthColumn"
    } ],
    "categoryField": "full_period",
    "fontFamily":"'Lato', Arial, Tahoma, sans-serif",
    "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0,
    "gridThickness": 0
    },
    "export": {
    "enabled": false
    }
    } );
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
    height: 'parent',
    header: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    defaultView: 'dayGridMonth',
    // defaultDate: '2019-08-12',
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    eventLimit: true, // allow "more" link when too many events
    events: {
    url: "<?=site_url('panelbackend/home/index?act=get_events')?>",
    },
    eventClick: function(info) {
      detailevent(info);
    },
    eventRender: function(info) {
      $(info.el).tooltip({title:info.event.title, placement: 'top', container: 'body'});
      /*var tooltip = new Tooltip(info.el, {
        title: info.event.title,
        placement: 'bottom',
        trigger: 'hover',
        container: 'body'
      });*/

    },
    });
    calendar.render();
    });
    function detailevent(info){
    $.ajax({
    type:"post",
    dataType:"html",
    url:"<?=current_url()?>",
    data:{
    act:"get_task",
    id:info.event.id
    },
    success:function(ret){
    $("#contenttask").html(ret);
    }
    });
    $("#myModal").modal("toggle");
    }

var tabCarousel = setInterval(function() {
var tabs = $('.nav-tabs > li'),
    active = tabs.filter('.active'),
    next = active.next('li'),
    toClick = next.length ? next.find('a') : tabs.eq(0).find('a');

toClick.trigger('click');
}, 3000);
    </script>
    <style type="text/css">
    .fc-toolbar.fc-header-toolbar {
    margin-bottom: 0em;
    }
    .box-header{
    padding: 10px;
    }
    .fc-ltr .fc-dayGrid-view .fc-day-top .fc-day-number {
    float: right;
    color: #333;
    font-size: 16px;
    padding: 5px 10px ;
    }
    .fc-unthemed td.fc-today {
    background: #ffe580;
    }
    .fc-content{
    cursor: pointer;
    }
    .nav-tabs > li > a {
    margin-right: 2px;
    padding: 7px;
    text-align: center;
    line-height: 1;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
}

.fc-button-primary {
    color: #fff;
    background-color: #a33f75;
    border-color: #8e426b;
}
.fc-button-primary:hover,.fc-button-primary:not(:disabled):active, .fc-button-primary:not(:disabled).fc-button-active {
    color: #fff;
    background-color: #632145;
    border-color: #632345;
}
.fc-button-primary:disabled {
    color: #fff;
    background-color: #a23f75;
    border-color: #96587a;
}
.tooltip {
    position: absolute;
    z-index: 999999 !important;
    text-align: center;
  }
  .scrtabs-tab-container{
    height: 30px;
  }
    </style>
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Detail Event</h4>
          </div>
          <div class="modal-body" id="contenttask">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>