<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

global $page, $template, $conf, $user, $tokens, $pwg_loaded_plugins;


# DO SOME STUFF HERE... or not !


$template->assign(array(
  // this is useful when having big blocks of text which must be translated
  // prefer separated HTML files over big lang.php files
  'INTRO_CONTENT' => load_language('intro.html', SKELETON_PATH, array('return'=>true)),
  'SKELETON_PATH' => SKELETON_PATH,
  'SKELETON_ABS_PATH' => realpath(SKELETON_PATH).'/',
  ));

$template->set_filename('skeleton_page', realpath(SKELETON_PATH . 'template/skeleton_page.tpl'));
$template->assign_var_from_handle('CONTENT', 'skeleton_page');
