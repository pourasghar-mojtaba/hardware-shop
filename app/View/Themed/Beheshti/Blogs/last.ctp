<script
	type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type":"WebPage",
  "name": "<?php echo __('news_and_magazin'); ?>" ,
  "url":"<?php echo __SITE_URL; ?>blogs/last",
  "description": "<?php echo $description_for_layout; ?>"
}









</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
	  {
		"@type": "ListItem",
		"position": 1,
		"name": "<?php echo __('armaghansalamatco'); ?>",
		"item": "<?php echo __SITE_URL; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 2,
		"name": "<?php echo __('blogs'); ?>",
		"item": "<?php echo __SITE_URL . 'blogs/last'; ?>"
	  }
  ]
}


</script>

<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__BLOG_LOCALE, 'blog') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
				<li><a href="#" title=""><?php echo __d(__BLOG_LOCALE, 'blog') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->

<section class="block">
	<div class="container">
		<div class="row">
			<aside class="col-md-4 column">

				<div class="category_widget widget">
					<div class="heading2">
						<h3><?php echo __d(__BLOG_LOCALE, 'tags') ?></h3>
					</div>
					<ul>

						<?php
						foreach ($besttags as $tag) {
							?>
						<li><a class="tag-link" href="#"><?php echo $tag['BlogTag']['title'] ?></a></li>
							<?php
						}
						?>

					</ul>
				</div><!-- Category Widget -->
			</aside>
			<div class="col-md-8 column">
				<div class="blog-sec">
					<div class="row">

						<?php
						foreach ($blogs as $blog) {
							?>
							<div class="col-md-12">
								<div class="blog-post">
									<div class="post-thumb">
										<img
											src="<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>"
											alt="<?php echo $blog['Blogtranslation']['title']; ?>"/>
										<div class="post-detail">

											<h2><a href="<?php echo __SITE_URL . "blog/" . $blog['Blog']['slug']; ?>" title=""><?php echo $blog['Blogtranslation']['title']; ?></a></h2>
											<span><i class="fa fa-calendar-o"></i>
											<?php echo $this->Cms->show_persian_date("j", strtotime($blog['Blog']['created'])); ?>, <?php echo $this->Cms->show_persian_date("F", strtotime($blog['Blog']['created'])); ?>
											</span>
											<p><?php echo $blog['Blogtranslation']['little_detail']; ?></p>
										</div>
									</div>

								</div><!-- Blog Post -->
							</div>
							<?php
						}
						?>

					</div>
					<!--<ul class="pagination">
						<li class="disabled"><a href="#" title=""><span>بعدی</span></a></li>
						<li><a href="#" title="">3</a></li>
						<li class="active"><a href="#" title="">2</a></li>
						<li><a href="#" title="">1</a></li>
						<li><a href="#" title=""><span>قبلی</span></a></li>
					</ul>-->
				</div>
			</div>

		</div>
	</div>
</section>



