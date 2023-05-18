<div class="head">							 
	  <?php if(!empty($products)){?>		
	  <a href="javascript:void(0)" class="button primary end_sale" style="width:200px;margin-left: 15px;margin-top: 13px;"><?php echo __d(__SHOP_LOCALE,'end_sale'); ?></a>				 
      <?php } ?>
    <h2 class="title right"><i class="icon icon-caret-left-blue"></i>سبد خريد شما در دکتر اينجاست</h2>
	<div class="clear"></div>
	<div><h3>تمام هزینه ارسال بر عهده فرستنده می باشد</h3></div>
	<div class="clear"></div>
</div>
<div class="columns basket_preview">
<form accept-charset="utf-8" method="post" class="myForm"  name="Basket" id="Basket" action="<?php echo __SITE_URL.__SHOP; ?>/orders/preper_pay_order">
    <?php
	if(!empty($products)){
		echo "
			<table data-toggle='table' class='basket' align='center'>
			    <thead>
			    <tr>
			        <th></th>
			        <th style='border-right: 0 none;'>شرح محصول</th>
			        <th>تعداد</th>
			        <th>قيمت</th>
			        <th></th>
			    </tr>
			    </thead>
			    <tbody>
		";
		$total= 0;
		foreach($products as $product){
			$total += $product['price'] * $product['num'];
			echo "
				    <tr class='main_column'>
				        <td style='width:20%' class='image'>
				            <a href='".__SITE_URL.__SHOP."/products/view/".$product['id']."'>
								<img src='" .__SITE_URL.__SHOP_IMAGE_URL.$product['image']."'>
							</a>	
				        </td>
				        <td style='width:20%' class='f14'>
							<a href='".__SITE_URL.__SHOP."/products/view/".$product['id']."'>".$product['title']."</a>
						</td>
				        <td style='width:20%' class='f14'>";
						echo "<select id='change_basket_item' disabled  onChange='refresh_basket(".$product['id'].",this.options[this.selectedIndex].value)'>";
						for($i = 1; $i <= 20; $i++){
							if($i==$product['num']){
								echo "<option value='".$i."' selected>".$i."</option>";
							}else echo "<option value='".$i."' >".$i."</option>";
						}
						echo "</select>";
						echo"</td>
				        <td class='f17' style='width:20%'>".number_format($product['price'])." ريال</td>
				        <td class='delete'>
						<img src='".__SITE_URL."img/icons/cancel-on.png' onclick=delete_basket_product(this,".$product['id'].")>
						</td>
				    </tr>
					
			";
		}
		echo "									
			    </tbody>
			</table>
			
		";
	 }	
		else echo 'سبد خرید خالی می باشد';
	?>	
	</form>			
</div>
<?php 
if(!empty($products)){
?>
<div class="finalprice">
    <div class="total clearfix">
        <span class="label">جمع کل خريد شما :</span>
        <span class="label-price">
             <?php echo number_format($total); ?>
            <span class="toman"><?php echo __d(__SHOP_LOCALE,'rial'); ?></span>
        </span>
    </div>
    <div class="sep"></div>
    <div class="payable clearfix">
        <span class="label green">مبلغ قابل پرداخت :</span>
        <span class="label-price green">
            <?php echo number_format($total); ?>
            <span class="toman green"><?php echo __d(__SHOP_LOCALE,'rial'); ?></span>
        </span>
    </div>
    <div class="total clearfix">
        <span class="label green">هزینه ارسال :</span>
        <span class="label-price green">
            0
            <span class="toman green"><?php echo __d(__SHOP_LOCALE,'rial'); ?></span>
        </span>
    </div>
</div>
<?php
 }
?>
<div class="clear"></div>
<div class="head" style="margin-bottom: 20px;">							 
	  <?php if(!empty($products)){?>
	  <a href="javascript:void(0)" class="button primary end_sale" style="width:200px;margin-left: 15px;margin-top: 13px;"><?php echo __d(__SHOP_LOCALE,'end_sale'); ?></a>									 
	  <?php } ?>	
	  <a href="javascript:void(0)" class="button secondary continue_sale" id='continue_sale' style="width:200px;margin-left: 15px;margin-top: 13px;"><?php echo __d(__SHOP_LOCALE,'continue_sale'); ?></a>	
	<div class="clear"></div>
</div>
<div class="clear"></div>
<script>
	$(function(){
		$('#continue_sale').click(function(){
			window.location.href = '<?php echo __SITE_URL; ?>';
		})
		
		$('.end_sale').click(function(){
			$('#Basket').submit();
		})	
	});
</script>