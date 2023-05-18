<?php

?>
<!-- Page Title-->

<!-- Page Content-->

<div class="inner-head overlap">
	<div data-velocity="-.2" style="background: url(<?php echo __SITE_URL.__THEME_PATH.'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__PRODUCT, 'shop') ?></h2>
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
				<div class="product-sec">
					<div class="row">
						<?php
						foreach ($products as $product) {
						?>
								<div class="col-md-4">
									<div class="product-box">
										<div class="product-thumb">
											<img src="<?php echo __SITE_URL . __PRODUCT_IMAGE_URL . $product['0']['image']; ?>" alt="<?php echo $product['Producttranslation']['title']; ?>" />
											<a href="<?php echo __SITE_URL . 'product/' . $product['Product']['slug']; ?>" title="" class="add-to-cart"><i class="fa  fa-shopping-bag"></i></a>
										</div>
										<h3><a href="<?php echo __SITE_URL . 'product/' . $product['Product']['slug']; ?>" title=""><?php echo $product['Producttranslation']['title']; ?></a></h3>
										<span class="price"><?php echo  number_format( $product['Product']['price']); ?> ریال</span>
									</div>
								</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


