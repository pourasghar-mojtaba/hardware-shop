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
<section class="bg-parallax bg-secondary py-5 mb-5">
	<div class="bg-parallax-img" data-parallax="{&quot;y&quot; : 100}"><img
			src="<?php echo __SITE_URL . __THEME_PATH; ?>img/pages/about-hero-bg.png" alt="Parallax Background"/>
	</div>
	<div class="container bg-parallax-content py-5 my-3 text-center">
		<h1 class="pb-4"><?php echo __( 'representative_of_world_famous_brands'); ?></h1>
	</div>
</section>
<section class="container pt-3 pb-4 mb-5" data-offset-top="110" id="services">
	<div class="row">
		<?php
		echo $this->Cms->convert_character_editor($page['Page']['body']);
		?>
	</div>
</section>
