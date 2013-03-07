<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

global $page, $template, $conf, $user, $tokens, $pwg_loaded_plugins;


# DO SOME STUFF HERE... or not !


$template->assign(array(
  'INTRO_CONTENT' => load_language('intro.html', SKELETON_PATH, array('return'=>true)),
  'SKELETON_PATH' => SKELETON_PATH,
  'SKELETON_ABS_PATH' => realpath(SKELETON_PATH).'/',
  ));

$template->set_filename('index', realpath(SKELETON_PATH . 'template/skeleton_page.tpl'));

?>