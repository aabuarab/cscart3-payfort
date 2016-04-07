function fn_payfort_fort_show_merchant_page(merchantPageUrl) {
    if($("#payfort_merchant_page").size()) {
        $( "#payfort_merchant_page" ).remove();
    }
    //$("#review-buttons-container .btn-checkout").hide();
    //$("#review-please-wait").show();
    
    $('<iframe  name="payfort_merchant_page" id="payfort_merchant_page"height="550px" frameborder="0" scrolling="no" onload="fn_payfort_fort_Iframe_loaded(this)" style="display:none"></iframe>').appendTo('#pf_iframe_content');
    $('.pf-iframe-spin').show();
    $('.pf-iframe-close').hide();
    $( "#payfort_merchant_page" ).attr("src", merchantPageUrl);
    $( "#payfort_payment_form" ).attr("action", merchantPageUrl);
    $( "#payfort_payment_form" ).attr("target","payfort_merchant_page");
    $( "#payfort_payment_form" ).children('.cm-no-hide-input').remove();
    $( "#payfort_payment_form" ).submit();
    //fix for touch devices
    if (fn_payfort_fort_is_touch_device()) {
        setTimeout(function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }, 1);
    }
    $( "#div-pf-iframe" ).show();
}

function fn_payfort_fort_is_touch_device() {
  return 'ontouchstart' in window        // works on most browsers 
      || navigator.maxTouchPoints;       // works on IE10/11 and Surface
}

function fn_payfort_fort_close_popup() {
    $( "#div-pf-iframe" ).hide();
    $( "#payfort_merchant_page" ).remove();
    //window.location = $( "#payfort_cancel_url" ).val();
}
function fn_payfort_fort_Iframe_loaded(ele) {
    $('.pf-iframe-spin').hide();
    $('.pf-iframe-close').show();
    $('#payfort_merchant_page').show();
}