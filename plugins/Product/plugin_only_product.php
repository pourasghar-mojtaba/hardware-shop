<?php

$info_array = array(
	"description"=>  __d(__PRODUCT_LOCALE,'product_plugin_detail') ,
	"website"    => "picosite.ir",
	"author"     => __d(__PRODUCT_LOCALE,'plugin_creator'),
	"email"      => "info@picosite.ir",
	"version"    => "1.0",
);
$install_query_array[]="
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `slug` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_id` (`product_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	CREATE TABLE `producttranslations` (
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `mini_detail` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `detail` text COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `producttranslations`
  ADD PRIMARY KEY (`product_id`,`language_id`);
";

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `productimages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
CREATE TABLE `productimagetranslations` (
  `product_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `productimagetranslations`
  ADD PRIMARY KEY (`product_image_id`,`language_id`);
";


$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `slug` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `image` VARCHAR(200) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	CREATE TABLE `productcategorytranslations` (
  `product_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `productcategorytranslations`
  ADD PRIMARY KEY (`product_category_id`,`language_id`);
";

$remove_query_array[]="DROP TABLE `products` ";
$remove_query_array[]="DROP TABLE `producttranslations` ";
$remove_query_array[]="DROP TABLE `productimages` ";
$remove_query_array[]="DROP TABLE `productimagetranslations` ";
$remove_query_array[]="DROP TABLE `productcategories` ";
$remove_query_array[]="DROP TABLE `productcategorytranslations` ";

$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'product_managment'),"controller"=>'products',"action"=>"admin_index","action_name"=>__d(__PRODUCT_LOCALE,'product_list'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'product_managment'),"controller"=>'products',"action"=>"admin_add","action_name"=>__d(__PRODUCT_LOCALE,'add_product'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'product_managment'),"controller"=>'products',"action"=>"admin_edit","action_name"=>__d(__PRODUCT_LOCALE,'edit_product'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'product_managment'),"controller"=>'products',"action"=>"admin_delete","action_name"=>__d(__PRODUCT_LOCALE,'delete_product'));
$remove_menu_query[] = array("controller"=>'products');


$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'category_managment'),"controller"=>'productcategories',"action"=>"admin_index","action_name"=>__d(__PRODUCT_LOCALE,'category_list'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'category_managment'),"controller"=>'productcategories',"action"=>"admin_add","action_name"=>__d(__PRODUCT_LOCALE,'add_category'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'category_managment'),"controller"=>'productcategories',"action"=>"admin_edit","action_name"=>__d(__PRODUCT_LOCALE,'edit_category'));
$install_menu_query[] = array("name"=>__d(__PRODUCT_LOCALE,'category_managment'),"controller"=>'productcategories',"action"=>"admin_delete","action_name"=>__d(__PRODUCT_LOCALE,'delete_category'));
$remove_menu_query[] = array("controller"=>'productcategories');

?>
