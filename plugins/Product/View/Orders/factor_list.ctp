
<?php
	 
?>

<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<?php echo $this->element('panel_menu'); ?>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			 
			<div id="ajax-content">
				
				<!--Start Breadcrumb-->
				<div class="row">
					<div id="breadcrumb" class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="javascript:void(0)"><?php echo __('user_account_transaction'); ?></a></li>
							<li><a href="<?php echo __SITE_URL.'factors/factor_list' ?>"><?php echo __('factor_list'); ?></a></li>
						</ol>
					</div>
				</div>
				<!--End Breadcrumb-->
				
				
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<div class="box-name">
									<i class="fa fa-usd"></i>
									<span><?php echo __('factor_list'); ?></span>
								</div>
								<div class="box-icons">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
									<a class="expand-link">
										<i class="fa fa-expand"></i>
									</a>
									<a class="close-link">
										<i class="fa fa-times"></i>
									</a>
								</div>
								<div class="no-move"></div>
							</div>
							<div class="box-content no-padding">
								 
								<?php echo $this->Session->flash(); ?>
								
								 
								
								<div class="box-content">
									<div class="col-sm-12">
										<div style="float:right"><label>
											<form method="POST">
												<input type="text" name="data[Factor][search]" placeholder="<?php echo __('search_sale_reference_id'); ?>"></label>
												<input type="submit" class="btn btn-primary" value="<?php echo __('search'); ?>" />
											</form>
										</div>
											<div class="span6" style="float:left">
												<div id="DataTables_Table_0_length" class="dataTables_length">
													<label>
													 <?php echo __('records_per_page'); ?> :
													<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value">
														<?php
															if(isset($_REQUEST['filter']) && $_REQUEST['filter']==10)
																echo "<option value='". __SITE_URL."factors/factor_list?filter=10 ' selected='selected'>10</option>";
																else echo"<option value='". __SITE_URL."factors/factor_list?filter=10 '>10</option>";
															if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
																echo "<option value='". __SITE_URL."factors/factor_list?filter=25 ' selected='selected'>25</option>";
																else echo"<option value='". __SITE_URL."factors/factor_list?filter=25 '>25</option>";	
															if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
																echo "<option value='". __SITE_URL."factors/factor_list?filter=50 ' selected='selected'>50</option>";
																else echo"<option value='". __SITE_URL."factors/factor_list?filter=50 '>50</option>";	
															if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
																echo "<option value='". __SITE_URL."factors/factor_list?filter=100 ' selected='selected'>100</option>";
																else echo"<option value='". __SITE_URL."factors/factor_list?filter=100 '>100</option>";			
														?>
													</select> 
													</label>
												</div>
										  </div>
									</div>
									<div class="clearfix"></div>
								</div>
								
								<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
									<thead>
										<tr>
										  <th><?php echo $this->Paginator->sort('Factor.id',__('id'));?></th>
										  <th><?php echo $this->Paginator->sort('Factor.sum_price', __('sum_price'));?></th>
										  <th><?php echo $this->Paginator->sort('Factor.sale_reference_id', __('sale_reference_id'));?></th>
										  <th><?php echo  __('item_count');?></th>
										  <th><?php echo $this->Paginator->sort('Bankmessag.message', __('bank_message'));?></th>
										  <th><?php echo $this->Paginator->sort('Factor.description', __('description'));?></th>
										  <th><?php echo $this->Paginator->sort('Factor.created',__('created'));?></th> 
										  <th><?php echo __('action'); ?>  </th>  
										</tr>
									</thead>
									<tbody>
									<!-- Start: list_row -->
									<?php 
						  				//pr($factors);
									  	if(!empty($factors))
										{
											foreach($factors as $factor)
											{
												
										?>
												<tr>								
													<td class="center"><?php echo $factor['Factor']['id']; ?></td> 
													 <td class="center"><?php echo $this->Cms->farsidigit(number_format($factor['Factor']['sum_price'])); ?></td>
													 <td class="center"><?php echo $factor['Factor']['sale_reference_id']; ?></td>
													 <td class="center"><?php echo $factor['0']['item_count']; ?></td>
													 <td class="center"><?php echo $factor['Bankmessag']['message']; ?></td>
													 <td class="center"><?php echo $factor['Factor']['description']; ?></td>
													<td class="center"><?php 
													echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($factor['Factor']['created'])); ?></td>                              		<td class="center ">
													    
														<a href="#" onclick="show_factor_item(<?php echo $factor['Factor']['id']; ?>,'<?php echo $factor['Factor']['sale_reference_id']; ?>')" class="btn btn-info" 
														>
															<i class="icon-trash icon-white"></i> 
															<?php echo __('show_factor_product'); ?>
														</a>
														<?php if($factor['Factor']['sale_reference_id']=='0' || $factor['Factor']['sale_reference_id']==''){ ?>
														<a href="<?php echo __SITE_URL.'factors/preper_pay_factor/'.$factor['Factor']['id']; ?>" class="btn btn-warning" 
														>
															<i class="icon-trash icon-white"></i> 
															<?php echo __('retry_pay'); ?>
														</a>
														<?php } ?>
													</td> 
													<tr>
														<td colspan="8">
															<div id="factor_place<?php echo $factor['Factor']['id']; ?>"></div>
															<div id='circleG' class='loading<?php echo $factor['Factor']['id']; ?>'>
																<div id='circleG_1' class='circleG'></div>
																<div id='circleG_2' class='circleG'></div>
																<div id='circleG_3' class='circleG'></div>
															</div> 
														</td>
													</tr>
												</tr>  
										<?php
										
											}
										}
									  ?> 
										
									<!-- End: list_row -->
									</tbody>								
																	
								</table>
								
								<div class="box-content"><div class="col-sm-6">
									<div class="dataTables_info" id="datatable-1_info"> </div></div>
									<div class="col-sm-6 text-left">
										<div class="dataTables_paginate paging_bootstrap">
											<ul class="pagination">
												<?php echo $this->Paginator->prev(__('prev'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'prev disabled'));?>
												<?php echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active','currentTag'=>'a'));?>
												<?php echo $this->Paginator->next(__('next'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'next disabled'));?>
											</ul>
										</div>
									</div>
									<div class="clearfix"></div>
										
									<div class="clearfix"></div>
							    </div>
								
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
		<!--End Content-->
	</div>
</div>

<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings
 
 function show_factor_item (factor_id,sale_reference_id){
	$(".loading"+factor_id).show();	 
	$.ajax({
			type:"POST",
			url:_url+'factoritems/get_factor_item/',
			data:'factor_id='+factor_id+'&sale_reference_id='+sale_reference_id,	
			success:function(response){
				$('#factor_place'+factor_id).html(response);
				$(".loading"+factor_id).hide();				  
			}
		}) ;	
}
 
$(document).ready(function() {
	WinMove();
});
</script>

