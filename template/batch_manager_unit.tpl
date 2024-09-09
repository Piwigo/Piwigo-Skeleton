{combine_script id="jquery.skeletonBatchManagerUnit" load="footer" path="{$SKELETON_PATH}/js/batch_manager_unit.js"}

{* This div works with Method 1 (see batch_manager_unit.js) *}
<div class="skeletons_input">
  <strong>{'Skeleton API Method'|translate}</strong>
  <input type="number" class="skeleton" name="Skeleton" min="0" max="1" value="{if isset($element.skeleton)}{$element.skeleton}{else}0{/if}">
  <label>Enter 0 or 1</label>
</div>

{* This div works with Method 2 (see batch_manager_unit.js)*}
<div class="skeletons_input">
  <strong>{'Skeleton pwg.images.setInfo Hook'|translate}</strong>
  <input type="number" class="skeleton2" name="Skeleton" min="0" max="1" value="{if isset($element.skeleton)}{$element.skeleton}{else}0{/if}">
  <label>Enter 0 or 1</label>
</div>

{html_style}
  .skeletons_input {
    flex: 0 0 calc(100% - 20px);
    margin: 0px 10px;
  }

  .skeletons_input strong {
    display: block;
    margin-bottom: 10px;
}

  .skeletons_input input {
      flex-direction:column;
      border: 1px solid #D3D3D3;
      background-color: #FFFFFF !important;
      border-radius: 2px;
      padding: 0 7px;
  }
{/html_style}