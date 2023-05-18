<!DOCTYPE html>
<html>
	<head>
		<?php

		echo $this->Html->charset('utf-8');

		?>
		<title>
			<?php
			if(isset($title_for_layout))   echo $title_for_layout; ?>
		</title>
		<meta name="keywords" content="<?php
		if(isset($keywords_for_layout))   echo $keywords_for_layout ?>"/>
		<meta name="description" content="<?php
		if(isset($description_for_layout))  echo $description_for_layout; ?>">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">

		<?php

		echo $this->Html->meta('icon');

		echo $this->Html->css('admin/bootstrap/css/bootstrap.min');
		echo $this->Html->css('admin/font-awesome.min');
		echo $this->Html->css('admin/ionicons.min');
		echo $this->Html->css('/js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2');

		echo $this->Html->css('admin/AdminLTE');
		echo $this->Html->css('admin/skins/_all-skins.min');

		echo $this->Html->script('admin/plugins/jQuery/jquery-2.2.0.min.js');
		//echo $this->Html->script('admin/plugins/jQueryUI/jquery-ui');
		//echo $this->Html->script('admin/plugins/jQuery/jquery-migrate-3.0.0.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">

		<script>
			_url = "<?php echo __SITE_URL.'admin/'  ?>";
			_inactive = "<?php echo __('inactive') ?>";
			_active = "<?php echo __('active') ?>";
			_durl = "<?php echo __SITE_URL;  ?>";
		</script>

		<div class="wrapper">

			<header class="main-header">

				<!-- Logo -->
				<a href="index2.html" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-lg">
						<b>
							<?php echo __('main_navigation'); ?>
						</b>
					</span>
				</a>

				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">
							Toggle navigation
						</span>
					</a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<!-- Control Sidebar Toggle Button -->

							<?php /*echo $this->element('Admin/skin_toggle');*/ ?>
							<!-- Messages: style can be found in dropdown.less-->
							<?php /*echo $this->element('Admin/messages_menu');*/ ?>
							<!-- Notifications: style can be found in dropdown.less -->
							<?php /*echo $this->element('Admin/notifications_menu');*/ ?>
							<!-- Tasks: style can be found in dropdown.less -->
							<?php /*echo $this->element('Admin/tasks_menu');*/ ?>
							<!-- User Account: style can be found in dropdown.less -->
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<?php echo $this->Html->image('admin/user2-160x160.jpg', array('class'=>'user-image','alt'  => $this->UserSession->getName())); ?>
									<span class="hidden-xs">
										<?php echo $this->UserSession->getName() ?>
									</span>
								</a>
								<ul class="dropdown-menu">
									<!-- User image -->
									<li class="user-header">
										<?php echo $this->Html->image('user2-160x160.jpg', array('class'=>'img-circle','alt'  => $this->UserSession->getName())); ?>
										<p>
											<?php echo __('مدیر سایت'); ?>
											<small>
												<?php echo $this->UserSession->getName() ?>
											</small>
										</p>
									</li>
									<!-- Menu Body -->

									<!-- Menu Footer-->
									<li class="user-footer">
										<div class="pull-left">
											<a href="<?php echo __SITE_URL.'admin/users/edit/'.$this->UserSession->getId() ?>" class="btn btn-default btn-flat">
												<?php echo __('edit'); ?>
											</a>
										</div>
										<div class="pull-right">
											<a href="<?php echo __SITE_URL.'admin/users/logout' ?>" class="btn btn-default btn-flat">
												<?php echo __('exit'); ?>
											</a>
										</div>
									</li>
								</ul>
							</li>

						</ul>
					</div>

				</nav>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<!-- Sidebar user panel -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li>
							<a href="<?php echo __SITE_URL."admin"; ?>">
								<i class="fa fa-dashboard">
								</i>
								<span>
									<?php echo __('dashboard'); ?>
								</span>
							</a>
						</li>
						<?php
						  $controllers = array('users','roles');
						?>
						<li class="treeview <?php if(in_array($this->request->params['controller'],$controllers)) echo 'active'; ?> ">
							<a href="#">
								<i class="fa fa-users">
								</i>
								<span>
									<?php echo __('permision_and_users'); ?>
								</span>
								<i class="fa fa-angle-left pull-right">
								</i>
							</a>
							<ul class="treeview-menu">
								<li <?php if($this->request->params['controller'] == 'roles') echo 'class="active"'; ?> >
									<a href="<?php echo __SITE_URL.'admin/roles/index' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('role_managment'); ?>
									</a>
								</li>
								<li <?php if($this->request->params['controller'] == 'users') echo 'class="active"'; ?>>
									<a href="<?php echo __SITE_URL.'admin/users/index' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('user_managment'); ?>
									</a>
								</li>
							</ul>
						</li>
						<?php
						  $controllers = array('pages','contactmessages');
						  $id = 0;
						  if(!empty($this->request->params['pass'][0])){
						  	$id = $this->request->params['pass'][0];
						  }

						?>
						<li class="treeview <?php if(in_array($this->request->params['controller'],$controllers)) echo 'active'; ?> ">
							<a href="#">
								<i class="fa fa-file-text-o">
								</i>
								<span>
									<?php echo __('page_managment'); ?>
								</span>
								<i class="fa fa-angle-left pull-right">
								</i>
							</a>
							<ul class="treeview-menu">
								<li <?php if($this->request->params['controller'] == 'pages' && $id == 1) echo 'class="active"'; ?> >
									<a href="<?php echo __SITE_URL.'admin/pages/edit/1' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('about_us'); ?>
									</a>
								</li>
								<li <?php if($this->request->params['controller'] == 'pages' && $id ==2) echo 'class="active"'; ?>>
									<a href="<?php echo __SITE_URL.'admin/pages/edit/2' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('contact_us'); ?>
									</a>
								</li>
								<li <?php if($this->request->params['controller'] == 'pages' && $id ==2) echo 'class="active"'; ?>>
									<a href="<?php echo __SITE_URL.'admin/pages/edit/5' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('pre_purchase_advice'); ?>
									</a>
								</li>
								<li <?php if($this->request->params['controller'] == 'contactmessages' ) echo 'class="active"'; ?>>
									<a href="<?php echo __SITE_URL.'admin/contactmessages/index' ?>">
										<i class="fa fa-circle-o">
										</i> <?php echo __('contact_messages'); ?>
									</a>
								</li>
							</ul>
						</li>

						<li <?php if($this->request->params['controller'] == 'filemanagers') echo 'class="active"'; ?>>
							<a href="<?php echo __SITE_URL.'admin/filemanagers/manager' ?>">
								<i class="fa fa-file">
								</i>
								<span>
									<?php echo __('file_manager'); ?>
								</span>
							</a>
						</li>

						<?php /*$role = $this->UserSession->getRole; pr($role);*/ ?>
						<li <?php if($this->request->params['controller'] == 'plugins') echo 'class="active"'; ?>>
							<a href="<?php echo __SITE_URL.'admin/plugins/index' ?>">
								<i class="fa fa-plug">
								</i>
								<span>
									<?php echo __('plugin_managment'); ?>
								</span>
							</a>
						</li>
						<?php $this->Plugin->run_hook('admin_menu',array("controller"=>$this->request->params['controller'],"action"=>$this->request->params['action'])); ?>
						<?php $this->Plugin->run_hook('admin_group_menu',array("controller"=>$this->request->params['controller'],"action"=>$this->request->params['action'])); ?>

						<li>
							<a href="<?php echo __SITE_URL.'admin/settings/edit' ?>">
								<i class="fa fa-cog">
								</i>
								<span>
									<?php echo __('site_setting'); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo __SITE_URL.'admin/siteinformations/index' ?>">
								<i class="fa fa-line-chart">
								</i>
								<span>
									<?php echo __('site_information'); ?>
								</span>
							</a>
						</li>
						<li>
							<a href="<?php echo __SITE_URL.'admin/backups/index' ?>">
								<i class="fa fa-database">
								</i>
								<span>
									<?php echo __('database_managment'); ?>
								</span>
							</a>
						</li>

						<!--<li>
						<a href="pages/widgets.html">
						<i class="fa fa-th"></i> <span>Widgets</span>
						<small class="label pull-right bg-green">new</small>
						</a>
						</li>-->

					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<?php
				echo $this->Flash->render();
				echo $this->fetch('content');
				 echo $this->element('sql_dump');
				?>
			</div>
			<!-- /.content-wrapper -->

			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>
						ورژن
					</b> 2
				</div>
				<strong>
					&copy; 2020
					<a href="https://picosite.ir/">
						<?php /*echo __('company_name');*/ ?>
						پیکو سایت
					</a>.
				</strong>

			</footer>



			<div class="control-sidebar-bg">
			</div>

		</div>
		<!-- ./wrapper -->


		<?php


		echo $this->Html->script('/css/admin/bootstrap/js/bootstrap.min');
		echo $this->Html->script('admin/plugins/fastclick/fastclick');
		echo $this->Html->script('admin/app');
		echo $this->Html->script('admin/plugins/sparkline/jquery.sparkline.min');
		echo $this->Html->script('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min');
		echo $this->Html->script('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en');
		echo $this->Html->script('admin/plugins/slimScroll/jquery.slimscroll.min');
		echo $this->Html->script('admin/plugins/chartjs/Chart.min');
		echo $this->Html->script('admin/pages/dashboard2');
		echo $this->Html->script('admin/demo');
		//echo $this->element('sql_dump');

		?>
	</body>
</html>
