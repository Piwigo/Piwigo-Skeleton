{combine_css path=$SKELETON_PATH|@cat:"admin/template/style.css"}

<h2>{$TITLE} &#8250; {'Edit photo'|translate} {$TABSHEET_TITLE}</h2>


<form action="{$F_ACTION}" method="post" id="catModify">
  <fieldset>
    <legend>{'My awesome photo tab'|translate}</legend>

    <p>
      <img src="{$TN_SRC}" alt="{'Thumbnail'|translate}" class="Thumbnail">
    </p>

    <p>
      <input class="submit" type="submit" value="{'Save'|translate}" name="save_skeleton">
    </p>
  </fieldset>
</form>