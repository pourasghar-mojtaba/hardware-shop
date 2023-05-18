<?php

$info_array = array(
	"description"=>  __d(__CATALOG_LOCALE,'catalog_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__CATALOG_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `file` VARCHAR(200) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";
$remove_query_array[]="DROP TABLE `catalogs` ";


$install_menu_query[] = array("name"=>__d(__CATALOG_LOCALE,'catalog_managment'),"controller"=>'catalogs',"action"=>"admin_index","action_name"=>__d(__CATALOG_LOCALE,'catalog_list'));
$install_menu_query[] = array("name"=>__d(__CATALOG_LOCALE,'catalog_managment'),"controller"=>'catalogs',"action"=>"admin_add","action_name"=>__d(__CATALOG_LOCALE,'add_catalog'));
$install_menu_query[] = array("name"=>__d(__CATALOG_LOCALE,'catalog_managment'),"controller"=>'catalogs',"action"=>"admin_edit","action_name"=>__d(__CATALOG_LOCALE,'edit_catalog'));
$install_menu_query[] = array("name"=>__d(__CATALOG_LOCALE,'catalog_managment'),"controller"=>'catalogs',"action"=>"admin_delete","action_name"=>__d(__CATALOG_LOCALE,'delete_catalog'));
$remove_menu_query[] = array("controller"=>'catalogs');

?>