<?php
	echo $this->Html->css('/'.__PRODUCT.'/js/lightslider/css/lightslider.min.css');
	echo $this->Html->script('/'.__PRODUCT.'/js/lightslider/js/lightslider.min.js');
?>
<div class="main-title">
	<div class="container">
		<h1 class="main-title__primary"><?php echo $product['Product']['title']; ?></h1>
		 
	</div>
</div>
<div class="breadcrumbs ">
	<div class="container">
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="<?php echo __('home') ?>" href="<?php echo __SITE_URL; ?>" class="home">
		<?php echo __('home') ?></a>
		</span>
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="<?php echo __d(__PRODUCT_LOCALE,'products') ?>" href="<?php echo __SITE_URL.__PRODUCT."/products/search?categoryid_filter=".$product['Product']['product_category_id']; ?>" class="home">
		<?php echo __d(__PRODUCT_LOCALE,'products') ?></a>
		</span>
		<span typeof="v:Breadcrumb"><span property="v:title"><?php echo $product['Product']['title']; ?></span></span>	
	</div>
</div>
<div class="master-container">
	<div class="container">
		<div class="row">
			<div class="col-xs-12  col-md-9  col-md-push-3" role="main">
				<div class="product product-type-simple">
					<div class="images">
						
						
						<div class="clearfix" style=" direction: ltr;height:300px">
			                <ul id="image-gallery"  class="gallery list-unstyled cS-hidden" >
			                    <?php 
									foreach($images as $image){
								?>
								<li data-thumb="<?php echo __SITE_URL.__PRODUCT_IMAGE_URL.__UPLOAD_THUMB.'/'.$image['Productimage']['image']; ?>"> 
			                        <a href='<?php echo __SITE_URL.__PRODUCT_IMAGE_URL.$image['Productimage']['image']; ?>' class='woocommerce-main-image zoom' title='' data-rel='prettyPhoto'>
									<?php echo "<img style='width:100%;height: 300px;'   src='".__SITE_URL.__PRODUCT_IMAGE_URL.$image['Productimage']['image']."' />"; ?>
									</a>
			                    </li>
								<?php
								 }
								?>
			                    
			                </ul>
			            </div>
						
					</div>
					<div class="summary entry-summary">
			 
						<h1 class="product_title entry-title"><?php echo $product['Product']['title']; ?></h1>
						 
						<div class="short-description">
							<p>
								<?php echo $product['Product']['mini_detail']; ?>
							</p>
						</div>
						 
					</div><!-- .summary -->
					<div class="woocommerce-tabs">
						<div class="panel entry-content" id="tab-description">
							<h2>توضیحات محصول</h2>
							<p>
								<?php echo $this->Cms->convert_character_editor($product['Product']['detail']); ?>
							</p>
						</div>
					</div>
					 
				</div>
			</div>
			<div class="col-xs-12  col-md-3  col-md-pull-9">
				<div class="sidebar shop-sidebar">
					<!-- Search Widget -->
					<div class="widget woocommerce widget_product_search push-down-30">
						<h4 class="sidebar__headings">جستجو محصولات</h4>
						<form action="<?php echo(__SITE_URL.__PRODUCT.'/products/search') ?>" method="GET" id="searchform" class="woocommerce-product-search">
						 
							<div>
								<label class="screen-reader-text" for="s">جستجو برای:</label>
								<input type="text" value="" name="search" id="s" placeholder="جستجو برای محصولات"/>
								<input type="submit" id="searchsubmit" value="جستجو"/>
								<input type="hidden" name="post_type" value="product"/>
							</div>
						</form>
					</div>
						
					 
					<!-- Top rated products Widget -->
					<div class="widget woocommerce widget_top_rated_products push-down-30">
						<h4 class="sidebar__headings"><?php echo __d(__PRODUCT_LOCALE,'last_products') ?></h4>
						<ul class="product_list_widget">
							<?php
								foreach($lastproducts as $lastproduct)
								{							
							?>
							<li>
								<a href="<?php echo __SITE_URL.__PRODUCT.'/products/view/'.$lastproduct['Product']['id'].'/'.$lastproduct['Product']['title']; ?>" title="">
								<?php echo $this->Html->image(__SITE_URL.__PRODUCT_IMAGE_URL.$lastproduct['0']['image'],array('alt'=>$lastproduct['Product']['title'],'height'=>'90','width'=>'90')); ?>
								<strong><?php echo $lastproduct['Product']['title']; ?></strong>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
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