<?php
	//pr($orders);
?>
<div class="dashboard-content">
	<!-- HEADLINE -->
	<div class="headline purchases primary">
		<h4>خرید های شما</h4>
		<!--<form id="purchase_filter_form" name="purchase_filter_form">
			<label for="itemspp_filter" class="select-block">
				<select name="itemspp_filter" id="itemspp_filter">
					<option value="0">مورد در صفحه 12</option>
					<option value="1">6 مورد در صفحه</option>
				</select>
				 
				<svg class="svg-arrow">
					<use xlink:href="#svg-arrow"></use>
				</svg>
				 
			</label>

			<label for="date_filter" class="select-block">
				<select name="date_filter" id="date_filter">
					<option value="0">تاریخ (جدید به قدیم)</option>
					<option value="1">تاریخ (قدیم به جدید)</option>
				</select>
				 
				<svg class="svg-arrow">
					<use xlink:href="#svg-arrow"></use>
				</svg>
				 
			</label>

			<div class="search-form">
				<input type="text" class="rounded search" name="search" id="search_products" placeholder="جستجوی محصولات">
				<input type="image" src="dashboard-images/search-icon-small.png" alt="search-icon">
			</div>
		</form>-->
	</div>
	<!-- /HEADLINE -->

	<!-- PURCHASES LIST -->
	<div class="purchases-list">
		<!-- PURCHASES LIST HEADER -->
		<div class="purchases-list-header">
			<div class="purchases-list-header-date">
				<p class="text-header small">شماره فاکتور</p>
			</div>
			<div class="purchases-list-header-date">
				<p class="text-header small">تعدلد کالا</p>
			</div>
			<div class="purchases-list-header-price">
				<p class="text-header small">مجموع کالا</p>
			</div>
			<div class="purchases-list-header-date">
				<p class="text-header small">تاریخ</p>
			</div>
			<div class="purchases-list-header-details" >
				<p class="text-header small" style="text-align:center">عملیات</p>
			</div>
		</div>
		<!-- /PURCHASES LIST HEADER -->

		<!-- PURCHASE ITEM -->
		<?php
			if(!empty($orders)){
				foreach($orders as $order){
		?>			
			<div class="purchase-item">
				<div class="purchase-item-date">
					<p><?php echo $order['Order']['id']; ?></p>
				</div>
				<div class="purchase-item-date">
					<p class="price" ><?php echo $order['0']['item_count']; ?></p>
				</div>
				<div class="purchase-item-price">
					<p class="price"><span></span><?php echo $order['Order']['sum_price']; ?></p>
				</div>
				<div class="purchase-item-date">
					<p ><?php echo $this->Cms->show_persian_date(" l ، j F Y    ",strtotime($order['Order']['created'])); ?></p>
				</div>
				<div class="purchase-item-details" >
					<?php if($order['Order']['refid']=='' || $order['Order']['refid']==0){ ?>
					<a href="<?php echo __SITE_URL.__SHOP.'/orders/preper_pay_order/'.$order['Order']['id']; ?>" class="button dark-light">پرداخت</a>
					<?php }else echo "<br><h4 style='text-align:center'>".__('پرداخت شده است')."</h4>"; ?>
				</div>
 
			</div>
		<?php
				}
			}
		?>
		
		<!-- /PURCHASE ITEM -->


		<!-- PAGER -->
		<?php
			if(!empty($_REQUEST['page']))
			{
				$page = $_REQUEST['page'];
			}
			else $page    = 1;

			$url_str = __SITE_URL.__BLOG.'/blogs/last?';
			$this->Paginate->with_hide($total_count,$page,$limit,$url_str);
		?>
		<!-- /PAGER -->
	</div>
	<!-- /PURCHASES LIST -->
</div>