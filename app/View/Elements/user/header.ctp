<?php
echo $this->Html->css('/js/user/plugins/font-awesome/css/font-awesome.min');
echo $this->Html->css('/js/user/plugins/bootstrap/css/bootstrap-rtl.min');
echo $this->Html->css('/js/user/plugins/fancybox/source/jquery.fancybox');
echo $this->Html->css('/js/user/plugins/revolution_slider/css/rs-style');
echo $this->Html->css('/js/user/plugins/revolution_slider/rs-plugin/css/settings');
echo $this->Html->css('/js/user/plugins/bxslider/jquery.bxslider-rtl');
echo $this->Html->css('/js/user/plugins/bxslider/jquery.bxslider-rtl');
echo $this->Html->css('user/style-metronic-rtl');
echo $this->Html->css('user/style-rtl');
echo $this->Html->css('user/themes/blue-rtl');
echo $this->Html->css('user/style-responsive-rtl');
echo $this->Html->css('user/custom-rtl');
echo $this->Html->css('/fonts/user/css/fontiran');
echo $this->Html->css('/fonts/user/css/style');
echo $this->Html->css('user/pages/portfolio-rtl');
?>
<div class="header navbar navbar-default navbar-static-top" style="background-image: url(<?php echo __SITE_URL.__IMAGE_PATH; ?>header.png) !important;">
	<div class="container">
		<div class="navbar-header">
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar">
				</span>
				<span class="icon-bar">
				</span>
				<span class="icon-bar">
				</span>
			</button>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN LOGO (you can use logo image instead of text)-->
			<a class="navbar-brand logo-v1" href="<?php echo __SITE_URL; ?>" style="margin-top:-15px">
				<h4 class="blue" style="color: rgb(255, 234, 0);font-weight: bold;">
					جام نمای فردوس
				</h4>
				<h5 class="blue" style="color: #fff;">
					ارائه دهنده خدمات صنابع  شیشه
				</h5>
			</a>
			<!-- END LOGO -->
		</div>

		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			    <?php 
					//active
					$controller = $this->request->params['controller']; 
					$action = $this->request->params['action'];
				?>
				<li class="dropdown <?php if ($action == 'display') echo "active"; ?>">
					<?php echo $this->Html->link(__('home'),__SITE_URL) ?>
				</li>
				<?php $this->Plugin->run_hook('user_menu'); ?>
				<?php $this->Plugin->run_hook('header_menu'); ?>
				<li class="dropdown <?php if ($action == 'about') echo "active"; ?>">
					<?php echo $this->Html->link(__d('user','about_us'),__SITE_URL.'pages/about/'.__d('user','about_us')) ?>
				</li>
				<li class="dropdown <?php if ($action == 'contact_us') echo "active"; ?>">
					<?php echo $this->Html->link(__d('user','contact_us'),__SITE_URL.'pages/contact_us/'.__d('user','about_us')) ?>
				</li>
				
				
				<!--<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">
						وبلاگ
						<i class="">
						</i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="blog.html">
								مقالات
							</a>
						</li>
						<li>
							<a href="blog_item.html">
								اخبار
							</a>
						</li>
					</ul>
				</li>

				<li class="menu-search">
					<span class="sep">
					</span>
					<i class="fa fa-search search-btn" style="color:#fff">
					</i>

					<div class="search-box">
						<form action="#">
							<div class="input-group input-large">
								<input class="form-control" placeholder="جستجو" type="text">
								<span class="input-group-btn">
									<button type="submit" class="btn theme-btn">
										بگرد
									</button>
								</span>
							</div>
						</form>
					</div>
				</li>-->
			</ul>
		</div>
		<!-- BEGIN TOP NAVIGATION MENU -->
	</div>
</div>