<?php 
/*
//commented by sunny on 17-march-2016
?>
<li>
	<p><strong>Item:</strong><span>5-Pack Magnets</span></p>
	<p><strong>Quantity:</strong><span><?php echo $mf_qty;?></span></p>
	<a href="javascript:void(0);" class="remove_cart_extras" value="1">Remove</a>
</li>
<li>
	<p><strong>Item:</strong>5-Pack Pins<span></span></p>
	<p><strong>Quantity:</strong><span><?php echo $pf_qty;?></span></p>
	<a href="javascript:void(0);" class="remove_cart_extras" value="2">Remove</a>
</li>
<?php 
*/
?>
<?php 
	foreach ($extras as $key => $extra_item) {
	
?>
<li>
	<p><strong>Item:</strong>
		<span>
		<!-- 5-Pack Magnets -->
		<?php echo $extra_item['item_name']; ?>
		</span>
	</p>
	<p><strong>Price:</strong>
		<span>
			<?php 
				/*echo $mf_qty;*/
				echo '$'.$extra_item['item_price'];
			?>
		</span>
	</p>
	<p><strong>Quantity:</strong>
		<span>
			<?php 
				/*echo $mf_qty;*/
				echo $extra_item['item_qty'];
			?>
		</span>
	</p>
	<a href="javascript:void(0);" class="remove_cart_extras" value="<?php echo $key;?>">Remove</a>
</li>
<?php 
	}
?>