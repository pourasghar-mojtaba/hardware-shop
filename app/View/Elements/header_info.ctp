<?php echo $this->Html->charset(); ?>
<meta name="viewport" content="initial-scale=1">

<meta name="robots" content="index, follow"/>
<title>
	<?php if($title_for_layout=='Home') echo SettingHandler::Instance()->siteTitle;else echo $title_for_layout; ?>
</title>

 
<?php
if(isset($description_for_layout))
{
	echo "<meta name='description' content='".$description_for_layout."' />";
}
echo "<meta name='description' content='".SettingHandler::Instance()->siteDescription."' />";
if(isset($keywords_for_layout))
{
	echo "<meta name='keywords' content='".$keywords_for_layout."' />";
}
echo "<meta name='keywords' content='".SettingHandler::Instance()->siteKeywords."' />";
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
echo $this->Html->meta('icon');

?>