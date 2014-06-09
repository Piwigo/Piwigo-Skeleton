{strip}
{combine_css id="skeleton" path=$SKELETON_PATH|cat:"template/style.css"}

{* <!-- nothing more than the button itself must be defined here --> *}
<a href="javascript:alert('Hello world!');" title="{'This is not the %s you are looking for'|translate:('button'|translate)}" class="pwg-state-default pwg-button" rel="nofollow">
  <span class="pwg-icon skeleton-button"> </span>
  <span class="pwg-button-text">{'Skeleton'|translate}</span>
</a>
{/strip}