<?php

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));
define('__SITE_URL',"http://".$_SERVER['HTTP_HOST'].'/hardwareshop/');
$site_path = realpath(dirname(__FILE__));

define('__UPLOAD_IMAGE_MAX_SIZE',2024000);
define('__UPLOAD_IMAGE_MAX_HEIGHT',20240);
define('__UPLOAD_IMAGE_MAX_WIDTH',20240);
define('__UPLOAD_IMAGE_EXTENSION',"jpg,png");
define('__UPLOAD_PDF_EXTENSION',"pdf");
define('__UPLOAD_File_EXT',"doc,docx,pdf,zip,mkv,mp4");
define('__UPLOAD_FILE_MAX_SIZE',5097152);
define('__UPLOAD_PDF_MAX_SIZE',5097152);
define('__UPLOAD_THUMB',"thumb");

define ('__SITE_PATH', $site_path.DS);
define("__BackUp_Path","uploads".DS."backup".DS);
define("__USER_IMAGE_PATH","uploads/users/");
define("__SALES_AGENCY_PATH","uploads/agencies/");
define ('__PLUGINS', ROOT . DS . 'plugins' . DS);

define('__ADMIN_LANG_INDEX',"admin_lang");
define('__ADMIN_LANG_DEFAULT_ID',"1");

define ('__USER_LOCAL','user');
define ('__USER','user/');
define ('__THEME','Beheshti');
define ('__THEME_PATH','theme/'.__THEME.'/');
define ('__THEME_ELEMENT',__USER.__THEME.DS);
define ('__IMAGE_PATH','img/'.__USER);
define ('__THEME_PLUGINS', ROOT . DS . 'app' . DS. 'View' . DS. 'Themed' . DS.__THEME. DS.'Plugins'. DS);

define("__SMS_USER","1111");
define("__SMS_PASSWORD","1111");
define("__SMS_COMMON_CODE","9889");
define("__LINE_NUMBER","982122381359");
define("__SMS_WEB_SERVICE_ADDRESS","http://ip.sms.ir/ws/SendReceive.asmx?wsdl");

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));
App::uses('PluginHandler', 'Lib');
PluginHandler::Instance()->load();
?>
