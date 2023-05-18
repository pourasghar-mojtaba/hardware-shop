
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
            	
				<?php echo $this->element('Users/setting_menu',array('active'=>'items_list')); ?>
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
												<input type="text" name="data[Orderitem][search]" class="myFormComponent" placeholder="<?php echo __('search'); ?>"> 
												<!--<input type="submit" class="btn green" value="<?php echo __('search'); ?>" />-->
											</form>
											</div>
												<div class="span6" style="float:left">
													<div id="DataTables_Table_0_length" class="dataTables_length">
														<label>
														 <?php echo __('records_per_page'); ?> :
														<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value" class="selectOption myFormComponent">
															<?php
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==10)
																	echo "<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=10 ' selected='selected'>10</option>";
																	else echo"<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=10 '>10</option>";
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
																	echo "<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=25 ' selected='selected'>25</option>";
																	else echo"<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=25 '>25</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
																	echo "<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=50 ' selected='selected'>50</option>";
																	else echo"<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=50 '>50</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
																	echo "<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=100 ' selected='selected'>100</option>";
																	else echo"<option value='". __SITE_URL."orderitems/items_list/".$order_id."?filter=100 '>100</option>";			
															?>
														</select> 
														</label>
													</div>
											  </div>
										</div>
										<div class="clearfix"></div>
									</div>
									<form method="POST" class="myForm">
									<table class="myTable aboutDr cell_center" id="datatable-1">
										<thead>
											<tr>
											  <th><?php echo $this->Paginator->sort('Orderitem.order_id',__('order_id'));?></th>
											  <th><?php echo $this->Paginator->sort('User.name', __('ordered_name'));?></th>
											  <th><?php echo $this->Paginator->sort('Product.title', __('product_title'));?></th>
											  <th><?php echo $this->Paginator->sort('Orderitem.item_count', __('count'));?></th>
											  <th><?php echo $this->Paginator->sort('Orderitem.sum_price', __('sum_price'));?></th>
											  <th><?php echo $this->Paginator->sort('Orderitem.created',__('created'));?></th> 
											  <th><?php echo __('status'); ?>  </th> 
											  
											</tr>
										</thead>
										<tbody>
										<!-- Start: list_row -->
									<?php 
						  				 
									  	if(!empty($order_items))
										{
											foreach($order_items as $order_item)
											{
												
										?>
												<tr>								
													<td class="center"><?php echo $order_item['Orderitem']['order_id']; ?></td> 
													<td class="center"><?php echo $order_item['User']['name']; ?></td>
													<td class="center"><?php echo $order_item['Product']['title']; ?></td>
													<td class="center"><?php echo $order_item['Orderitem']['item_count']; ?></td>
													<td class="center"><?php echo number_format($order_item['Orderitem']['sum_price']); ?></td>											 
													 
													<td class="center"><?php 
													echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order_item['Orderitem']['created'])); ?></td>                              		
													<td class="center ">
													<?php
													   
													  echo $this->Cms->order_status($order_item['Orderitem']['status']);
													?>
													  
													</td>
													
													 
												</tr>  
										<?php
										
											}
										?>
									
										
										
									  <?php	
										}
									  ?> 
										
									<!-- End: list_row -->
										</tbody>								
																		
									</table>
									</form>
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
<script>
	$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});

</script>
