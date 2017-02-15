<?php
	// Remove Unwanted Columns
	function sv_wc_csv_export_remove_order_column( $column_headers ) {

		unset( $column_headers['order_date']);
		unset( $column_headers['status'] );
		unset( $column_headers['shipping_total'] );
		unset( $column_headers['shipping_tax_total'] );
		unset( $column_headers['fee_total'] );
		unset( $column_headers['fee_tax_total'] );
		unset( $column_headers['tax_total'] );
		unset( $column_headers['cart_discount'] );
		unset( $column_headers['order_discount'] );
		unset( $column_headers['discount_total'] );
		unset( $column_headers['refunded_total'] );
		unset( $column_headers['shipping_method'] );
		unset( $column_headers['item_meta'] );
		unset( $column_headers['item_tax'] );
		unset( $column_headers['item_refunded'] );
		unset( $column_headers['shipping_items'] );
		unset( $column_headers['fee_items'] );
		unset( $column_headers['tax_items'] );
		unset( $column_headers['coupon_items'] );
		unset( $column_headers['order_notes'] );
		unset( $column_headers['download_permissions'] );
		unset( $column_headers['customer_note'] );
		unset( $column_headers['order_comments'] );
		unset( $column_headers['billing_title'] );
		return $column_headers;
	}
	add_filter( 'wc_customer_order_csv_export_order_headers', 'sv_wc_csv_export_remove_order_column' );


	/** Add custom column headers **/
	function wc_csv_export_modify_column_headers( $column_headers ) {

		$new_headers = array(
			'fund' => 'fund',
			'appeal' => 'appeal_code',
			'lwrgifts' => 'lwrgifts',
			'prod_cats' => 'item category',
			'addl_info' => 'additional info',
		);

		return array_merge( $column_headers, $new_headers );
	}
	add_filter( 'wc_customer_order_csv_export_order_headers', 'wc_csv_export_modify_column_headers' );
	
	
	/** Move column headers **/
	function wc_csv_export_move_column_headers( $column_headers ) {
		
		$moved_headers = array();
	
				foreach ( $column_headers as $column_key => $column_name ) {
						$moved_headers[ $column_key ] = $column_name;
		
						if ( 'order_number' == $column_key ) {
							// add order date immediately after order_number
							$moved_headers['order_date'] = 'date';
						}
						if ( 'customer_id' == $column_key ) {
							$moved_headers['billing_title'] = 'billing_title';
						}
				}

		return $moved_headers;
	
	}
	add_filter( 'wc_customer_order_csv_export_order_headers', 'wc_csv_export_move_column_headers' );

	

	/** Set the data for each for custom columns **/
	function wc_csv_export_modify_row_data( $order_data, $item, $order, $csv_generator ) {

		// Determine the product ID from the SKU, and use that to find the fund and appeal code
		$pid = wc_get_product_id_by_sku($item[sku]);
		$fund = wc_get_product_terms( $pid, 'pa_fund' );
		$appeal = wc_get_product_terms( $pid, 'pa_appeal-code' );
		$lwrgifts = wc_get_product_terms( $pid, 'pa_att-lwrgifts' );
		$prod_cats = wc_get_product_terms( $pid, 'product_cat' );
		
			foreach ($prod_cats as $prod_cat) {
				$cat_parent = $prod_cat->parent;
			}
			if ($cat_parent != '0' ) {
				$parent_cat = get_term_by( 'id', $cat_parent, 'product_cat' ); // implode( ', ', $cat_name );
				$cats = $parent_cat->name;
			} else {
				$cats = $prod_cat->name;
			}

		$date = $order->order_date;
		$new_date = date('n-d-Y', strtotime($date) );
		
							
		// Add the fund & appeal code to the order_data & return each line
		$order_data['order_date'] = $new_date;
		$order_data['fund'] = $fund[0];
		$order_data['appeal'] = $appeal[0];
		$order_data['lwrgifts'] = $lwrgifts[0];
		$order_data['prod_cats'] = $cats;
		$order_data['addl_info'] = $item['meta'];
		
		// print_r($parent_cat);
		return $order_data;
			
	}
	add_filter( 'wc_customer_order_csv_export_order_row_one_row_per_item', 'wc_csv_export_modify_row_data', 10, 4 );



	function resource_import_format( $order_data, $order ) {

			$order_data[2][ "order_number" ] = $order_data[2][ "order_number" ];

		return $order_data;
	}
	add_filter( 'wc_customer_order_csv_export_order_row', 'resource_import_format', 20, 2 );
	

	
?>