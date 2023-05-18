<!-- Page Title-->


<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__USER_LOCAL, 'edit_password') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->

<section class="block ">
	<div class="container">
		<div class="row">

			<div class="container mb-4">
				<div class="row">
					<?php echo $this->element('profile_setting_menu', array('active' => 'edit_password')); ?>
					<!-- Profile Settings-->
					<div class="col-lg-8 pb-5">
						<?php echo $this->Form->create('User', array('id' => 'ChangeProfile', 'name' => 'ChangeProfile', 'enctype' => 'multipart/form-data', 'class' => 'row', 'onsubmit' => 'return check_field()')); ?>
						<div class="col-md-12">
							<?php echo $this->Session->flash(); ?>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('old_password', array(
									'type' => 'password',
									'label' => __('old_password'),
									'placeholder' => __(''),
									'class' => 'form-control',
									'required' => 'required'
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('new_password', array(
									'type' => 'password',
									'label' => __('new_password'),
									'placeholder' => __(''),
									'class' => 'form-control',
									'required' => 'required'
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('repeat_new_password', array(
									'type' => 'password',
									'label' => __('repeat_new_password'),
									'placeholder' => __(''),
									'class' => 'form-control',
									'required' => 'required'
								));
								?>
							</div>
						</div>
						<div class="col-12">
							<hr class="mt-2 mb-3">
							<div class="d-flex flex-wrap justify-content-between align-items-center">
								<button class="btn btn-primary flat-btn" type="submit">
									<?php echo __('save_changes'); ?>
								</button>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
