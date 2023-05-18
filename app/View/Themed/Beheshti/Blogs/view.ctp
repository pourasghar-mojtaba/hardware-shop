<script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"NewsArticle",
    "inLanguage":"fa-IR",
    "mainEntityOfPage":{
       "@type": "WebPage",
       "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
       "url":"<?php echo __SITE_URL . 'blog/' . $blog['Blog']['slug']; ?>"
     },
    "headline":"<?php echo $blog['Blogtranslation']['title']; ?>",
    "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
    "author":{
  		"@type":"Person",
  		"name":"<?php echo __('armaghansalamatco'); ?>"
        },
    "creator":{
  		"@type":"Person",
  		"url":"<?php echo __SITE_URL; ?>",
  		"name":"<?php echo __('armaghansalamatco'); ?>"},
    "image":{
  		"@type":"ImageObject",
  		"url":"<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>",
  		"width":500,
  		"height":500
        },
    "datePublished":"<?php echo $blog['Blog']['created']; ?>",
    "dateModified":"<?php echo $blog['Blog']['created']; ?>",
    "keywords":"<?php echo $keywords_for_layout; ?>",
    "publisher":{
  		"@type":"Organization",
  		"url":"<?php echo __SITE_URL; ?>",
  		"name":"<?php echo __('armaghansalamatco'); ?>",
  		"logo":{
  			"@type":"ImageObject",
  			"url":"<?php echo __SITE_URL; ?>img/logo.png",
  			"width":500,
  			"height":500
            }
     },
    "articleSection":"<?php echo __('news_and_magazin'); ?>",
    "description":"<?php echo $blog['Blog']['little_detail']; ?>"
  }




</script>

<script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Article",
    "headline": "<?php echo $blog['Blogtranslation']['title']; ?>",
    "articlebody":"<?php echo $blog['Blog']['detail']; ?>",
    "name": "<?php echo $blog['Blogtranslation']['title']; ?>",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
        "id": "<?php echo __SITE_URL . 'blog/' . $blog['Blog']['slug']; ?>"
    },
    "image": {
        "@type": "ImageObject",
        "url": "<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>",
        "width": 1200,
        "height": 900
    },
    "author": {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "<?php echo __('armaghansalamatco'); ?>",
        "url": "<?php echo __SITE_URL; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo __SITE_URL; ?>img/logo.png",
            "width": 326,
            "height": 60
        },
        "sameAs": [
            "https://twitter.com/armaghansalamatco",
            "https://www.instagram.com/armaghansalamatco/"
        ]
    },

    "datePublished": "<?php echo $blog['Blog']['created']; ?>",
    "dateModified": "<?php echo $blog['Blog']['created']; ?>",
    "publisher": {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "<?php echo __('armaghansalamatco'); ?>",
        "url": "<?php echo __SITE_URL; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo __SITE_URL; ?>img/logo.png",
            "width": 326,
            "height": 60
        },
        "sameAs": [
            "https://www.facebook.com/armaghansalamatco/",
            "https://twitter.com/armaghansalamatco",
            "https://www.instagram.com/armaghansalamatco/"
        ]
    },
    "description": "<?php echo $blog['Blog']['little_detail']; ?>"
}



</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $blog['Blogtranslation']['title']; ?>",
  "publisher": "<?php echo __('armaghansalamatco'); ?>",
  "url": "<?php echo __SITE_URL . 'blog/' . $blog['Blog']['slug']; ?>"
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
		"name": "<?php echo __('news_and_magazin'); ?>",
		"item": "<?php echo __SITE_URL . 'blogs/last'; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 3,
		"name": "<?php echo $blog['Blogtranslation']['title']; ?>",
		"item": "<?php echo __SITE_URL . 'blog/' . $blog['Blog']['slug']; ?>"
	  }
  ]
}




</script>
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/custom-scroll/jquery-scrollbar.css'); ?>
<!-- Page Title-->

<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo $blog['Blogtranslation']['title']; ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
				<li><a href="<?php echo __SITE_URL . __BLOG . '/blogs/last'; ?>" title=""><?php echo __d(__BLOG_LOCALE, 'weblog') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->

<section class="block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<div class="single-post-sec">
							<div class="blog-post">
								<div class="post-thumb">
									<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>" alt="<?php echo $blog['Blogtranslation']['title']; ?>" />
									<div class="post-detail">

										<span><i class="fa fa-calendar-o"></i>
										<?php echo $this->Cms->show_persian_date("j", strtotime($blog['Blog']['created'])); ?>, <?php echo $this->Cms->show_persian_date("F", strtotime($blog['Blog']['created'])); ?>
										</span>

									</div>
								</div>
								<h1></h1>
								<div class="blog_body">
									<?php
									echo $blog['Blogtranslation']['little_detail'];
									echo $this->Cms->convert_character_editor($blog['Blogtranslation']['detail']);
									?>
								</div>
								<p></p>
								<div class="post-tags">
									<span><i class="fa fa-tags"></i> برچسپ ها :</span>
									<?php
									foreach ($besttags as $tag) {
									?>
									<a href="" title=""><?php echo $tag['BlogTag']['title'] ?></a>,
										<?php
									}
									?>
								</div>
							</div><!-- Blog Post -->
							<div class="related-posts">
								<div class="heading3">
									<h3>پست مرتبط</h3>

								</div>
								<div class="related">
									<div class="row">
										<?php
										if (!empty($similar_blogs)) {
											foreach ($similar_blogs as $similar_blog) {
												?>
												<div class="col-md-6">
													<div class="post-style2">
														<div class="post2-thumb">
															<img
																src="<?php echo __SITE_URL . __BLOG_IMAGE_URL . __UPLOAD_BLOG_THUMB . '/' . $similar_blog['Blog']['image']; ?>"
																alt=""/>
														</div>
														<span>
															<?php echo $this->Cms->show_persian_date("j", strtotime($similar_blog['Blog']['created'])); ?>
															<?php echo $this->Cms->show_persian_date("F", strtotime($similar_blog['Blog']['created'])); ?>
														</span>
														<h3><a href="#" title=""><?php echo $similar_blog['Blogtranslation']['title']; ?> </a></h3>
														<p><?php echo $similar_blog['Blogtranslation']['little_detail']; ?></p>
													</div>
												</div>
												<?php
											}
										}
										?>
									</div>
								</div>
							</div><!-- Related Posts -->

						</div><!-- Blog POst Sec -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/pagination.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/sidebar.js');
?>

