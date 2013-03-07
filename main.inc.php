<?php 
/*
Plugin Name: skeleton
Version: auto
Description: This is not a plugin. It's a skeleton for future plugins.
Plugin URI: auto
Author: Mistic
Author URI: http://www.strangeplanet.fr
*/

/**
 * This is te main file of the plugin, called by Piwigo in "include/common.inc.php" line 137.
 * At this point of the code, Piwigo is not completely initialized, so nothing should be done directly
 * except define constants and event handlers (see http://piwigo.org/doc/doku.php?id=dev:plugins)
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

global $prefixeTable;

// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
defined('SKELETON_ID') or define('SKELETON_ID', basename(dirname(__FILE__)));
define('SKELETON_PATH' ,   PHPWG_PLUGINS_PATH . SKELETON_ID . '/');
define('SKELETON_TABLE',   $prefixeTable . 'skeleton');
define('SKELETON_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . SKELETON_ID);
define('SKELETON_PUBLIC',  get_absolute_root_url() . make_index_url(array('section' => 'skeleton')) . '/');
define('SKELETON_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/');
define('SKELETON_VERSION', 'auto');
// this is automatically updated by PEM if you publish your plugin with SVN, otherwise you musn't forget to change it, as well as "Version" in the plugin header


// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'skeleton_init');

if (defined('IN_ADMIN'))
{
  // admin plugins menu link
  add_event_handler('get_admin_plugin_menu_links', 'skeleton_admin_plugin_menu_links');
  
  // new tab on photo page
  add_event_handler('tabsheet_before_select', 'skeleton_tabsheet_before_select', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
  
  // new prefiler in Batch Manager
  add_event_handler('get_batch_manager_prefilters', 'skeleton_add_batch_manager_prefilters');
  add_event_handler('perform_batch_manager_prefilters', 'skeleton_perform_batch_manager_prefilters', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
  
  // new action in Batch Manager
  add_event_handler('loc_end_element_set_global', 'skeleton_loc_end_element_set_global');
  add_event_handler('element_set_global_action', 'skeleton_element_set_global_action', EVENT_HANDLER_PRIORITY_NEUTRAL, 2);
  
  // file containing all previous handlers functions
  include_once(SKELETON_PATH . 'include/admin_events.inc.php');
}
else
{
  // add a public section
  add_event_handler('loc_end_section_init', 'skeleton_loc_end_section_init');
  add_event_handler('loc_end_index', 'skeleton_loc_end_page');
  
  // add item to existing menu (EVENT_HANDLER_PRIORITY_NEUTRAL+10 is for compatibility with Advanced Menu Manager)
  add_event_handler('blockmanager_apply', 'skeleton_blockmanager_apply1', EVENT_HANDLER_PRIORITY_NEUTRAL+10);
  
  // add a new menu block
  add_event_handler('blockmanager_register_blocks', 'skeleton_blockmanager_register_blocks');
  add_event_handler('blockmanager_apply', 'skeleton_blockmanager_apply2');
  // NOTE: skeleton_blockmanager_apply1() and skeleton_blockmanager_apply2() can (should) be merged
  
  // add button on album and photos pages
  add_event_handler('loc_end_index', 'skeleton_add_button');
  add_event_handler('loc_end_picture', 'skeleton_add_button');
  
  // prefilter on photo page
  add_event_handler('loc_end_picture', 'skeleton_loc_end_picture');
  
  // file containing all previous handlers functions
  include_once(SKELETON_PATH . 'include/public_events.inc.php');
}

// add API function
add_event_handler('ws_add_methods', 'skeleton_ws_add_methods');


// files containing specific plugin functions
include_once(SKELETON_PATH . 'include/functions.inc.php');
include_once(SKELETON_PATH . 'include/ws_functions.inc.php');




/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
function skeleton_init()
{
  global $conf, $pwg_loaded_plugins;
  
  // apply upgrade if needed
  if (
    SKELETON_VERSION == 'auto' or
    $pwg_loaded_plugins[SKELETON_ID]['version'] == 'auto' or
    version_compare($pwg_loaded_plugins[SKELETON_ID]['version'], SKELETON_VERSION, '<')
  )
  {
    // call install function
    include_once(SKELETON_PATH . 'include/install.inc.php');
    skeleton_install();
    
    // update plugin version in database
    if ( $pwg_loaded_plugins[SKELETON_ID]['version'] != 'auto' and SKELETON_VERSION != 'auto' )
    {
      $query = '
UPDATE '. PLUGINS_TABLE .'
SET version = "'. SKELETON_VERSION .'"
WHERE id = "'. SKELETON_ID .'"';
      pwg_query($query);
      
      $pwg_loaded_plugins[SKELETON_ID]['version'] = SKELETON_VERSION;
      
      if (defined('IN_ADMIN'))
      {
        $_SESSION['page_infos'][] = 'Skeleton updated to version '. SKELETON_VERSION;
      }
    }
  }
  
  // load plugin language file
  load_language('plugin.lang', SKELETON_PATH);
  
  // prepare plugin configuration
  $conf['skeleton'] = unserialize($conf['skeleton']);
}

?>