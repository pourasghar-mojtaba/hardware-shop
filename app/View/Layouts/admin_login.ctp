<!DOCTYPE html>
<html>
<head>
	<?php

echo $this->Html->charset('utf-8');

?>
	<title>
		<?php if (isset($title_for_layout))   echo $title_for_layout; ?>
	</title>
    <meta name="keywords" content="<?php if (isset($keywords_for_layout))   echo $keywords_for_layout ?>"/>
        <meta name="description" content="<?php  if (isset($description_for_layout))  echo $description_for_layout; ?>">
	    <META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<?php

echo $this->Html->meta('icon');

echo $this->Html->css('admin/bootstrap/css/bootstrap.min');
echo $this->Html->css('admin/font-awesome.min');
echo $this->Html->css('admin/ionicons.min');
echo $this->Html->css('admin/AdminLTE');
	echo $this->Html->script('admin/plugins/jQuery/jquery-2.2.0.min.js');
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

?>
</head>
<body  class="hold-transition login-page">

<?php
echo $this->Flash->render();
echo $this->fetch('content');
echo $this->Html->script('admin/plugins/jQuery/jQuery-2.2.0.min');
echo $this->Html->script('/css/admin/bootstrap/js/bootstrap.min.js');

echo $this->element('sql_dump');

?>
</body>
</html>
