<div class="page-container">

	<!-- BEGIN BREADCRUMBS -->
	<div class="row breadcrumbs margin-bottom-40">
		<div class="container">
			<div class="col-md-8 col-sm-8 ">
				<ul class="pull-left breadcrumb">
					<li>
						<?php echo $this->Html->link(__('home'),__SITE_URL) ?>
					</li>
					<li class="active">
						<?php echo $page['Page']['title']; ?>
					</li>
				</ul>
			</div>
			<div class="col-md-4 col-sm-4 text-center">
				<h1>
					<?php echo $page['Page']['title']; ?>
				</h1>
			</div>

		</div>
	</div>
	<!-- END BREADCRUMBS -->

	<!-- BEGIN CONTAINER -->
	<div class="container min-hight">
		<!-- BEGIN ABOUT INFO -->
		<div class="row margin-bottom-30">
			<!-- BEGIN INFO BLOCK -->
			<div class="col-md-12 space-mobile">
				<?php
					echo $this->Cms->convert_character_editor($page['Page']['body']);
				?>
				<!-- BEGIN LISTS -->
				<div class="row front-lists-v1">
					<div class="col-md-6">
						<ul class="list-unstyled margin-bottom-20">
							<li>
								<i class="fa fa-check">
								</i> صنایع تولید شیشه
							</li>
							<li>
								<i class="fa fa-check">
								</i> طراحی دکوراسیون های شیشه ای
							</li>
							<li>
								<i class="fa fa-check">
								</i> پیاده سازی و اجرا
							</li>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-check">
								</i> پشتیبانی
							</li>
							<li>
								<i class="fa fa-check">
								</i> فروش
							</li>
							<li>
								<i class="fa fa-check">
								</i> مدیریت
							</li>
						</ul>
					</div>
				</div>
				<!-- END LISTS -->
			</div>
			<!-- END INFO BLOCK -->

		</div>
		<!-- END ABOUT INFO -->

		<!-- BEGIN TESTIMONIALS AND PROGRESS BAR -->
		<div class="row margin-bottom-40">
			<!-- BEGIN TESTIMONIALS -->
			<div class='col-md-7 testimonials-v1'>
			<?php $this->Plugin->run_hook('manager_message'); ?>
			</div>
			<!-- END TESTIMONIALS -->

			<!-- BEGIN PROGRESS BAR -->
			<div class="col-md-5 front-skills space-mobile">
				<h2 class="block">
					مهارت های ما
				</h2>
				<span>
					تولید شیشه 90%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 90%;">
					</div>
				</div>
				<span>
					دکوراسیون 80%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 60%;">
					</div>
				</div>
				<span>
					شیشه های دوجداره 100%
				</span>
				<div class="progress">
					<div role="progressbar" class="progress-bar" style="width: 100%;">
					</div>
				</div>
			</div>
			<!-- END PROGRESS BAR -->
		</div>
		<!-- END TESTIMONIALS AND PROGRESS BAR -->

		<!-- BEGIN OUR TEAM -->		
		<?php $this->Plugin->run_hook('manager_image'); ?>
		<!-- END OUR TEAM -->
	</div>
	<!-- END CONTAINER -->

</div>