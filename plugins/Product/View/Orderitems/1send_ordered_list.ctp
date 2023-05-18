
<?php 
	$this->Cms->autoCompileLess(ROOT.DS.APP_DIR.DS.'webroot'.DS.'less'. DS .'setting.less', ROOT.DS.APP_DIR.DS.'webroot'.DS.'css'.DS.'setting.css');
	
	echo $this->Html->css('setting');
	echo $this->Html->css('profile');
	//pr($orderitems);
?>

<div class="pageContainer1 container-fluid">
    <?php echo $this->element('header'); ?>  
    <div class="clear"></div>
	<?php echo $this->element('Users/edit_cover_profile'); ?>
	<div class="content">
    	
        <div class="midContent">
        	<div class="col-md-3">
            	
				<?php echo $this->element('Users/setting_menu',array('active'=>'send_ordered_list')); ?>
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
									<div class="col-sm-12" style="margin-bottom: 8px;">
										<div style="float:right" >
											<form method="POST" class="myForm">
												<input type="text" name="data[Order][search]" class="myFormComponent" placeholder="بر اساس نام سفارش دهنده"> 
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
																	echo "<option value='". __SITE_URL."orderitems/ordered_list?filter=10 ' selected='selected'>10</option>";
																	else echo"<option value='". __SITE_URL."orderitems/ordered_list?filter=10 '>10</option>";
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
																	echo "<option value='". __SITE_URL."orderitems/ordered_list?filter=25 ' selected='selected'>25</option>";
																	else echo"<option value='". __SITE_URL."orderitems/ordered_list?filter=25 '>25</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
																	echo "<option value='". __SITE_URL."orderitems/ordered_list?filter=50 ' selected='selected'>50</option>";
																	else echo"<option value='". __SITE_URL."orderitems/ordered_list?filter=50 '>50</option>";	
																if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
																	echo "<option value='". __SITE_URL."orderitems/ordered_list?filter=100 ' selected='selected'>100</option>";
																	else echo"<option value='". __SITE_URL."orderitems/ordered_list?filter=100 '>100</option>";			
															?>
														</select> 
														</label>
													</div>
											  </div>
										</div>
										<div class="clearfix"></div>
									</div>
									<form method="POST" class="myForm">
									<table class="myTable aboutDr cell_center" id="datatable-1" >
										<thead>
											<tr>
											  <th><?php echo $this->Paginator->sort('Orderitem.order_id',__('order_id'));?></th>
											  <th><?php echo $this->Paginator->sort('User.message', __('ordered_name'));?></th>
											  <th><?php echo $this->Paginator->sort('Orderitem.sum_price', __('sum_price'));?></th>
											  <th><?php echo $this->Paginator->sort('Orderitem.item_count', __('item_count'));?></th>		  
											  <th><?php echo $this->Paginator->sort('Orderitem.created',__('created'));?></th> 
											  <th><?php echo __('action'); ?>  </th> 
											  <th align="center">											
												<label style="float:left"><input type='checkbox' id='selecctall' style="margin-left: 5px;"/></label>									
											  </th> 
											</tr>
										</thead>
										<tbody>
										<!-- Start: list_row -->
									<?php 
						  				//pr($orderitems);
									  	if(!empty($orders))
										{
											foreach($orders as $order)
											{
												
										?>
												<tr>								
													<td class="center"><?php echo $order['Orderitem']['order_id']; ?></td> 
													<td class="center"><?php echo $order['User']['name']; ?></td>
													<td class="center"><?php echo number_format($order['0']['sum_price']); ?></td>
													 <td class="center"><?php echo $order['0']['item_count']; ?></td>
													 
													<td class="center"><?php 
													echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Orderitem']['created'])); ?></td>                   <td class="center ">
													    
														
														<div  class="btn  darkBlue" onclick="show_order_product(<?php echo $order['Orderitem']['order_id']; ?>);">
															<span><?php echo __('order_print'); ?></span>
															<span class="icon icon-edit-circled-left"></span>
										                </div>
														 
														
														<!--<a href="<?php echo __SITE_URL.'orderitems/items_list/'; ?>" class="btn btn-info" 
														>
															<div  class="btn violet" >
															<span><?php echo __('show_order_product'); ?></span>
															<span class="icon icon-view-circled-left"></span>
											                </div>
														</a>-->
														
													</td> 
													<td align="center">
													<input class='checkbox1' type='checkbox' name="orders[]"  value='<?php echo $order['Orderitem']['order_id']; ?>'>
													</td>
												</tr>  
										<?php
										
											}
										?>
										<tr>
											<td>
												<select class="myFormComponent" name="status">
													<option value="1">برگردانده به لیست سفارش</option>
												</select>
											</td>
											<td>	
												<input type="submit" value="تغییر وضعیت">
											</td>
										</tr>
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

function show_order_product(id){
	var url = "<?php echo __SITE_URL.'orderitems/order_print/'; ?>"+id;
	window.open(url,'_blank', 'toolbar=0,location=0,menubar=0,resizable=1');
}

</script>
