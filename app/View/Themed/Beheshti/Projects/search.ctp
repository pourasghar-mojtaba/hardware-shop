 
<div class="main-title">
	<div class="container">
		<h1 class="main-title__primary"><?php echo __d(__PRODUCT_LOCALE,'products'); ?></h1>
		<h3 class="main-title__secondary"><?php 
		
				foreach($productcategory as $category)
				{
					if($category['id']==$categoryid_filter){
						echo $category['title'];
					}
				}
				
		 ?></h3>
	</div>
</div>
<div class="breadcrumbs ">
	<div class="container">
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" title="برو به ساخت و ساز." href="index.html" class="home">ساخت و ساز</a></span>
		<span property="v:title"><?php echo __d(__PRODUCT_LOCALE,'products'); ?></span>
	</div>
</div>
<div class="master-container">
	<div class="container">
		<div class="row">
			<div class="col-xs-12  col-md-9  col-md-push-3" role="main">
				<p class="woocommerce-result-count">نمایش <?php echo count($products); ?> از <?php echo $total_count; ?> نتیجه</p>
				<ul class="products">
					<?php
						$i=0;
						foreach($products as $product){
													
					?>
					
					<li class="product <?php if($i==0) echo 'first';if($i==3) {echo 'last';$i=-1;} ?>">
						<a href="<?php echo __SITE_URL.__PRODUCT.'/products/view/'.$product['Product']['id'].'/'.$product['Product']['title']; ?>">
							<?php echo $this->Html->image(__SITE_URL.__PRODUCT_IMAGE_URL.$product['0']['image'],array('alt'=>$product['Product']['title'],'height'=>'150','width'=>'150')); ?>
							<h3><?php echo $product['Product']['title']; ?></h3>
														 
							 
						</a>
						 
					</li>
					
				<?php
				$i++;
					}
				?>	
				
					
					
				</ul>
				<nav class="pagination text-center">
					<?php
					if(!empty($_REQUEST['page']))
					{
						$page = $_REQUEST['page'];
					}
					else 
						$page = 1;

					$url_str = __SITE_URL.__PRODUCT.'/products/search?categoryid_filter='.$categoryid_filter.'&itemspp_filter='.$itemspp_filter;
					$this->Paginate->with_hide($total_count,$page,$limit,$url_str);
				?>
				</nav>
			</div>
			<div class="col-xs-12  col-md-3  col-md-pull-9">
				<div class="sidebar shop-sidebar">
					<!-- Search Widget -->
					<div class="widget woocommerce widget_product_search push-down-30">
						<h4 class="sidebar__headings">جستجو محصولات</h4>
						<form action="<?php echo(__SITE_URL.__PRODUCT.'/products/search') ?>" method="GET" id="searchform" class="woocommerce-product-search">
							<input type="hidden" id="categoryid_filter" name="categoryid_filter" value="<?php echo($categoryid_filter) ?>" />
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
