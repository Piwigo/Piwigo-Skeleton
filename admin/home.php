<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Home tab                                                              |
// +-----------------------------------------------------------------------+

// send variables to template
$template->assign(array(
  'skeleton' => $conf['skeleton'],
  ));

$page['messages'][] = l10n('What Skeleton can do for me?');

// define template file
$template->set_filename('skeleton_content', realpath(SKELETON_PATH . 'admin/template/home.tpl'));
