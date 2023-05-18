<!-- Page Title-->

<!-- Page Content-->

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
						<div class="table-responsive">
							<table class="table table-hover mb-0">
								<thead>
								<tr >
									<th><?php echo __d(__PRODUCT_LOCALE, 'order_id'); ?> </th>
									<th><?php echo __d(__PRODUCT_LOCALE, 'title'); ?></th>
									<th><?php echo __d(__PRODUCT_LOCALE, 'refid'); ?></th>
									<th><?php echo __d(__PRODUCT_LOCALE, 'item_count'); ?> </th>
									<th><?php echo __('created'); ?></th>
									<th><?php echo __('status'); ?></th>
									<th><?php echo __d(__PRODUCT_LOCALE, 'bank_message'); ?></th>
									<th><?php echo __d(__PRODUCT_LOCALE, 'sum_price'); ?></th>
									<th><?php echo __('action'); ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								if (!empty($orders)) {
									foreach ($orders as $order) {
										?>
										<tr>
											<td><?php echo $order['Order']['id']; ?></td>
											<td><?php echo $order['Order']['title']; ?></td>
											<td><?php echo $order['Order']['refid']; ?></td>
											<td><?php echo $order['0']['item_count']; ?></td>
											<!--<td><?php echo $this->Cms->show_persian_date(" l ، j F Y    ", strtotime($order['Order']['created'])); ?></td>-->
											<td><?php echo $this->Cms->show_persian_date("  j F Y    ", strtotime($order['Order']['created'])); ?></td>
											<td><span class="m-0">
										<?php
										echo $this->Product->user_order_status($order['Order']['status']);
										?>
									</span></td>
											<td><?php echo $order['Bankmessag']['message']; ?></td>
											<td><?php echo number_format($order['Order']['sum_price']) . ' ' . __('rial'); ?></td>
											<th>
												<?php if ($order['Order']['refid'] == '' || $order['Order']['refid'] == 0) { ?>
													<a href="<?php echo __SITE_URL . __PRODUCT . '/orders/preper_pay_order/' . $order['Order']['id']; ?>"
													   class="button dark-light">
														<?php echo __d(__PRODUCT_LOCALE, 'pay'); ?>
													</a>
												<?php } else echo "<br><h8 style='text-align:center'>" . __d(__PRODUCT_LOCALE, 'payed') . "</h8>"; ?>
												|
												<a href="<?php echo __SITE_URL  . 'orders/detail/' . $order['Order']['id']; ?>"> جزییات </a>

											</th>
										</tr>
										<?php
									}
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
