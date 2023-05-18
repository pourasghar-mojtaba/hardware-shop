<?php

$info_array = array(
	"description"=>  __d(__COMPANY_LOCALE,'company_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__COMPANY_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(200) NULL DEFAULT NULL,
  `url` VARCHAR(500) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	
CREATE TABLE `companytranslations` (
  `company_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `companytranslations`
  ADD PRIMARY KEY (`company_id`,`language_id`);
";

$remove_query_array[]="DROP TABLE `companies` ";
$remove_query_array[]="DROP TABLE `companytranslations` ";

$install_menu_query[] = array("name"=>__d(__COMPANY_LOCALE,'company_managment'),"controller"=>'companies',"action"=>"admin_index","action_name"=>__d(__COMPANY_LOCALE,'company_list'));
$install_menu_query[] = array("name"=>__d(__COMPANY_LOCALE,'company_managment'),"controller"=>'companies',"action"=>"admin_add","action_name"=>__d(__COMPANY_LOCALE,'add_company'));
$install_menu_query[] = array("name"=>__d(__COMPANY_LOCALE,'company_managment'),"controller"=>'companies',"action"=>"admin_edit","action_name"=>__d(__COMPANY_LOCALE,'edit_company'));
$install_menu_query[] = array("name"=>__d(__COMPANY_LOCALE,'company_managment'),"controller"=>'companies',"action"=>"admin_delete","action_name"=>__d(__COMPANY_LOCALE,'delete_company'));
$remove_menu_query[] = array("controller"=>'companies');

?>
