<!-- topbar starts -->
	 
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- right menu starts -->
				<?php echo $this->element('Admin/right_menu'); ?>       
            
			<!-- right menu ends -->
			
			<div id="content" class="span10">
			<!-- content starts -->
			

				<?php if($this->Session->check('Message.flash')) {?>
				<div >
					  <?php echo $this->Session->flash(); ?>
				</div>
				<?php } ?>
				 
			 <div class="row-fluid sortable ui-sortable">	
				<div class="box span12">
					<div data-original-title="" class="box-header well">
						<h2><?php echo __('settle_list'); ?></h2>
						<div class="box-icon">
							<a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php echo $this->Form->create('User', array('id'=>'SearchFrom','name'=>'SearchFrom')); ?>
						<div class="row-fluid">
							<div class="span6">
								<div id="DataTables_Table_0_length" class="dataTables_length">
									<label>
									 
									 <?php echo __('records_per_page'); ?> :
									<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value">
										<?php
	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
												echo "<option value='". __SITE_URL."admin/orderitems/settle_list?filter=50 ' selected='selected'>50</option>";
												else echo"<option value='". __SITE_URL."admin/orderitems/settle_list?filter=50 '>50</option>";	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
												echo "<option value='". __SITE_URL."admin/orderitems/settle_list?filter=100 ' selected='selected'>100</option>";
												else echo"<option value='". __SITE_URL."admin/orderitems/settle_list?filter=100 '>100</option>";			
												if(isset($_REQUEST['filter']) && $_REQUEST['filter']==150)
												echo "<option value='". __SITE_URL."admin/orderitems/settle_list?filter=150 ' selected='selected'>150</option>";
												else echo"<option value='". __SITE_URL."admin/orderitems/settle_list?filter=150 '>150</option>";
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==200)
												echo "<option value='". __SITE_URL."admin/orderitems/settle_list?filter=200 ' selected='selected'>200</option>";
												else echo"<option value='". __SITE_URL."admin/orderitems/settle_list?filter=200 '>200</option>";
										?>
									</select> 
									</label>
								</div>
							</div>
							<div class="span6">
								
								<div class="dataTables_filter" id="DataTables_Table_0_filter">
								<label><?php echo __('search'); ?>: <input type="text" id="search" 
								placeholder="<?php echo __('search_with_charity_name'); ?>" name="data[Orderitem][search]" aria-controls="DataTables_Table_0"></label>
								</div>
							  	
							</div>
						</div>
						</form>
						<form method="POST" class="myForm">
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
									<tr>

									  <th><?php echo $this->Paginator->sort('User.name', __('charity_name'));?></th>
									  <th><?php echo $this->Paginator->sort('Orderitem.admin_price', __('admin_price'));?></th> 
									  <th><?php echo $this->Paginator->sort('Orderitem.user_price', __('user_price'));?></th> 
									  <th><?php echo __('action'); ?></th>
									</tr>
								</thead>   
							  <tbody>
							     <?php 
						  				 
									  	if(!empty($order_items))
										{
											foreach($order_items as $order_item)
											{
												
										?>
												<tr>								
													
													<td class="center"><?php echo $order_item['User']['name']; ?></td>
													<td class="center"><?php echo number_format($order_item['0']['admin_price']); ?></td>											 
													<td class="center"><?php echo number_format($order_item['0']['user_price']); ?></td>											 
													<td class="center ">

														<?php if($order['Order']['sale_reference_id']=='0' || $order['Order']['sale_reference_id']==''){ ?>
														<a href="<?php echo __SITE_URL.'orders/preper_pay_order/'.$order['Order']['id']; ?>" class="btn btn-warning" 
														>
															<div  class="btn  darkBlue">
															<span><?php echo __('retry_pay'); ?></span>
															<span class="icon icon-edit-circled-left"></span>
											                </div>
														</a>
														<?php } ?>
														
													</td>
													 
												</tr>  
										<?php
										
											}
										?>
									
										
									  <?php	
										}
									  ?>                                
							  </tbody>
						 </table> 
						 </form>
						 <div class="pagination pagination-centered">
						  <ul>
						  <?php echo $this->Paginator->prev(__('prev'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'prev disabled'));?>
							<!--<li><a href="#">Prev</a></li>->
							<!--<li class="active">
							  <a href="#">1</a>
							</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>-->
							<?php echo $this->Paginator->numbers(array('tag'=>'li','separator'=>'','currentClass'=>'active','currentTag'=>'a'));?>
							<!--<li><a href="#">Next</a></li>-->
							<?php echo $this->Paginator->next(__('next'), array('tag'=>'li'), null, array('disabledTag'=>'a','tag'=>'li','class' => 'next disabled'));?>
						  </ul>
						</div>     
					</div>
				</div><!--/span-->
			</div>
		
    
					<!-- content ends -->
			</div><!--/#content.span10-->
	</div><!--/fluid-row-->
</div>				
	



	