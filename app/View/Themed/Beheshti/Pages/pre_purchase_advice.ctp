<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
	  {
		"@type": "ListItem",
		"position": 1,
		"name": "<?php echo __('site_name'); ?>",
		"item": "<?php echo __SITE_URL; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 2,
		"name": "<?php echo $page['Page']['title']; ?>",
		"item": "<?php echo "https://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
	  }
  ]
}

</script>
<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __( 'pre_purchase_advice'); ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->

<section class="block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="gallery-fancy-sec about-sec">
					<div class="row">
						<div class="col-md-12">
							<div class="fancy-gallery-infos">
								<?php
								echo $this->Cms->convert_character_editor($page['Page']['body']);
								?>
							</div>
						</div>



					</div>
				</div>
			</div>
		</div>
	</div>
</section>


