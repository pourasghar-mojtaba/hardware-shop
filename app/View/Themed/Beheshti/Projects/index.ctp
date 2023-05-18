<!-- ============================ Hero Banner  Start================================== -->
<div class="page-title-wrap pt-img-wrap" style="background:url(<?php echo __SITE_URL.__THEME_PATH;?>img/ser-1.jpg) no-repeat;">
	<div class="container">
		<div class="col-lg-12 col-md-12">
			<div class="pt-caption text-center mt-5">
				<h1><?php echo __d(__PROJECT_LOCALE,'projects') ?></h1>
				<p><a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<span class="current-page"><?php echo $category['Projectcategory']['title']; ?></span></p>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- ============================ Hero Banner End ================================== -->
			
<!-- ====== Portfolio Start ====== -->
<section id="portfolio">
	<div class="container">
		<div class="row">
				
			<div class="col-lg-12 col-md-12 col-xs-12">
 
					
				<div class="row portfolio-gallary">
					<?php
						foreach($projects as $project){
							
					?>	
					<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 port-item design development">
						<div class="portfolio-wrap portfolio-inner">
							<?php echo $this->Html->image(__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$project['0']['image'],array('alt'=>$project['Project']['title'])); ?>
							<div class="label">
								<div class="label-text">
									<a href="<?php echo __SITE_URL.__PROJECT.'/projects/view/'.$project['Project']['id'].'/'.str_replace(' ','-',$project['Project']['title']); ?>" class="text-title"><?php echo $project['Project']['title']; ?></a>
									<!--<span class="lead-i"><?php echo $project['Project']['mini_detail']; ?></span>-->
								</div>
								<div class="label-bg"></div>
							</div>
							<div class="zoom">
								<a href="<?php echo __SITE_URL.__PROJECT_IMAGE_URL.$project['0']['image']; ?>" class="popup-box"  data-lightbox="image" data-title="<?php echo $project['Project']['title']; ?>">
									<i class="ti-zoom-in"></i>
								</a>
							</div>
						</div>
					</div>
					<?php
					}
					?>

				</div>
			</div>
						
		</div>
	</div>
</section>
<!-- ====== Portfolio End ====== -->
			
<!-- ============================ Sign up Start ================================== -->
<section class="cta" style="background:#fb993e url(<?php echo __SITE_URL.__THEME_PATH;?>/img/line6.png)no-repeat">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 col-md-10">
				<div class="cta-sec text-center">
					<h2><?php echo __d(__PROJECT_LOCALE,'to_order_call_with_us') ?></h2>
					<p><?php echo __d(__PROJECT_LOCALE,'little_time_little_cost') ?></p>
					<a href="<?php echo __SITE_URL; ?>pages/contact_us/" class="btn btn-cta"><?php echo __d(__PROJECT_LOCALE,'order_project') ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div>
<!-- ============================ Sign up End ================================== -->