$(function() {
  // ==========================================================
  // How to add a new tab in the user modal?
  // ==========================================================
  // Step 1: Use the event to add your tpl (for this example: skeleton/template/notes.tpl)
  // to the “user_list” page (see the tpl to find out what you need to put there).
  // Example event => "add_event_handler('loc_end_admin', 'skeleton_add_tab_users_modal', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);"
  //
  // Then, follow Method 1 or Method 2 as explained below.
  
  // ==========================================================
  // Method 1: Adding a Tab with a Dedicated Function
  // ==========================================================
  // 1. Create a new table to store the data. To do this, 
  // go to the “install” function in the “maintain.class.php” file (found in plugins/skeleton/maintain.class.php)
  // and look at the example for “add a new table”.
  // Remember to also define the logic for deleting the table in the "uninstall" function.
  //
  // 2. Use the “ws_add_methods” event to add new API methods to get and set your data.
  // Example event => "add_event_handler('ws_add_methods', 'skeleton_ws_add_methods', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);"
  // 
  // NEW IN PIWIGO 15:
  // 3. Use the plugin_add_tab_in_user_modal function to add a new tab to the user modal with the following parameters:
  // => param 1 (string): Name of the tab
  // => param 2 (string): ID of the div or element to be added to the tab 
  // (your content should be coded in the first step by adding the tpl)
  // => param 3 (string or null): Name of the column in the user_infos table (IMPORTANT: this parameter must be null in this method)
  // => param 4 (function or null): Function to retrieve data from the plugin's HTML element and save it
  // => param 5 (function or null): Function to retrieve data from your API method and display it in the plugin's HTML element
  //
  // IMPORTANT: PARAM 3 MUST BE NULL IF PARAM 4 AND 5 ARE USED!
  plugin_add_tab_in_user_modal(
    'Skeleton Notes',
    'skeletons_textarea',
    null,
    () => {
      // Function to retrieve data from the HTML element and save it via your API method
      console.log('set data');
    },
    () => {
      // Function to retrieve data from the database via your API method and display it in the user modal tab
      console.log('get data skeletons_textarea');
    }
  );

  // ==========================================================
  // Method 2: Adding a Tab with a New Column in Users Table
  // ==========================================================
  // 1. Add a new column to the “users_infos” table for your plugin data.
  // To do this, go to the “install” function in the “maintain.class.php” file (found in plugins/skeleton/maintain.class.php)
  // and see the example for “add a new column to existing table (for users modal)”.
  // Remember to also define the logic for deleting the column in the "uninstall" function.
  //
  // 2. Use the “ws_invoke_allowed” and “ws_users_getList” events to add your parameter to the API methods users.setInfos and users.getInfos.
  // Example events: 
  // add_event_handler('ws_invoke_allowed', 'skeleton_ws_users_setInfo', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
  // add_event_handler('ws_users_getList', 'skeleton_ws_users_getList', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
  // Follow the examples in the respective functions “skeleton_ws_users_setInfo” and “skeleton_ws_users_getList”.
  //
  // NEW IN PIWIGO 15:
  // 3. Use the plugin_add_tab_in_user_modal function to add a new tab to the user modal with the following parameters:
  // => param 1 (string): Name of the tab
  // => param 2 (string): ID of the div or element to be added to the tab 
  // (your content should be coded in the first step by adding the tpl)
  // => param 3 (string or null): Name of the column in the user_infos table
  // => param 4 (function or null): Function to retrieve data from the plugin's HTML element and save it (IMPORTANT: this parameter 4 is null in this method)
  // => param 5 (function or null): Function to retrieve data from your API method and display it in the plugin's HTML element (IMPORTANT: this parameter 5 is null in this method)
  //
  // IMPORTANT: DO NOT PASS PARAM 4 AND 5 IF PARAM 3 IS USED!
  plugin_add_tab_in_user_modal(
    'Skeleton Notes v2',
    'skeletons_textarea2',
    'skeleton_notes'
  );
});