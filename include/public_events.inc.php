<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

/**
 * detect current section
 */
function skeleton_loc_end_section_init()
{
  global $tokens, $page, $conf;

  if ($tokens[0] == 'skeleton')
  {
    $page['section'] = 'skeleton';

    // section_title is for breadcrumb, title is for page <title>
    $page['section_title'] = '<a href="'.get_absolute_root_url().'">'.l10n('Home').'</a>'.$conf['level_separator'].'<a href="'.SKELETON_PUBLIC.'">'.l10n('Skeleton').'</a>';
    $page['title'] = l10n('Skeleton');

    $page['body_id'] = 'theSkeletonPage';
    $page['is_external'] = true; // inform Piwigo that you are on a new page
  }
}

/**
 * include public page
 */
function skeleton_loc_end_page()
{
  global $page, $template;

  if (isset($page['section']) and $page['section']=='skeleton')
  {
    include(SKELETON_PATH . 'include/skeleton_page.inc.php');
  }
}

/*
 * button on album and photos pages
 */
function skeleton_add_button()
{
  global $template;

  $template->assign('SKELETON_PATH', SKELETON_PATH);
  $template->set_filename('skeleton_button', realpath(SKELETON_PATH.'template/my_button.tpl'));
  $button = $template->parse('skeleton_button', true);

  if (script_basename()=='index')
  {
    $template->add_index_button($button, BUTTONS_RANK_NEUTRAL);
  }
  else
  {
    $template->add_picture_button($button, BUTTONS_RANK_NEUTRAL);
  }
}

/**
 * add a prefilter on photo page
 */
function skeleton_loc_end_picture()
{
  global $template;

  $template->set_prefilter('picture', 'skeleton_picture_prefilter');
}

function skeleton_picture_prefilter($content)
{
  $search = '{if $display_info.author and isset($INFO_AUTHOR)}';
  $replace = '
<div id="Skeleton" class="imageInfo">
  <dt>{\'Skeleton\'|@translate}</dt>
  <dd style="color:orange;">{\'Piwigo rocks\'|@translate}</dd>
</div>
';

  return str_replace($search, $replace.$search, $content);
}

/**
 * add a block in profile page
 */
function skeleton_add_profile_block()
{
  global $template;

  $block = array(
    'name' => 'Profile Skeleton',
    'desc' => 'This is the simplest example to add block in plugin',
    'template' => 'plugins/' . SKELETON_ID . '/template/skeleton_profile_block.tpl',
    'standard_show_save' => true
  );
  $template->append('PLUGINS_PROFILE', $block);
}

/**
 * save data in the theme profile page
 */
function skeleton_profile_save($user_id)
{
  unset($_POST['mail_address']);
  unset($_POST['password']);
  unset($_POST['use_new_pwd']);
  unset($_POST['passwordConf']);
  unset($_POST['nb_image_page']);
  unset($_POST['theme']);
  unset($_POST['language']);
  unset($_POST['recent_period']);
  unset($_POST['expand']);
  unset($_POST['show_nb_comments']);
  unset($_POST['show_nb_hits']);
  unset($_POST['pwg_token']);

  echo '<pre>';
  echo print_r('POST FROM SKELETON PLUGIN <br />');
  echo print_r(save_generic_profile($_POST));
  echo print_r($_POST);
  echo '</pre>';
  exit;
}