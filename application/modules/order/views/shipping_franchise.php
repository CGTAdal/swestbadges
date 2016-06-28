<link rel="stylesheet" href="<?php echo base_url();?>application/views/front_end/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine-en.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/front_end/js/jquery.validationEngine.js" charset="utf-8"></script>
<style>
#edit-shipping-box span{width:100px;color:#737373}
#edit-shipping-box input[type="text"] {width:330px;}
#payment-box span{width:200px; color:#737373}
.extra-block{
	clear: both;
	margin-top: 10px;
}
.product-holder{
	width: 100%;
	display: inline-block;
}
.product-holder span{
	float: left;
}
.product-holder span:first-child{
	float: left;
	width: 200px;
	height: 24px;
	overflow: hidden;
}
label span{
	margin-right: 16px;
}
</style>
<div class="main clb">
	<div class="main-left fll">
		<div class="clb shipping">
			<form action="" method="post" id="form_order_customer">
				<h3 class="title">Shipping Address:</h3>
				<div class="pl-20 fontGL mb-30">
					<!-- <div>Jenny Craig Centre <?php echo $store->store_number;?></div> -->
					<div><!--ATTN:--> <?php echo $store->store_location_name;?></div>
					<div><?php echo $store->store_address;?></div>
					<div><?php echo $store->store_address_2;?></div>
					<div><?php echo $store->store_city.', '.$store->store_state.' '.$store->store_zip;?></div>
				</div>
				<h3 class="title">Order Total:</h3>
				<div class="pl-20 fontGL mb-30">
					<?php 
						$total_badge_price = isset($this->session->userdata['badges_total_cost']) ? $this->session->userdata['badges_total_cost'] : 0;
						$total_extra_price = isset($this->session->userdata['extras_total_cost']) ? $this->session->userdata['extras_total_cost'] : 0;
					?>
					<?php if($total_badges>0) {?>
						<h3 class="title no-border">Badges:</h3>
						<?php 
							foreach ($badges as $key => $badge) {
							?>
							<div class="product-holder" title="<?php echo $badge['style']; ?>">
								<span>
									<?php 
										echo $badge['style'];
									?>
								</span>
								<span>
									&nbsp;&nbsp;: 1 x $<?php echo $badge['price']; ?>
								</span>
							</div>
							<?php
							}
						?>
						<div class="product-holder">
							<span>Total Badges &nbsp;</span>&nbsp;&nbsp;: 
							$<?php
								echo $total_badge_price;
							?>
							<?php 
								/* //commented by sunny on 17-march-2016
							?>
							<font id="total-badges-number">
								<?php echo ($total_badges);?>
							</font> 
							x $10.00
							<?php */?>
						</div>
						<br/>
					<?php }?>
					<?php if(count($extras) > 0) {?>
						<div class="extra-block">
							<h3 class="title no-border">Extras:</h3>
							<?php 
								foreach ($extras as $key => $extra) {
								?>
									<div class="product-holder" title="<?php echo $extra['item_name']; ?>">
										<?php
											//$extraTotalDetail .= $extra['item_qty'].' x $'.$extra['item_price'].' + ';
										?>
										<span>
											<?php 
												echo $extra['item_name'];
											?>
										</span>
										<span>
											&nbsp;&nbsp;: <?php echo $extra['item_qty'].' x $'.$extra['item_price']; ?>
										</span>
									</div>
								<?php
								}
							?>
							<div class="product-holder">
								<span>
									Total Extras 
								</span>
								<span>
									&nbsp;&nbsp;: $<?php echo $total_extra_price; ?>
								</span>
							</div>
							<?php 
								/*$extraTotalDetail = '';
								foreach ($extras as $key => $extra) {
									$extraTotalDetail .= $extra['item_qty'].' x $'.$extra['item_price'].' + ';
								}
								echo substr($extraTotalDetail, 0, -2);*/
							?>
						</div>
						<br/>
					<?php }?>
					<?php if($total_tenured>0) {?>
						<div>Total Tenured Badges: <font id="total-badges-number"><?php echo ($total_tenured);?></font> x $6.25</div>
					<?php }?>
					<?php /*if($total_mf > 0) {?>
						<div id="total-magnetics">Total 5-Pack Magnets: <?php echo $total_mf.' x $6.25';?></div>
					<?php }?>
					<?php if($total_pf > 0) {?>
						<div id="total-pins">Total 5-Pack Pins: <?php echo $total_pf.' x $3.5';?></div>
					<?php } */?>
					<?php 
						// $tmp 	= explode('.',number_format($total_badges*10.00 + $total_tenured*6.25 + $total_mf*6.25 + $total_pf*3.5,2));
						$tmp 	= explode('.',number_format($total_badges*10.00,2));
						$first 	= $tmp[0];
						$last	= $tmp[1];
						if($last > 0){
							$last = trim($last,'0');
						}
						//$total_price = $first.'.'.$last;					
						$total_price = $total_badge_price + $total_extra_price;
						$shipping_charge = 5.00;
					?>
					<div class="product-holder">
						<span> Shipping Charge</span> &nbsp;&nbsp;: $<font id="total-order-price">5.00</font>
					</div>
					
					<?php //sales tax only applicable on florida ?>
					<?php 
						  $sale_tax_part = 0;
						  $sales_tax_pre = 6; 
						  $sales_tax = $total_price*($sales_tax_pre/100);
					?>
					<?php 
						$divStyle = 'display:none;';
						if( $store->store_state == 'florida' ) {
							$divStyle = '';	
							$sale_tax_part = $sales_tax;
						}
						?>
					<div class="product-holder" id="sale_tax_holder" style="<?php echo $divStyle;?>">
						<span> Sales Tax</span> &nbsp;&nbsp;: $<font id="sales_tax_amt"><?php echo number_format($sales_tax,2);?></font>
					</div>

					<br/>
					<div class="product-holder">
						<span> Total Amount</span> &nbsp;&nbsp;: $<font id="total_price_amt"><?php echo number_format(($total_price + $sale_tax_part + $shipping_charge),2);?></font>
					</div>
				</div>
				<h3 class="title">Billing Address:</h3>
				<?php /*?>
				<div class="pl-20 fontGL mb-30" id="shipping-info">
					<div><?php echo $store->store_location_name;?></div>
					<div><?php echo $store->store_phone;?></div>
					<div><?php echo $store->store_address;?></div>
					<div><?php echo $store->store_city.', '.$store->store_state.' '.$store->store_zip;?></div>
					<div><a href="javascript: void(0);" id="edit-shipping" >Edit address</a></div>
				</div>
				<?php */ ?>
				<div class="pl-20 fontGL mb-30" id="edit-shipping-box">
					<label>
						<span>First Name:</span>
						<input type="text" name="fname" id="" class="validate[required]" value="<?php echo @$_REQUEST['fname'] ?>"/>						
					</label>
					<label>
						<span>Last Name:</span>
						<input type="text" name="lname" id="" class="validate[required]" value="<?php echo @$_REQUEST['lname'] ?>"/>
					</label>
					<label>
						<span>Phone:</span>
						<input type="text" name="phone" id="" class="validate[required]" value="<?php echo $store->store_phone;?>"/>
					</label>
					<label>
						<span>Address:</span>
						<input type="text" name="address" id="" class="validate[required]" value="<?php echo $store->store_address;?>"/>
					</label>
					<label>
						<span>City:</span>
						<input type="text" name="city" id="" class="validate[required]" value="<?php echo $store->store_city;?>"/>
					</label>
					<label>
						<span>State:</span>
						<!-- commented by sunny 18-march-2016 -->
						<!-- <input type="text" name="state" id="" class="validate[required]" value="<?php //echo $store->store_state;?>"/> -->
						<select name="state" id="billing-state" class="validate[required] sb-setstatecss sb-setstatewidthonshpping">
							<option value="">Select State</option>
							<?php 
								foreach ($states as $key => $state) {
									$optionSelected ='';

									if(strtolower($store->store_state) == strtolower($state['state_name']))
										$optionSelected = 'selected="selected"';
							?>
							<option <?php echo $optionSelected; ?> value="<?php echo strtolower($state['state_name']); ?>"><?php echo $state['state_name']; ?></option>
							<?php 
								}
							?>
						</select>
					</label>
					<label>
						<span>Zip:</span>
						<input type="text" name="zip" id="" class="validate[required]" value="<?php echo $store->store_zip;?>"/>
					</label>
				</div>
				<h3 class="title">Payment:</h3>
				<div class="pl-20 fontGL mb-30" id="payment-box">
					<div style="margin-bottom: 10px;color:red;"><?php echo isset($payment_error) ?  urldecode($payment_error) : "";?></div>
					<label>
						<span>Credit card type:</span>
						<select style="width:243px;padding:4px;" name="credit_card_type">
							<option value="No~Visa">Visa</option>
							<option value="No~MasterCard">Master Card</option>
							<option value="No~Amex">American Express</option>
							<option value="No~Discover">Discover/Novus</option>
						</select>
					</label>
					<label>
						<span>Credit card number:</span>
						<input type="text" name="credit_card_number" id="" class="validate[required,creditCard]" value=""  autocomplete="off"/>
					</label>
					<div style="font-size: 18px;margin-bottom: 15px;padding-left:75px;">
						<span>Expiration date:</span>
						<select style="width:70px;padding:4px;margin-left:16px" name="expiration_month" id="expiration_month">
							<?php for($i=1; $i<=12; $i++) {?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php }?>
						</select>
						&nbsp;
						<select style="width:100px;padding:4px;" name="expiration_year" class="validate[funcCall[checkExpirationDate]]">
							<?php $k= date('y'); for($i=date('Y');$i<=date('Y')+15;$i++) {?>
                                <option value=<?php echo $k; ?>><?php echo $i; ?></option>
                                <?php $k++; }?>	 
						</select>
					</div>
					<label>
						<span>3-Digit security code:</span>
						<input type="text" name="credit_card_cvv2" value="" autocomplete="off">
					</label>
					<label>
						<span>First name on card:</span>
						<input type="text" name="credit_card_firstname" id="" class="validate[required]" value=""/>
					</label>
					<label>
						<span>Last name on card:</span>
						<input type="text" name="credit_card_lastname" id="" class="validate[required]" value=""/>
					</label>
				</div>
				<div class="txtC">
					<input type="submit" name="submit" id="place_order" value="Place Order" />
				</div>
			</form>
		</div>
	</div>
	<!--END main left-->
	<?php
		$order_box = Modules::run('order/detailOrderBox');
		echo $order_box;
	?>
	
	<!--END main right-->
	<input type="hidden" id="store_id" value="<?php echo $store->store_id;?>" />
</div>
<!--END main-->
<script>
	$(document).ready(function(){

		//TO DO: Need to remove if client confirm sales tax applied on basis of store state
		/*var total_price = <?php //echo $total_price;?>;
		var sales_tax = <?php //echo $sales_tax;?>;*/

		/*$('#billing-state').change(function(){
			state = $(this).val();
			if(state == 'florida'){
				total_price1 = total_price+sales_tax;
				$('#total_price_amt').html(total_price1.toFixed(2));
				$('#sale_tax_amt').html(sales_tax);
				$('#sale_tax_holder').css('display','inline-block');
			}else{
				$('#sale_tax_holder').css('display','none');
				$('#total_price_amt').html(total_price.toFixed(2));
			}
		});*/

		$("#form_order_customer").validationEngine('attach',{
			promptPosition : "topRight", 
			autoHidePrompt: true,
			autoHideDelay: 3000
		});

		// Remove cart Item in function Shipping
		$('.remove_cart_item_shipping').live('click', function (){
			var size = $('#shipping_list li').size();
			var parent = $(this).parent();
			var item_id = $('#shipping_list li').index(parent);
			$.post(
				'<?php echo base_url();?>order/ajax/deleteBadge',
				{item_id: item_id},					
				function(data){
					var size = $('#shipping_list li').size();				
					if(size-1 > 0){
						$('#total-badges-number').html(data.total_badges);
						$('#total-order-price').html(data.total_order_price);	
					}else{
						$('#total-badges-number').parent().remove();
						$('#total-order-price').html(data.total_order_price);
						$('#badge-title').remove();
						$('#shipping_list').remove();			
					}
					parent.remove();
					window.location.href = '<?php echo base_url();?>order/shipping';
				},
				'json'
			);									
		});

		$('.remove_cart_extras').live('click',function(){
			var type = $(this).attr('value');
			$.post(
				"<?php echo base_url();?>order/ajax/deleteExtras",
				{type: type},
				function(data){
					// code here
					if(data.total_extras=='0') {
						$('#extras-title').remove();
						$('#extras_list').remove();
					}
					$('#total-order-price').html(data.total_cost);
					window.location.href = '<?php echo base_url();?>order/shipping';
				},
				'json'
			);
			$(this).parent().remove();
			if(type=='1') $('#total-magnetics').remove();
			else if(type=='2') $('#total-pins').remove();
			return;			
		});
		
	});
	
	function checkExpirationDate(field, rules, i, options){
		var exp_year 	= "20"+field.val();
		var exp_month	= $('#expiration_month').val();
		var check		= true;
		var currentY	= new Date().getFullYear();
		var currentM	= new Date().getMonth(); 
		if( (exp_year < currentY) || (exp_year == currentY && exp_month < currentM)) {
			check = false;
		}
		
		if (!check) {
			return options.allrules.check_ExpirationDate.alertText;
		} else {
			field.validationEngine('hide');
		}

	}
</script>