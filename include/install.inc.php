<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

/**
 * The installation function is called by main.inc.php and maintain.inc.php
 * in order to install and/or update the plugin.
 *
 * That's why all operations must be conditionned :
 *    - use "if empty" for configuration vars
 *    - use "IF NOT EXISTS" for table creation
 *
 * Unlike the functions in maintain.inc.php, the name of this function must be unique
 * and not enter in conflict with other plugins.
 */

function skeleton_install() 
{
  global $conf, $prefixeTable;
  
  // add config parameter
  if (empty($conf['skeleton']))
  {
    $skeleton_default_config = serialize(array(
      'option1' => 10,
      'option2' => true,
      ));
  
    conf_update_param('skeleton', $skeleton_default_config);
    $conf['skeleton'] = $skeleton_default_config;
  }
  else
  {
    // if you need to test the "old" configuration you must check if not yet unserialized
    $old_conf = is_string($conf['skeleton']) ? unserialize($conf['skeleton']) : $conf['skeleton'];
  }
  
  // add a new table
	pwg_query('
CREATE TABLE IF NOT EXISTS `'. $prefixeTable .'skeleton` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field1` mediumint(8) DEFAULT NULL,
  `field2` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
;');

  // add a new column to existing table
  $result = pwg_query('SHOW COLUMNS FROM `'.IMAGES_TABLE.'` LIKE "skeleton";');
  if (!pwg_db_num_rows($result))
  {      
    pwg_query('ALTER TABLE `' . IMAGES_TABLE . '` ADD `skeleton` TINYINT(1) NOT NULL DEFAULT 0;');
  }

  // create a local directory
  if (!file_exists(PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/')) 
  {
    mkdir(PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/', 0755);
  }

}

?>