<?php
defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

/**
 * This class is used to expose maintenance methods to the plugins manager
 * It must extends PluginMaintain and be named "PLUGINID_maintain"
 * where PLUGINID is the directory name of your plugin.
 */
class skeleton_maintain extends PluginMaintain
{
  private $default_conf = array(
    'option1' => 10,
    'option2' => true,
    'option3' => 'two',
    );

  private $table;
  private $dir;

  function __construct($plugin_id)
  {
    parent::__construct($plugin_id); // always call parent constructor

    global $prefixeTable;

    // Class members can't be declared with computed values so initialization is done here
    $this->table = $prefixeTable . 'skeleton';
    $this->dir = PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/';
  }

  /**
   * Plugin installation
   *
   * Perform here all needed step for the plugin installation such as create default config,
   * add database tables, add fields to existing tables, create local folders...
   */
  function install($plugin_version, &$errors=array())
  {
    global $conf;

    // add config parameter
    if (empty($conf['skeleton']))
    {
      // conf_update_param well serialize and escape array before database insertion
      // the third parameter indicates to update $conf['skeleton'] global variable as well
      conf_update_param('skeleton', $this->default_conf, true);
    }
    else
    {
      $old_conf = safe_unserialize($conf['skeleton']);

      if (empty($old_conf['option3']))
      { // use case: this parameter was added in a new version
        $old_conf['option3'] = 'two';
      }

      conf_update_param('skeleton', $old_conf, true);
    }

    // add a new table
    pwg_query('
CREATE TABLE IF NOT EXISTS `'. $this->table .'` (
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
    if (!file_exists($this->dir))
    {
      mkdir($this->dir, 0755);
    }
  }

  /**
   * Plugin activation
   *
   * This function is triggered after installation, by manual activation or after a plugin update
   * for this last case you must manage updates tasks of your plugin in this function
   */
  function activate($plugin_version, &$errors=array())
  {
  }

  /**
   * Plugin deactivation
   *
   * Triggered before uninstallation or by manual deactivation
   */
  function deactivate()
  {
  }

  /**
   * Plugin (auto)update
   *
   * This function is called when Piwigo detects that the registered version of
   * the plugin is older than the version exposed in main.inc.php
   * Thus it's called after a plugin update from admin panel or a manual update by FTP
   */
  function update($old_version, $new_version, &$errors=array())
  {
    // I (mistic100) chosed to handle install and update in the same method
    // you are free to do otherwize
    $this->install($new_version, $errors);
  }

  /**
   * Plugin uninstallation
   *
   * Perform here all cleaning tasks when the plugin is removed
   * you should revert all changes made in 'install'
   */
  function uninstall()
  {
    // delete configuration
    conf_delete_param('skeleton');

    // delete table
    pwg_query('DROP TABLE `'. $this->table .'`;');

    // delete field
    pwg_query('ALTER TABLE `'. IMAGES_TABLE .'` DROP `skeleton`;');

    // delete local folder
    // use a recursive function if you plan to have nested directories
    foreach (scandir($this->dir) as $file)
    {
      if ($file == '.' or $file == '..') continue;
      unlink($this->dir.$file);
    }
    rmdir($this->dir);
  }
}