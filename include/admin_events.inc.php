<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

/**
 * admin plugins menu link
 */
function skeleton_admin_plugin_menu_links($menu)
{
  $menu[] = array(
    'NAME' => l10n('Skeleton'),
    'URL' => SKELETON_ADMIN,
    );

  return $menu;
}

/**
 * add a tab on photo properties page
 */
function skeleton_tabsheet_before_select($sheets, $id)
{
  if ($id == 'photo')
  {
    $sheets['skeleton'] = array(
      'caption' => l10n('Skeleton'),
      'url' => SKELETON_ADMIN.'-photo&amp;image_id='.$_GET['image_id'],
      );
  }

  return $sheets;
}

/**
 * add a prefilter to the Batch Downloader
 */
function skeleton_add_batch_manager_prefilters($prefilters)
{
  $prefilters[] = array(
    'ID' => 'skeleton',
    'NAME' => l10n('Skeleton'),
    );

  return $prefilters;
}

/**
 * perform added prefilter
 */
function skeleton_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
  if ($prefilter == 'skeleton')
  {
    $query = '
SELECT id
  FROM '.IMAGES_TABLE.'
  ORDER BY RAND()
  LIMIT 20
;';
    $filter_sets[] = query2array($query, null, 'id');
  }

  return $filter_sets;
}

/**
 * add an action to the Batch Manager
 */
function skeleton_loc_end_element_set_global()
{
  global $template;

  /*
    CONTENT is optional
    for big contents it is advised to use a template file

    $template->set_filename('skeleton_batchmanager_action', realpath(SKELETON_PATH.'template/batchmanager_action.tpl'));
    $content = $template->parse('skeleton_batchmanager_action', true);
   */
  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'skeleton',
    'NAME' => l10n('Skeleton'),
    'CONTENT' => '<label><input type="checkbox" name="check_skeleton"> '.l10n('Check me!').'</label>',
    ));
}

/**
 * perform added action
 */
function skeleton_element_set_global_action($action, $collection)
{
  global $page;

  if ($action == 'skeleton')
  {
    if (empty($_POST['check_skeleton']))
    {
      $page['warnings'][] = l10n('Nothing appened, but you didn\'t check the box!');
    }
    else
    {
      $page['infos'][] = l10n('Nothing appened, but you checked the box!');
    }
  }
}
