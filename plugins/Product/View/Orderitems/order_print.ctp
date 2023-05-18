<style>
	body{
		direction:rtl;
		font-family: 'b yekan','tahoma';
	}
	table{
		font-size: 13px;
	}
	table td{
		line-height: 30px;
	}
	table th{
		line-height: 30px;
		text-align: center;
	}
	.order_header{
		float: right;
		
	}
	.order_header .order_title{
		
	}
	.order_header .order_date{
		
	}
	.site_logo{
		float: left;
	}
	.site_logo img{
		height: 40px;
	}
	.bold{
		font-weight: bold;
	}
	.border{
		border: 1px solid #63b4da;
	}
	.border_top{
		border-top: 1px solid #63b4da;
	}
	.border_right{
		border-right: 1px solid #63b4da;
	}
	.order_detail td{
		border-top: 1px solid #63b4da;
		text-align: center;
	}
	.order_detail th{
		background: #cedfee;
	}
	.width50{
		border-spacing: 0;
    	border-collapse: 0;
		width: 50%;
	}
	.width100{
		border-spacing: 0;
    	border-collapse: 0;
		width: 100%;
	}
	.width80{
		border-spacing: 0;
    	border-collapse: 0;
		width: 80%;
	}
	.padding_right{
		padding-right: 5px;
	}
	.padding_left{
		padding-left: 5px;
	}
	.left{
		float: left;
	}
	a{
		text-decoration: none;
		color: #2fa9f2;
	}
</style>
<table class="width80 border " cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td colspan="2" class="padding_right">
			<div class="order_header">
				<div class="order_title">
					<span class="bold"><?php echo __('order_id'); ?> :</span>
					<span > <?php echo $order['Order']['id']; ?> </span>
				</div>
				<div class="order_date">
					<span class="bold"><?php echo __('date'); ?> :</span>
					<span><?php echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Order']['created'])); ?></span>
				</div>
			</div>
			<div class="site_logo padding_left">
				<img src="<?php echo __SITE_URL.'img/logo.png'; ?>" />
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<table class="width100 border_top padding_right">
				<tr>
					<td>
						<span class="bold"> <?php echo __('user_name'); ?> :</span>
						<span > <?php echo $user['User']['name']; ?> </span>
					</td>
					<td>
						<span class="bold"><?php echo __('phone'); ?> :</span>
						<span > <?php echo $user_detail['Userdetail']['telephon']; ?> </span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="bold"><?php echo __('mobile'); ?> :</span>
						<span > <?php echo $user['User']['mobile']; ?> </span>
					</td>
					<td>
						<span class="bold"> <?php echo __('post_code'); ?> :</span>
						<span > <?php echo $user_detail['Userdetail']['post_code']; ?> </span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="bold"><?php echo __('address'); ?> :</span>
						<span > 
							<?php 
   								 echo $user_detail['Userdetail']['address'];                         
                             ?>
						</span>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table class="width100 border_top border_right padding_right">
				<tr>
					<td>
						<span class="bold"> <?php echo __('customr_name'); ?> :</span>
						<span > <?php echo $user['User']['name']; ?> </span>
					</td>
					<td>
						<span class="bold"><?php echo __('phone'); ?> :</span>
						<span > <?php echo $user_detail['Userdetail']['telephon']; ?> </span>
					</td>
				</tr>
				<tr>
					<td>
						<span class="bold"> <?php echo __('mobile'); ?> :</span>
						<span > <?php echo $user['User']['mobile']; ?> </span>
					</td>
					<td>
						<span class="bold"><?php echo __('post_code'); ?> :</span>
						<span > <?php echo $user_detail['Userdetail']['post_code']; ?> </span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<span class="bold"><?php echo __('address'); ?> :</span>
						<span > 
						<?php echo $user_detail['Userdetail']['address']; ?>
						</span>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="border_top">
			<table class="width100 order_detail">
				<tr>
					<th width="5%"> <?php echo __('row'); ?></th>
					<th class="border_right" width="45%"><?php echo __('product_title'); ?></th>
					<th class="border_right" width="20%"><?php echo __('base_price'); ?></th>
					<th class="border_right" width="10%"><?php echo __('count'); ?></th>
					<th class="border_right" width="20%"><?php echo __('price'); ?></th>
				</tr>
				<?php
				  $i=1;
				   if(!empty($order_items)){
				   	   $item_count=0;
					   $sum_price=0;
				   	   foreach($order_items as $order_item){
					   	  $item_count += $order_item['Orderitem']['item_count'];
						  $sum_price += $order_item['Orderitem']['sum_price'];
						  echo "
						     <tr>
								<td>".$i."</td>
								<td class='border_right'>".$order_item['Product']['title']."</td>
								<td class='border_right'>".number_format($order_item['Product']['price']).' '.__('rial')."</td>
								<td class='border_right'>".$order_item['Orderitem']['item_count']."</td>
								<td class='border_right'>".number_format($order_item['Orderitem']['sum_price']).' '.__('rial')."</td>
							</tr>
						  ";
						  $i++;
					   }
				   }
				?>				
			</table>
		</td>
	</tr>
</table>
<br />
<table class="width80  " cellpadding="0" cellspacing="0" align="center">
<tr><td>

	<table cellpadding="0" cellspacing="0" class="left order_detail border ">
		<tr>
			<th class="border_right" width="10%"><?php echo __('sum_count'); ?></th>
			<th class="border_right" width="20%"><?php echo __('sum_price'); ?></th>
		</tr>
		<tr >
			<td class="border_right"><?php echo $item_count; ?></td>
			<td class="border_right"><?php echo number_format($sum_price).' '.__('rial'); ?></td>
		</tr>
	</table>

</td></tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
		<span>در صورت بروز هرگونه مشکل از طریق صفحه &nbsp;</span><a href="<?php echo __SITE_URL; ?>pages/view/5">تماس با ما</a>
		<span> با مدیر سایت تماس بگیرید.</span>
	</td>
</tr>
</table>
<?php
	/*pr($user);
	pr($order_id);
	pr($order_items);
	pr($user_details);*/
	
?>
<script>
	window.print();
</script>