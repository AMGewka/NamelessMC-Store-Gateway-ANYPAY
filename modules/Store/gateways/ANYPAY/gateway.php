<?php
/**
 * ANYPAY_Gateway class
 *
 * @package Modules\Store
 * @author AMGewka
 * @version 1.8.2
 * @license MIT
 */
class ANYPAY_Gateway extends GatewayBase {

    public function __construct() {
        $name = 'ANYPAY';
        $author = '<a href="https://github.com/AMGewka" target="_blank" rel="nofollow noopener">AMGewka</a>';
        $gateway_version = '1.8.2';
        $store_version = '1.7.1';
        $settings = ROOT_PATH . '/modules/Store/gateways/ANYPAY/gateway_settings/settings.php';

        parent::__construct($name, $author, $gateway_version, $store_version, $settings);
    }
    public function onCheckoutPageLoad(TemplateBase $template, Customer $customer): void {}

    public function processOrder(Order $order): void {
        $projectId = StoreConfig::get('ANYPAY.shopid_key');
        $secret_key = StoreConfig::get('ANYPAY.secret1_key');
        
        if ($projectId == null || empty($projectId)) {
            $this->addError('The administration has not completed the configuration of this gateway!');
            return;
        }

        $id = $order->data()->id;
        $username = $order->customer()->getUsername();
        $amount = $order->getAmount()->getTotalCents() / 100;
        $currency = $order->getAmount()->getCurrency();
        $desc = '';

        $email = $order->customer()->getUser()->data()->email;

        // Add the email parameter if it's not empty
        if (empty($email)) {
            $email = StoreConfig::get('ANYPAY.admin_email');
        }

        $arr_sign = array( 
            $projectId, 
            $id,
            $amount, 
            $currency,
            '',
            '',
            '', 
            $secret_key
        );

        $sign = hash('sha256', implode(':', $arr_sign)); 
        header("Location: https://anypay.io/merchant?merchant_id=" . $projectId
            . "&amount=" . $amount
            . "&currency=" . $currency
            . "&pay_id=" . $id
            . "&email=" . $email
            . "&sign=" . $sign);
    }


    public function handleReturn(): bool {
        if (isset($_GET['do']) && $_GET['do'] == 'success') {
            header("Location: " . URL::getSelfURL(), '/') . URL::build('/store/');
        }

        return false;
    }

    public function handleListener(): void {
        $projectId = StoreConfig::get('ANYPAY.shopid_key');
        $secretKey = StoreConfig::get('ANYPAY.secret1_key');
        $status = 'paid';

        $arr_ip = array(
            '185.162.128.38', 
            '185.162.128.39', 
            '185.162.128.88'
        );

        $arr_sign = array(
            $_REQUEST['currency'], 
            $_REQUEST['amount'], 
            $_REQUEST['pay_id'],
            $projectId,
            $status,
            $secretKey
        );

        $sign = hash('sha256', implode(":", $arr_sign)); 

        if(!in_array($_SERVER['REMOTE_ADDR'], $arr_ip)){
            die("bad ip!");
        } 

        if($sign != $_REQUEST['sign']){
            die('We have: ' . $sign);
        }

        $payment = new Payment($arr_sign[2], 'transaction');
        if ($payment->exists()) {
            $data = [
                'transaction' => $arr_sign[2],
                'amount_cents' => Store::toCents($arr_sign[1]),
                'currency' => $arr_sign[0],
                'fee_cents' => '0'
            ];
        } else {
            // Register new payment
            $data = [
                'order_id' => $arr_sign[2],
                'gateway_id' => $this->getId(),
                'transaction' => $arr_sign[2],
                'amount_cents' => Store::toCents($arr_sign[1]),
                'currency' => $arr_sign[0],
                'fee_cents' => '0'
            ];
        }

        $payment->handlePaymentEvent(Payment::COMPLETED, $data);
    }

}

$gateway = new ANYPAY_Gateway();