{combine_css path=$SKELETON_PATH|@cat:"template/style.css"}


{* <!-- add scripts here --> *}
{footer_script require='jquery'}{literal}
var reverse=0;
$("#test").click(function() {
  if (!reverse) {
    $("body").css('-moz-transform','rotate(180deg)');
    $("body").css('-webkit-transform','rotate(180deg)');
    $("body").css('-o-transform','rotate(180deg)');
    reverse=1;
  } else {
    $("body").css('-moz-transform','rotate(0deg)');
    $("body").css('-webkit-transform','rotate(0deg)');
    $("body").css('-o-transform','rotate(0deg)');
    reverse=0;
  }
});
{/literal}{/footer_script}


{* <!-- Menubar & titrePage --> *}
{if $themeconf.name == "stripped" or $themeconf.parent == "stripped"}
  {include file=$SKELETON_ABS_PATH|@cat:'template/themes/stripped.tpl'}
  {assign var="clear" value="true"}
{elseif $themeconf.name == "simple-grey" or $themeconf.parent == "simple"}
  {include file=$SKELETON_ABS_PATH|@cat:'template/themes/simple.tpl'}
  {assign var="clear" value="true"}
{else}
  {include file=$SKELETON_ABS_PATH|@cat:'template/themes/default.tpl'}
{/if}

{if isset($errors) or not empty($infos)}
{include file='infos_errors.tpl'}
{/if}


{* <!-- add page content here --> *}
<h1>{'What Skeleton can do for me?'|@translate}</h1>
<blockquote>
  {$INTRO_CONTENT}
</blockquote>

<div id="test">Click for fun</div>


{if $clear}<div style="clear: both;"></div>
</div>{/if}
</div>{* <!-- content --> *}