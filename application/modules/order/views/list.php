<style>
.order{cursor:pointer;}
</style>
<div class="main clb">
	<div class="txtC shipping mb-40">
		<table cellpadding="10" cellspacing="0" align="center">
			<tr>
				<th>Order #</th>
				<th>Date</th>
				<?php 
					$allowedItemsId = array(1,2,18,19);
					foreach ($items as $key => $item) {
						if(in_array($item['item_id'], $allowedItemsId))
							echo '<th>'.$item['item_name'].' Qty'.'</th>';
					}
				?>
				<?php 
					/*
					//commented by sunny on 16-march-2016
				?>
				<th>Standard Badge Qty</th>
				<th>Tenured Badge Qty</th>
				<th>5-Pack Magnets</th>
				<th>5-Pack Pins</th>
				<?php 
					*/
				?>
				<th>Ship Date</th>
			</tr>
			<?php if(count($orders)>0) {?>
				<?php $i=0;foreach($orders as $order) {?>
					<tr class="fontGL <?php echo ($i%2==0)?'row0':'row1';?> order" value="<?php echo $order->order_id;?>">
						<td>
							<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
						</td>
						<td align="center"><?php echo date('n/j/Y',$order->order_date);?></td>
						<?php 
							$order_detail = unserialize($order->order_items);
							/*echo '<pre>';print_r($order_detail); echo '</pre>';*/
							foreach ($items as $key => $item) {
								if(in_array($item['item_id'], $allowedItemsId)){
									$itemCount = 0;
									
									if(!empty($order_detail['badges'])){
										foreach ($order_detail['badges'] as $order_item) {
											/*echo $item['item_name'];
											echo '<pre>';print_r($order_item); echo '</pre>'; exit;*/
											if(!empty($order_item) && in_array($item['item_name'], $order_item)){
												$itemCount++;
												//exit;	
											}
										}
									}
									echo '<td>'.$itemCount.'</td>';
								}
							}
						?>
						<?php 
							/*
							//commented by sunny on 16-march-2016
						?>
						<td align="center"><?php echo $order->order_total?></td>
						<td align="center"><?php echo $order->order_tenured_qty;?></td>
						<td align="center"><?php echo $order->order_mf_qty?></td>
						<td align="center"><?php echo $order->order_pf_qty?></td>
						<?php 
							*/
						?>
						<td align="center"><?php echo ($order->order_shipdate==0)?'pending':date('n/j/Y',$order->order_shipdate);?></td>
					</tr>
				<?php $i++;}?>
			<?php } else {?>
				<tr class="fontGL row0">
					<td colspan="6">No order</td>
				</tr>
			<?php }?>
		</table>
	</div>
	<div class="mb-40">&nbsp;</div>
</div>
<!--END main-->
<script>
	$(document).ready(function(){
		$('.order').click(function(){
			var order_id = $(this).attr('value');
			window.location="<?php echo base_url();?>order/detail/"+order_id;
		});
	});
</script>