<form accept-charset="utf-8" method="post" class="myForm" name="Basket" id="Basket"
	  action="<?php echo __SITE_URL . __PRODUCT; ?>/orders/preper_pay_order">
	<section class="block">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="cart-lists">
						<ul>
							<?php
							$total = 300000;
							if (!empty($products)) {

								foreach ($products as $product) {
									$total += $product['price'] * $product['num'];

									?>
									<li>
										<div class="cart-thumb">
											<span><img
													src="<?php echo __SITE_URL . __PRODUCT_IMAGE_URL . $product['image']; ?>"
													alt="<?php echo $product['title']; ?>"/></span>
											<a class="delete-cart" onclick=delete_basket_product(this,<?php echo $product['id']; ?>) title=""><i class="fa fa-trash-o"></i></a>
											<h3><a href="<?php echo __SITE_URL . 'product/' . $product['slug'] ?>" title=""><?php echo $product['title']; ?></a></h3>
										</div>
										<div class="c-input-number">
											<input id="change_basket_item"
												   onChange="refresh_basket(<?php echo $product['id'] ?>,this.value)" type="number"
												   value="<?php echo $product['num']; ?>" class="form-control">
										</div>
										<div class="cart-item-quantity">
											<i class="fa  fa-shopping-basket"></i>
											<span><?php echo number_format($product['price']); ?> ریال</span>
										</div>
									</li>
									<?php
								}

							} else {
								echo "
										<div class='alert alert-warning alert-dismissible fade show text-center mb-30'>
											<span class='close' data-dismiss='alert'></span>
											  " . __d(__PRODUCT_LOCALE, 'your_basket_is_empty') . "
										</div>
										";
							}
							?>
						</ul>
					</div>
					<div class="coupens-area">

						<input type="button" class="flat-btn continue_sale" name="update_cart" value="به روز رسانی سبد خرید">
						<input type="submit" class="checkout-button flat-btn end_sale" name="proceed" value="اقدام به پرداخت">
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="block remove-top">
		<div class="container">
			<div class="row">
				<div class="col-md-6 column">
					<div class="cart-total-box">
						<h2 class="cart-head-title">مجموع سبد خرید</h2>
						<ul>
							<li><h3>زیر مجموع سبد خرید:</h3> <span><?php echo number_format($total); ?> ریال</span></li>
							<li><h3>ارسال :</h3> <span>ارسال رایگان</span></li>
						</ul>
					</div><!-- Cart  -->
				</div>

			</div>
		</div>
	</section>

</form>
<script>
    $(function () {
        $('.continue_sale').click(function () {
            window.location.href = '<?php echo __SITE_URL . 'products'; ?>';
        });

        $('.end_sale').click(function () {
            $('#Basket').submit();
        })
    });
</script>
