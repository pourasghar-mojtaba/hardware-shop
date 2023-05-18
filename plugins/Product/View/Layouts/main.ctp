<!DOCTYPE html>
<html>
<head>
	<?php
		echo $this->element('header_info');		
	?>
</head>
<script type="text/javascript">
	//_url = '<?php echo __SITE_URL  ?>';
</script>		
<!-- BEGIN BODY -->
<body class="page-header-fixed">	
	<?php
	  echo $this->element(__THEME_ELEMENT.'header');
	   		
	  echo $this->fetch('content');  
	  //echo $this->element('sql_dump');  
	  echo $this->Flash->render();  
      echo $this->element(__THEME_ELEMENT.'footer');   
	  
	   echo $this->Html->css('/js/Zebra_Dialog-master/public/css/zebra_dialog.css');
	   echo $this->Html->script('/js/Zebra_Dialog-master/public/javascript/zebra_dialog');
	   
	   echo "<script type='text/javascript' src='".__SITE_URL.__SHOP."/js/global.js'></script>";
	  ?>	
	
</body>
<!-- END BODY -->
</html>