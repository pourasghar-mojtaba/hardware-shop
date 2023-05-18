 <?php
 
 	 if(!empty($basket_products)){
	  	foreach($basket_products as $basket_product){				
 ?>
	 
	<li class='dropdown-item basket_item' id="product_<?php echo $basket_product['id']; ?>">
		<a href='<?php echo __SITE_URL.__SHOP.'/'.'products/view/'.$basket_product['id']; ?>' class='link-to'></a>
		 
		<svg class='svg-plus'  onClick='delete_basket_confirm(<?php echo $basket_product['id']; ?>);'>
			<use xlink:href='#svg-plus'></use>
		</svg>
		 
		<div class='dropdown-triangle'></div>
		<figure class='product-preview-image tiny'>
			<img src='<?php echo __SITE_URL.__SHOP_IMAGE_URL.__UPLOAD_THUMB.'/'.$basket_product['image']; ?>' alt=''>
		</figure>
		<p class='text-header tiny'><?php echo $basket_product['title']; ?></p>
		<p class='category tiny primary'><?php echo __d(__SHOP_LOCALE,'number').' : '.$basket_product['num']; ?></p>
		<p class='price tiny'><span>تومان</span><?php echo $basket_product['price']; ?></p>
	</li>
	 

	
<?php
	}
  }
?>	
 