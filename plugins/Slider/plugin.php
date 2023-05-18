<?php

$info_array = array(
	"description"=>  __d(__SLIDER_LOCALE,'slider_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__SLIDER_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";


$install_query_array[] = "
	
CREATE TABLE `slidertranslations` (
  `slider_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `detail` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `url` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `image` VARCHAR(200) NULL DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `slidertranslations`
  ADD PRIMARY KEY (`slider_id`,`language_id`);
";


$remove_query_array[]="DROP TABLE `sliders` ";
$remove_query_array[]="DROP TABLE `slidertranslations` ";


$install_menu_query[] = array("name"=>__d(__SLIDER_LOCALE,'slider_managment'),"controller"=>'sliders',"action"=>"admin_index","action_name"=>__d(__SLIDER_LOCALE,'slider_list'));
$install_menu_query[] = array("name"=>__d(__SLIDER_LOCALE,'slider_managment'),"controller"=>'sliders',"action"=>"admin_add","action_name"=>__d(__SLIDER_LOCALE,'add_slider'));
$install_menu_query[] = array("name"=>__d(__SLIDER_LOCALE,'slider_managment'),"controller"=>'sliders',"action"=>"admin_edit","action_name"=>__d(__SLIDER_LOCALE,'edit_slider'));
$install_menu_query[] = array("name"=>__d(__SLIDER_LOCALE,'slider_managment'),"controller"=>'sliders',"action"=>"admin_delete","action_name"=>__d(__SLIDER_LOCALE,'delete_slider'));
$remove_menu_query[] = array("controller"=>'sliders');

?>