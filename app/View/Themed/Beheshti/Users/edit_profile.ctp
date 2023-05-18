<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__USER_LOCAL, 'account_setting') ?></h2>
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
					<?php echo $this->element('profile_setting_menu', array('active' => 'edit_profile')); ?>
					<!-- Profile Settings-->
					<div class="col-lg-8 pb-5">
						<?php echo $this->Form->create('User', array('id' => 'ChangeProfile', 'name' => 'ChangeProfile', 'enctype' => 'multipart/form-data', 'class' => 'row', 'onsubmit' => 'return check_field()')); ?>
						<div class="col-md-12">
							<?php echo $this->Session->flash(); ?>
						</div>
						<div class="col-md-6">
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
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('mobile', array(
									'type' => 'tel',
									'label' => __d(__USER_LOCAL, 'mobile'),
									'placeholder' => '۰۲۱-۱۱۱۱۱۱۱۱',
									'class' => 'form-control',
									'required' => 'required',
									'disabled' => 'disabled',
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('email', array(
									'type' => 'email',
									'label' => __('email'),
									'placeholder' => __('enter_email'),
									'class' => 'form-control',
									'required' => 'required'
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="new_email" class="rl-label"><?php echo __('sex') ?></label>
								<select name='data[User][sex]' class="form-control">
									<?php
									if ($user['User']['sex'] == 1) echo "<option value='1' selected>" . __('man') . "</option>"; else echo "<option value='1'>" . __('man') . "</option>";
									if ($user['User']['sex'] == 0) echo "<option value='0' selected>" . __('woman') . "</option>"; else echo "<option value='0'>" . __('woman') . "</option>";
									?>
								</select>
							</div>
						</div>
						<!--<div class="col-md-6">
							<div class="form-group">
								<label for="account-pass">رمز عبور جدید</label>
								<input class="form-control" type="password" id="account-pass">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="account-confirm-pass">تایید رمز عبور</label>
								<input class="form-control" type="password" id="account-confirm-pass">
							</div>
						</div>-->
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
