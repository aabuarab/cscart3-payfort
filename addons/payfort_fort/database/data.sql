REPLACE INTO ?:payment_processors (processor, processor_script, processor_template, admin_template, callback, type) VALUES ('PayFort Credit Card', 'payfort_fort_cc.php', '../../../../addons/payfort_fort/views/orders/components/payments/payfort_fort_cc.tpl', 'payfort_fort_cc.tpl', 'N', 'P');
REPLACE INTO ?:payment_processors (processor, processor_script, processor_template, admin_template, callback, type) VALUES ('PayFort Sadad', 'payfort_fort_sadad.php', 'cc_outside.tpl', 'payfort_fort_sadad.tpl', 'N', 'P');
REPLACE INTO ?:payment_processors (processor, processor_script, processor_template, admin_template, callback, type) VALUES ('PayFort Naps', 'payfort_fort_naps.php', 'cc_outside.tpl', 'payfort_fort_naps.tpl', 'N', 'P');