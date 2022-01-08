<?php
/*
Plugin Name: skeleton
Version: auto
Description: This is not a plugin. It's a skeleton for future plugins.
Plugin URI: auto
Author: Mistic
Author URI: http://www.strangeplanet.fr
Has Settings: true
*/

/**
 * This is the main file of the plugin, called by Piwigo in "include/common.inc.php" line 137.
 * At this point of the code, Piwigo is not completely initialized, so nothing should be done directly
 * except define constants and event handlers (see http://piwigo.org/doc/doku.php?id=dev:plugins)
 */

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


if (basename(dirname(__FILE__)) != 'skeleton')
{
  add_event_handler('init', 'skeleton_error');
  function skeleton_error()
  {
    global $page;
    $page['errors'][] = 'Skeleton folder name is incorrect, uninstall the plugin and rename it to "skeleton"';
  }
  return;
}


// +-----------------------------------------------------------------------+
// | Define plugin constants                                               |
// +-----------------------------------------------------------------------+
global $prefixeTable;

define('SKELETON_ID',      basename(dirname(__FILE__)));
define('SKELETON_PATH' ,   PHPWG_PLUGINS_PATH . SKELETON_ID . '/');
define('SKELETON_TABLE',   $prefixeTable . 'skeleton');
define('SKELETON_ADMIN',   get_root_url() . 'admin.php?page=plugin-' . SKELETON_ID);
define('SKELETON_PUBLIC',  get_absolute_root_url() . make_index_url(array('section' => 'skeleton')) . '/');
define('SKELETON_DIR',     PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'skeleton/');



// +-----------------------------------------------------------------------+
// | Add event handlers                                                    |
// +-----------------------------------------------------------------------+
// init the plugin
add_event_handler('init', 'skeleton_init');

/*
 * this is the common way to define event functions: create a new function for each event you want to handle
 */
if (defined('IN_ADMIN'))
{
  // file containing all admin handlers functions
  $admin_file = SKELETON_PATH . 'include/admin_events.inc.php';

  // new tab on photo page
  add_event_handler('tabsheet_before_select', 'skeleton_tabsheet_before_select',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new prefiler in Batch Manager
  add_event_handler('get_batch_manager_prefilters', 'skeleton_add_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('perform_batch_manager_prefilters', 'skeleton_perform_batch_manager_prefilters',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new action in Batch Manager
  add_event_handler('loc_end_element_set_global', 'skeleton_loc_end_element_set_global',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('element_set_global_action', 'skeleton_element_set_global_action',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}
else
{
  // file containing all public handlers functions
  $public_file = SKELETON_PATH . 'include/public_events.inc.php';

  // add a public section
  add_event_handler('loc_end_section_init', 'skeleton_loc_end_section_init',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_index', 'skeleton_loc_end_page',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // add button on album and photos pages
  add_event_handler('loc_end_index', 'skeleton_add_button',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_picture', 'skeleton_add_button',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // prefilter on photo page
  add_event_handler('loc_end_picture', 'skeleton_loc_end_picture',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
}

// file containing API function
$ws_file = SKELETON_PATH . 'include/ws_functions.inc.php';

// add API function
add_event_handler('ws_add_methods', 'skeleton_ws_add_methods',
    EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);


/*
 * event functions can also be wrapped in a class
 */

// file containing the class for menu handlers functions
$menu_file = SKELETON_PATH . 'include/menu_events.class.php';

// add item to existing menu (EVENT_HANDLER_PRIORITY_NEUTRAL+10 is for compatibility with Advanced Menu Manager plugin)
add_event_handler('blockmanager_apply', array('SkeletonMenu', 'blockmanager_apply1'),
  EVENT_HANDLER_PRIORITY_NEUTRAL+10, $menu_file);

// add a new menu block (the declaration must be done every time, in order to be able to manage the menu block in "Menus" screen and Advanced Menu Manager)
add_event_handler('blockmanager_register_blocks', array('SkeletonMenu', 'blockmanager_register_blocks'),
  EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);
add_event_handler('blockmanager_apply', array('SkeletonMenu', 'blockmanager_apply2'),
  EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);

// NOTE: blockmanager_apply1() and blockmanager_apply2() can (must) be merged


/**
 * plugin initialization
 *   - check for upgrades
 *   - unserialize configuration
 *   - load language
 */
function skeleton_init()
{
  global $conf;

  // load plugin language file
  load_language('plugin.lang', SKELETON_PATH);

  // prepare plugin configuration
  $conf['skeleton'] = safe_unserialize($conf['skeleton']);
}
