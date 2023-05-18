
<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __('login') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<section class="block">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="account-user">
					<div class="logo">
					</div><!-- LOGO -->
					<p>ایجاد یک حساب کاربری کمتر از یک دقیقه طول می کشد. اگر حساب کاربری دارید، لطفا وارد شوید </p>
					<?php echo $this->Form->create('User', array('enctype' =>'multipart/form-data','class'   =>'needs-validation wizard'
					,'url'     =>"login")); ?>
						<h4>فرم ورود</h4>
						<div class="field">
							<input name="data[User][mobile]" type="text" placeholder="<?php echo __d(__USER_LOCAL,'mobile'); ?>" required>
						</div>
						<div class="field">
							<input type="password" name="data[User][password]" placeholder="<?php echo __d(__USER_LOCAL,'password'); ?>" required>
						</div>
						<div class="field">
							<input type="submit" value="اکنون ارسال کنید" class="flat-btn">
						</div>
					</form>

				</div>
			</div>
			<div class="col-md-6">
				<div class="registration-sec">
					<h3>فرم ثبت نام</h3>

					<?php echo $this->Form->create('User', array('id'      => 'RegisterForm','enctype' =>'multipart/form-data','class'   =>'needs-validation'
					,'onsubmit'=>'return check_field()','url'     =>"register")); ?>

					<?php
					if($this->Session->check('Message.flash')){
						echo $this->Session->flash();
					}
					?>
						<div class="field">
							<input type="text" required id="reg-fn" name="data[User][name]" placeholder="<?php echo __('name'); ?>">
						</div>
						<div class="field">
							<input type="text" required id="reg-phone" name="data[User][mobile]" placeholder="<?php echo __d(__USER_LOCAL,'mobile'); ?>">
						</div>
						<div class="field">
							<input type="password" required id="reg-password" name="data[User][password]" placeholder="<?php echo __d(__USER_LOCAL,'password'); ?>">
						</div>
						<div class="field">
							<input type="password" required id="reg-password-confirm" placeholder="<?php echo __d(__USER_LOCAL,'confirm_password'); ?>">
						</div>
						<input type="submit" value="اکنون ثبت نام کنید" class="flat-btn">
					</form>
				</div><!-- Registration sec -->
			</div>
		</div>

	</div>
</section>
