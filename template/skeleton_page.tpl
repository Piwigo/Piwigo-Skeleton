{* <!-- load CSS files --> *}
{combine_css id="skeleton" path=$SKELETON_PATH|cat:"template/style.css"}

{* <!-- load JS files --> *}
{* {combine_script id="skeleton" require="jquery" path=$SKELETON_PATH|cat:"template/script.js"} *}

{* <!-- add inline JS --> *}
{footer_script require="jquery"}
  jQuery('#skeleton').on('click', function(){
    alert('{'Hello world!'|translate}');
  });
{/footer_script}

{* <!-- add inline CSS --> *}
{html_style}
  #skeleton {
    display:block;
  }
{/html_style}


{* <!-- add page content here --> *}
<h1>{'What Skeleton can do for me?'|translate}</h1>

<blockquote>
  {$INTRO_CONTENT}
</blockquote>

<div id="skeleton">{'Click for fun'|translate}</div>