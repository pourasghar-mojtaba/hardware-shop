<?php
/**
 * Setting Fixture
 */
class SettingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'site_title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'site_keywords' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 500, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'site_description' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 700, 'collate' => 'utf8_persian_ci', 'charset' => 'utf8'),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_persian_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'site_title' => 'Lorem ipsum dolor sit amet',
			'site_keywords' => 'Lorem ipsum dolor sit amet',
			'site_description' => 'Lorem ipsum dolor sit amet'
		),
	);

}
