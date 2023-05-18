<?php
	echo $this->Html->css('/'.__PROJECT.'/js/lightslider/css/lightslider.min.css');
	echo $this->Html->script('/'.__PROJECT.'/js/lightslider/js/lightslider.min.js');
?>	 
<!-- ============================ Hero Banner  Start================================== -->
<div class="page-title-wrap pt-img-wrap" style="background:url(<?php echo __SITE_URL.__THEME_PATH;?>img/ser-1.jpg) no-repeat;">
	<div class="container">
		<div class="col-lg-12 col-md-12">
			<div class="pt-caption text-center mt-5">
				<h1><?php echo $project['Project']['title']; ?></h1>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- ============================ Hero Banner End ================================== -->
			
<!-- ====== Portfolio Detail ====== -->
<section>
	<div class="container">
				
		<div class="row mb-4">
			<div class="col-lg-7 col-md-6 col-sm-12">
				 
				<ul id="image-gallery"  class="gallery list-unstyled cS-hidden"  >
                    <?php 
						foreach($images as $image){
					?>
					<li data-thumb="<?php echo __SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$image['Projectimage']['image']; ?>"> 
                        <a href='<?php echo __SITE_URL.__PROJECT_IMAGE_URL.$image['Projectimage']['image']; ?>' class='woocommerce-main-image zoom' title='' data-rel='prettyPhoto'>
						<?php echo "<img class='img-fluid mx-auto'   src='".__SITE_URL.__PROJECT_IMAGE_URL.$image['Projectimage']['image']."' />"; ?>
						</a>
                    </li>
					<?php
					 }
					?>
                    
                </ul>
			</div>
						
			<div class="col-lg-5 col-md-6 col-sm-12">
				<div class="portfolio-detail-caption">
							
					<div class="portfolio-detail-caption-header">
						<h3><?php echo $project['Project']['title']; ?></h3>
 
					</div>
					<div class="portfolio-detail-caption-overview">
						<p> <?php echo $project['Project']['mini_detail']; ?></p>
 
									
						<h5></h5>
						</ul>
						<ul class="our-team-profile ts-light-bg">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
								
				</div>
			</div>
		</div>
					
		<div class="row mb-5">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<?php echo $this->Cms->convert_character_editor($project['Project']['detail']); ?>
			</div>
		</div>
					
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<h3><?php echo __d(__PROJECT_LOCALE,'last_projects') ?></h3>
			</div>
		</div>
		<div class="row" id="portfolio">
			<?php
				foreach($lastprojects as $lastproject)
				{							
			?>			
			<!-- Single Project -->
			<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
				<div class="project portfolio-inner">
				 
					<?php echo $this->Html->image(__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$lastproject['0']['image'],array('alt'=>$lastproject['Project']['title'])); ?>
					<div class="label">
						<div class="label-text"> <a href="<?php echo __SITE_URL.__PROJECT.'/projects/view/'.$lastproject['Project']['id'].'/'.$lastproject['Project']['title']; ?>" class="text-title"><?php echo $lastproject['Project']['title']; ?></a></div>
						<div class="label-bg"></div>
					</div>
					<div class="zoom">
						<a href="<?php echo __SITE_URL.__PROJECT_IMAGE_URL.$lastproject['0']['image']?>" class="popup-box"  data-lightbox="image" data-title="<?php echo $lastproject['Project']['title']; ?>">
							<i class="ti-zoom-in"></i>
						</a>
					</div>
				</div>
			</div>
						
			<?php } ?> 
						
		</div>
				
	</div>
</section>
<!-- ====== Portfolio Detail End ====== --> 
			
<!-- ============================ Sign up Start ================================== -->
<section class="cta" style="background:#fb993e url(<?php echo __SITE_URL.__THEME_PATH;?>img/line6.png)no-repeat">
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
<script>
    	 $(document).ready(function() {
			 
            $('#image-gallery').lightSlider({
                gallery:false,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                speed:2000,
                auto:true,
                loop:true,
				slideEndAnimation: false,
                pause: 5000,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }  
            });
		});
    </script>