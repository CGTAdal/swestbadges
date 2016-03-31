<?php
class Ajax extends MX_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('order_model');
	}
	
	function addBadgesToCart() {
		if(isset($this->session->userdata['cart'])) {
			$cart 	= $this->session->userdata['cart'];
			$badges	= (isset($cart['badges']))?$cart['badges']:array();
			$total_cost = (isset($this->session->userdata['badges_total_cost'])) ?  $this->session->userdata['badges_total_cost'] : 0;
		} else {
			$cart 	= array();
			$badges	= array();
			$total_cost = 0;
		}
		
		$styles			= $this->input->post('styles');
		$prices			= $this->input->post('prices');
		$item_id		= $this->input->post('item_id');
		$names			= $this->input->post('names');
		$titles			= $this->input->post('titles');
		$licenses		= $this->input->post('licenses');
		$fasteners		= $this->input->post('fasteners');
		$spk_spanish	= $this->input->post('spk_spanish');
		$service_year	= $this->input->post('service_year');
		
		$total 			= 0;
		$total_tenured	= 0;
		$items = array();
		foreach($styles as $key=>$style) {
			$temp_item = array();
			$temp_item['style']			= $style;
			$temp_item['name']			= $names[$key];
			$temp_item['price']			= $prices[$key];
			$temp_item['item_id']		= $item_id[$key];
			$total_cost = $total_cost + $prices[$key];
			if(isset($fasteners[$key])){
				$temp_item['fastener']	= $fasteners[$key];
			}
			if($titles) {
				$temp_item['title']		= $titles[$key];
			}
			if($licenses) {
				$temp_item['license']	= $licenses[$key];
			}
			if($spk_spanish) {
				$temp_item['spk_spanish']	= $spk_spanish[$key];
			}
			if($service_year) {
				$temp_item['service_year']	= $service_year[$key];
			}
			$items[] = $badges[] 	= $temp_item;
			if($style != 'tenured name badge') {
				$total++;
			} else {
				$total_tenured++;
			}
		}
		
		$cart['badges']	= $badges;
		$this->session->set_userdata('cart',$cart);
		$this->session->set_userdata('badges_total_cost',$total_cost);
		
		if(!isset($this->session->userdata['cart_total'])) {
			$cart_total = $total;
		} else {
			$cart_total = $this->session->userdata['cart_total'];
			$cart_total += $total;
		}
		$this->session->set_userdata('cart_total',$cart_total);
		
		if(!isset($this->session->userdata['tenured_total'])) {
			$this->session->set_userdata('tenured_total',$total_tenured);
		} else {
			$cart_tenured_total = $this->session->userdata['tenured_total'];
			$this->session->set_userdata('tenured_total',$cart_tenured_total + $total_tenured);
		}
		
		$data['badges']	= $items;
		$this->load->view('order/list_badges',$data);
		return;
	}
	
	function addExtrasToCart() {
		//echo '<pre>'; print_r($this->input->post()); exit;
		if(isset($this->session->userdata['cart'])) {
			$cart 		= $this->session->userdata['cart'];
		} else {
			$cart 		= array();
		}
		$total_cost = 0;
		$extras	= array();

		$extra_qty_array = $this->input->post('extra_qty');
		$extra_id_array = $this->input->post('extra_id');
		$extra_price_array = $this->input->post('extra_price');

		$this->db->select('item_id, item_name, item_price');
		$items_query = $this->db->get_where('items',array('item_status' => 1));
		$items = $items_query->result_array();
		
		//echo '<pre>'; print_r(array_search(1, array_column($items, 'item_id'))); exit;

		if(is_array($extra_qty_array) && count($extra_qty_array) > 0 && array_sum($extra_qty_array) > 0){
			foreach ($extra_id_array as $key => $extra_item_id) {
				$temp_item = array();
				if($extra_item_id !='' && !in_array($extra_item_id, array(-1,0))){
					
					$db_item_key = array_search($extra_item_id, $this->array_column($items, 'item_id'));
					
					$temp_item['item_id']     = $extra_item_id;
					$temp_item['item_name']   = (!empty($db_item_key) && isset($items[$db_item_key]['item_name'])) ? $items[$db_item_key]['item_name'] : 'Product #';
					$temp_item['item_price']  = (!empty($db_item_key) && isset($items[$db_item_key]['item_price'])) ? $items[$db_item_key]['item_price'] : $extra_price_array[$key];
					$temp_item['item_qty']    = $extra_qty_array[$key];
					$total_cost 			  = $total_cost + ($temp_item['item_qty'] * $temp_item['item_price']);
					$extras[] 	= $temp_item;

				}/*
					//this code working in case of static extra item which is commented on 31-march-2016
					elseif (in_array($extra_item_id, array(-1,0))) {
					$temp_item['item_id']      = $extra_item_id;
					$temp_item['item_name']    = ($extra_item_id == -1) ? 'Magnetic Fastener' : '5-Pack Pins';
					$temp_item['item_price']   = ($extra_item_id == -1) ? 3.00 : 3.5;
					$temp_item['item_qty']     = $extra_qty_array[$key];
					$total_cost 			   = $total_cost + ($temp_item['item_qty'] * $temp_item['item_price']);
					$extras[] 	= $temp_item;
				}*/
			}
			//echo '<pre>'; print_r($extras); exit;
			$cart['extras'] = $extras;
			$this->session->set_userdata('cart',$cart);
			$this->session->set_userdata('extras_total_cost',$total_cost);
			$data['extras'] = $extras;
			$this->load->view('order/list_extras',$data);
			return;
		}

		/*
		// commented by sunny on 17-march-2016
		$magnet_qty = (int)$this->input->post('magnet_qty');
		$pin_qty	= (int)$this->input->post('pin_qty');
		
		if($magnet_qty + $pin_qty > 0) {
			if(isset($this->session->userdata['cart'])) {
				$cart 	= $this->session->userdata['cart'];
			} else {
				$cart = array();
			}
			
			$cart['order_mf_qty'] = $data['mf_qty'] = $magnet_qty;
			$cart['order_pf_qty'] = $data['pf_qty'] = $pin_qty;
			
			$this->session->set_userdata('cart',$cart);
			
			$this->load->view('order/list_extras',$data);
			return;
		}*/
	}
	
	function addInputBox() {				
		$current_input_boxes_number = $this->input->post('current_input_boxes_number');
		$type = $this->input->post('type');		
		$id     = $this->input->post('id');
		$item_name = '';
		$item_id = 0;
		$price = 0;
		if(!empty($id)){
			$item_detail = $this->db->get_where('items',array('item_id' => (int)$id), 1)->result_array();
			//print_r($item_detail); exit;
			$item_name = $item_detail[0]['item_name'];
			$item_id = $item_detail[0]['item_id'];
			$price = $item_detail[0]['item_price'];
		}

		switch($type) {
			case '1':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = !empty($item_name) ? $item_name : "Southwest Name Badge";
				$data['item_id'] = $item_id;
				#$data['title']	 = "no title included";
				#$data['license'] = 1;
				$data['price']	 = $price;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '2':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = !empty($item_name) ? $item_name : "Southwest Wing";
				$data['item_id'] = $item_id;
				#$data['title']	= "";
				$data['price']	= $price;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '3':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "expert";
				$data['title']	= "expert";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '4':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "specialist";
				$data['title']	= "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '5':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "optical";
				$data['title_options'] = array(
					'licensed optician'				=> 'licensed optician',
					'licensed optician manager'		=> 'licensed optician manager',
					'apprenticed optician'			=> 'apprenticed optician',
					'licensed dispensing optician' 	=> 'licensed dispensing optician',
					'optical lead expert'			=> 'optical lead expert',
					'optical specialist'			=> 'optical specialist'
				);
				$this->load->view('order/form/additional_input_name_form_optical',$data);
				return;				
			break;
			case '7':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "minor specialist";
				$data['title']	= "specialist";
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '9':
				$data['number']	= $current_input_boxes_number + 1;
				$data['style']	= "custom decorating";
				$data['title_options'] = array(
					'in-home decorator'	=> 'in-home decorator',
					'installer'			=> 'installer'
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;				
			break;
			case '10':
				$data['number']		= $current_input_boxes_number + 1;
				$data['style']		= "salon";
				$data['title']		= "no title included";
				$data['license']	= 1;
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
			break;
			case '11':
				$data['number']	 = $current_input_boxes_number + 1;
				$data['style']	 = "tenured name badge";
				$data['service_year']	= array(
					'5'		=> '5 years (Amethyst)',
					'10'	=> '10 years (Ruby)',
					'15'	=> '15 years (Sapphire)',
					'20' 	=> '20 years (Diamond)',
					'25' 	=> '25 years (Peridot)',
				);
				$this->load->view('order/form/additional_input_name_form',$data);
				return;
		}
	}
	
	function showNamesField() {
		$type	= $this->input->post('type');
		$id     = $this->input->post('id');
		$item_name = '';
		$item_id = 0;
		$price = 0;
		if(!empty($id)){
			$item_detail = $this->db->get_where('items',array('item_id' => (int)$id), 1)->result_array();
			//print_r($item_detail); exit;
			$item_name = $item_detail[0]['item_name'];
			$item_id = $item_detail[0]['item_id'];
			$price = $item_detail[0]['item_price'];
		}
		switch ($type) {
			case '1':
				$data	= array();
				$data['description']	= "";
				$data['style']			= !empty($item_name) ? $item_name : "Southwest Name Badge";
				$data['item_id']			= $item_id;
				#$data['title']			= "no title included";
				$data['type']			= 1;
				$data['price']			= $price;
				//$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '2':
				$data	= array();
				$data['description']	= "";
				$data['style']			= !empty($item_name) ? $item_name : "Southwest Wing";
				$data['item_id']			= $item_id;
				#$data['title']			= "no title included";
				$data['type']			= 2;
				$data['price']			= $price;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '3':
				$data	= array();
				$data['description']	= "Title: expert";
				$data['style']			= "expert";
				$data['title']			= "expert";
				$data['type']			= 3;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '4':
				$data	= array();
				$data['description']	= "Title: specialist";
				$data['style']			= "specialist";
				$data['title']			= "specialist";
				$data['type']			= 4;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '5':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "optical";
				$data['type']			= 5;
				$data['title_options'] 	= array(
					'licensed optician'				=> 'licensed optician',
					'licensed optician manager'		=> 'licensed optician manager',
					'apprenticed optician'			=> 'apprenticed optician',
					'licensed dispensing optician' 	=> 'licensed dispensing optician',
					'optical lead expert'			=> 'optical lead expert',
					'optical specialist'			=> 'optical specialist'
				);
				
				$this->load->view('order/form/input_names_form_optical',$data);
				break;
			case '6':
				$data = array();
				$this->load->view('order/form/input_names_form_generic',$data);
				break;
			case '7':
				$data	= array();
				$data['description']	= "Enter Name For Minor Badge";
				$data['style']			= "minor specialist";
				$data['title']			= "specialist";
				$data['type']			= 7;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '8':
				$data	= array();
				$this->load->view('order/form/input_names_form_minor',$data);
				break;
			case '9':
				$data	= array();
				$data['description']	= "Title: Please Select For Each Badge";
				$data['style']			= "custom decorating";
				$data['type']			= 9;
				$data['title_options'] 	= array(
					'in-home decorator'	=> 'in-home decorator',
					'installer'			=> 'installer'
				);
				
				$this->load->view('order/form/input_names_form',$data);
				break;
				break;
			case '10':
				$data	= array();
				$data['description']	= "No Titles On Salon Badges";
				$data['style']			= "salon";
				//$data['title']			= "salon";
				$data['title']		= "no title included";
				$data['type']			= 10;
				$data['license']		= 1;
				$this->load->view('order/form/input_names_form',$data);
				break;
			case '11':
				$data	= array();
				$data['description']	= "";
				$data['style']			= "tenured name badge";
				$data['type']			= 11;
				$data['service_year']	= array(
					'5'		=> '5 years (Amethyst)',
					'10'	=> '10 years (Ruby)',
					'15'	=> '15 years (Sapphire)',
					'20' 	=> '20 years (Diamond)',
					'25' 	=> '25 years (Peridot)',
				);
				$this->load->view('order/form/input_names_form',$data);
				break;
		}
	}
	
	function deleteApprovalBadge() {
		$item_id 	= $this->input->post('item_id');
		$order_id	= $this->input->post('order_id');
		$order 		= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$order_id));
		$items		= (count($order)>0)?unserialize($order->order_items):'';			

		$badges	= $items;
		unset($badges[$item_id]);
		
		$new_badges	= array();
		foreach($badges as $badge) {
			$new_badges[] = $badge;
		}
		if(count($new_badges)>0) {
			$items = $new_badges;
		} else {
			$items = '';
		}
		
		$data = array('order_items'=>serialize($items));
		$data['order_total'] = $order->order_total - 1;
		
		# save order into database
		$this->order_model->saveItem('orders',array('id'=>$order_id,'field'=>'order_id'),$data);
		
		echo json_encode($data);
	}
	
	function deleteApprovalExtras() {
		$type 		= $this->input->post('type');
		$order_id	= $this->input->post('order_id');
		
		$order 		= $this->order_model->getItemDetail('orders',array('field'=>'order_id','id'=>$order_id));
		
		$data = array();
		switch ($type) {
			case '1': 
				$order->order_mf_qty = $data['order_mf_qty'] = 0;
			break;
			case '2':
				$order->order_pf_qty = $data['order_pf_qty'] = 0;
			break;
		}
		
		# save order into database
		$this->order_model->saveItem('orders',array('id'=>$order_id,'field'=>'order_id'),$data);
		$total_extras = $order->order_mf_qty + $order->order_pf_qty;
		
		$data = array(
			'removed_item'		=> $type,
			'total_extras'		=> "$total_extras"
		);
		echo json_encode($data);
	}
	
	function deleteBadge() {		
		//echo '<pre>'; print_r($this->session->userdata['cart']); exit;
		$id 	= (int)$this->input->post('item_id');
		$cart 	= $this->session->userdata['cart'];
		$total_cost = isset($this->session->userdata['badges_total_cost']) ? $this->session->userdata['badges_total_cost'] : 0;
		$badges	= $cart['badges'];
		
		unset($badges[$id]);
		$new_badges	= array();
		$total_cost = 0;
		foreach($badges as $badge) {
			$new_badges[] = $badge;
			$total_cost = $total_cost + $badge['price'];
		}
		if(count($new_badges)>0) {
			$cart['badges']	= $new_badges;
		} else {
			unset($cart['badges']);
		}
		$this->session->set_userdata('cart',$cart);
		$this->session->set_userdata('badges_total_cost',$total_cost);

		$cart_total	= $this->session->userdata['cart_total'];
		$this->session->set_userdata('cart_total',$cart_total-1);
		
		$total_mf	= (isset($cart['order_mf_qty']))?$cart['order_mf_qty']:0;
		$total_pf	= (isset($cart['order_pf_qty']))?$cart['order_pf_qty']:0;
		
		$total_order_price = number_format(($cart_total-1)*10.00 + $total_mf * 3.00 + $total_pf * 3.5,2);
		$tmp	= explode(".", $total_order_price);
		$first 	= $tmp[0];
		$last	= $tmp[1];
		if($last > 0){
			$last = trim($last,'0');
		}
		$total_price = $first.'.'.$last;
		
		$data = array(
			'total_badges'		=> $cart_total-1,
			'total_order_price' => $total_price
		);
		
		echo json_encode($data);
		
	}
	
	function deleteExtras() {
		$type 	= (int)$this->input->post('type');
		$cart	= $this->session->userdata['cart'];
		$total_cost = isset($this->session->userdata['extras_total_cost']) ? $this->session->userdata['extras_total_cost'] : 0;
		$extras	= $cart['extras'];
		//echo '<pre>'; print_r($cart); exit;
		
		unset($extras[$type]);
		$new_extras	= array();
		$total_cost = 0;
		foreach($extras as $extra) {
			$new_extras[] = $extra;
			$total_cost = $total_cost + $extra['item_price']*$extra['item_qty'];
		}

		if(count($new_extras)>0) {
			$cart['extras']	= $new_extras;
		} else {
			unset($cart['extras']);
		}


		$total_badges	= isset($this->session->userdata['cart_total'])?$this->session->userdata['cart_total']:0;
		$badges_cost	= $total_badges*10.00;
		$extras_cost	= 0;
		/*switch ($type) {
			
			case '1':
				unset($cart['order_mf_qty']);
				$extras_cost = isset($cart['order_pf_qty']) ? $cart['order_pf_qty'] * 3.5: 0; 
			break;
			case '2':
				unset($cart['order_pf_qty']);
				$extras_cost = isset($cart['order_mf_qty']) ? $cart['order_mf_qty'] * 6.25: 0;
			break;
		}*/
		
		$this->session->set_userdata('cart',$cart);
		$this->session->set_userdata('extras_total_cost',$total_cost);

		$data = array(
			'removed_item'		=> $type,
			//'total_extras'		=> (!isset($cart['order_mf_qty'])&&!isset($cart['order_pf_qty'])) ? 0 : 1, // commented by sunny on 17-march-2016
			'total_extras'		=> (!isset($cart['extras'])) ? 0 : 1,
			'total_cost'		=> number_format($badges_cost + $extras_cost,2)
		);
		echo json_encode($data);
	}
	
	function deleteCart(){
		$this->session->unset_userdata('cart');
		$this->session->unset_userdata('badges_total_cost');
		$this->session->unset_userdata('extras_total_cost');
		$this->session->unset_userdata('cart_total');
	}
	
	function abcxyz() {
		$this->load->view('order/list_extras');
	}
	
	function changeStoreShippingAddress() {
		$store_id = $this->input->post('store_id');
		if($store_id!="") {
			$this->load->model('store/store_model');
			$store	= $this->store_model->getStoreDetail(array('store_id'=>$store_id));
			
			$data['store']	= $store;
			$this->load->view('shipping_address',$data);
		} else {
			echo "";
		}
	}

	function array_column(array $array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (!is_array($subArray)) {
                continue;
            } elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $result[$subArray[$indexKey]] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}