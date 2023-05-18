<?php

echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/bootstrap.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/font-awesome.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/owl.carousel.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/style.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/rtl.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/fonts/fonts.css');

echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/responsive.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/colors/colors.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'revolution/css/settings.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'revolution/css/layers.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'revolution/css/navigation.css');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jquery-3.3.1.min.js');
echo $this->Html->script('/' . __PRODUCT . '/js/funtions');
$this->Plugin->run_hook('header_library');
$User_Info = $this->Session->read('User_Info');

?>



<header class="simple-header for-sticky white">

	<div class="menu">
		<div class="container">
			<div class="logo">
				<a href="<?php echo __SITE_URL; ?>" title="">
					<i class="fa fa-laptop"></i>
					<span>سایت فروش سخت افزار</span>
					<strong>دانشگاه شهید بهشتی</strong>
				</a>
			</div><!-- LOGO -->
			<div class="basket_icon">
				<a href="<?php echo __SITE_URL; ?>products/basket" data-toggle="offcanvas">
					<i class="fa fa-shopping-basket"></i>
				</a>
				<span class="badge badge-danger" id="basket_counter">0</span>
			</div>
			<?php if (!empty($User_Info)) { ?>
				<div class="popup-client">
				<span>
				<a class="btn btn-gradient mr-3 d-none d-xl-inline-block"
				   href="<?php echo __SITE_URL . 'users/edit_profile' ?>">
					<i class="fe-icon-user"></i>
					<?php echo $User_Info['name']; ?>
				</a>
				<a class="btn btn-gradient mr-2 d-none d-xl-inline-block"
				   href="<?php echo __SITE_URL . 'users/logout' ?>">
					<?php echo __d(__USER_LOCAL, 'exit'); ?>
				</a>
				</span>
				</div>
			<?php } else { ?>
				<div class="popup-client">
					<span><a href="<?php echo __SITE_URL . '/users/login'; ?>"> ورود/ثبت نام</a><i
							class="fa fa-user"></i>  </span>
				</div>
			<?php } ?>



			<span class="menu-toggle"><i class="fa fa-bars"></i></span>
			<nav>
				<ul>
					<!--<li class="menu-item-has-children">
						<a href="#" title="">رویداد ها</a>
						<ul>
							<li><a href="event.html" title="">رویداد</a></li>
						</ul>
					</li>
					<li><a href="contact.html" title="">تماس</a></li>-->
					<li class="nav-item mega-dropdown-toggle ">
						<a class="nav-link" href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
					</li>
					<?php $this->Plugin->run_hook('user_menu', array("lang" => $this->Session->read('Config.language'))); ?>
					<li><?php echo $this->Html->link(__('pre_purchase_advice'), __SITE_URL . 'pages/pre_purchase_advice/') ?></li>
					<li><?php echo $this->Html->link(__d('user', 'about_us'), __SITE_URL . 'pages/about/') ?></li>
					<li><?php echo $this->Html->link(__d('user', 'contact_us'), __SITE_URL . 'pages/contact_us/') ?></li>
				</ul>
			</nav>

		</div>
	</div>
</header>

