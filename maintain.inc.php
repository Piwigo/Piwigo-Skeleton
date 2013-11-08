<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin
 */
class skeleton_maintain extends PluginMaintain
{
  /*
   * My pattern uses a single installation method, which handles both installation
   * and activation, where Piwigo always calls 'activate' just after 'install'
   * As a result I use a marker in order to not execute the installation method twice
   *
   * The installation function is called by main.inc.php and maintain.inc.php
   * in order to install and/or update the plugin.
   *
   * That's why all operations must be conditionned :
   *    - use "if empty" for configuration vars
   *    - use "IF NOT EXISTS" for table creation
   */
  private $installed = false;

  /**
   * plugin installation
   *
   * perform here all needed step for the plugin installation
   * such as create default config, add database tables,
   * add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    global $conf, $prefixeTable;

    // add config parameter
    if (empty($conf['skeleton']))
    {
      $conf['skeleton'] = serialize(array(
        'option1' => 10,
        'option2' => true,
        'option3' => 'two',
        ));

      conf_update_param('skeleton', $conf['skeleton']);
    }
    else
    {
      // if you need to test the "old" configuration you must check if not yet unserialized
      $old_conf = is_string($conf['skeleton']) ? unserialize($conf['skeleton']) : $conf['skeleton'];

      if (empty($old_conf['option3']))
      { // use case: this parameter was added in a new version
        $old_conf['option3'] = 'two';
      }

      $conf['skeleton'] = serialize($old_conf);
      conf_update_param('skeleton', $conf['skeleton']);
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

    $this->installed = true;
  }

  /**
   * plugin activation
   *
   * this function is triggered after installation, by manual activation
   * or after a plugin update
   * for this last case you must manage updates tasks of your plugin in this function
   */
  function activate($plugin_version, &$errors=array())
  {
    if (!$this->installed)
    {
      $this->install($plugin_version, $errors);
    }
  }

  /**
   * plugin deactivation
   *
   * triggered before uninstallation or by manual deactivation
   */
  function deactivate()
  {
  }

  /**
   * plugin uninstallation
   *
   * perform here all cleaning tasks when the plugin is removed
   * you should revert all changes made by 'install'
   */
  function uninstall()
  {
    global $prefixeTable;

    // delete configuration
    conf_delete_param('skeleton');

    // delete table
    pwg_query('DROP TABLE `'. $prefixeTable .'skeleton`;');

    // delete field
    pwg_query('ALTER TABLE `'. IMAGES_TABLE .'` DROP `skeleton`;');

    // delete local folder
    // use a recursive function if you plan to have nested directories
    $dir = PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/';
    foreach (scandir($dir) as $file)
    {
      if ($file == '.' or $file == '..') continue;
      unlink($dir.$file);
    }
    rmdir($dir);
  }
}