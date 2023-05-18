<?php
$Pay_Info = $this->Session->read('Pay_Info');
$User_Info = $this->Session->read('User_Info');
?>
<div class="page-title d-flex" aria-label="Page title"
	 style="background-image: url(<?php echo __SITE_URL . __THEME_PATH; ?>img/page-title/shop-pattern.jpg);">
	<div class="container text-right align-self-center">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo __SITE_URL; ?>">
				<li class="breadcrumb-item"><a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a></a>
				</li>
				<li class="breadcrumb-item"><a
						href="<?php echo __SITE_URL . 'products'; ?>"><?php echo __d(__PRODUCT, 'shop') ?></a>
				</li>
			</ol>
		</nav>

	</div>
</div>
<!-- Page Content-->
<form id="pay_form" name="pay_form">
	<div class="container pb-4 mb-2">
		<div class="row">

			<!-- Checkout: Review-->
			<div class="col-xl-9 col-lg-8 pb-5">
				<div class="wizard">

					<div class="wizard-body">

						<?php
						if($this->Session->check('Message.flash'))
						{
							echo $this->Session->flash();
						}
						?>
						<div class="row">
							<div class="col-sm-6">
								<h4 class="h6"><?php echo __d(__GATEWAY_LOCALE,'transaction_id') ?> :</h4>
								<ul class="list-unstyled">
									<li>
										<?php echo $transaction_id; ?>
									</li>
									<li><span class="text-muted"><?php echo __d(__GATEWAY_LOCALE,'order_id') ?> :&nbsp;</span><?php echo $order_id; ?>
									</li>

								</ul>
							</div>

						</div>
					</div>
					<div class="wizard-footer d-flex justify-content-between">
						<a id="pay" class="btn btn-primary my-2" href="<?php echo $back_url; ?>"><?php echo __d(__GATEWAY_LOCALE,'confirm_purchase'); ?></a>
					</div>
				</div>
			</div>


		</div>
	</div>
</form>
