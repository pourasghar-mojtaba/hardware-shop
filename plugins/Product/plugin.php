<?php

$info_array = array(
	"description" => __d(__PRODUCT_LOCALE, 'product_plugin_detail'),
	"website" => "picosite.ir",
	"author" => __d(__PRODUCT_LOCALE, 'plugin_creator'),
	"email" => "info@picosite.ir",
	"version" => "1.0",
);
$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) NOT NULL,
  `slug` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `price` BIGINT NOT NULL DEFAULT '0',
  `num`  INT NOT NULL DEFAULT '0',
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

$install_query_array[] = "
DROP TABLE IF EXISTS `discountcoupons`;
CREATE TABLE IF NOT EXISTS `discountcoupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_type_id` int(11) DEFAULT NULL,
  `code` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
";

$install_query_array[] = "
DROP TABLE IF EXISTS `discounttypes`;
CREATE TABLE IF NOT EXISTS `discounttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` decimal(5,2) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
";

$install_query_array[] = "
	CREATE TABLE `discounttypetranslations` (
  `discount_type_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `discounttypetranslations`
  ADD PRIMARY KEY (`discount_type_id`,`language_id`);
";

$install_query_array[] = "
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `sum_price` bigint(20) NOT NULL,
  `items_count` int(11) NOT NULL DEFAULT '0',
  `bankmessage_id` int(11) NOT NULL DEFAULT '-1',
  `refid` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '-1',
  `description` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
";

$install_query_array[] = "
DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `settlement_id` int(11) DEFAULT NULL,
  `item_count` int(11) NOT NULL,
  `sum_price` bigint(20) NOT NULL,
  `admin_price` bigint(20) NOT NULL,
  `user_price` bigint(20) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
";

$install_query_array[] = "
DROP TABLE IF EXISTS `productdiscounts`;
CREATE TABLE IF NOT EXISTS `productdiscounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `discount_type_id` int(11) NOT NULL,
  `start_date` INT NOT NULL DEFAULT '0',
  `end_date` INT NOT NULL DEFAULT '0',
  `status` SMALLINT(1) NOT NULL DEFAULT '1',
  `approved` smallint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
";
$install_query_array[] = "
DROP TABLE IF EXISTS `productproperties`;
CREATE TABLE IF NOT EXISTS `productproperties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `property_value` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
";
$install_query_array[] = "
DROP TABLE IF EXISTS `productrelatetags`;
CREATE TABLE IF NOT EXISTS `productrelatetags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
";
$install_query_array[] = "
DROP TABLE IF EXISTS `producttags`;
CREATE TABLE IF NOT EXISTS `producttags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
";
$install_query_array[] = "
DROP TABLE IF EXISTS `properties`;
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
";
$install_query_array[] = "
DROP TABLE IF EXISTS `propertydetails`;
CREATE TABLE IF NOT EXISTS `propertydetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `value` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;
";

$remove_query_array[] = "DROP TABLE `products` ";
$remove_query_array[] = "DROP TABLE `producttranslations` ";
$remove_query_array[] = "DROP TABLE `productimages` ";
$remove_query_array[] = "DROP TABLE `productimagetranslations` ";
$remove_query_array[] = "DROP TABLE `productcategories` ";
$remove_query_array[] = "DROP TABLE `productcategorytranslations` ";
$remove_query_array[] = "DROP TABLE `discountcoupons` ";
$remove_query_array[] = "DROP TABLE `discounttypes` ";
$remove_query_array[] = "DROP TABLE `discounttypetranslations` ";
$remove_query_array[] = "DROP TABLE `orders` ";
$remove_query_array[] = "DROP TABLE `orderitems` ";
$remove_query_array[] = "DROP TABLE `productdiscounts` ";
$remove_query_array[] = "DROP TABLE `productproperties` ";
$remove_query_array[] = "DROP TABLE `productrelatetags` ";
$remove_query_array[] = "DROP TABLE `producttags` ";
$remove_query_array[] = "DROP TABLE `properties` ";
$remove_query_array[] = "DROP TABLE `propertydetails` ";

$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'product_managment'), "controller" => 'products', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'product_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'product_managment'), "controller" => 'products', "action" => "admin_add", "action_name" => __d(__PRODUCT_LOCALE, 'add_product'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'product_managment'), "controller" => 'products', "action" => "admin_edit", "action_name" => __d(__PRODUCT_LOCALE, 'edit_product'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'product_managment'), "controller" => 'products', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_product'));
$remove_menu_query[] = array("controller" => 'products');


$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'category_managment'), "controller" => 'productcategories', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'category_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'category_managment'), "controller" => 'productcategories', "action" => "admin_add", "action_name" => __d(__PRODUCT_LOCALE, 'add_category'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'category_managment'), "controller" => 'productcategories', "action" => "admin_edit", "action_name" => __d(__PRODUCT_LOCALE, 'edit_category'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'category_managment'), "controller" => 'productcategories', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_category'));
$remove_menu_query[] = array("controller" => 'productcategories');

$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'order_managment'), "controller" => 'orders', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'order_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'order_managment'), "controller" => 'orders', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_order'));
$remove_menu_query[] = array("controller" => 'orders');

$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'orderitems_managment'), "controller" => 'orderitems', "action" => "admin_items_list", "action_name" => __d(__PRODUCT_LOCALE, 'orderitems_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'orderitems_managment'), "controller" => 'orderitems', "action" => "admin_order_print", "action_name" => __d(__PRODUCT_LOCALE, 'print_orderitems'));
$remove_menu_query[] = array("controller" => 'orderitems');


$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discounttype_managment'), "controller" => 'discounttypes', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'discounttype_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discounttype_managment'), "controller" => 'discounttypes', "action" => "admin_add", "action_name" => __d(__PRODUCT_LOCALE, 'add_discounttype'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discounttype_managment'), "controller" => 'discounttypes', "action" => "admin_edit", "action_name" => __d(__PRODUCT_LOCALE, 'edit_discounttype'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discounttype_managment'), "controller" => 'discounttypes', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_discounttype'));
$remove_menu_query[] = array("controller" => 'discounttypes');


$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discountcoupon_managment'), "controller" => 'discountcoupons', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'discountcoupon_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discountcoupon_managment'), "controller" => 'discountcoupons', "action" => "admin_add", "action_name" => __d(__PRODUCT_LOCALE, 'add_discountcoupon'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'discountcoupon_managment'), "controller" => 'discountcoupons', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_discountcoupon'));
$remove_menu_query[] = array("controller" => 'discountcoupons');

$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'productdiscount_managment'), "controller" => 'productdiscounts', "action" => "admin_index", "action_name" => __d(__PRODUCT_LOCALE, 'productdiscount_list'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'productdiscount_managment'), "controller" => 'productdiscounts', "action" => "admin_add", "action_name" => __d(__PRODUCT_LOCALE, 'add_productdiscount'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'productdiscount_managment'), "controller" => 'productdiscounts', "action" => "admin_edit", "action_name" => __d(__PRODUCT_LOCALE, 'edit_productdiscount'));
$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'productdiscount_managment'), "controller" => 'productdiscounts', "action" => "admin_delete", "action_name" => __d(__PRODUCT_LOCALE, 'delete_productdiscount'));
$remove_menu_query[] = array("controller" => 'productdiscounts');

$install_menu_query[] = array("name" => __d(__PRODUCT_LOCALE, 'producttag_managment'), "controller" => 'producttags', "action" => "admin_tag_search", "action_name" => __d(__PRODUCT_LOCALE, 'tag_search'));
$remove_menu_query[] = array("controller" => 'producttags');

?>
