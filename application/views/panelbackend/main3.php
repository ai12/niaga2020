<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=Title($page_title)?></title>
  	<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico" type="image/x-icon" />

    <!-- Bootstrap Core Css -->
    <link href="<?=base_url("assets")?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Css -->
    <link href="<?php echo base_url()?>assets/css/styleprint.css" rel="stylesheet">
</head>

<body style="margin-top:0px; background-color: #fff"> 
<?php echo $content;?> 
</body>

</html>