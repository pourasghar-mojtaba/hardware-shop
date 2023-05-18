<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2>تماس با ما</h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->



<section class="block remove-top">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading4">

				</div>
				<div class="contact-page-sec">
					<div class="row">

						<div class="col-md-6 column">
							<div class="contact-details">
								<div class="contact-infos">
									<?php
									echo $this->Cms->convert_character_editor($page['Page']['body']);
									?>
								</div>
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d207371.97794182188!2d51.2097318698786!3d35.69701178750461!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e00491ff3dcd9%3A0xf0b3697c567024bc!2sTehran%2C%20Tehran%20Province%2C%20Iran!5e0!3m2!1sen!2s!4v1590585988213!5m2!1sen!2s"></iframe>
							</div>
						</div>
						<div class="col-md-6 column">
							<div id="contact">
								<div id="message"></div>
								<div class="contact-form">

										<?php echo $this->Form->create('Contactmessage', array('id' => 'RegisterForm', 'enctype' => 'multipart/form-data', 'class' => 'contactform'
										, 'onsubmit' => 'return check_field()', 'url' => "/contactmessages/sendmessage")); ?>

										<?php
										if ($this->Session->check('Message.flash')) {
											echo $this->Session->flash();
										}
										?>
										<div class="row">
											<div class="col-md-12">
												<i class="fa fa-user"></i>
												<?php
												echo $this->Form->input('name', array(
													'type' => 'text',
													'label' => false,
													'div'=> false,
													'placeholder' => __('name'),
													'class' => 'input-style',
													'required' => 'required'
												));
												?>
											</div>
											<div class="col-md-12">
												<i class="fa fa-at"></i>
												<?php
												echo $this->Form->input('email', array(
													'type' => 'text',
													'label' => false,
													'div'=> false,
													'placeholder' => __('email'),
													'class' => 'input-style',
													'required' => 'required'
												));
												?>
											</div>
											<div class="col-md-12">
												<i class="fa fa-sticky-note"></i>
												<?php
												echo $this->Form->input('subject', array(
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
												echo $this->Form->input('message', array(
													'type' => 'textarea',
													'label' => false,
													'div'=> false,
													'placeholder' => __('message'),
													'class' => 'input-style',
													'required' => 'required'
												));
												?>
											</div>

											<div class="col-sm-12">
													<img id="captcha" src="<?php echo __SITE_URL ?>captcha/advanced-captcha.php" alt=""/>
													<a href="#" onclick='$("#captcha").attr("src", "<?php echo __SITE_URL ?>captcha/advanced-captcha.php?" + (new Date()).getTime())'><img src="<?php echo __SITE_URL.'img/icons/refresh.gif' ?>"  /></a>
													<?php
													echo $this->Form->input('captcha', array(
														'type' => 'text',
														'label' => false,
														'div'=> false,
														'placeholder' => __('captcha'),
														'class' => 'form-control',
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
	</div>
</section>
