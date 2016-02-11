<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">Address 1</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" name="addr1" id="addr1" value="<?php echo $addr1;?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">Address 2 / Landmark</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" name="addr2" id="addr2" value="<?php echo $addr2;?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">City</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" name="city" id="city" value="<?php echo $city;?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">State</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" name="state" id="state" value="<?php echo $state;?>"/>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">Country</label>
	<div class="col-sm-10">
		<select class="form-control" name="country" id="country">
		   <!-- <option value="">-- Select --</option>-->
		    <?php 
		    	$country_data = $this->config->item('country');
		    	foreach($country_data as $key => $value){
		    		if($key == $country)
					echo "<option value='".$key."' selected='true'>".$value."</option>";
					else
					echo "<option value='".$key."'>".$value."</option>";
				}
		    ?>
	  </select>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 col-sm-2 control-label">Pin Code</label>
	<div class="col-sm-10">
	<input type="text" class="form-control" name="pincode" id="pincode" value="<?php echo $pincode;?>"/>
	</div>
</div>