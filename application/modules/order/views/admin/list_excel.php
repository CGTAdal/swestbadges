<table cellpadding="10" cellspacing="0" align="center">
	<thead>
		<tr>
			<th>Order Date</th>
			<th>Order #</th>
			<th >Name</th>
			<?php /*?><th>Ship Date</th>
			<th>Item</th> <?php */?>
			<th>State</th>
			<th>Ship Date</th>
			<?php
				$items_sorted = array();
				$items_badge_arr = array();
				$items_extra_arr = array();
				$items_extra_arr = array(10 => array('item_id'=> '21', 'item_name' => '5-Pack Magnets', 'item_price' => 6.25));
				$allowedItemsId = array(1,2,18,19);
				$i=0;
				foreach ($items as $key => $value) {
					if(in_array($value['item_id'], $allowedItemsId))
						$items_badge_arr[$key] = $value;
					else
						$items_extra_arr[$key] = $value;
				}
				$items_sorted = $items_badge_arr + $items_extra_arr;
				//echo '<pre>'; print_r($items_sorted); echo '</pre>'; exit;
				foreach ($items_sorted as $key => $item) {
					//if(in_array($item['item_id'], $allowedItemsId))
						echo '<th>'.$item['item_name'].' Qty'.'</th>';
						echo '<th>'.$item['item_name'].' Total'.'</th>';
				}
			?>
			<?php /*?><th>Market #</th>
			<th>Badge Quantity</th>
			<th>Badge Total</th>
			<th>Tenured Quantity</th>
			<th>Tenured Total</th>
			<th>5-Pack Magnets</th>
			<th>5-Pack Pins</th> <?php */?>
			<th>Order Cost</th>
			<th>Tax</th>
			<th>Sub Total</th>
			<th>Shipping Charge</th>
			<th >Total</th>
			<th >Net</th>
			<!-- <th >Approved Date</th> -->
		</tr>
	</thead>
	<?php if(count($orders)>0) {?>
		<?php $i=0;foreach($orders as $order) {?>
			<tr>
				<td>
					<?php echo date('m/d/Y',$order->order_date);?>
				</td>
				<td>
					<?php echo str_pad($order->order_id,6,'0',STR_PAD_LEFT);?>
				</td>
				<?php /*?> <td><?php //echo $order->store_number;?></td> <?php */?>
				<td><?php echo $order->store_location_name;?></td>
				<?php /*?>
				<td><?php //echo ($order->order_shipdate==0)?'pending':date('m/d/Y',$order->order_shipdate);?></td>
				<td>Name Badges</td>
				<?php */?>
				<td><?php echo $order->store_state;?></td>
				<td><?php echo ($order->order_shipdate==0)?'&nbsp;': date('m/d/Y',$order->order_shipdate);?></td>
				<?php 
					$order_detail = unserialize($order->order_items);
					/*echo '<pre>';print_r($order_detail); echo '</pre>';*/
					foreach ($items_sorted as $key => $item) {
						//if(in_array($item['item_id'], $allowedItemsId)){
							$itemCount = 0;
							$itemTotalPrice = 0;
							if(!empty($order_detail['badges']) && in_array($item['item_id'], $allowedItemsId)){
								foreach ($order_detail['badges'] as $order_item) {
									if(!empty($order_item) && in_array($item['item_name'], $order_item)){
										$itemCount++;
										$itemTotalPrice = $itemTotalPrice + ($order_item['price']);
									}
								}
							}elseif (!empty($order_detail['extras'])) {
								foreach ($order_detail['extras'] as $order_item) {
									if(!empty($order_item) && in_array($item['item_id'], $order_item)){
										$itemCount = $order_item['item_qty'];
										$itemTotalPrice = $itemTotalPrice + ($order_item['item_price'] * $order_item['item_qty']);
									}
								}
							}
							echo '<td>'.$itemCount.'</td>';
							echo '<td>'.$itemTotalPrice.'</td>';
						//}
					}
				?>
				<?php /*?>
				<td><?php echo $order->director_number;?></td>
				<td><?php echo $order->order_total?></td>
				<td>
					<?php echo number_format($order->order_total * 4.75, 2);?>
				</td>
				<td><?php echo $order->order_tenured_qty;?></td>
				<td>
					<?php echo number_format($order->order_tenured_qty * 6.25, 2);?>
				</td>
				<td><?php echo $order->order_mf_qty?></td>
				<td><?php echo $order->order_pf_qty?></td>
				<?php */?>
				<td>
					<?php
						/*if($order->order_cost==0) { 
							echo number_format($order->order_total * 4.75 + $order->order_mf_qty * 6.25 + $order->order_pf_qty * 3.5,2);
						} else {
							echo number_format($order->order_cost,2);									
						}*/
						$order_cost = $order->order_cost;
						echo number_format($order_cost,2);
					?>
				</td>
				<td>
					<?php 
						//echo number_format($order->order_tax,2);
						$sales_tax = $order->order_tax;
						echo number_format($sales_tax,2);
					?>
				</td>
				<td> <?php echo number_format(($order_cost+$sales_tax),2);?> </td>
				<td> 
					<?php 
						$shipping_charge = 5.00;
						echo number_format($shipping_charge,2); 
					?> 
				</td>
				<td>
					<?php
						/*if($order->order_cost==0) { 
							echo number_format($order->order_total * 4.75 + $order->order_mf_qty * 6.25 + $order->order_pf_qty * 3.5 + $order->order_tax,2);
						} else {
							echo number_format($order->order_cost + $order->order_tax,2);									
						}*/
						$total_amt = number_format(($order_cost+$sales_tax+$shipping_charge),2);
						echo $total_amt;
					?>
				</td>
				<td> 
					<?php 
						$net_amt = (($order->order_total * 2.75) + 3.50) + ($total_amt * (2.45/100)) + 0.28;
						echo number_format($net_amt,2);
					?>
				</td>
				<!-- <td><?php //echo ($order->order_status==2)?date('m/d/Y',$order->order_approve_dated):'--';?></td> -->
			</tr>
		<?php $i++;}?>
	<?php } else {?>
		<tr class="fontGL row0">
			<td colspan="3">No order</td>
		</tr>				
	<?php }?>
</table>