
<section class="bg-parallax py-5"><span class="bg-overlay" style="opacity: .6;"></span>
	<div class="bg-parallax-img" data-parallax="{&quot;y&quot; : 100}"><img
			src="<?php echo __SITE_URL . __THEME_PATH; ?>img/pages/contacts-hero-bg.jpg" alt="Parallax Background"/>
	</div>
	<div class="bg-parallax-content px-3 py-md-5 mx-auto mt-lg-5 mb-lg-5 text-center" style="max-width: 800px;">
		<h1 class="text-white pt-2"><?php echo __('granting_sales_agency'); ?></h1>

	</div>
</section>

<!-- Contact Form-->
<section class="container mb-5 pb-3">
	<div class="wizard">
		<div class="wizard-body pt-3">



			<?php echo $this->Form->create('Salesagency', array('id' => 'RegisterForm', 'enctype' => 'multipart/form-data', 'class' => 'needs-validation'
			, 'onsubmit' => 'return check_field()', 'url' => "/salesagencies/send")); ?>

			<?php
			if ($this->Session->check('Message.flash')) {
				echo $this->Session->flash();
			}
			?>
			<div class="row pt-3">
				<div class="col-sm-6">
					<div class="form-group">
						<?php
						echo $this->Form->input('name', array(
							'type' => 'text',
							'label' => __('name'),
							'placeholder' => __('enter_name'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<?php
						echo $this->Form->input('email', array(
							'type' => 'text',
							'label' => __('email'),
							'placeholder' => __('enter_email'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<?php
						/*echo $this->Form->input('subject', array(
							'type' => 'text',
							'label' => __('subject'),
							'placeholder' => __('subject'),
							'class' => 'form-control',
							'required' => 'required'
						));*/

						echo $this->Form->input('form_type', array(
							'type' => 'select',
							'options' => array(0 => __('obtaining_sales_representative'), 1 => __('employment')),
							'label' => __('subject'),
							'default' => '1',
							'class' => 'form-control'
						));

						?>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<?php
						echo $this->Form->input('mobile', array(
							'type' => 'text',
							'label' => __d(__USER_LOCAL,'mobile'),
							'placeholder' => __('+98----'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<?php
						echo $this->Form->input('file', array(
							'type' => 'file',
							'label' => __('request_file'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<?php
				echo $this->Form->input('message', array(
					'type' => 'textarea',
					'label' => __('message'),
					'placeholder' => __('message'),
					'class' => 'form-control',
					'required' => 'required'
				));
				?>

			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<img id="captcha" src="<?php echo __SITE_URL ?>captcha/advanced-captcha.php" alt=""/>
					<a href="#" onclick='$("#captcha").attr("src", "<?php echo __SITE_URL ?>captcha/advanced-captcha.php?" + (new Date()).getTime())'><img src="<?php echo __SITE_URL.'img/icons/refresh.gif' ?>"  /></a>
					<?php
					echo $this->Form->input('captcha', array(
						'type' => 'text',
						'label' => __('captcha'),
						'placeholder' => __('captcha'),
						'class' => 'form-control',
						'required' => 'required'
					));
					?>
				</div>
			</div>
			<div class="text-center">
				<button class="btn btn-primary" type="submit"><?php echo __('Send_request'); ?></button>
			</div>
			</form>
		</div>
	</div>
</section>
<!-- Map-->
