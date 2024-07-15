$(function() {
  // /**
  // * Adds a new tab to the user's modal
  // *
  // * function plugin_add_tab_in_user_modal
  // *
  // * @param {string} tab_name - The tab name (will also be used for the new tab id)
  // * @param {string} content_id - The id of the HTML element
  // * @param {string | null} users_table  - The name of the column created in the 
  //            users table (must be null if the set_data_function and get_data_function 
  //            functions are used)
  // * @param {() => {} | null} set_data_function - API call set function with ajax (must
  //             be null if users_table is used)
  // * @param {() => {} | null} get_data_function - API call get function with ajax (must
  //             be null if users_table is used)
  //* @returns {void} Displays the new tab in the user's modal
  //*/

  // Method 1 
  plugin_add_tab_in_user_modal(
    'Skeleton Notes',
    'skeletons_textarea',
    null,
    () => {
      console.log('set data');
    },
    () => {
      console.log('get data skeletons_textarea');
    }
  );

  // Method 2 with new column in users table
  plugin_add_tab_in_user_modal(
    'Skeleton Notes v2',
    'skeletons_textarea2',
    'skeleton_notes'
  );
});