<!-- Page Title-->
<div class="page-title d-flex" aria-label="Page title"
	 style="background-image: url(<?php echo __SITE_URL . __THEME_PATH; ?>img/page-title/shop-pattern.jpg);">
	<div class="container text-right align-self-center">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				</li>
				<li class="breadcrumb-item"><?php echo __d(__USER_LOCAL, 'account') ?>
				</li>
			</ol>
		</nav>
		<h1 class="page-title-heading"><?php echo __d(__PRODUCT_LOCALE, 'order_list') ?></h1>
	</div>
</div>
<!-- Page Content-->
<div class="container mb-4">
	<div class="row">
		<?php echo $this->element('profile_setting_menu', array('active' => 'purchases')); ?>
		<!-- Profile Settings-->
		<div class="col-lg-8 pb-5">
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
					<tr>
						<th><?php echo __d(__PRODUCT_LOCALE,'order_id'); ?> #</th>
						<th><?php echo __d(__PRODUCT_LOCALE,'refid'); ?></th>
						<th><?php echo __d(__PRODUCT_LOCALE,'item_count'); ?> </th>
						<th><?php echo __('created'); ?></th>
						<th><?php echo __('status'); ?></th>
						<th><?php echo __d(__PRODUCT_LOCALE,'bank_message'); ?></th>
						<th><?php echo __d(__PRODUCT_LOCALE,'sum_price'); ?></th>
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
								<td><?php echo $order['Order']['refid']; ?></td>
								<td><?php echo $order['0']['item_count']; ?></td>
								<td><?php echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Order']['created'])); ?></td>
								<td><span class="m-0">
										<?php
											echo $this->Product->user_order_status($order['Order']['status']);
										?>
									</span></td>
								<td><?php echo $order['Bankmessag']['message']; ?></td>
								<td><?php echo number_format( $order['Order']['sum_price']).' '.__('rial'); ?></td>
								<th>
									<?php if($order['Order']['refid']=='' || $order['Order']['refid']==0){ ?>
										<a href="<?php echo __SITE_URL.__PRODUCT.'/orders/preper_pay_order/'.$order['Order']['id']; ?>" class="button dark-light">
											<?php echo __d(__PRODUCT_LOCALE,'pay'); ?>
										</a>
									<?php }else echo "<br><h4 style='text-align:center'>".__d(__PRODUCT_LOCALE,'payed')."</h4>"; ?>
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
