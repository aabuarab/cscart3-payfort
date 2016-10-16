<?php
if ( !defined('AREA') ) { die('Access denied'); }

require_once dirname(__FILE__) . "/payfort.functions.php";

function fn_update_payfort_fort_settings($settings)
{
    if (isset($settings['payment_settings'])) {
        $settings['payment_settings'] = serialize($settings['payment_settings']);
    }
    
    foreach ($settings as $setting_name => $setting_value) {
        CSettings::instance()->update_value($setting_name, $setting_value, 'payfort_fort');
    }
}

function fn_get_payfort_fort_settings($lang_code = DESCR_SL)
{
    $payfort_fort_settings = CSettings::instance()->get_values('payfort_fort', 'ADDON');
    if (!empty($payfort_fort_settings['general']['payment_settings'])) {
        $payfort_fort_settings['general']['payment_settings'] = unserialize($payfort_fort_settings['general']['payment_settings']);
    }
    
    return $payfort_fort_settings['general'];
}

function fn_payfort_fort_get_payment_methods(&$payment_methods, &$auth)
{
    $area = AREA;
    if($area == 'C') {
        
        foreach($payment_methods as $k => $payment ) {
            $processor_data = fn_get_processor_data($payment['payment_id']);
            if($processor_data['processor_script'] == 'payfort_fort_sadad.php' || $processor_data['processor_script'] == 'payfort_fort_naps.php') {
                if($processor_data['processor_script'] == 'payfort_fort_sadad.php') {
                    $allowedCurrency = 'SAR';
                }
                if($processor_data['processor_script'] == 'payfort_fort_naps.php') {
                    $allowedCurrency = 'QAR';
                }
                $pfHelper = Payfort_Fort_Helper::getInstance();
                $currency = $pfHelper->getFortCurrency(CART_PRIMARY_CURRENCY, CART_SECONDARY_CURRENCY);
                
                if($currency != $allowedCurrency) {
                    unset($payment_methods[$k]);
                }
            }
        }
    }
}

//function fn_payfort_fort_pre_place_order(&$cart, &$allow) {
    //$cart['rewrite_order_id'] = array();
//}

//function fn_validate_paypal_order_info($data, $order_info)
//{
//    if (empty($data) || empty($order_info)) {
//        return false;
//    }
//
//    $errors = array();
//    $currency_code = null;
//    $total = isset($order_info['total']) ? $order_info['total'] : null;
//
//    if (!empty($order_info['payment_method']['processor_params']['currency'])) {
//        $currency = fn_payfort_fort_get_valid_currency($order_info['payment_method']['processor_params']['currency']);
//        $currency_code = $currency['code'];
//
//        if ($total && $currency_code != CART_PRIMARY_CURRENCY) {
//            $total = fn_format_price_by_currency($total, CART_PRIMARY_CURRENCY, $currency_code);
//        }
//    }
//
//    if (!isset($data['num_cart_items']) || count($order_info['products']) != $data['num_cart_items']) {
//        if (
//            isset($order_info['payment_method'])
//            && isset($order_info['payment_method']['processor_id'])
//            && 'paypal.php' == db_get_field("SELECT processor_script FROM ?:payment_processors WHERE processor_id = ?i", $order_info['payment_method']['processor_id'])
//        ) {
//            list(, $count) = fn_pp_standart_prepare_products($order_info);
//
//            if ($count != $data['num_cart_items']) {
//                $errors[] = __('pp_product_count_is_incorrect');
//            }
//        }
//    }
//
//    if (!isset($data['mc_currency']) || $data['mc_currency'] != $currency_code) {
//        //if cureency defined in paypal settings do not match currency in IPN
//        $errors[] = __('pp_currency_is_incorrect');
//    } elseif (!isset($data['mc_gross']) || !isset($total) || (float) $data['mc_gross'] != (float) $total) {
//        //if currency is ok, check totals
//        $errors[] = __('pp_total_is_incorrect');
//    }
//
//    if (!empty($errors)) {
//        $pp_response['ipn_errors'] = implode('; ', $errors);
//        fn_update_order_payment_info($order_info['order_id'], $pp_response);
//        return false;
//    }
//    return true;
//}