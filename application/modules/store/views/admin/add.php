<div style="min-height: 300px;" class="portlet x12">
	<div class="portlet-header"><h4>Add a new Account</h4></div>			
		<div class="portlet-content" >		
			<form class="form label-inline" id="form_store_add" method="post" action="<?php echo base_url();?>admin/store/add">
				<?php /*?>
				<div class="field">
					<label class="required">Unit</label>
					<?php						 
						$data = array(
								'name'	=> "store_number",
								'id'	=> "store_number",
								'value'	=> $this->input->post('store_number'),
								'class' => 'medium validate[required, ajax[ajaxCheckAccountNumber]]',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_number!="")?"<p>".$error_number."</p>":"";
					?>
				</div>
				<div class="field">
					<label>Express Account</label> 
					<input type="text" class="medium" size="50" name="store_express" id="store_express" value="<?php echo (isset($store->store_express))?$store->store_express:"";?>">
				</div>	
				<div class="field">
					<label>Ground Account</label> 
					<input type="text" class="medium" size="50" name="store_ground" id="store_ground" value="<?php echo (isset($store->store_ground))?$store->store_ground:"";?>">
				</div>	
				<?php */?>
				<div class="field">
					<label for="fname" class="required">Name</label> 
					<input type="text" class="medium validate[required]" size="50" name="store_location_name" id="store_location_name" value="<?php echo (isset($tore->store_location_name))?$store->store_location_name:"";?>">
				</div>
				<div class="field email-field" >
					<label class="required">Email</label>
					<?php						 
						$data = array(
								'name'	=> "store_email",
								'id'	=> "store_email",
								'value'	=> $this->input->post('store_email'),
								'class' => 'medium validate[required, custom[email], ajax[ajaxCheckEmailExists]]',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_email!="")?"<p>".$error_email."</p>":"";
					?>
				</div>
				<div class="field password-field" >
					<label class="required">Password</label>
					<?php						 
						$data = array(
								'name'	=> "store_password",
								'id'	=> "store_password",
								'class' => 'medium validate[required]',
								'size'	=> '50'
							);
						echo form_input($data);						
					?>
				</div>
				<div class="field">
					<label for="address2">Phone</label>
					<?php						 
						$data = array(
								'name'	=> "store_phone",
								'id'	=> "store_phone",
								'value'	=> $this->input->post('store_phone'),
								'class' => 'medium',
								'size'	=> '50'
							);
						echo form_input($data);						
						echo ($error_phone!="")?"<p>".$error_phone."</p>":"";
					?>
				</div>	

				<div class="field">
					<label class="required">Mailing Address</label> 
					<input type="text" class="medium validate[required]" size="50" name="store_address" id="store_address" value="<?php echo (isset($store->store_address))?$store->store_address:"";?>">
				</div>
				<div class="field">
					<label for="fname">Address Line 2</label> 
					<input type="text" class="medium" size="50" name="store_address_2" id="store_address_2" value="<?php echo (isset($store->store_address_2))?$store->store_address_2:"";?>">
				</div>

				<div class="field">
					<label class="required">City </label> 
					<input type="text" class="medium validate[required]" size="50" name="store_city" id="store_city" value="<?php echo (isset($store->store_city))?$store->store_city:"";?>">
				</div>					
				<div class="field">
					<label class="required">State </label> 
					<!-- commented by sunny 18-march-2016 -->
					<!-- <input type="text" class="large validate[required]" size="50" name="store_state" id="store_state" value="<?php //echo (isset($store->store_state))?$store->store_state:"";?>"> -->
					<select class="large validate[required]"   name="store_state" id="store_state">
						<option value="">Select State</option>
						<?php 
							foreach ($states as $key => $state) {
								$optionSelected ='';
								if(isset($store->store_state) && (strtolower($store->store_state) == strtolower($state['state_name'])) )
									$optionSelected = 'selected="selected"';
						?>
						<option value="<?php echo strtolower($state['state_name']); ?>" <?php echo $optionSelected; ?>><?php echo $state['state_name']; ?></option>
						<?php 
							}
						?>
					</select>
				</div>
				<div class="field">
					<label class="required">Zip</label> 
					<input type="text" class="large validate[required]" size="50" name="store_zip" id="store_zip" value="<?php echo (isset($store->store_zip))?$store->store_zip:"";?>">
				</div>
				<?php /*?>
				<div class="field">
					<label for="address2">Contact</label> 
					<input type="text" class="large" size="50" name="store_contact" id="store_contact" value="<?php echo (isset($store->store_contact))?$store->store_contact:"";?>">
				</div>				
				<?php */?>
				<div class="field">
					<label class="required">Employee #:</label>
					<input type="text" name="employee" id="employee" size="50" class="validate[required] large"/>
				</div>
				<div class="field">
					<label class="required">Mailcode:</label>
					<input type="text" name="mailcode" id="mailcode" size="50" class="validate[funcCall[checkMailCode]]] large"/>
					<a class="mailcode-link" href="javascript:void(0);" onclick="showLocationField()">Don’t have a mailcode?</a>
					
				</div>
				<div class="field hidden">
					<label class="required">Please enter your Location and Title:</label>
					<input type="text" name="store_location_title" id="store_location_title" size="50" class="validate[required] large"/>
				</div>
				<?php 
					/*
					//commented as per client feedback. Only single role exist in the website now.
				?>
				<div class="field">
					<label for="address2">Type</label> 
					<select name="store_role" id="select_role">
						<!-- <option value="1">Store</option> -->
						<option value="2">Market Director</option>
						<option value="3" selected="selected">Franchise</option>
					</select>
				</div>
				<?php 
					*/
				?>
				<div class="field"><?php echo ($error_full!="")?"<p>".$error_full."</p>":"";?></div>
				<input type="hidden" name="store_id" id="store_id" value="<?php echo (isset($store->store_id))?$store->store_id:0;?>">				
				<div class="buttonrow" align="center" style="margin-left:165px">					
					<input type="submit" class="btn btn-orange" value="Save" value="Submit"/>
					<input type="button" class="btn btn-grey" id="Cancel" value="Cancel">					
				</div>
		</form>
		<br><br>		
	</div>
</div>
<script>
var isMailCode = true;
function showLocationField() {
	isMailCode = false;
	$(".hidden").show();
}
function checkMailCode(field, rules, i, options){
	if (isMailCode) {
        rules.push('required'); 
    }
}
$(document).ready(function(){
	$("#form_store_add").validationEngine({promptPosition : "topRight", ajaxFormValidationMethod: 'post'});
	
	$('.btn-grey').live('click',function(){				
		parent.history.back();
		return false;
	})
	
	$('#select_role').change(function(){
		if($(this).val()=='2' || $(this).val()=='3') {
			$('.email-field').removeClass('hidden');
			$('.password-field').removeClass('hidden');
		} else {
			$('.email-field').addClass('hidden');
			$('.password-field').addClass('hidden');
			
		}
	});
});

</script>