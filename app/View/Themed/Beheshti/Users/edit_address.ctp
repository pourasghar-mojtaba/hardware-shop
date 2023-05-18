

<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__USER_LOCAL, 'edit_address') ?></h2>
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
					<?php echo $this->element('profile_setting_menu', array('active' => 'edit_address')); ?>
					<!-- Profile Settings-->
					<div class="col-lg-8 pb-5">
						<?php echo $this->Form->create('Userdetail', array('id' => 'ChangeProfile', 'name' => 'ChangeProfile', 'enctype' => 'multipart/form-data', 'class' => 'row', 'onsubmit' => 'return check_field()')); ?>
						<div class="col-md-12">
							<?php echo $this->Session->flash(); ?>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('court_id', array(
									'type' => 'select',
									'id' => 'court_id',
									'options' => $courts,
									'label' => __d(__USER_LOCAL, 'court'),
									'class' => 'form-control input-sm'
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('city_id', array(
									'type' => 'select',
									'id' => 'city_id',
									'options' => '',// $companies,
									'label' => __d(__USER_LOCAL, 'city'),
									'class' => 'form-control input-sm'
								));
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php
								echo $this->Form->input('telephon', array(
									'type' => 'text',
									'label' => __d(__USER_LOCAL, 'telephon'),
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
								echo $this->Form->input('post_code', array(
									'type' => 'text',
									'label' => __d(__USER_LOCAL, 'post_code'),
									'placeholder' => __(''),
									'class' => 'form-control',
									'required' => 'required'
								));
								?>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<?php
								echo $this->Form->input('address', array(
									'type' => 'text',
									'label' => __d(__USER_LOCAL, 'address'),
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

<script>
    function get_cities(court_id, city_id) {
        $.ajax(
            {
                type: "GET",
                url: '<?php echo __SITE_URL; ?>' + 'cities/get_cities/' + court_id + '/' + city_id,
                data: 'court_id=' + court_id,
                dataType: "html",
                success: function (response) {
                    $('#city_id').html(response);
                }
            });
    }

    $('#court_id').on('change', function () {
        get_cities(this.value, -1);
    });

    get_cities($("#court_id").val(), '<?php echo empty($this->request->data['Userdetail']['city_id']) ? '0' : $this->request->data['Userdetail']['city_id']; ?>');

</script>
