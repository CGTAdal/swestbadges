<div class="main-right flr">
		<div class="yourOrder">
			<h3 class="title">Your Order:</h3>
			<?php if($badges) {?>
				<h3 class="title no-border" id="badge-title" >Badges:</h3>
				<ul class="ul-main mb-30" id = "shipping_list">
					<?php foreach($badges as $badge) {?>
						<li>
							<p><strong>Style:</strong><span><?php echo $badge['style'];?></span></p>
							<p><strong>Price:</strong><span><?php echo '$'.$badge['price'];?></span></p>
							<?php if(isset($badge['name'])) {?>
								<p><strong>Name:</strong><span><?php echo $badge['name'];?></span></p>
							<?php }?>
							<?php if(isset($badge['license'])) {?>
								<p><strong>License #:</strong><span><?php echo $badge['license'];?></span></p>
							<?php }?>
							<?php if(isset($badge['title'])) {?>
								<p><strong>Title:</strong><span><?php echo $badge['title'];?></span></p>
							<?php }?>
							<?php if(isset($badge['fastener'])) {?>
							<p><strong>Fastener:</strong><span><?php echo $badge['fastener'];?></span></p>
							<?php }?>
							<?php if(isset($badge['spk_spanish'])) {?>
								<p><strong>Hablo Español:</strong><span><?php echo $badge['spk_spanish'];?></span></p>
							<?php }?>
							<?php if(isset($badge['service_year'])) {?>
								<p><strong>Years Of Service:</strong><span><?php echo $badge['service_year'];?> years</span></p>
							<?php }?>
							<?php if($remove_cart == "shipping"){?>
								<a href="javascript:void(0);" class="remove_cart_item_shipping">Remove</a>
							<?php }?>
							<?php if($remove_cart == "approvaldetail") {?>
								<a href="javascript:void(0);" class="remove_approval_item">Remove</a>
							<?php }?>
						</li>
					<?php }?>
				</ul>
			<?php }?>
			
			<h3 class="title no-border" id="extras-title" style="display:<?php echo ($mf_qty + $pf_qty > 0)?"block":"none";?>">Extras:</h3>		
			<h3 class="title no-border" id="extras-title" style="display:<?php echo ($extra_item_count > 0)?"block":"none";?>">Extras:</h3>
			<ul class="ul-main mb-30" id="extras_list">
				<?php /*
					//commented by sunny on 17-march-2016
					if($mf_qty > 0) {?>
					<li>
						<p><strong>Item:</strong><span>5-Pack Magnets</span></p>
						<p><strong>Quantity:</strong><span><?php echo $mf_qty;?></span></p>
						<?php if($remove_cart == "shipping"){?>
							<a href="javascript:void(0);" class="remove_cart_extras" value="1">Remove</a>
						<?php }?>
						<?php if($remove_cart == "approvaldetail"){?>
							<a href="javascript:void(0);" class="remove_approval_extras" value="1">Remove</a>
						<?php }?>
					</li>
				<?php }?>
				<?php if($pf_qty > 0) {?>
					<li>
						<p><strong>Item:</strong><span>5-Pack Pins</span></p>
						<p><strong>Quantity:</strong><span><?php echo $pf_qty;?></span></p>
						<?php if($remove_cart == "shipping"){?>
							<a href="javascript:void(0);" class="remove_cart_extras" value="2">Remove</a>
						<?php }?>
						<?php if($remove_cart == "approvaldetail"){?>
							<a href="javascript:void(0);" class="remove_approval_extras" value="2">Remove</a>
						<?php }?>
					</li>
				<?php }*/?>	
				<?php if(isset($cart['extras'])) {?>
					<?php foreach ($cart['extras'] as $key => $extra_item) { ?>
					<li>
						<p>
							<strong>Item:</strong>
							<span>
							<!-- 5-Pack Magnets -->
							<?php echo $extra_item['item_name']; ?>
							</span>
						</p>
						<p>
							<strong>Price:</strong>
							<span>
								<?php 
									/*echo $mf_qty;*/
									echo '$'.$extra_item['item_price'];
								?>
							</span>
						</p>
						<p>
							<strong>Quantity:</strong>
							<span>
								<?php 
									/*echo $mf_qty;*/
									echo $extra_item['item_qty'];
								?>
							</span>
						</p>
						<a href="javascript:void(0);" class="remove_cart_extras" value="<?php echo $key;?>">Remove</a>
					</li>
					<?php }?>
				<?php }?>
			</ul>
		</div>
</div>
