<style type="text/css">
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
</style>
<?php if(count($order)>0) {?>
	<div class="main clb">
		<div class="txtC mb-30">
			<div class="view-order">
				Order #:
				<span class="fontGL">
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</span>
				<span class="split"> </span>
				Order Date: <span class="fontGL"><?php echo date('n/j/Y',$order->order_date);?></span>
			</div>
		</div>
		<div class="main-left fll">
			<div class="clb shipping">
				<h3 class="title">Shipping Address: </h3>
				<div class="pl-20 fontGL mb-30">					
					
					<div><?php echo $shipping['attn'];?></div>
					<div><?php echo $shipping['address'];?></div>
					<div><?php echo isset($shipping['address_2']) ? $shipping['address_2'] : "";?></div>
					<div><?php echo $shipping['city'].', '.$shipping['state'].' '.$shipping['zip'];?></div>
				</div>
				<?php if($order->store_role!=3) {?>
					<h3 class="title">Order Placed By: <?php echo ($order->order_customer!='')?$order->order_customer:'';?></h3>
				<?php } else {?>
					<h3 class="title">Billing Address: </h3>
					<div class="pl-20 fontGL mb-30">					
						<div><?php echo $billing['fname'].' '.$billing['lname'];?></div>
						<div><?php echo $billing['phone'];?></div>
						<div><?php echo $billing['address'];?></div>
						<div><?php echo $billing['city'].', '.$billing['state'].' '.$billing['zip'];?></div>
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
										$total_badge_price = $total_badge_price + $badge['price'];
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
						<?php if(isset($extras) && is_array($extras) && count($extras) > 0) {?>
							<div class="extra-block">
								<h3 class="title no-border">Extras:</h3>
								<?php 
									foreach ($extras as $key => $extra) {
										$total_extra_price = $total_extra_price + ($extra['item_qty']*$extra['item_price']);
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
						<?php 
							//commented by sunny on 18-march-2016
							/*if($total_badges>0) {?>
							<div>Total Badges: <font id=""><?php echo ($total_badges);?></font> x $4.75</div>
						<?php }*/?>
						<?php if($total_tenured>0) {?>
							<div>Total Tenured Badges: <font id=""><?php echo ($total_tenured);?></font> x $6.25</div>
						<?php }?>
						<?php if($total_mf > 0) {?>
							<div id="total-magnetics">Total 5-Pack Magnets: <?php echo $total_mf.' x $6.25';?></div>
						<?php }?>
						<?php if($total_pf > 0) {?>
							<div id="total-pins">Total 5-Pack Pins: <?php echo $total_pf.' x $3.5';?></div>
						<?php }?>
						<?php 
							$tmp 	= explode('.',number_format($total_badges*4.75 + $total_tenured * 6.25 + $total_mf*6.25 + $total_pf*3.5,2));
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
							if( $store_state == 'florida' ) {
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

						<!-- <div>Total: $<font id="total-order-price"><?php //echo $total_price;?></font></div> -->
					</div>
				<?php }?>
			</div>
		</div>
		<!--END main left-->
		<?php
			$order_box = Modules::run('order/detailOrderBox');
			echo $order_box; 
		?>
		<!--END main right-->
	</div>
<?php } else {?>
	<div class="main clb"><div style="padding-left:400px">No order found.</div></div>
<?php }?>
<!--END main-->