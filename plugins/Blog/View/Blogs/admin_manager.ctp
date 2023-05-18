<!-- topbar starts -->
	<?php
		
		echo $this->Html->css('/js/admin/manager/css/jquery-ui');
		echo $this->Html->css('/js/admin/manager/css/elfinder.min');
		echo $this->Html->css('/js/admin/manager/css/theme');
		echo $this->Html->script('/js/admin/manager/js/jquery-ui.min');
		echo $this->Html->script('/js/admin/manager/js/elfinder.min');
		//echo $this->Html->script('/js/admin/manager/js/i18n/elfinder.LANG');
		//echo $this->Html->script('/js/admin/manager/js/i18n/elfinder.ar');
		
	?> 
	<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					url : '<?php echo __SITE_URL ?>'+'/js/admin/manager/php/connector.php?url=<?php echo __SITE_URL ?>'  // connector URL (REQUIRED)
					 , lang: 'ar'              // language (OPTIONAL)
				}).elfinder('instance');
			});
		</script>
	<!-- topbar ends -->
		<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- right menu starts -->
				<?php echo $this->element('Admin/right_menu'); ?>       
			<!-- right menu ends -->
			
			<div id="content" class="span10">
			<!-- content starts -->
			
			 
			<?php if($this->Session->check('Message.flash')) {?>
				<div style="clear:both">
					  <?php echo $this->Session->flash(); ?>
				</div>
				<?php } ?>
				 
			 <div class="row-fluid sortable ui-sortable">	
				<div class="box span12">
					<div data-original-title="" class="box-header well">
						<h2><?php echo __('file_managment'); ?></h2>
						<div class="box-icon">
							<a class="btn btn-minimize btn-round" href="#"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="elfinder"></div>   
					</div>
				</div><!--/span-->
			</div>
		
    
					<!-- content ends -->
			</div><!--/#content.span10-->
	</div><!--/fluid-row-->
</div>				
	




	