<?php

if ( !defined('AREA') ) { die('Access denied'); }

if ($mode == 'get_merchant_page_data') {

    $cart = empty($_SESSION['cart']) ? array() : $_SESSION['cart'];
    if(empty($cart)) {
        echo json_encode(array('error' => true));
        exit;
    }
    $cart['payment_info'] = array(
        
    );
    
    $payment_id = (empty($_REQUEST['payment_id']) ? $cart['payment_id'] : $_REQUEST['payment_id']);
    
    $processor_data = fn_get_payment_method_data($payment_id);
    
    $customer_auth = fn_fill_auth($cart['user_data']);
    $arrPlaceOrderParams = array('payment_id' => $payment_id);
    $checkout_place_order_status = fn_checkout_place_order($cart, $customer_auth, $arrPlaceOrderParams);
    if($checkout_place_order_status == PLACE_ORDER_STATUS_DENIED || $checkout_place_order_status == PLACE_ORDER_STATUS_TO_CART) {
        echo json_encode(array('error' => true));
        exit;
    }
}
