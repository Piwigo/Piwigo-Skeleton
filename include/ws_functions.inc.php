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

    //skeleton.setInfo method registration
    $service->addMethod(
      'skeleton.setInfo',
      'skeleton_ws_setInfo',
      array(
        'image_id' => array(
          'type' => WS_TYPE_INT | WS_TYPE_POSITIVE | WS_TYPE_NOTNULL,
        ),
        'skeleton' => array(
          'type' => WS_TYPE_INT | WS_TYPE_NOTNULL,
          'info' => 'Value to set for the skeleton field, should be 0 or 1',
        ),
      ),
      'Update the skeleton field in the piwigo_images table',
      null,
      array(
        'hidden' => false,
        'admin_only' => true,
        'post_only' => true,
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

// this function hooks to pwg.images.setInfo calls which contains skeleton data
// which allows to process additional data in a single HTTP request
function skeleton_ws_images_setInfo($res, $methodName, $params) {
  if ($methodName != 'pwg.images.setInfo') {
    return $res;
  }
  if (!isset($_POST['skeleton'])) {
    return $res;
  }
  if (empty($params['image_id'])) {
    return $res;
  }
  
  $image_id = $params['image_id'];
  $update = array(
    array(
      'id' => $image_id,
      'skeleton' => $_POST['skeleton'],
    )
  );
  mass_updates(
    IMAGES_TABLE,
    array(
      'primary' => array('id'),
      'update'  => array('skeleton')
    ),
    $update
  );
  return $res;
}

// function called by the API method skeleton.setInfo
function skeleton_ws_setInfo($params, &$service)
{
  if (!isset($params['image_id']) || !isset($params['skeleton'])) {
    return new PwgError(WS_ERR_INVALID_PARAM, 'Both image_id and skeleton value are required parameters.');
  }

  $image_id = intval($params['image_id']);
  $skeleton_value = intval($params['skeleton']);

  if ($skeleton_value !== 0 && $skeleton_value !== 1) {
    return new PwgError(WS_ERR_INVALID_PARAM, 'Invalid skeleton value. Must be 0 or 1.');
  }

  $query = '
    UPDATE '.IMAGES_TABLE.'
    SET skeleton = '.$skeleton_value.'
    WHERE id = '.$image_id.'
  ;';

  pwg_query($query);

  return array(
    'status' => 'success',
    'message' => 'Skeleton field updated successfully for picture ' . $image_id,
  );
}