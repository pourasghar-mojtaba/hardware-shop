 <?php
 	
?>
 

<!-- jQuery and jQuery UI (REQUIRED) -->
<!--<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>-->

<!-- elFinder CSS (REQUIRED) -->
<!--<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">-->
<?php

echo $this->Html->css('/js/admin/manager/js/jqueryjs/jquery-ui.css');
echo $this->Html->script('/js/admin/manager/js/jqueryjs/jquery.min.js');
echo $this->Html->script('/js/admin/manager/js/jqueryjs/jquery-ui.min.js');

echo $this->Html->css('/js/admin/manager/css/elfinder.min');
echo $this->Html->css('/js/admin/manager/css/theme');
?>
<!-- elFinder JS (REQUIRED) -->
<!--<script type="text/javascript" src="js/elfinder.min.js"></script>

	 
<script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>-->
		
<?php
echo $this->Html->script('/js/admin/manager/js/elfinder.min');
//echo $this->Html->script('/js/admin/manager/js/i18n/elfinder.LANG');
//echo $this->Html->script('/js/admin/manager/js/i18n/elfinder.ar');
?>

<!-- elFinder initialization (REQUIRED) -->
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
			var elf = $('#elfinder').elfinder({
					//url : 'php/connector.php'  // connector URL (REQUIRED)
					url : '<?php echo __SITE_URL ?>'+'/js/admin/manager/php/connector.php?url=<?php echo __SITE_URL ?>'
					// lang: 'ru',             // language (OPTIONAL)
				}).elfinder('instance');
		});
</script>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<!--<div class="box-header with-border">
				<h3 class="box-title">Quick Example</h3>
				</div>-->

				<form role="form">              
				<div class="box-body">

					<!-- Element where elFinder will be created (REQUIRED) -->
					<div id="elfinder"></div>

				</div>
				<!-- /.box-body -->
				 
				<div class="clear">
				</div>
			</div>
			<!--body-->


		</div>
	</div>
</section>
