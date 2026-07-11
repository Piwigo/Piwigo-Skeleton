{combine_css path=$SKELETON_PATH|@cat:"admin/template/style.css"}
{combine_script id='common' load='footer' path='admin/themes/default/js/common.js'}

{footer_script}
jQuery('input[name="option2"]').change(function() {
  $('.option1').toggle();
});
{/footer_script}


<form method="post" action="" class="properties">

<fieldset class="mainConf">
  <legend><span class="icon-cog icon-purple"></span>{'Common configuration'|translate}</legend>

  <ul>
    <li>
      <label class="font-checkbox">
        <span class="icon-check"></span>
        <input type="checkbox" name="option2" value="1" {if $skeleton.option2}checked="checked"{/if}>
        {'Checkbox'|translate}
      </label>
      <span class="icon-help-circled tiptip" title="{'Check me!'|translate}" style="cursor:help"></span>
    </li>

    <li class="option1" {if not $skeleton.option2}style="display:none;"{/if}>
      <label>
        <b>{'Integer'|translate}</b>
        <input type="text" name="option1" value="{$skeleton.option1}" size="4">
      </label>
    </li>
  </ul>
</fieldset>

<fieldset class="mainConf">
  <legend><span class="icon-wrench icon-yellow"></span>{'Secondary configuration'|translate}</legend>
  <ul>
    <li>
      <label>
        <b>{'Select'|translate}</b>
        {html_options name=option3 options=$select_options selected=$skeleton.option3}
      </label>
    </li>
  </ul>
</fieldset>

<div class="savebar-footer">
  <div class="savebar-footer-start">
  </div>
  <div class="savebar-footer-end">

{if isset($save_success)}
  <div class="savebar-footer-block">
    <div class="badge info-message">
      <i class="icon-ok-circled"></i>{$save_success}
    </div>
  </div>
{/if}
{if isset($save_error)}
  <div class="savebar-footer-block">
    <div class="badge info-warning">
      <i class="icon-warning-circled"></i>{$save_error}
    </div>
  </div>
{/if}
    
  <div class="savebar-footer-block">
    <button class="buttonLike"  type="submit" name="save_config"><i class="icon-floppy"></i> {'Save Settings'|translate}</button>
  </div>
</div>

</form>