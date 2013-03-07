<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

defined('SKELETON_ID') or define('SKELETON_ID', basename(dirname(__FILE__)));
include_once(PHPWG_PLUGINS_PATH . SKELETON_ID . '/include/install.inc.php');

/**
 * plugin installation
 *
 * perform here all needed step for the plugin installation
 * such as create default config, add database tables, 
 * add fields to existing tables, create local folders...
 */
function plugin_install() 
{
  skeleton_install();
  define('skeleton_installed', true);
}

/**
 * plugin activation
 *
 * this function is triggered adter installation, by manual activation
 * or after a plugin update
 * for this last case you must manage updates tasks of your plugin in this function
 */
function plugin_activate()
{
  if (!defined('skeleton_installed')) // a plugin is activated just after its installation
  {
    skeleton_install();
  }
}

/**
 * plugin unactivation
 *
 * triggered before uninstallation or by manual unactivation
 */
function plugin_unactivate()
{
}

/**
 * plugin uninstallation
 *
 * perform here all cleaning tasks when the plugin is removed
 * you should revert all changes made by plugin_install()
 */
function plugin_uninstall() 
{
  global $prefixeTable;
  
  // delete configuration
  pwg_query('DELETE FROM `'. CONFIG_TABLE .'` WHERE param = "skeleton" LIMIT 1;');
  
  // delete table
  pwg_query('DROP TABLE `'. $prefixeTable .'skeleton`;');
  
  // delete field
  pwg_query('ALTER TABLE `'. IMAGES_TABLE .'` DROP `skeleton`;');
  
  // delete local folder
  $dir = PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/';
  foreach (scandir($dir) as $file)
  {
    if ($file == '.' or $file == '..') continue;
    unlink($dir.$file);
  }
  rmdir($dir);
}

?>