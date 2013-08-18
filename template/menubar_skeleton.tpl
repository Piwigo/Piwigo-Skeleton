<dt>{$block->get_title()}</dt>
<dd>
  {'Menublock added by Skeleton plugin'|translate}
	<ul>{strip}
		{foreach from=$block->data item=link}
		<li><a href="{$link.URL}" title="{$link.TITLE}"{if isset($link.REL)} {$link.REL}{/if}>{$link.NAME}</a></li>
		{/foreach}
	{/strip}</ul>
</dd>
