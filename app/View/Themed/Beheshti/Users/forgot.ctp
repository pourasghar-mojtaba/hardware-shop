<!-- Page Title-->
<div class="page-title d-flex" aria-label="Page title"
	 style="background-image: url(<?php echo __SITE_URL . __THEME_PATH; ?>img/page-title/shop-pattern.jpg);">
	<div class="container text-right align-self-center">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				</li>
				<li class="breadcrumb-item"><a
						href="<?php echo __SITE_URL . 'users/login'; ?>"><?php echo __('login') ?></a>
				</li>
			</ol>
		</nav>
		<h1 class="page-title-heading"><?php echo __('forget_password') ?></h1>
	</div>
</div>
<div class="container pb-5 mb-4">
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-10">
			<?php
			if($this->Session->check('Message.flash')){
				echo $this->Session->flash();
			}
			?>
		</div>
		<div class="col-lg-8 col-md-10">
			<h3 class="h4"><?php echo __d(__USER_LOCAL,'mobile') ?></h3>
			<form class="wizard needs-validation" novalidate method="post">
				<div class="wizard-body pt-4">
					<input class="form-control" type="number" required name="data[User][mobile]">

					<div class="invalid-feedback"><?php echo __d(__USER_LOCAL,'please_enter_correct_code') ?></div>
				</div>
				<div class="wizard-footer py-3">
					<button class="btn btn-primary" type="submit"><?php echo __('send') ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
