<?php

$info_array = array(
	"description"=>  __d(__LINK_LOCALE,'link_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__LINK_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `detail` VARCHAR(300) NULL DEFAULT NULL,
  `link_type` tinyint(4) NOT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";
$remove_query_array[]="DROP TABLE `links` ";


$install_menu_query[] = array("name"=>__d(__LINK_LOCALE,'link_managment'),"controller"=>'links',"action"=>"admin_index","action_name"=>__d(__LINK_LOCALE,'link_list'));
$install_menu_query[] = array("name"=>__d(__LINK_LOCALE,'link_managment'),"controller"=>'links',"action"=>"admin_add","action_name"=>__d(__LINK_LOCALE,'add_link'));
$install_menu_query[] = array("name"=>__d(__LINK_LOCALE,'link_managment'),"controller"=>'links',"action"=>"admin_edit","action_name"=>__d(__LINK_LOCALE,'edit_link'));
$install_menu_query[] = array("name"=>__d(__LINK_LOCALE,'link_managment'),"controller"=>'links',"action"=>"admin_delete","action_name"=>__d(__LINK_LOCALE,'delete_link'));
$remove_menu_query[] = array("controller"=>'links');

?>