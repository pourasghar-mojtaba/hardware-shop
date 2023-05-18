<?php
echo $this->Html->css('/js/admin/plugins/iCheck/flat/blue');
echo $this->Html->script('admin/plugins/iCheck/icheck.min');
$actionAddress = '';
if (!empty($items['url'])) {
	$actionAddress = $items['url'];
} else
	$actionAddress = strtolower($items['action']) . 's';
?>
<section class="content-header">
	<h2>
		<?php

		echo $items['action_name'];
		if (!empty($items['add_style'])) {
			if (isset($items['add_style']['select'])) {
				$attributs = array(
					'class' => 'form-control input-sm',
					'style' => 'width:80px'
				);
			} elseif (isset($items['add_style']['link'])) {
				$attributs = array(
					'class' => 'add-new-h2'
				);
			}
			echo $this->AdminHtml->addButton($items['add_style'], $attributs);
		}

		?>
	</h2>
	<ol class="breadcrumb">
		<li>
			<a href="<?php echo __SITE_URL . "admin"; ?>">
				<i class="fa fa-dashboard">
				</i> <?php echo __('home'); ?>
			</a>
		</li>
		<li class="active">
			<?php echo $items['action_name']; ?>
		</li>
	</ol>
	<?php echo $this->Session->flash(); ?>
	<?php
	if (isset($items['sub_items']) && !empty($items['sub_items'])) {
		?>
		<ul class="subsubsub">
			<li class="all">
				<a class="current" href="plugins.php?plugin_status=all">
					همه
					<span class="count">
						(27)
					</span>
				</a> |
			</li>
			<li class="active">
				<a href="plugins.php?plugin_status=active">
					فعال
					<span class="count">
						(9)
					</span>
				</a> |
			</li>
			<li class="inactive">
				<a href="plugins.php?plugin_status=inactive">
					غیرفعال
					<span class="count">
						(18)
					</span>
				</a> |
			</li>
			<li class="upgrade">
				<a href="plugins.php?plugin_status=upgrade">
					آماده&zwnj;ی به&zwnj;روزرسانی
					<span class="count">
						(14)
					</span>
				</a>
			</li>
		</ul>
		<?php
	} ?>
	<div class="box_paginate_number">
		<span>
			<?php echo __('records_per_page'); ?>
		</span>
		<select name="example1_length" aria-controls="example1" class="form-control input-sm"
				onchange="if (this.value) window.location.href=this.value">
			<?php
			if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == 10)
				echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=10 ' selected='selected'>10</option>";
			else echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=10 '>10</option>";
			if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == 25)
				echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=25 ' selected='selected'>25</option>";
			else echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=25 '>25</option>";
			if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == 50)
				echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=50 ' selected='selected'>50</option>";
			else echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=50 '>50</option>";
			if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == 100)
				echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=100 ' selected='selected'>100</option>";
			else echo "<option value='" . __SITE_URL . "admin/" . $actionAddress . "/index?filter=100 '>100</option>";
			?>
		</select>
	</div>

	<?php
	if (isset($items['filter_items']) && !empty($items['filter_items'])) {
		?>
		<div class="tablenav top">

			<div class="alignleft actions bulkactions">
				<label class="screen-reader-text" for="bulk-action-selector-top">
					انتخاب کار دسته&zwnj;جمعی
				</label>
				<select id="bulk-action-selector-top" name="action">
					<option selected="selected" value="-1">
						کارهای دسته&zwnj;جمعی
					</option>
					<option value="unapprove">
						نپذیرفتن
					</option>
					<option value="approve">
						پذیرفتن
					</option>
					<option value="spam">
						نشان&zwnj;گذاری به&zwnj;عنوان جفنگ
					</option>
					<option value="trash">
						انتقال به زباله&zwnj;دان
					</option>
				</select>
				<input type="submit" value="اجرا" class="btn btn-default" id="doaction" name="">
			</div>
			<div class="alignleft actions">
				<label for="filter-by-comment-type" class="screen-reader-text">
					پالایش بر اساس نوع دیدگاه
				</label>
				<select name="comment_type" id="filter-by-comment-type">
					<option value="">
						همه نوع دیدگاه
					</option>
					<option value="comment">
						دیدگاه&zwnj;ها
					</option>
					<option value="pings">
						پینگ&zwnj;ها
					</option>
				</select>
				<input type="submit" value="صافی" class="btn btn-default" id="post-query-submit" name="filter_action">
			</div>
			<div class="tablenav-pages no-pages">
				<span class="displaying-num">
					0 مورد
				</span>
				<span class="pagination-links">
					<a href="http://springdesigng.com/wp-admin/edit-comments.php" title="رفتن به صفحه&zwnj;ی اول"
					   class="first-page disabled">
						«
					</a>
					<a href="http://springdesigng.com/wp-admin/edit-comments.php?paged=1"
					   title="رفتن به صفحه&zwnj;ی قبل" class="prev-page disabled">
						‹
					</a>
					<span class="paging-input">
						<label class="screen-reader-text" for="current-page-selector">
							انتخاب برگه
						</label><input type="text" size="1" value="1" name="paged" title="صفحه&zwnj;ی فعلی"
									   id="current-page-selector" class="current-page"> از
						<span class="total-pages">
							0
						</span>
					</span>
					<a href="http://springdesigng.com/wp-admin/edit-comments.php?paged=0"
					   title="رفتن به صفحه&zwnj;ی بعد" class="next-page">
						›
					</a>
					<a href="http://springdesigng.com/wp-admin/edit-comments.php?paged=0" title="رفتن به آخرین صفحه"
					   class="last-page">
						»
					</a>
				</span>
			</div>
			<br class="clear">
		</div>
		<?php
	} ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">

			<!--body-->
			<div class="box">
				<div class="box-header with-border">
					<?php

					$languages = $this->requestAction(__SITE_URL . 'admin/languages/getall/');
					if (count($languages) > 1) {
						foreach ($languages as $language) {
							if ($language['Language']['code'] == $_COOKIE['CakeCookie'][__ADMIN_LANG_INDEX]) {
								$current_lang = $language['Language']['title'];
							}
						}
						?>
						<ul class="nav nav-tabs pull-right">
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
									<?php echo __('language'); ?> : (<?php echo $current_lang; ?>)<span
										class="caret"></span>
								</a>

								<ul class="dropdown-menu">
									<?php
									foreach ($languages as $language) {
										echo "<li role='presentation'><a role='menuitem' tabindex='-1' href='" . __SITE_URL . "admin/languages/change/" . $language['Language']['code'] . "/" . $language['Language']['id'] . "'>" . $language['Language']['title'] . "</a></li>";
									}
									?>
								</ul>

							</li>

						</ul>
						<?php
					}
					?>
				</div>

				<div class="box-header">

					<?php
					if ($items['show_search_box']) {
						?>
						<div class="box-tools">
							<?php echo $this->Form->create($items['action']); ?>
							<div style="width: 150px;" class="input-group input-group-sm">
								<?php echo $this->Form->input('search', array("label" => false, 'div' => false, "type" => "text", "class" => "form-control pull-right", "placeholder" => __("search"), 'style' => 'direction:rtl;')); ?>
								<div class="input-group-btn">
									<button class="btn btn-default" type="submit">
										<i class="fa fa-search">
										</i>
									</button>
								</div>
							</div>
							<?php echo $this->Form->end(); ?>
						</div>
						<?php
					} ?>
					<div class="box_paginate">
						<?php
						echo $this->element('Admin/paginate');
						?>
					</div>

				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
						<tr>
							<th>
								<button type="button" class="btn btn-default btn-sm checkbox-toggle">
									<i class="fa fa-square-o">
									</i>
								</button>
							</th>
							<?php
							if (!empty($items['titles'])) {
								foreach ($items['titles'] as $title) {
									echo "<th>";
									$action = $items['action'];
									if (isset($title['action']) && !empty($title['action'])) {
										$action = $title['action'];
									}
									if (!empty($title['index'])) {

										if (strpos($title['index'], '.', 0) > 0)
											echo $this->Paginator->sort($title['index'], __($title['title']));
										else echo $this->Paginator->sort($action . '.' . $title['index'], __($title['title']));
									} else echo __($title['title']);
									echo "</th>";
								}
							}
							?>
						</tr>
