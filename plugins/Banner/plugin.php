<?php

$info_array = array(
	"description"=>  __d(__BANNER_LOCALE,'banner_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__BANNER_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[]="

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `bannerlocation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `link` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

 
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`) USING BTREE;

 
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";
$install_query_array[] = "
 CREATE TABLE `bannerlocations` (
  `id` int(11) NOT NULL,
  `location` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


INSERT INTO `bannerlocations` (`id`, `location`, `status`, `created`) VALUES
(1, 'بالای صفحه اصلی', 1, '2019-06-06 00:00:00'),
(2, 'گوشه چپ صفحه وبلاگ', 1, '2019-06-06 00:00:00');


ALTER TABLE `bannerlocations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bannerlocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";

$install_query_array[] = "
	
CREATE TABLE `bannertranslations` (
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `bannertranslations`
  ADD PRIMARY KEY (`banner_id`,`language_id`);
";

$remove_query_array[]="DROP TABLE `banners` ";
$remove_query_array[]="DROP TABLE `bannerlocations` ";
$remove_query_array[]="DROP TABLE `bannertranslations` ";


 

$install_menu_query[] = array("name"=>__d(__BANNER_LOCALE,'banner_managment'),"controller"=>'banners',"action"=>"admin_index", "action_name"=>__d(__BANNER_LOCALE,'banner_list'));
$install_menu_query[] = array("name"=>__d(__BANNER_LOCALE,'banner_managment'),"controller"=>'banners',"action"=>"admin_add", "action_name"=>__d(__BANNER_LOCALE,'add_banner'));
$install_menu_query[] = array("name"=>__d(__BANNER_LOCALE,'banner_managment'),"controller"=>'banners',"action"=>"admin_edit", "action_name"=>__d(__BANNER_LOCALE,'edit_banner'));
$install_menu_query[] = array("name"=>__d(__BANNER_LOCALE,'banner_managment'),"controller"=>'banners',"action"=>"admin_delete", "action_name"=>__d(__BANNER_LOCALE,'delete_banner'));
$remove_menu_query[] = array("controller"=>'banners');


?>