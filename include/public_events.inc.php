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
    
    // define body_id
    add_event_handler('loc_begin_page_header', 'skeleton_loc_begin_page_header');
  }
}

function skeleton_loc_begin_page_header()
{
  global $page;
  $page['body_id'] = 'theSkeletonPage';
}

/**
 * include public page
 */
function skeleton_loc_end_page()
{
  global $page, $template;

  if ( isset($page['section']) and $page['section']=='skeleton' )
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
    $template->add_index_button('<li>'.$button.'</li>', EVENT_HANDLER_PRIORITY_NEUTRAL);
  }
  else
  {
    $template->add_picture_button($button, EVENT_HANDLER_PRIORITY_NEUTRAL);
  }
}

/**
 * add link in existing menu
 */
function skeleton_blockmanager_apply1($menu_ref_arr)
{
  $menu = &$menu_ref_arr[0];  
  
  if ( ($block = $menu->get_block('mbMenu')) != null )
  {
    array_push($block->data, array(
      'URL' => SKELETON_PUBLIC,
      'TITLE' => l10n('Skeleton'),
      'NAME' => l10n('Skeleton'),
    ));
  }
}

/**
 * add a nbew menu block
 */
function skeleton_blockmanager_register_blocks($menu_ref_arr)
{
  $menu = &$menu_ref_arr[0];
  
  if ($menu->get_id() == 'menubar')
  {
    $menu->register_block(new RegisteredBlock('mbSkeleton', l10n('Skeleton'), 'skeleton'));
  }
}

/**
 * fill the added menu block
 */
function skeleton_blockmanager_apply2($menu_ref_arr)
{
  $menu = &$menu_ref_arr[0];
  
  if ( ($block = $menu->get_block('mbSkeleton')) != null )
  {
    global $template;
    
    $block->set_title(l10n('Skeleton'));
    
    $block->data['link1'] =
      array(
        'URL' => get_absolute_root_url(),
        'TITLE' => l10n('First link'),
        'NAME' => l10n('Link 1'),
        'REL'=> 'rel="nofollow"',
      );

    $block->data['link2'] =
      array(
        'URL' => SKELETON_PUBLIC,
        'TITLE' => l10n('Second link'),
        'NAME' => l10n('Link 2'),
      );
    
    $template->set_template_dir(SKELETON_PATH . 'template/');
    $block->template = 'menubar_skeleton.tpl';
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
  $replace = '<div id="Skeleton" class="imageInfo">
		<dt>{\'Skeleton\'|@translate}</dt>
		<dd style="color:orange;">{\'Piwigo rocks\'|@translate}</dd>
	</div>
'.$search;

  return str_replace($search, $replace, $content);
}
  

?>