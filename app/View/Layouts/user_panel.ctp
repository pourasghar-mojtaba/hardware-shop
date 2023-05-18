<?php
	$User_Info = $this->Session->read('User_Info');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
     
		<?php
		echo $this->Html->css(__SITE_URL.__THEME_PATH.'dashboard-css/vendor/simple-line-icons');
		echo $this->Html->css(__SITE_URL.__THEME_PATH.'dashboard-css/style');
		 
		?>
		<!-- favicon -->
		<link rel="icon" href="favicon.ico">
		<title>
			<?php
		if(isset($title_for_layout)) echo  $title_for_layout ?>
		</title>
	</head>
	<body>

		<!-- SIDE MENU -->
		<div id="dashboard-options-menu" class="side-menu dashboard left closed">
			<!-- SVG PLUS -->
			<svg class="svg-plus">
				<use xlink:href="#svg-plus"></use>
			</svg>
			<!-- /SVG PLUS -->
        
			<!-- SIDE MENU HEADER -->
			<div class="side-menu-header">
				<!-- USER QUICKVIEW -->
				<div class="user-quickview">
					<!-- USER AVATAR -->
					<!--<a href="author-profile.html">
						<div class="outer-ring">
							<div class="inner-ring"></div>
							<figure class="user-avatar">
								<img src="<?php echo __SITE_URL.__THEME_PATH.'dashboard-images/'; ?>avatars/avatar_01.jpg" alt="avatar">
							</figure>
						</div>
					</a>-->
					<!-- /USER AVATAR -->

					<!-- USER INFORMATION -->
					<p class="user-name"><?php echo $User_Info['name']; ?></p>
					<!--<p class="user-money">65000</p>-->
					<!-- /USER INFORMATION -->
				</div>
				<!-- /USER QUICKVIEW -->
			</div>
			<!-- /SIDE MENU HEADER -->

			<!-- SIDE MENU TITLE -->
			<p class="side-menu-title">حساب کاربری</p>
			<!-- /SIDE MENU TITLE -->
			<?php
				$action= NULL;
				if($this->request->params['action']=='edit_profile'){
					$action = 'active'; 
				}
			?>
			<!-- DROPDOWN -->
			<ul class="dropdown dark hover-effect interactive">
				<!-- DROPDOWN ITEM -->
				<li class="dropdown-item <?php echo $action; ?>">
					<a href="<?php echo __SITE_URL.'users/edit_profile' ?>">
						<span class="sl-icon icon-settings"></span>
						<?php echo __('edit_all_info') ?>
					</a>
				</li>
			
				<!--<li class="dropdown-item">
					<a href="<?php echo __SITE_URL.'users/edit_address' ?>">
						<span class="sl-icon icon-layers"></span>
						<?php echo __('edit_address') ?>
					</a>
				</li>-->
				<?php
					$action= NULL;
					if($this->request->params['action']=='edit_password'){
						$action = 'active'; 
					}
				?>
				<li class="dropdown-item <?php echo $action; ?>">
					<a href="<?php echo __SITE_URL.'users/edit_password' ?>">
						<span class="sl-icon icon-folder-alt"></span>
						<?php echo __('edit_password') ?>
					</a>
				</li>
				<!-- /DROPDOWN ITEM -->

				<!-- DROPDOWN ITEM -->
				
				<?php $this->Plugin->run_hook('user_panel_menu');  ?>
				<!-- /DROPDOWN ITEM -->
			</ul>
			<!-- /DROPDOWN -->

     
			</ul>
			<!-- /DROPDOWN -->

			<a href="<?php echo __SITE_URL; ?>" class="button medium secondary">خروج از مدیریت</a>
		</div>
		<!-- /SIDE MENU -->

		<!-- DASHBOARD BODY -->
		<div class="dashboard-body">
			<!-- DASHBOARD HEADER -->
			<div class="dashboard-header retracted">
				<!-- DB CLOSE BUTTON -->
				<a href="<?php echo __SITE_URL; ?>" class="db-close-button">
					<img src="<?php echo __SITE_URL.__THEME_PATH.'dashboard-images/'; ?>dashboard/back-icon.png" alt="back-icon">
				</a>
				<!-- DB CLOSE BUTTON -->

				<!-- DB OPTIONS BUTTON -->
				<div class="db-options-button">
					<img src="<?php echo __SITE_URL.__THEME_PATH.'dashboard-images/'; ?>dashboard/db-list-right.png" alt="db-list-right">
					<img src="<?php echo __SITE_URL.__THEME_PATH.'dashboard-images/'; ?>dashboard/close-icon.png" alt="close-icon">
				</div>
				<!-- DB OPTIONS BUTTON -->

				<!-- DASHBOARD HEADER ITEM -->
				<div class="dashboard-header-item title">
					<!-- DB SIDE MENU HANDLER -->
					<div class="db-side-menu-handler">
						<img src="<?php echo __SITE_URL.__THEME_PATH.'dashboard-images/'; ?>dashboard/db-list-left.png" alt="db-list-left">
					</div>
					<!-- /DB SIDE MENU HANDLER -->
					<h6>صفحه داشبورد</h6>
				</div>
				<!-- /DASHBOARD HEADER ITEM -->

				 

				<!-- DASHBOARD HEADER ITEM -->
				<div class="dashboard-header-item stats">
					<!-- STATS META -->
					<div class="stats-meta">
						<div class="pie-chart pie-chart1">
							<!-- SVG PLUS -->
							<svg class="svg-plus primary">
								<use xlink:href="#svg-plus"></use>
							</svg>
							<!-- /SVG PLUS -->
						</div>
						<h6>0</h6>
						<p>بازدید کل</p>
					</div>
					<!-- /STATS META -->
				</div>
				<!-- /DASHBOARD HEADER ITEM -->

				<!-- DASHBOARD HEADER ITEM -->
				<div class="dashboard-header-item stats">
					<!-- STATS META -->
					<div class="stats-meta">
						<div class="pie-chart pie-chart2">
							<!-- SVG PLUS -->
							<svg class="svg-minus tertiary">
								<use xlink:href="#svg-minus"></use>
							</svg>
							<!-- /SVG PLUS -->
						</div>
						<h6>0</h6>
						<p>تعداد خرید در ماه</p>
					</div>
					<!-- /STATS META -->
				</div>
				<!-- /DASHBOARD HEADER ITEM -->

				 

				<!-- DASHBOARD HEADER ITEM -->
				<div class="dashboard-header-item back-button">
					<a href="<?php echo __SITE_URL; ?>" class="button mid dark-light">بازگشت به خانه</a>
				</div>
				<!-- /DASHBOARD HEADER ITEM -->
			</div>
			<!-- DASHBOARD HEADER -->

			<!-- DASHBOARD CONTENT -->
			<?php
			echo $this->Flash->render();
			echo $this->fetch('content');  
			echo $this->element('sql_dump');  	  		
			?>
			<!-- DASHBOARD CONTENT -->
		</div>
		<!-- /DASHBOARD BODY -->

		<div class="shadow-film closed"></div>

		<!-- SVG ARROW -->
		<svg style="display: none;">	
			<symbol id="svg-arrow" viewBox="0 0 3.923 6.64014" preserveAspectRatio="xMinYMin meet">
				<path d="M3.711,2.92L0.994,0.202c-0.215-0.213-0.562-0.213-0.776,0c-0.215,0.215-0.215,0.562,0,0.777l2.329,2.329
				L0.217,5.638c-0.215,0.215-0.214,0.562,0,0.776c0.214,0.214,0.562,0.215,0.776,0l2.717-2.718C3.925,3.482,3.925,3.135,3.711,2.92z"/>
			</symbol>
		</svg>
		<!-- /SVG ARROW -->

		<!-- SVG PLUS -->
		<svg style="display: none;">
			<symbol id="svg-plus" viewBox="0 0 13 13" preserveAspectRatio="xMinYMin meet">
				<rect x="5" width="3" height="13"/>
				<rect y="5" width="13" height="3"/>
			</symbol>
		</svg>
		<!-- /SVG PLUS -->

		<!-- SVG MINUS -->
		<svg style="display: none;">
			<symbol id="svg-minus" viewBox="0 0 13 13" preserveAspectRatio="xMinYMin meet">
				<rect y="5" width="13" height="3"/>
			</symbol>
		</svg>
		<!-- /SVG MINUS -->
		<?php
		echo $this->Html->script(__SITE_URL.__THEME_PATH.'dashboard-js/vendor/jquery-3.1.0.min');
		echo $this->Html->script(__SITE_URL.__THEME_PATH.'dashboard-js/vendor/jquery.xmpiechart.min');
		echo $this->Html->script(__SITE_URL.__THEME_PATH.'dashboard-js/side-menu');
		echo $this->Html->script(__SITE_URL.__THEME_PATH.'dashboard-js/dashboard-header');
		?>
 
	</body>
</html>