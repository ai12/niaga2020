<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo($page_title) ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?= base_url("assets/template/backend") ?>/bootstrap/css/bootstrap.css">
	<link href="<?= base_url() ?>assets/css/dataTables.bootstrap.css" rel="stylesheet">
	<!-- Font Awesome -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css"> -->
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.js"></script>
    <![endif]-->

	<!-- jQuery 2.1.4 -->
	<script src="<?= base_url("assets/template/backend") ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?= base_url("assets/template/backend") ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/autoNumeric.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="<?= site_url() ?>assets/template/frontend/js/bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="<?= base_url("assets/template/backend") ?>/plugins/slimScroll/jquery.slimscroll.js"></script>
	<script src="<?= base_url("assets/template/backend") ?>/plugins/sweetalert/sweetalert.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url("assets/template/backend") ?>/dist/js/app.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?= base_url("assets/template/backend") ?>/dist/js/demo.js"></script>

	<script src="<?php echo base_url() ?>assets/js/tab-scrolling/jquery.scrolling-tabs.min.js"></script>
	<script type="text/javascript">
		function site_url(url) {
			return "<?= site_url() ?>" + url;
		}
	</script>
	<script src="<?= base_url("assets/js") ?>/custom.js"></script>
	<?= $add_plugin ?>

	<!-- Ionicons -->
	<!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.css">-->
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url("assets/template/backend") ?>/dist/css/AdminLTE.css">
	<link rel="stylesheet" href="<?= base_url("assets/template/backend") ?>/dist/css/animate.css">
	<link rel="stylesheet" href="<?= base_url("assets/template/backend") ?>/dist/css/skins/_all-skins.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/tab-scrolling/jquery.scrolling-tabs.min.css">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->

<body class="hold-transition skin-blue layout-top-nav">
	<!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div> -->
	<div class="wrapper">
		<div class="main-header2">
			<div class="main-header3">
				<div class="main-header1">
					<header class="main-header">
						<div class="top-header1">
							<div class="top-header">
								<img src="<?= base_url("assets/template/backend") ?>/dist/img/logo-pjb-service-shear2.png" height="38px" style="float: left;
    display: inline;
    margin: 20px 15px;" />
								<div style="    color: #fff;
    padding: 25px 10px;
    font-size: 20px;">
									<?php echo $title ?>
								</div>
							</div>
						</div>
						<nav class="navbar navbar-static-top" id="header-fix">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
										<i class="glyphicon glyphicon-menu-hamburger"></i>
									</button>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
									<?= $main_menu = $this->Global_model->GetMenu(); ?>
								</div><!-- /.navbar-collapse -->
								<!-- Navbar Right Menu -->
								<div class="navbar-custom-menu">
									<ul class="nav navbar-nav">

										<!-- User Account: style can be found in dropdown.less -->
										<li class="dropdown">
											<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
												<i class="glyphicon glyphicon-question-sign" style="font-size: 16px"></i>
											</a>
											<ul class="dropdown-menu" style="min-width: 150px !important;">
												<!-- <li class="header" style="text-align: center;"><b>HELP</b><hr></li> -->
												<li class="body">
													<a target="_blank" href="<?= site_url('panelbackend/home/ug') ?>">
														<div class="menu-info">
															<i class="glyphicon glyphicon-book"></i>
															USER GUIDE
														</div>
													</a>

												</li>
											</ul>
										</li>
										<li class="dropdown user user-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<img src="<?= base_url() . "assets/img/akuarip.jpg" ?>" class="user-image" alt="User Image">
												<span class="hidden-xs"><?= $_SESSION[SESSION_APP]['name'] ?></span>
											</a>
											<ul class="dropdown-menu">
												<!-- User image -->
												<li class="user-header">
													<img src="<?= base_url() . "assets/img/akuarip.jpg" ?>" class="img-circle" alt="User Image">
													<p>
														<?= $_SESSION[SESSION_APP]['name'] ?>
													</p>
												</li>
												<?php if ($is_administrator) { ?>
													<li class="user-body">
														<div class="col-xs-12 text-center">
															<a href="<?= base_url("panelbackend/loginas") ?>"><i class="fa fa-user fa-fw"></i> Login sebagai user lain</a>
														</div>
													</li>
												<?php } ?>
												<!-- Menu Footer-->
												<?php if ($_SESSION[SESSION_APP]['login']) { ?>
													<li class="user-footer">
														<div class="pull-left">
															<a href="<?= base_url("panelbackend/home/profile") ?>" class="btn btn-default btn-flat">Profile</a>
														</div>
														<div class="pull-right">
															<a href="<?= base_url("panelbackend/login/logout") ?>" class="btn btn-default btn-flat">Sign out</a>
														</div>
													</li>
												<?php } else { ?>
													<li class="user-body">
														<div class="col-xs-12 text-center">
															<a href="<?= base_url("panelbackend/login") ?>"><i class="fa fa-user fa-fw"></i> Login</a>
														</div>
													</li>
												<?php } ?>
											</ul>
										</li>
									</ul>
								</div>
							</div><!-- /.container-fluid -->
						</nav>
						<nav class="navbar navbar-static-top">
							<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
										<i class="glyphicon glyphicon-menu-hamburger"></i>
									</button>
								</div>
								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
									<?= $main_menu ?>
								</div><!-- /.navbar-collapse -->
								<!-- Navbar Right Menu -->
								<div class="navbar-custom-menu">
									<ul class="nav navbar-nav">



										<li class="dropdown messages-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="glyphicon glyphicon-flag" style="font-size: 16px"></i>
												<span class="label label-danger"><?php echo ($rowsdead)?count($rowsdead):''; ?></span>
											</a>
											<ul class="dropdown-menu">
												<li class="header"><?= count($rowsdead) ?> proyek mendekati deadline</li>
												<li>
													<!-- inner menu: contains the actual data -->
													<ul class="menu">
														<?php foreach ($rowsdead as $r) { ?>
															<li>
																<!-- start message -->
																<a href="<?= site_url('panelbackend/proyek/detail/' . $r['id_proyek']) ?>">
																	<div style="margin: 0px; font-size: 12px; color: #444; width: 210px; float:left;white-space: normal;">
																		<?= $r['nama_proyek'] ?>
																		<br />
																		<small style="color:#666"><?= Eng2Ind($r['tgl_rencana_selesai']) ?></small>
																	</div>
																	<div style="float: right;">
																		<small><?= $r['hari'] ?> hari</small>
																	</div>
																</a>
															</li><!-- end message -->
														<?php } ?>
													</ul>
												</li>
											</ul>
										</li>

										<!-- User Account: style can be found in dropdown.less -->
										<li class="dropdown">
											<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
												<i class="glyphicon glyphicon-question-sign" style="font-size: 16px"></i>
											</a>
											<ul class="dropdown-menu" style="min-width: 150px !important;">
												<!-- <li class="header" style="text-align: center;"><b>HELP</b><hr></li> -->
												<li class="body">
													<a target="_blank" href="<?= site_url('panelbackend/home/ug') ?>">
														<div class="menu-info">
															<i class="glyphicon glyphicon-book"></i>
															USER GUIDE
														</div>
													</a>

												</li>
											</ul>
										</li>
										<li class="dropdown user user-menu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<img src="<?= base_url() . "assets/img/akuarip.jpg" ?>" class="user-image" alt="User Image">
												<span class="hidden-xs"><?= $_SESSION[SESSION_APP]['name'] ?></span>
											</a>
											<ul class="dropdown-menu">
												<!-- User image -->
												<li class="user-header">
													<img src="<?= base_url() . "assets/img/akuarip.jpg" ?>" class="img-circle" alt="User Image">
													<p>
														<?= $_SESSION[SESSION_APP]['name'] ?>
													</p>
												</li>
												<?php if ($is_administrator) { ?>
													<li class="user-body">
														<div class="col-xs-12 text-center">
															<a href="<?= base_url("panelbackend/loginas") ?>"><i class="fa fa-user fa-fw"></i> Login sebagai user lain</a>
														</div>
													</li>
												<?php } ?>
												<!-- Menu Footer-->
												<?php if ($_SESSION[SESSION_APP]['login']) { ?>
													<li class="user-footer">
														<div class="pull-left">
															<a href="<?= base_url("panelbackend/home/profile") ?>" class="btn btn-default btn-flat">Profile</a>
														</div>
														<div class="pull-right">
															<a href="<?= base_url("panelbackend/login/logout") ?>" class="btn btn-default btn-flat">Sign out</a>
														</div>
													</li>
												<?php } else { ?>
													<li class="user-body">
														<div class="col-xs-12 text-center">
															<a href="<?= base_url("panelbackend/login") ?>"><i class="fa fa-user fa-fw"></i> Login</a>
														</div>
													</li>
												<?php } ?>
											</ul>
										</li>
									</ul>
								</div>
							</div><!-- /.container-fluid -->
						</nav>
					</header>
				</div>
			</div>
		</div>
		<!-- Full Width Column -->
		<div class="content-wrapper">
			<div class="container">
				<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
					<input type="hidden" name="act" id="act" />
					<input type="hidden" name="go" id="go" />
					<input type="hidden" name="key" id="key" />
					<?php
					if($isi!=''):
						$this->load->view($template);
					endif;
				?>
				<?php
					//echo $content; ?>

				</form>
			</div><!-- /.container -->
		</div><!-- /.content-wrapper -->
		<?php /*<footer class="main-footer">
        <div class="container">
        <strong><?=config_item('copyright')?></strong>
        </div><!-- /.container -->
      </footer> */ ?>
	</div><!-- ./wrapper -->
</body>

</html>
<script type="text/javascript">
	function goSetvalue() {
		$("#act").val('set_value');
		$("#main_form").submit();
	}

	$(window).scroll(function() {
		var scrol1 = $(window).scrollTop();
		sessionStorage.setItem("scroll<?= $page_ctrl . $mode ?>", scrol1);
	});

	$(function() {
		var scrol1 = sessionStorage.getItem("scroll<?= $page_ctrl . $mode ?>");
		console.log(scrol1);
		$(window).scrollTop(scrol1);
	});
</script>