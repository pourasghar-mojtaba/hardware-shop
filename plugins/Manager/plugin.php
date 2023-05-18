<?php

$info_array = array(
	"description"=>  __d('manager','manager_message_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d('manager','plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[1]="
CREATE TABLE `manager_messages` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL ,
  `message` varchar(300) collate utf8_persian_ci NOT NULL,
  `status` tinyint(2) NOT NULL default '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";
$remove_query_array[1]="DROP TABLE `manager_messages` ";

$install_menu_query[] = array("name"=>__d('manager','manager_message_managment'),"controller"=>'managermessages',"action"=>"admin_index","action_name"=>__d('manager','message_list'));
$install_menu_query[] = array("name"=>__d('manager','manager_message_managment'),"controller"=>'managermessages',"action"=>"admin_add","action_name"=>__d('manager','add_message'));
$install_menu_query[] = array("name"=>__d('manager','manager_message_managment'),"controller"=>'managermessages',"action"=>"admin_edit","action_name"=>__d('manager','edit_message'));
$install_menu_query[] = array("name"=>__d('manager','manager_message_managment'),"controller"=>'managermessages',"action"=>"admin_delete","action_name"=>__d('manager','delete_message'));
$remove_menu_query[] = array("controller"=>'managermessages');

?>