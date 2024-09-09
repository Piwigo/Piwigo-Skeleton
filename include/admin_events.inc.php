<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

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

/**
 * add template for a tab in users modal
 */
function skeleton_add_tab_users_modal()
{
  global $page, $template;

  if ('user_list' === $page['page'])
  {
    $template->set_filename('skeleton_notes', realpath(SKELETON_PATH.'template/notes.tpl'));
    $template->assign(array(
      'SKELETON_PATH' => SKELETON_PATH,
    ));
    $template->parse('skeleton_notes');
  }
}

/**
 * add a prefilter on batch manager unit
 * 
 * PLUGINS_BATCH_MANAGER_UNIT_ELEMENT_SUBTEMPLATE is the hook for your HTML injection in the batch manager unit mode page
 * 
 * If your data is located within the piwigo_images table in the database it will be loaded by default with the template and doesn't need to be pre-assigned here
 * You can directly use it by calling $element.[dataName] in your template
 */
function skeleton_loc_end_element_set_unit()
{
    global $template, $page;
    
    $template->assign(array(
        'SKELETON_PATH' => SKELETON_PATH,
    ));
    $template->append('PLUGINS_BATCH_MANAGER_UNIT_ELEMENT_SUBTEMPLATE', 'plugins/skeleton/template/batch_manager_unit.tpl');
}

