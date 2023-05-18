<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $product['Producttranslation']['title']; ?>",
  "publisher": "<?php echo __('armaghansalamatco'); ?>",
  "url": "<?php echo __SITE_URL . 'product/' . $product['Product']['slug']; ?>"
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
		"name": "<?php echo __d(__PRODUCT, 'shop'); ?>",
		"item": "<?php echo __SITE_URL . 'products'; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 3,
		"name": "<?php echo $product['Producttranslation']['title']; ?>",
		"item": "<?php echo __SITE_URL . 'product/' . $product['Product']['slug']; ?>"
	  }
  ]
}



</script>

<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo $product['Producttranslation']['title']; ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
				<li><a href="<?php echo __SITE_URL . 'products'; ?>" title=""><?php echo __d(__PRODUCT, 'shop') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->

<section class="block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="single-product-sec">
					<div class="row">

						<div class="col-md-6">
							<div class="single-product-infos">
								<h2> <?php echo $product['Producttranslation']['title']; ?></h2>
								<span class="price"><?php  echo  number_format( $product['Product']['price']);?> ریال</span>

								<div>
									<?php echo $product['Producttranslation']['mini_detail']; ?>
									<?php echo $this->Cms->convert_character_editor($product['Producttranslation']['detail']); ?>
								</div>

								<?php
								echo "<span id='basket_loading' style='display:none'>
										<img  src='".__SITE_URL.__PRODUCT."/img/loader/5.gif' />
									</span>";
								?>
								<a href="javascript:void(0)"  id="add_to_basket" title="" class="flat-btn add_to_cart"><i class="fa fa-shopping-bag"></i>افزودن به سبد خرید</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="single-product-tabs">
								<div class="tab-content">
									<?php
									$i = 0;
									foreach ($images as $image) {
									?>
										<div id="tab<?php echo $i+1 ?>" class="tab-pane fade in <?php if ($i == 0) echo "active"; ?>">
											<img src="<?php echo __SITE_URL . __PRODUCT_IMAGE_URL . $image['Productimage']['image']; ?>"
												 alt="<?php echo $product['Producttranslation']['title']; ?>" />
										</div>
										<?php
										$i++;
									}
									?>
								</div>
								<ul class="nav nav-tabs">
									<?php
									$i = 0;
									foreach ($images as $image) {

										?>
										<li class="<?php if ($i == 0) echo "active"; ?>">
											<a href="#<?php echo "id_" . $image['Productimage']['id'] ?>" data-toggle="tab" href="#tab<?php echo $i+1 ?>">
												<img
													src="<?php echo __SITE_URL . __PRODUCT_IMAGE_URL . __UPLOAD_THUMB . '/' . $image['Productimage']['image']; ?>"
													alt="<?php echo $product['Producttranslation']['title']; ?>">
											</a>
										</li>
										<?php
										$i++;
									}
									?>

								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<script>
	$('#add_to_basket').click(function () {
	   // var count = $("select#quantity option").filter(":selected").val();
	    var count =1;// $("#quantity").val();
        add_to_basket(<?php echo $product['Product']['id']; ?>,count,'#basket_loading')
    })
</script>
