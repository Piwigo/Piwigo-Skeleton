<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Configuration tab                                                     |
// +-----------------------------------------------------------------------+

// save config
if (isset($_POST['save_config']))
{
  $conf['skeleton'] = array(
    'option1' => intval($_POST['option1']),
    'option2' => isset($_POST['option2']),
    );
      
  conf_update_param('skeleton', serialize($conf['skeleton']));
  array_push($page['infos'], l10n('Information data registered in database'));
}

// send config to template
$template->assign(array(
  'skeleton' => $conf['skeleton'],
  ));

// define template file
$template->set_filename('skeleton_content', realpath(SKELETON_PATH . 'admin/template/config.tpl'));

?>