<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

function skeleton_ws_add_methods($arr)
{
  $service = &$arr[0];

  // only the first two parameters are mandatory
  $service->addMethod(
    'pwg.PHPinfo', // method name
    'ws_php_info', // linked PHP function
    array( // list of parameters
      'what' => array(
        'default' => 'INFO_ALL', // default value
        'info' => 'This parameter has a default value', // parameter description
        ),
      'ids' => array(
        'flags' => WS_PARAM_OPTIONAL|WS_PARAM_FORCE_ARRAY, // flags are WS_PARAM_OPTIONAL, WS_PARAM_ACCEPT_ARRAY, WS_PARAM_FORCE_ARRAY
        'type' => WS_TYPE_INT|WS_TYPE_POSITIVE|WS_TYPE_NOTNULL, // types are WS_TYPE_BOOL, WS_TYPE_INT, WS_TYPE_FLOAT, WS_TYPE_POSITIVE, WS_TYPE_NOTNULL, WS_TYPE_ID
        'info' => 'This one must be an array',
        ),
      'count' => array(
        'flags' => WS_PARAM_OPTIONAL,
        'type' => WS_TYPE_INT|WS_TYPE_POSITIVE,
        'maxValue' => 100, // maximum value for ints and floats
        ),
      ),
    'Returns phpinfo', // method description
    null, // file to include after param check and before function exec
    array(
      'hidden' => false, // you can hide your method from reflection.getMethodList method
      'admin_only' => true, // you can restrict access to admins only
      'post_only' => false, // you can disallow GET resquests for this method
      )
    );
}

function ws_php_info($params, &$service)
{
  return phpinfo(constant($params['what']));
}

// add method for users modal
function skeleton_ws_users_getList($users){
  $user_ids = array();
  foreach ($users as $user_id => $user){
    $user_ids[] = $user_id;
  }
  if (count($user_ids) == 0){
    return $users;
  }
  $query = '
    SELECT
      user_id,
      skeleton_notes
    FROM '.USER_INFOS_TABLE.'
      WHERE user_id IN ('.implode(',', $user_ids).')
  ;';
  $result = pwg_query($query);
  while ($row = pwg_db_fetch_assoc($result)){
    $users[$row['user_id']]['skeleton_notes'] = $row['skeleton_notes'];
  }
  return $users;
}

function skeleton_ws_users_setInfo($res, $methodName, $params){
  if ($methodName != 'pwg.users.setInfo'){
    return $res;
  }
  if (!isset($_POST['skeleton_notes'])){
    return $res;
  }
  if (count($params['user_id']) == 0){
    return $res;
  }
  
  $updates = array();

  foreach ($params['user_id'] as $user_id){
    $updates[] = array(
      'user_id' => $user_id,
      'skeleton_notes' => $_POST['skeleton_notes'],
    );
  }
  if (count($updates) > 0){
    mass_updates(
      USER_INFOS_TABLE,
      array(
        'primary' => array('user_id'),
        'update'  => array('skeleton_notes')
      ),
      $updates
    );
  }
  return $res;
}