<?php
$User_Info = $this->Session->read('User_Info');
?>
<div class="col-lg-3 pb-5">
	<!-- Account Sidebar-->
	<div class="author-card pb-3">
		<div class="author-card-cover" >
			 &nbsp;<?php echo $User_Info['name']; ?>

		</div>

	</div>
	<div class="wizard">
		<nav class="list-group list-group-flush">
			<a class="list-group-item <?php if($active =='purchases') echo 'active'; ?>" href="<?php echo __SITE_URL.'orders/purchases' ?>">
				<i class="fe-icon-shopping-bag ml-1 text-muted"></i><?php echo __d(__PRODUCT_LOCALE, 'order_list') ?>
			</a>
			<a class="list-group-item <?php if($active =='register') echo 'active'; ?>" href="<?php echo __SITE_URL.'orders/register' ?>">
				<i class="fe-icon-shopping-bag ml-1 text-muted"></i><?php echo __d(__PRODUCT_LOCALE, 'register_order') ?>
			</a>
			<a class="list-group-item <?php if($active =='edit_profile') echo 'active'; ?>" href="<?php echo __SITE_URL.'users/edit_profile' ?>">
				<i class="fe-icon-user text-muted"></i><?php echo __d(__USER_LOCAL, 'account_setting') ?>
			</a>
			<a class="list-group-item <?php if($active =='edit_password') echo 'active'; ?>" href="<?php echo __SITE_URL.'users/edit_password' ?>">
				<i class="fe-icon-user text-muted"></i><?php echo __d(__USER_LOCAL, 'edit_password') ?>
			</a>
			<a class="list-group-item <?php if($active =='edit_address') echo 'active'; ?>" href="<?php echo __SITE_URL.'users/edit_address' ?>">
				<i class="fe-icon-map-pin text-muted"></i><?php echo __d(__USER_LOCAL, 'edit_address') ?>
			</a>
			 </nav>
	</div>
</div>
