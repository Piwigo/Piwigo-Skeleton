<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

function skeleton_ws_add_methods($arr)
{
  $service = &$arr[0];
  
  $service->addMethod(
    'pwg.PHPinfo',
    'ws_php_info',
    array(
      'what' => array('default'=> 'INFO_ALL'),
      ),
    'Returns phpinfo (don\'t use XML request format)'
    );
}

function ws_php_info($params, &$service)
{
  if (!is_admin())
  {
    return new PwgError(403, 'Forbidden');
  }
  
  return phpinfo(constant($params['what']));
}


?>