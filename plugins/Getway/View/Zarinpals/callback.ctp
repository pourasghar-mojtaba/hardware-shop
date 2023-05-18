<?php
echo $this->Html->css('/getway/css/getway');
 
echo $this->Html->css('profile');
 
?>

<div class="pageContainer container-fluid" style="padding-bottom: 0px;">
	<?php echo $this->element('header'); ?>
	<div class="clear">
	</div>

	<div class="midContent">

		<div class="col-md-12 shop">

			

			<div class="col-md-12">
				
				<section id="hp-ssod">
				<div class="shadow_box col-sm-4 settingForms col-md-offset-4" style="margin-top: 30px;margin-bottom:30px;padding: 20px" >


					<div class="settingContent" style="margin-top: 10px;padding: 25">
						<form id="pay_form" name="pay_form">
							<div id="generalSetting">
								<div class="col-md-12">
									<?php echo $this->Session->flash(); ?>
								</div>
								<?php
								if($result_value){
									?>
									<div class="col-md-12">
										<div id="title" class="col-md-3">
											<?php echo __('transaction_id') ?> :
										</div>
										<div id="title" class="col-md-6">
											<?php echo $transaction_id; ?>
										</div>
									</div>
									<?php
								} ?>
								<div class="col-md-12" style="margin-top: 10px;margin-bottom:10px;">
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
						</form>
					</div>

				</div>

			</div>
			</section>
		</div>
		<div class="clear">
		</div>

	</div>

</div>
</div>
