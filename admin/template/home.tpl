{combine_css path=$SKELETON_PATH|@cat:"admin/template/style.css"}

{html_style}
  fieldset.mainConf p {
    text-align:left;
  }
{/html_style}

<fieldset class="mainConf">
  <legend><span class="icon-fire icon-purple"></span>{'Are you creating a plugin for Piwigo?'|translate}</legend>
  <p>{'If not, this plugin is totally useless and you should delete it!'|translate}</p>
</fieldset>

<fieldset class="mainConf">
  <legend><span class="icon-heart icon-red"></span>{'You want to develop a Piwigo plugin?'|translate}</legend>

  <p>{'This plugin is an example of a simple plugin structure, but with cool options:'|translate}</p>

  <ul>
    <li>{'Multilingual plugin'|translate}</li>
    <li>{'Installation and upgrade process'|translate}</li>
    <li>{'Administration page'|translate}</li>
    <li>{'Public page'|translate}</li>
    <li>{'Add tabs to core admin pages'|translate}</li>
    <li>{'Add filters and actions to the Batch Manager'|translate}</li>
    <li>{'Simple template prefilter (on picture.php page)'|translate}</li>
    <li>{'Add new method to the API'|translate}</li>
    <li>{'Add a toolbar button'|translate}</li>
  </ul>
</fieldset>

<fieldset class="mainConf">
  <legend><span class="icon-key icon-green"></span>{'Licensing'|translate}</legend>

  <p>{'This work is in the public domain, without any license, you can entirely re-use it and say it\'s your own work :-)'|translate}</p>

</fieldset>