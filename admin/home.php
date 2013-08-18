<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

// +-----------------------------------------------------------------------+
// | Home tab                                                              |
// +-----------------------------------------------------------------------+

// send variables to template
$template->assign(array(
  'skeleton' => $conf['skeleton'],
  'INTRO_CONTENT' => load_language('intro.html', SKELETON_PATH, array('return'=>true)),
  ));

// define template file
$template->set_filename('skeleton_content', realpath(SKELETON_PATH . 'admin/template/home.tpl'));
