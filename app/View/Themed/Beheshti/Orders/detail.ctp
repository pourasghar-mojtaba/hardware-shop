<div class="inner-head overlap">
	<div data-velocity="-.2"
		 style="background: url(<?php echo __SITE_URL . __THEME_PATH . 'img'; ?>/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;"
		 class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
	<div class="container">
		<div class="inner-content">
			<span><i class="fa fa-bolt"></i></span>
			<h2><?php echo __d(__PRODUCT_LOCALE, 'order_list') ?></h2>
			<ul>
				<li><a href="<?php echo __SITE_URL; ?>" title=""><?php echo __('home') ?></a></li>
			</ul>
		</div>
	</div>
</div><!-- inner Head -->
<section class="block ">
	<div class="container">
		<div class="row">
			<div class="container mb-4">
				<div class="row">
					<?php echo $this->element('profile_setting_menu', array('active' => 'purchases')); ?>
					<!-- Profile Settings-->
					<div class="col-lg-9 pb-5">
						<?php
						if ($this->Session->check('Message.flash')) {
							echo $this->Session->flash();
						}
						?>
						<div class="d-flex justify-content-end pb-3">
							<!--<div class="form-inline">
								<label class="text-muted ml-3" for="order-sort">مرتب‌سازی سفارش</label>
								<select class="form-control" id="order-sort">
									<option>همه</option>
									<option>تحویل داده شده</option>
									<option>در حال پردازش</option>
									<option>با تاخیر</option>
									<option>لغو شد</option>
								</select>
							</div>-->
						</div>

						<?php
						if ($order['Order']['manual'] == 1) {
							?>
							<div class="col-md-6 column">
								<div class="cart-total-box">
									<h2 class="cart-head-title">اقلام</h2>
									<ul>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'order_id'); ?> : </h3>
											<span><?php echo $order['Order']['id']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'item_count'); ?> : </h3>
											<span><?php echo $order['0']['item_count']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'sum_price'); ?> : </h3>
											<span>  <?php echo number_format($order['Order']['sum_price']) . ' ' . __('rial'); ?></span>
										</li>
										<?php
										if (!empty($order['Order']['factor_pdf'])) {
											?>
											<li><h3>فاکتور : </h3> <span>  <a  target="_blank" style="color: #1d78cb" href="<?php echo  __SITE_URL. __PRODUCT_IMAGE_URL . $order['Order']['factor_pdf']; ?>">دانلود فاکتور</a> </span></li>
											<?php
										}
										?>
									</ul>
								</div><!-- Cart  -->
							</div>
							<div class="col-md-6 column">
								<div class="cart-total-box">
									<h2 class="cart-head-title">اطلاعات پرداخت</h2>
									<ul>
										<li><h3> <?php echo __d(__PRODUCT_LOCALE, 'refid'); ?> :</h3>
											<span><?php echo $order['Order']['refid']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'bank_message'); ?> : </h3> <span>
											<?php echo $order['Bankmessag']['message']; ?>
											</span></li>
										<li><h3><?php echo __('status'); ?> : </h3> <span>
												<?php
												echo $this->Product->user_order_status($order['Order']['status']);
												?>
											</span></li>
										<li><h3></h3> <span>   </span></li>
									</ul>
								</div><!-- Cart  -->
							</div>
							<div class="column">
								<h2 class="cart-head-title">توضیحات مدیر سایت </h2>
								<div>
									<?php
									echo $this->Cms->convert_character_editor($order['Order']['description']);
									?>
								</div>
							</div>
							<div class="column">
								<h2 class="cart-head-title">توضیحات شما</h2>
								<h3><?php echo $order['Order']['title']; ?></h3>
								<div>
									<?php
									echo $this->Cms->convert_character_editor($order['Order']['user_description']);
									?>
								</div>
							</div>
							<?php
						} // Auto
						else {
							?>
							<div class="col-md-6 column">
								<div class="cart-total-box">
									<h2 class="cart-head-title">اقلام</h2>
									<ul>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'order_id'); ?> : </h3>
											<span><?php echo $order['Order']['id']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'item_count'); ?> : </h3>
											<span><?php echo $order['0']['item_count']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'sum_price'); ?> : </h3>
											<span>  <?php echo number_format($order['Order']['sum_price']) . ' ' . __('rial'); ?></span>
										</li>
									</ul>
								</div><!-- Cart  -->
							</div>
							<div class="col-md-6 column">
								<div class="cart-total-box">
									<h2 class="cart-head-title">اطلاعات پرداخت</h2>
									<ul>
										<li><h3> <?php echo __d(__PRODUCT_LOCALE, 'refid'); ?> :</h3>
											<span><?php echo $order['Order']['refid']; ?></span></li>
										<li><h3><?php echo __d(__PRODUCT_LOCALE, 'bank_message'); ?> : </h3> <span>
											<?php echo $order['Bankmessag']['message']; ?>
											</span></li>
										<li><h3><?php echo __('status'); ?> : </h3> <span>
												<?php
												echo $this->Product->user_order_status($order['Order']['status']);
												?>
											</span></li>
										<li><h3></h3> <span>   </span></li>
									</ul>
								</div><!-- Cart  -->
							</div>
							<div class="col-md-12">

								<div class="cart-lists">
									<ul>
										<?php
										$total = 300000;
										if (!empty($orderitems)) {

											foreach ($orderitems as $orderitem) {
												?>
												<li>
													<div class="cart-thumb">
											<span><img
													src="<?php echo __SITE_URL . __PRODUCT_IMAGE_URL . $orderitem['0']['image']; ?>"
													alt="<?php echo $orderitem['Producttranslation']['title']; ?>"/></span>
														<h3>
															<a href="<?php echo __SITE_URL . 'product/' . $orderitem['Product']['slug'] ?>"
															   title=""><?php echo $orderitem['Producttranslation']['title']; ?></a>
														</h3>
													</div>
													<div class="cart-item-quantity">
														<i class="fa  fa-shopping-basket"></i>
														<span><?php echo number_format($orderitem['Orderitem']['sum_price']); ?> ریال</span>
													</div>
												</li>
												<?php
											}

										}
										?>
									</ul>
								</div>

							</div>
							<div class="column">
								<h2 class="cart-head-title">توضیحات مدیر سایت </h2>
								<div>
									<?php
									echo $this->Cms->convert_character_editor($order['Order']['description']);
									?>
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
