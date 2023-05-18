
<?php 
	$this->Cms->autoCompileLess(ROOT.DS.APP_DIR.DS.'webroot'.DS.'less'. DS .'setting.less', ROOT.DS.APP_DIR.DS.'webroot'.DS.'css'.DS.'setting.css');
	
	echo $this->Html->css('setting');
	echo $this->Html->css('profile');
?>

<div class="pageContainer1 container-fluid">
    <?php echo $this->element('header'); ?>  
    <div class="clear"></div>
	<?php echo $this->element('Users/edit_cover_profile'); ?>
	<div class="content">
    	
        <div class="midContent">
        	<div class="col-md-3">
            	
				<?php echo $this->element('Users/setting_menu',array('active'=>'order_list')); ?>
				<?php echo $this->element('right_ads'); ?>
				
            </div>
        	<div class="col-md-9">
                <div class="mainPanel">
                   <div class="dataBox">
				   		<div>
							<div id="generalSetting" style="display: block;">

                            <div class="Horizontal_bar"></div>
							<div class="col-md-10"> 
								<?php  echo $this->Session->flash(); ?>
							</div>

						    <div class="clear"></div>
                           		<div class="box-content">
									<div class="col-sm-12">
										<div style="float:right" >
											<form method="POST" class="myForm">
												<input type="text" name="data[Order][search]" class="myFormComponent" placeholder="بر اساس شماره سفارش"> 
												<!--<input type="submit" class="btn green" value="<?php echo __('search'); ?>" />-->
											</form>
											</div>
												<div class="span2" style="float:left">
													<div id="DataTables_Table_0_length" class="dataTables_length">
														<label>
														 <?php echo __('records_per_page'); ?> :
														<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value" class="selectOption myFormComponent">
															<?php
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==10)
																	echo "<option value='". __SITE_URL."orders/order_list?filter=10 ' selected='selected'>10</option>";
																	else echo"<option value='". __SITE_URL."orders/order_list?filter=10 '>10</option>";
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
																	echo "<option value='". __SITE_URL."orders/order_list?filter=25 ' selected='selected'>25</option>";
																	else echo"<option value='". __SITE_URL."orders/order_list?filter=25 '>25</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
																	echo "<option value='". __SITE_URL."orders/order_list?filter=50 ' selected='selected'>50</option>";
																	else echo"<option value='". __SITE_URL."orders/order_list?filter=50 '>50</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
																	echo "<option value='". __SITE_URL."orders/order_list?filter=100 ' selected='selected'>100</option>";
																	else echo"<option value='". __SITE_URL."orders/order_list?filter=100 '>100</option>";			
															?>
														</select> 
														</label>
													</div>
											  </div>
										</div>
										<div class="clearfix"></div>
									</div>
									
									<table class="myTable aboutDr cell_center" id="datatable-1">
										<thead>
											<tr>
											  <th><?php echo $this->Paginator->sort('Order.id',__('id'));?></th>
											  <th><?php echo $this->Paginator->sort('Order.sum_price', __('sum_price'));?></th>
											  <th><?php echo $this->Paginator->sort('Order.refid', __('refid'));?></th>
											  <th><?php echo  __('item_count');?></th>
											  <th><?php echo $this->Paginator->sort('Bankmessag.message', __('bank_message'));?></th>
											  <th><?php echo $this->Paginator->sort('Order.created',__('created'));?></th> 
											  <th><?php echo __('action'); ?>  </th>  
											</tr>
										</thead>
										<tbody>
										<!-- Start: list_row -->
									<?php 
						  				//pr($orders);
									  	if(!empty($orders))
										{
											foreach($orders as $order)
											{
												
										?>
												<tr>								
													<td class="center"><?php echo $order['Order']['id']; ?></td> 
													 <td class="center"><?php echo number_format($order['Order']['sum_price']); ?></td>
													 <td class="center"><?php echo $order['Order']['refid']; ?></td>
													 <td class="center"><?php echo $order['0']['item_count']; ?></td>
													 <td class="center"><?php echo $order['Bankmessag']['message']; ?></td>
													<td class="center"><?php 
													echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Order']['created'])); ?></td>                              		<td class="center ">
													    
														<a href="<?php echo __SITE_URL.'orderitems/items_list/'.$order['Order']['id']; ?>" class="btn btn-info" 
														>
															<div  class="btn violet">
															<span><?php echo __('show_order_product'); ?></span>
															<span class="icon icon-view-circled-left"></span>
											                </div>
														</a>
														<?php if($order['Order']['refid']=='0' || $order['Order']['refid']==''){ ?>
														<a href="<?php echo __SITE_URL.'orders/preper_pay_order/'.$order['Order']['id']; ?>" class="btn btn-warning" 
														>
															<div  class="btn  darkBlue">
															<span><?php echo __('retry_pay'); ?></span>
															<span class="icon icon-edit-circled-left"></span>
											                </div>
														</a>
														<?php } ?>
													</td> 
													<tr>
														<td colspan="8">
															<div id="order_place<?php echo $order['Order']['id']; ?>"></div>
															<div id='circleG' class='loading<?php echo $order['Order']['id']; ?>'>
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
                            <div class="Horizontal_bar"></div>
                            <div class="clear"></div>
                         
                           </div>
						</div>
				   </div> 
                </div>
               <div class="clear"></div>
            </div>
        	
        </div>
    </div>
 </div>

