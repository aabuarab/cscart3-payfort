<?php
/**
 * @var array $processor_data
 * @var array $order_info
 * @var string $mode
 */
if ( !defined('AREA') ) { die('Access denied'); }

// Return from payfort website
if (defined('PAYMENT_NOTIFICATION')) {
    $payment_method = PAYFORT_FORT_PAYMENT_METHOD_INSTALLMENTS;
    $response_mode = 'online';
    $integration_type = PAYFORT_FORT_INTEGRATION_TYPE_REDIRECTION;
    if ($mode == 'return') {
        $response_mode = 'offline';
    }
    elseif($mode == 'merchantPageResponse') {
        $integration_type = PAYFORT_FORT_INTEGRATION_TYPE_MERCAHNT_PAGE;
    }
    if($mode == 'return' || $mode == 'responseOnline' || $mode == 'merchantPageResponse') {
        fn_payfort_fort_process_response($payment_method, $response_mode, $integration_type);
    }
    elseif ($mode == 'notify') {
        fn_order_placement_routines($_REQUEST['order_id'], false);
    }
    
} else {
    fn_payfort_fort_process_request($order_id, $order_info, PAYFORT_FORT_PAYMENT_METHOD_INSTALLMENTS);
}
exit;
