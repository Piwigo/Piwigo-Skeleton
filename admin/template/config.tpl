{combine_css path=$SKELETON_PATH|@cat:"admin/template/style.css"}

{footer_script}{literal}
jQuery('input[name="option2"]').change(function() {
  $('.option1').toggle();
});
{/literal}{/footer_script}

<div class="titrePage">
	<h2>Skeleton</h2>
</div>

<form method="post" action="" class="properties">
<fieldset>
  <legend>{'Common configuration'|@translate}</legend>
  
  <ul>
    <li>
      <label>
        <span class="property">
          {'Checkbox'|@translate}
          <a class="showInfo" title="{'Check me!'|@translate}">i</a>
        </span>
        <input type="checkbox" name="option2" value="1" {if $skeleton.option2}checked="checked"{/if}>
      </label>
    </li>
    <li class="option1" {if not $skeleton.option2}style="display:none;"{/if}>
      <label>
        <span class="property">{'Integer'|@translate}</span>
        <input type="text" name="option1" value="{$skeleton.option1}" size="4">
      </label>
    </li>
  </ul>
</fieldset>

<p style="text-align:left;"><input type="submit" name="save_config" value="{'Save Settings'|@translate}"></p>

</form>