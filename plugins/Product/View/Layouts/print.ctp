<!DOCTYPE html>
<html>
	<head>
		<?php

		echo $this->Html->charset('utf-8');

		?>
		<title>
			<?php
			if(isset($title_for_layout))   echo $title_for_layout; ?>
		</title>
		<meta name="keywords" content="<?php
		if(isset($keywords_for_layout))   echo $keywords_for_layout ?>"/>
		<meta name="description" content="<?php
		if(isset($description_for_layout))  echo $description_for_layout; ?>">
		<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
		<?php

		echo $this->Html->meta('icon');

 

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">		

		<?php
			echo $this->Flash->render();
			echo $this->fetch('content');

		?>
	</body>
</html>
