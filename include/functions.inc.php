<?php
defined('SKELETON_PATH') or die('Hacking attempt!');

// you can add something here :-)

// profile simple save in block for POST AND AJAX
function save_generic_profile($params)
{
  $required = [
    'text_input', 'number_input', 'date_input', 'time_input',
    'color_input', 'checkbox_input', 'radio_input', 'select_input',
    'file_input', 'textarea_input'
  ];
  
  foreach ($required as $key) {
    if (!isset($params[$key])) {
      return array('success' => false, 'message' => "Missing parameter: $key");
    }
  }

  // save data in database...

  return array('success' => true);
}