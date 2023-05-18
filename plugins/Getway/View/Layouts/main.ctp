
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php if(isset($title_for_layout)) echo  $title_for_layout ?> 
	</title>
	
	
	<meta name="keywords" content="<?php if(isset($keywords_for_layout)) echo $keywords_for_layout ?>"/>
    <meta name="description" content="<?php if(isset($description_for_layout)) echo $description_for_layout; ?>">   

	<meta name="copyright" content="madaner.com" />
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
</head>
<body>
  <?php echo $this->fetch('content');  ?>
</body>
</html>	