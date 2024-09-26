<?php

/*
 *  Made by AMGewka
 *  https://github.com/AMGewka
 *
 *  License: MIT
 *
 *  Store module
 */
require_once(ROOT_PATH . '/modules/Store/classes/StoreConfig.php');
$anypay_language = new Language(ROOT_PATH . '/modules/Store/gateways/ANYPAY/language', LANGUAGE);

$smarty->assign([
    'SHOP_ID' => $anypay_language->get('shopid'),
    'SHOP_KEY' => $anypay_language->get('secret'),
    'RE_EMAIL' => $anypay_language->get('reemail'),
    'ENABLE_GATEWAY' => $anypay_language->get('enablegateway'),
    'GATEWAY_NAME' => $anypay_language->get('gatewayname'),
    'BANK_CARD' => $anypay_language->get('bankcard'),
    'ONLINE_PAYMENTS' => $anypay_language->get('onlinepay'),
    'ONLINE_WALLET' => $anypay_language->get('onlinewal'),
    'MOBILE_OPERATOR' => $anypay_language->get('mobileoper'),
    'CRYPTOCURRENCIES' => $anypay_language->get('crypto'),
    'GATEWAY_LINK' => $anypay_language->get('gatewaylink'),
    'GATEWAY_TESTED' => $anypay_language->get('gatewaytest'),
    'ALERT_URL' => $anypay_language->get('alerturl'),
    'SUCCESS_URL' => $anypay_language->get('sucurl'),
    'FAILED_URL' => $anypay_language->get('failurl')
]);

if (Input::exists()) {
    if (Token::check()) {
        if (isset($_POST['shopid_key']) && isset($_POST['secret1_key']) && isset($_POST['admin_email']) && strlen($_POST['shopid_key']) && strlen($_POST['admin_email']) && strlen($_POST['secret1_key'])) {
            StoreConfig::set('ANYPAY.shopid_key', $_POST['shopid_key']);
            StoreConfig::set('ANYPAY.secret1_key', $_POST['secret1_key']);
            StoreConfig::set('ANYPAY.admin_email', $_POST['admin_email']);
        }

        // Is this gateway enabled
        if (isset($_POST['enable']) && $_POST['enable'] == 'on') $enabled = 1;
        else $enabled = 0;

        DB::getInstance()->update('store_gateways', $gateway->getId(), [
            'enabled' => $enabled
        ]);

        Session::flash('gateways_success', $language->get('admin', 'successfully_updated'));
    } else
        $errors = [$language->get('general', 'invalid_token')];
}

$smarty->assign([
    'SETTINGS_TEMPLATE' => ROOT_PATH . '/modules/Store/gateways/ANYPAY/gateway_settings/settings.tpl',
    'ENABLE_VALUE' => ((isset($enabled)) ? $enabled : $gateway->isEnabled()),
    'SHOP_ID_VALUE' => ((isset($_POST['shopid_key']) && $_POST['shopid_key']) ? Output::getClean(Input::get('shopid_key')) : StoreConfig::get('ANYPAY.shopid_key')),
    'SHOP_API_KEY_VALUE' => ((isset($_POST['secret1_key']) && $_POST['secret1_key']) ? Output::getClean(Input::get('secret1_key')) : StoreConfig::get('ANYPAY.secret1_key')),
    'ADMIN_EMAIL' => ((isset($_POST['admin_email']) && $_POST['admin_email']) ? Output::getClean(Input::get('admin_email')) : StoreConfig::get('ANYPAY.admin_email'))
]);