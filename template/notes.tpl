{* Your file javascript () *}
{combine_script id="jquery.skeletonsnotes" load="footer" path="{$SKELETON_PATH}/js/notes.js"}

{* The HTML element to display in user modal
/!\ this id is important for the script *}
<textarea id="skeletons_textarea"></textarea>
<textarea id="skeletons_textarea2"></textarea>

{* The HTML Style 
/!\ For better integration display: none; your html element *}
{html_style}
  #skeletons_textarea,
  #skeletons_textarea2 {
    display: none;
    width: 100%;
    height: 100%;
    resize: none;
  }
{/html_style}