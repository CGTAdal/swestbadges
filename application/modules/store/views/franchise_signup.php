<link rel="stylesheet" href="<?php echo base_url();?>application/views/front_end/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine.js" charset="utf-8"></script>
<form action="" method="post" id="signup-form">
	<div class="login">
		<a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>application/views/front_end/images/logo.jpg" class="mb-20"/></a>
		<br/>
		<a href="<?php echo base_url();?>"><img class="mb-60" src="<?php echo base_url();?>application/views/front_end/images/namebadge.png"></a>
		<div class="fc-signup">
			<!-- <label>
				<span class="required">Centre Number:</span>
				<input type="text" name="number" id="number" class="validate[required, ajax[ajaxCheckAccountNumber]]"/>
			</label> -->
			<!-- <div class="small-red-heading">You must be a Pilot or Flight Attendant to purchase these items. Orders will be verified.</div> -->
			<label>
				<span class="required">Name:</span>
				<input type="text" name="name" id="" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Email:</span>
				<input type="text" name="email" id="email" class="validate[required, custom[email], ajax[ajaxCheckEmailExists]]"/>
			</label>
			<label>
				<span class="required">Password:</span>
				<input type="password" name="password" id="password" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Confirm Password:</span>
				<input type="password" name="" id="confirm_password" class="validate[required, equals[password]]"/>
			</label>			
			<label>
				<span class="required">Phone:</span>
				<input type="text" name="phone" id="" class="validate[required]" />
			</label>
			<label>
				<span class="required">Mailing Address:</span>
				<input type="text" name="mailing_address" id="mailing_address" class="validate[required]"/>
			</label>
			<label>
				<span>Address Line 2:</span>
				<input type="text" name="line2" id=""/>
			</label>
			<label>
				<span class="required">City:</span>
				<input type="text" name="city" id="city" class="validate[required]"/>
			</label>
			<label>
				<span class="required">State:</span>
				<!-- commented by sunny 18-march-2016 -->
				<!-- <input type="text" name="state" id="state" class="validate[required]"/> -->
				<select name="state" id="state" class="validate[required] sb-setstatecss">
					<option value="">Select State</option>
					<?php 
						foreach ($states as $key => $state) {
					?>
					<option value="<?php echo strtolower($state['state_name']); ?>"><?php echo $state['state_name']; ?></option>
					<?php 
						}
					?>
				</select>
			</label>
			<label>
				<span class="required">Zip:</span>
				<input type="text" name="zip" id="zip" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Employee #:</span>
				<input type="text" name="employee" id="employee" class="validate[required]"/>
			</label>
			<label>
				<span class="required">Mailcode:</span>
				<input type="text" name="mailcode" id="mailcode" class="validate[funcCall[checkMailCode]]]"/>
				<a class="mailcode-link" href="javascript:void(0);" onclick="showLocationField()">Don’t have a mailcode?</a>
			</label>
			<label class="hidden">
				<span class="required">Please enter your Location and Title:</span>
				<input type="text" name="store_location_title" id="store_location_title" class="validate[required]"/>
			</label>
			<label><span>&nbsp;</span><input type="submit" name="submit" value="Submit" id=""/></label>
		</div>
	</div>
</form>
<script>
	var isMailCode = true;

	$("#signup-form").validationEngine({
		promptPosition : "topRight", 
		ajaxFormValidationMethod: 'post',
		autoHidePrompt: true,
		autoHideDelay: 3000
	});
	
	function showLocationField() {
		isMailCode = false;
		$(".hidden").show();
	}
	function checkMailCode(field, rules, i, options){
		if (isMailCode) {
	        rules.push('required'); 
	    }
	}
</script>