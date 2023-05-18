<?php

$info_array = array(
	"description"=>  __d(__GALLERY_LOCALE,'gallery_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__GALLERY_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[]="
CREATE TABLE `galleries` (
  `id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `galleries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; 
  
";

$install_query_array[] ="
	
CREATE TABLE `gallerytranslations` (
  `gallery_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `gallerytranslations`
  ADD PRIMARY KEY (`gallery_id`,`language_id`);
";


$install_query_array[] = "

CREATE TABLE `galleryimages` (
  `id` bigint(20) NOT NULL,
  `gallery_id` bigint(20) NOT NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `galleryimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_id` (`gallery_id`);

ALTER TABLE `galleryimages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
";
$install_query_array[] ="
	
CREATE TABLE `galleryimagetranslations` (
  `galleryimage_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `galleryimagetranslations`
  ADD PRIMARY KEY (`galleryimage_id`,`language_id`);

";

$remove_query_array[]="DROP TABLE `galleries` ";
$remove_query_array[]="DROP TABLE `gallerytranslations` ";
$remove_query_array[]="DROP TABLE `galleryimages` ";
$remove_query_array[]="DROP TABLE `galleryimagetranslations` ";

/**
* 
 DELIMITER $$
CREATE TRIGGER `delete_gallery_relate_table` 
AFTER DELETE ON `galleries` 
FOR EACH ROW 
begin
delete from gallerytranslations where gallery_id = old.id;
end
$$
DELIMITER ;
 
 DELIMITER $$
CREATE TRIGGER `delete_galleryimage_relate_tables` 
AFTER DELETE ON `galleryimages` FOR EACH ROW begin
delete from galleryimagetranslations where galleryimage_id = old.id;
end;$$
DELIMITER ;  
    
*/
$install_menu_query[] = array("name"=>__d(__GALLERY_LOCALE,'gallery_managment'),"controller"=>'galleries',"action"=>"admin_index","action_name"=>__d(__GALLERY_LOCALE,'gallery_list'));
$install_menu_query[] = array("name"=>__d(__GALLERY_LOCALE,'gallery_managment'),"controller"=>'galleries',"action"=>"admin_add","action_name"=>__d(__GALLERY_LOCALE,'add_gallery'));
$install_menu_query[] = array("name"=>__d(__GALLERY_LOCALE,'gallery_managment'),"controller"=>'galleries',"action"=>"admin_edit","action_name"=>__d(__GALLERY_LOCALE,'edit_gallery'));
$install_menu_query[] = array("name"=>__d(__GALLERY_LOCALE,'gallery_managment'),"controller"=>'galleries',"action"=>"admin_delete","action_name"=>__d(__GALLERY_LOCALE,'delete_gallery'));
$remove_menu_query[] = array("controller"=>'galleries');



?>