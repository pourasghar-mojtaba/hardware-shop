
<?php

$items = array();
$controller = 'orders';
$items['action_name'] = __d(__SHOP_LOCALE,'order_list');
$items['action'] = 'Order';
$items['add_style'] =
array('link'=>array(
		'title'=>__d(__SHOP_LOCALE,'add_category'),
		'url'  => __SITE_URL.'admin/'.__SHOP.'/'.$controller.'/add'
	)
);
$items['titles'] = array(
	array('title'=> __d(__SHOP_LOCALE,'sum_price'),'index'=> 'sum_price'),
	array('title'=> __d(__SHOP_LOCALE,'refid'),'index'=> 'refid'),
	array('title'=> __d(__SHOP_LOCALE,'item_count')),
	array('title'=> __d(__SHOP_LOCALE,'send_count')),
	array('title'=> __d(__SHOP_LOCALE,'accept_count')),
	array('title'=> __d(__SHOP_LOCALE,'not_accept_count')),
	array('title'=> __d(__SHOP_LOCALE,'bank_message')),
	array('title'=> __('created'),'index'=> 'created'),
);



$records = $orders;
$items['show_search_box'] = TRUE;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record['Order']['id'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/'.__SHOP.'/'.$controller.'/delete/'.$record['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Order']['refid']."</td>";
		echo "<td>".$record['0']['item_count']."</td>";
		echo "<td>".$record['0']['send_count']."</td>";
		echo "<td>".$record['0']['accept_count']."</td>";
		echo "<td>".$record['0']['not_accept_count']."</td>";
		echo "<td>".$record['Bankmessag']['message']."</td>";
		echo "<td>";
		if($record['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

<!-- topbar starts -->
	 
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- right menu starts -->
				<?php echo $this->element('Admin/right_menu'); ?>       
			<!-- right menu ends -->
			
			<div id="content" class="span10">
			<!-- content starts -->
			
			<!--<div>
				<ul class="breadcrumb">
					<li>
						<i class="icon-add"></i><a href="<?php echo __SITE_URL."admin/shop/orders/add"; ?>">&nbsp;<?php echo __('add_product'); ?></a> 
					</li>
				</ul>
			</div>-->
		
			<?php if($this->Session->check('Message.flash')) {?>
				<div >
					  <?php echo $this->Session->flash(); ?>
				</div>
				<?php } ?>
				 
			 <div class="row-fluid sortable ui-sortable">	
				<div class="box span12">
					<div data-original-title="" class="box-header well">
						<h2><?php echo __('order_managment'); ?></h2>
						<div class="box-icon">
							<a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php echo $this->Form->create('Product', array('id'=>'SearchFrom','name'=>'SearchFrom')); ?>
						<div class="row-fluid">
							<div class="span6">
								<div id="DataTables_Table_0_length" class="dataTables_length">
									<label>
									 <?php echo __('records_per_page'); ?>  :
									<select size="1" aria-controls="DataTables_Table_0" onchange="if (this.value) window.location.href=this.value">
										<?php
											
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==10)
												echo "<option value='". __SITE_URL."admin/orders/ordered_list?filter=10 ' selected='selected'>10</option>";
												else echo"<option value='". __SITE_URL."admin/orders/ordered_list?filter=10 '>10</option>";
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==25)
												echo "<option value='". __SITE_URL."admin/orders/ordered_list?filter=25 ' selected='selected'>25</option>";
												else echo"<option value='". __SITE_URL."admin/orders/ordered_list?filter=25 '>25</option>";	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==50)
												echo "<option value='". __SITE_URL."admin/orders/ordered_list?filter=50 ' selected='selected'>50</option>";
												else echo"<option value='". __SITE_URL."admin/orders/ordered_list?filter=50 '>50</option>";	
											if(isset($_REQUEST['filter']) && $_REQUEST['filter']==100)
												echo "<option value='". __SITE_URL."admin/orders/ordered_list?filter=100 ' selected='selected'>100</option>";
												else echo"<option value='". __SITE_URL."admin/orders/ordered_list?filter=100 '>100</option>";			
										
										?>
									</select>
									</label>
								</div>
							</div>
							<div class="span6">
							
								<div class="dataTables_filter" id="DataTables_Table_0_filter">
								<label><?php echo __('search'); ?>: 
								<input type="text" placeholder="<?php echo __('search_in_title'); ?>" name="data[Product][search]" aria-controls="DataTables_Table_0"></label>
								</div>
							 	
							</div>
						</div>
						</form>
						<table class="table table-bordered table-striped table-condensed">
							  <thead>
								  <tr>
								  <th><?php echo $this->Paginator->sort('Order.id',__('id'));?></th>
								  <th><?php echo $this->Paginator->sort('Order.sum_price', __('sum_price'));?></th>
								  <th><?php echo $this->Paginator->sort('Order.refid', __('refid'));?></th>
								  <th><?php echo  __('item_count');?></th>
								  <th><?php echo  __('send_count');?></th>
								  <th><?php echo  __('accept_count');?></th>
								  <th><?php echo  __('not_accept_count');?></th>
								  <th><?php echo $this->Paginator->sort('Bankmessag.message', __('bank_message'));?></th>
								  <th><?php echo $this->Paginator->sort('Order.created',__('created'));?></th> 
								  <th><?php echo __('action'); ?>  </th>  
								</tr>
							  </thead>   
							  <tbody>
							  <?php 
							  
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
												 <td class="center"><?php echo $order['0']['send_count']; ?></td>
												 <td class="center"><?php echo $order['0']['accept_count']; ?></td>
												 <td class="center"><?php echo $order['0']['not_accept_count']; ?></td>
												 <td class="center"><?php echo $order['Bankmessag']['message']; ?></td>
												<td class="center"><?php 
												echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Order']['created'])); ?></td>                       <td class="center ">
												    
										<div  class="btn btn-success" onclick="show_order_product(<?php echo $order['Order']['id']; ?>);">
											<span><?php echo __('order_print'); ?></span>
											<span class="icon icon-edit-circled-left"></span>
						                </div>
													<a class="btn btn-info" href="<?php echo __SITE_URL.'admin/orderitems/items_list/'.$order['Order']['id']; ?>">
													<i class="icon-edit icon-white"></i>  
													<?php echo __('show_order_product'); ?>          
												    </a>
													<?php if($order['Order']['refid']<=0){ ?>
														<a href="<?php echo __SITE_URL.'admin/orders/delete/'.$order['Order']['id']; ?>" class="btn btn-danger" 
													onclick="return confirm('<?php echo __('r_u_sure'); ?>')">
														<i class="icon-trash icon-white"></i> 
														<?php echo __('delete'); ?>
													    </a>
													<?php } ?>
												</td> 
											</tr>  
									<?php
									
										}
									}
								  ?>                                
							  </tbody>
						 </table>  
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
	
<script>
	function show_order_product(id){
	var url = _url+"<?php echo 'orderitems/order_print/'; ?>"+id;
	window.open(url,'_blank', 'toolbar=0,location=0,menubar=0,resizable=1');
}
</script>




	