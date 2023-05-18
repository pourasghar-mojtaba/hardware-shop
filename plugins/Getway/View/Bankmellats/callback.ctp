<?php
echo $this->Html->css('/getway/css/getway');
echo $this->Html->css('bootstrap');
$Pay_Info = $this->Session->read('Pay_Info');
echo $this->Html->css('profile');
// pr($Pay_Info);
//pr($back_url);
?>



<div class="pageContainer container-fluid">
	<?php echo $this->element('header'); ?>
	<div class="clear">
	</div>
	<div class="content" >

		<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
			<div class="dataBox" >
				<div class="col-md-12">
					<header>
						<h3>
							<legend class="myFormComponent">								
								<?php echo __('callback_info') ?>
							</legend>
						</h3>
					</header>
					<?php
					if($this->Session->check('Message.flash'))
					{
						echo $this->Session->flash();
					}
					?>

					<?php
					if($transaction_id > 0)
					{
						?>
						<div class="col-md-6">
							<div id="title" class="col-md-4">
								<?php echo __('transaction_id') ?> :
							</div>
							<div id="title" class="col-md-6">
								<?php echo $transaction_id; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div id="title" class="col-md-4">
								<?php echo __('order_id') ?> :
							</div>
							<div id="title" class="col-md-6">
								<?php echo $order_id; ?>
							</div>
						</div>
						<?php
					} ?>
					<div class="col-md-6 col-sm-12" >
						<a href="<?php echo $back_url; ?>">
							<button type="button" class="green myFormComponent" id="pay">
								<span class="text">
									<?php echo __('confirm_purchase'); ?>
								</span>
								<span class="icon icon-left-open">
								</span>
							</button>
						</a>
					</div>
					
				</div>
				<div class="clear">
				</div>
			</div>
		</div>

	</div>
</div>



