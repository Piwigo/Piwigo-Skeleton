{combine_css path=$SKELETON_PATH|@cat:"admin/template/style.css"}

<div class="titrePage">
	<h2>Skeleton</h2>
</div>

<form method="post" action="" class="properties">
<fieldset>
  <legend>{'What Skeleton can do for me?'|@translate}</legend>
  
  {$INTRO_CONTENT}
</fieldset>
  
</form>