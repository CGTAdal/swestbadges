 <style type="text/css">
 	.title{
 		 padding-left: 40px;
    	 text-align: left;
 	}
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
	.product-holder span:first-child{
		text-align: left;
		padding-left: 50px;
	}
</style>
 <div class="main clb">
	<div class="mb-40">&nbsp;</div>
	<div class="mb-30 txtC shipping">Order Number: <span class="fontGL"><?php echo $orderId;?></span></div>
	<div class="mb-30 txtC shipping fontGL">Thank you for your order. All orders are shipped within 5 business days. Please allow an additional 1 - 3 days for delivery.</div>
	<?php if(isset($account_type) ) {?>
		<div class="mb-30 txtC mb-30">
			<?php 
				$total_badge_price = 0;
				$total_extra_price = 0;
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
						<span>Total Badges &nbsp;</span><span>&nbsp;&nbsp;: 
						$<?php
							echo $total_badge_price;
						?>
						</span>
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

			<?php /*if($total_badges>0) {?>
				<div align="center">Total Badges: <?php echo ($total_badges);?> x $4.75</div>
			<?php }*/?>
			<?php if($total_tenured>0) {?>
				<div align="center">Total Tenured Badges: <?php echo ($total_tenured);?> x $6.25</div>
			<?php }?>
			<?php if($total_mf > 0) {?>
				<div align="center">Total 5-Pack Magnets: <?php echo $total_mf.' x $6.25';?></div>
			<?php }?>
			<?php if($total_pf > 0) {?>
				<div align="center">Total 5-Pack Pins: <?php echo $total_pf.' x $3.5';?></div>
			<?php }?>
			<?php 
				$tmp 	= explode('.',number_format($total_badges * 4.75 + $total_tenured * 6.25 + $total_mf * 6.25 + $total_pf * 3.5,2));
				$first 	= $tmp[0];
				$last	= $tmp[1];
				if($last > 0){
					$last = trim($last,'0');
				}
				//$total_price = $first.'.'.$last;					
				$total_price = $total_badge_price + $total_extra_price;
				$shipping_charge = 3.50;
			?>
			<div class="product-holder">
				<span> Shipping Charge</span><span> &nbsp;&nbsp;: $<font id="total-order-price">3.50</font></span>
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
				<span> Sales Tax</span><span> &nbsp;&nbsp;: $<font id="sales_tax_amt"><?php echo number_format($sales_tax,2);?></font></span>
			</div>

			<br/>
			<div class="product-holder">
				<span> Total Amount for order #<?php echo $orderId;?></span><span> &nbsp;&nbsp;: $<font id="total_price_amt"><?php echo number_format(($total_price + $sale_tax_part + $shipping_charge),2);?></font></span>
			</div>
			<!-- <div align="center">Total for order #<?php //echo $orderId;?>: $<?php //echo $total_price;?></div> -->
		</div>
	<?php }?>
	<div class="mb-40">&nbsp;</div>
</div>