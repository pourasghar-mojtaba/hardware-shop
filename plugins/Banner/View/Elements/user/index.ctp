<?php
	
?>
<div class="page-container">

	<!-- BEGIN BREADCRUMBS -->
	<div class="row breadcrumbs margin-bottom-40">
		<div class="container">
			<div class="col-md-8 col-sm-8 ">
				<ul class="pull-left breadcrumb">
					<li>
						<?php echo $this->Html->link(__('home'),__SITE_URL) ?>
					</li>
					<li class="active">
						<?php echo __d(__PRODUCT,'products') ?>
					</li>
				</ul>
			</div>
			<div class="col-md-4 col-sm-4 text-center">
				<h1>
					<?php echo __d(__PRODUCT,'products') ?>
				</h1>
			</div>

		</div>
	</div>
	<!-- END BREADCRUMBS -->

	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN CONTAINER -->
			<div class="container min-hight portfolio-page margin-bottom-40">
				<!-- BEGIN FILTER -->
				<div class="filter-v1 margin-top-10">

					<div class="row mix-grid thumbnails">
						<?php
						if(!empty($products))
						{
							$i = 1;
							foreach($products as $product)
							{
								if ($i == 4) $i = 1; 
								$style = '';
								if($i==1){
									$style = "category_1";
								}
								if($i==2){
									$style = "category_1 category_2";
								}
								if($i==3){
									$style = "category_3";
								}
								echo "
									<div class='col-md-4 col-sm-6 mix ".$style."'>
										<div class='mix-inner'>";
											 
											echo $this->Html->image(__SITE_URL.__PRODUCT_IMAGE_URL.$product['0']['image'],array('alt'=>$product['Product']['title'],'class'=>'img-responsive'));
											echo"<div class='mix-details'>
												<h4>
													".$product['Product']['title']."
												</h4>
												<p>
													".$product['Product']['mini_detail']."
												</p>
												<a class='mix-link' href='".__SITE_URL.'pages/contact_us/'.__d('user','contact_us')."'>
													<i class='fa fa-link'>
													</i>
												</a>
												<a class='mix-preview fancybox-button' href='".__SITE_URL.__PRODUCT_IMAGE_URL.$product['0']['image']."' title='".$product['Product']['title']."' data-rel='fancybox-button'>
													<i class='fa fa-search'>
													</i>
												</a>
											</div>
										</div>
								   </div>
								";
								$i++;
							}
						}
						?>
						
					</div>
				</div>
				<!-- END FILTER -->
			</div>
			<!-- END CONTAINER -->
		</div>
	</div>

</div>
 