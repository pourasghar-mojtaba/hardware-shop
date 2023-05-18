<?php

$info_array = array(
	"description"=>  __d(__PRICE_LOCALE,'price_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__PRICE_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `buy_price` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `sel_price` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `price_date` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";
$remove_query_array[]="DROP TABLE `prices` ";


$install_menu_query[] = array("name"=>__d(__PRICE_LOCALE,'price_managment'),"controller"=>'prices',"action"=>"admin_index","action_name"=>__d(__PRICE_LOCALE,'price_list'));
$install_menu_query[] = array("name"=>__d(__PRICE_LOCALE,'price_managment'),"controller"=>'prices',"action"=>"admin_add","action_name"=>__d(__PRICE_LOCALE,'add_price'));
$install_menu_query[] = array("name"=>__d(__PRICE_LOCALE,'price_managment'),"controller"=>'prices',"action"=>"admin_edit","action_name"=>__d(__PRICE_LOCALE,'edit_price'));
$install_menu_query[] = array("name"=>__d(__PRICE_LOCALE,'price_managment'),"controller"=>'prices',"action"=>"admin_delete","action_name"=>__d(__PRICE_LOCALE,'delete_price'));
$remove_menu_query[] = array("controller"=>'prices');

?>