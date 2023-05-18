<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__PRODUCT_LOCALE, 'register_order') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<section class="block ">
	<div class="container">
		<div class="row">
			<!-- Page Content-->
			<div class="container mb-4">
				<div class="row">
					<?php echo $this->element('profile_setting_menu', array('active' => 'register')); ?>
					<!-- Profile Settings-->
					<div class="col-md-8 column">
						<div id="contact">
							<div id="message"></div>
							<div class="contact-form">

								<?php echo $this->Form->create('Order', array('id' => 'RegisterForm', 'enctype' => 'multipart/form-data', 'class' => 'contactform'
								, 'onsubmit' => 'return check_field()', 'url' => "/orders/register")); ?>

								<?php
								if ($this->Session->check('Message.flash')) {
									echo $this->Session->flash();
								}
								?>
								<div class="row">

									<div class="col-md-12">
										<i class="fa fa-sticky-note"></i>
										<?php
										echo $this->Form->input('title', array(
											'type' => 'text',
											'label' => false,
											'div'=> false,
											'placeholder' => __('subject'),
											'class' => 'input-style',
											'required' => 'required'
										));
										?>
									</div>
									<div class="col-md-12">
										<i class="fa fa-pencil"></i>

										<?php
										echo $this->Form->input('user_description', array(
											'type' => 'textarea',
											'label' => false,
											'div'=> false,
											'placeholder' => __('message'),
											'class' => 'input-style',
											'required' => 'required'
										));
										?>
									</div>
									<div class="col-md-12">
										<input type="submit"  class="flat-btn" id="submit" type="submit" value="ارسال" />
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>
