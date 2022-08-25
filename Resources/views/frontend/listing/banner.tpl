{if $smarty.server.REQUEST_URI == '/testing/'}
	<form action="{url controller="SwagControllerTest"}" method="post" style="    width: 100%;">
	    <div style="display:flex;align-items: flex-end;gap: 20px;">
	      <div>
	        <label for="length_input_filter" style="">Length</label>
	        <input type="text" id="length_input_filter" placement="Length" class="form-control" style="width: 100%;" name="length_input_filter">
	      </div>
	      <div>
	        <label for="height_input_filter">Height</label>
	        <input type="text" id="height_input_filter" placement="Height" class="form-control" style="width: 100%;" name="height_input_filter">
	      </div>
	      <div>
	        <label for="width_input_filter">Width</label>
	        <input type="text" id="width_input_filter" placement="Width" class="form-control" style="width: 100%;" name="width_input_filter">
	      </div>
	      <div>
	        <label></label>
	        <input type="submit" value="Submit" class="form-control" style="width: 100%;background: #e14711;border: transparent;padding: 10px;color: #fff;/* margin-top: 10px; */">
	      </div>
	    </div>
	    <div style="clear:both;"></div>
	</form>
	<br>

{/if}
