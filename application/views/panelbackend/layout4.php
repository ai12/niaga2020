<?php
if($width)
	$width_page = $width;
?>
<div id="container" class="container">
<?php if(!$this->post[date('Ymd')]){ ?>
<center>
	<div class="notshow">
	<?php if($excel!==false){ ?>
	<a download="<?=$exp=str_replace(array('"',"'"), "", $page_title)?>.xls" class="btn btn-sm btn-primary" href="#" onclick="return ExcellentExport.excel(this, 'datatable', '<?=$exp?>');">
	<span class="glyphicon glyphicon-th"></span> Excel</a>
    &nbsp;
    <?php }?>
	<a class="btn btn-sm btn-primary" onclick="window.print()">
	<span class="glyphicon glyphicon-print"></span>
	Print
	</a>
	<br/>
	<br/>
	</div>
</center>
<?php } ?>
<div id="datatable">
	<?php if(!$no_header){ ?>
	<div class="header">
	<table border="0" style="padding: 0px; margin: 0px;" width="100%">
	<tr>
		<td style="border: 1px solid #333; background: #337ab7 !important; font-size: 14px; padding: 5px 10px !important;">
			<b style="color: #fff  !important"><?=$this->config->item("company_name")?></b>
		</td>
		<td style="border: 0px solid #333; vertical-align: middle !important;" width="100px" align="right" rowspan="2">
		<img src="<?=base_url()?>assets/img/logo.jpg" width="70px">
		</td>
	</tr>
	<tr>
		<td style="border: 1px solid #333; font-size: 14px; padding: 10px 10px !important;">
			<b style="color: #337ab7 !important;"><?=$page_title?></b>
		<?php if($sub_page_title){ echo "<br/>".$sub_page_title; } ?>
		</td>
	</tr>
	</table>
	</div>
	<?php  } ?>
<?php echo $content1;?>
</div>
</div>
<?php if(!$this->post[date('Ymd')]){ ?>
<script src="<?php echo base_url()?>assets/js/excellentexport.min.js"></script>
<style>
		.notshow{
			margin-top: 10px;
		}
	@media print{
		.notshow{
			display: none;
		}
		body{
			margin: 0px;
			padding: 10px 5px;
		}
		html{
			margin:0px;
			padding:0px;
		}
	}
#container{
	width: 100%;
    font-size:14px;
    font-family:Arial, Helvetica, sans-serif;
}
td,th{
    padding: 3px;
    font-size: 12px;
    vertical-align:text-center;
}
.h4, .h5, .h6, h4, h5, h6, hr {
    margin-top: 5px;
    margin-bottom: 5px;
}
.tableku {
    margin-top: 20px;
    width:100%;
    border:1px solid #555;
}
.tableku td{border: 1px solid #555;
    padding: 0px 3px;
	vertical-align: top;
}
.tableku thead th{
	border:1px solid #555;
	border-bottom:2px  solid #555;
	padding:0px 3px;
}
.tableku th{
	border:1px solid #555;
	padding:0px 3px;
}
.tableku thead, .tableku1 thead{
	border:1px solid #555;
	page-break-before: always;
}
hr{
	border-color:#555;
}
.tableku1 {
    margin-top: 10px;
    width:100%;
    border:1px solid #555;
}
.tableku1 td{
    border:1px solid #555;
	padding:3px 5px;   
	vertical-align: top;
}
.tableku1 thead th{
	border:1px solid #555;
	border-bottom:2px  solid #555;
	padding:3px 5px;    
	text-align: center;
}
.tableku1 th{
	border:1px solid #555;
	padding:0px 3px;
	text-align: center;
}

</style>
<?php } ?>