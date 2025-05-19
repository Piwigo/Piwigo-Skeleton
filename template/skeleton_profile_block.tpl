<div>
  <label for="text_input">Text</label>
  <div class="input-container">
    <input name="text_input" id="text_input" type="text" />
  </div>
</div>

<div>
  <label for="number_input">Number</label>
  <div class="input-container">
    <input name="number_input" id="number_input" type="number" />
  </div>
</div>

<div>
  <label for="date_input">Date</label>
  <div class="input-container">
    <input name="date_input" id="date_input" type="date" />
  </div>
</div>

<div>
  <label for="time_input">Hour</label>
  <div class="input-container">
    <input name="time_input" id="time_input" type="time" />
  </div>
</div>

<div>
  <label for="color_input">Color</label>
  <div class="input-container">
    <input name="color_input" id="color_input" type="color" />
  </div>
</div>

<div>
  <label for="checkbox_input">Accept the condition</label>
  <div class="input-container">
    <input name="checkbox_input" type="checkbox" value="1" />
  </div>
</div>

<div>
  <label for="radio_input">
    Choose an option
  </label>
  <div class="input-container">
    {html_radios name='radio_input' options=['option1', 'option2']}
  </div>
</div>

<div>
  <label for="select_input">Choose</label>
  <div class="input-container">
    <select name="select_input" id="select_input">
      <option value="">-- Choose one --</option>
      <option value="valeur1">Value 1</option>
      <option value="valeur2">Value 2</option>
    </select>
  </div>
</div>

<div>
  <label for="file_input">File</label>
  <div class="input-container">
    <input name="file_input" id="file_input" type="file" />
  </div>
</div>

<div>
  <label for="textarea_input">Message</label>
  <div class="input-container">
    <textarea name="textarea_input" id="textarea_input" rows="4"></textarea>
  </div>
</div>
