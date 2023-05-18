<?php

$info_array = array(
	"description"=>  __d(__BLOG_LOCALE,'blog_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__BLOG_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[]="
 CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slug` varchar(300) COLLATE utf8_persian_ci  NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `video` varchar(300) COLLATE utf8_persian_ci DEFAULT NULL,
  `profile_id` int(11) NOT NULL COMMENT 'source profile id',
  `link` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `num_viewed` int(11) NOT NULL DEFAULT '0',
  `num_new_comment` int(11) NOT NULL DEFAULT '0',
  `num_comment` int(11) NOT NULL DEFAULT '0',
  `pinsts` smallint(6) NOT NULL DEFAULT '0',
  `pingsts` smallint(6) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";
$install_query_array[] = "
 CREATE TABLE `blogtags` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `blogtags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `blogtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";
$install_query_array[] = "
 CREATE TABLE `blogcomments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `blogcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`,`user_id`);


ALTER TABLE `blogcomments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
";
$install_query_array[] ="
 CREATE TABLE `blogrelatetags` (
  `id` int(11) NOT NULL,
  `blog_tag_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `blogrelatetags`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `blogrelatetags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
";


$install_query_array[] = "
	CREATE TABLE `blogtranslations` (
  `blog_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `little_detail` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `detail` text COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `blogtranslations`
  ADD PRIMARY KEY (`blog_id`,`language_id`);
";


$remove_query_array[]="DROP TABLE `blogs` ";
$remove_query_array[]="DROP TABLE `blogtags` ";
$remove_query_array[]="DROP TABLE `blogcomments` ";
$remove_query_array[]="DROP TABLE `blogrelatetags` ";
$remove_query_array[]="DROP TABLE `blogtranslations` ";


$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blog_managment'),"controller"=>'blogs',"action"=>"admin_index", "action_name"=>__d(__BLOG_LOCALE,'blog_list'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blog_managment'),"controller"=>'blogs',"action"=>"admin_add", "action_name"=>__d(__BLOG_LOCALE,'add_blog'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blog_managment'),"controller"=>'blogs',"action"=>"admin_edit", "action_name"=>__d(__BLOG_LOCALE,'edit_blog'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blog_managment'),"controller"=>'blogs',"action"=>"admin_delete", "action_name"=>__d(__BLOG_LOCALE,'delete_blog'));
$remove_menu_query[] = array("controller"=>'blogs');


$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blogcomment_managment'),"controller"=>'blogcomments',"action"=>"admin_index", "action_name"=>__d(__BLOG_LOCALE,'blogcomment_list'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blogcomment_managment'),"controller"=>'blogcomments',"action"=>"admin_add", "action_name"=>__d(__BLOG_LOCALE,'add_blogcomment'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blogcomment_managment'),"controller"=>'blogcomments',"action"=>"admin_edit", "action_name"=>__d(__BLOG_LOCALE,'edit_blogcomment'));
$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blogcomment_managment'),"controller"=>'blogcomments',"action"=>"admin_delete", "action_name"=>__d(__BLOG_LOCALE,'delete_blogcomment'));
$remove_menu_query[] = array("controller"=>'blogcomments');


$install_menu_query[] = array("name"=>__d(__BLOG_LOCALE,'blogtag_managment'),"controller"=>'blogtags',"action"=>"admin_tag_search", "action_name"=>__d(__BLOG_LOCALE,'blog_tag_search'));
$remove_menu_query[] = array("controller"=>'blogtags');

?>
