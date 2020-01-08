<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Omnipay\Omnipay;

require_once(APPPATH . 'third_party/omnipay/vendor/autoload.php');

class Stripe_gateway extends App_gateway
{
    public function __construct()
    {
        /**
        * Call App_gateway __construct function
        */
        parent::__construct();

        /**
        * REQUIRED
        * Gateway unique id
        * The ID must be alpha/alphanumeric
        */
        $this->setId('stripe');

        /**
         * REQUIRED
         * Gateway name
         */
        $this->setName('Stripe');

        /**
         * Add gateway settings
        */
        $this->setSettings(array(
            array(
                'name' => 'api_secret_key',
                'encrypted' => true,
                'label' => 'settings_paymentmethod_stripe_api_secret_key'
            ),
            array(
                'name' => 'api_publishable_key',
                'label' => 'settings_paymentmethod_stripe_api_publishable_key'
            ),
            array(
                'name' => 'currencies',
                'label' => 'settings_paymentmethod_currencies',
                'default_value' => 'USD,CAD'
            ),
            array(
                'name' => 'test_mode_enabled',
                'type' => 'yes_no',
                'default_value' => 1,
                'label' => 'settings_paymentmethod_testing_mode'
            )
        ));

        /**
         * REQUIRED
         * Hook gateway with other online payment modes
         */
        // add_action('before_add_online_payment_modes', array( $this, 'initMode' ));


    }

    public function process_payment($data)
    {
        redirect(site_url('gateways/stripe/make_payment?total=' . $data['amount'].'&currency='.$data['currency']));
    }

    public function finish_payment($data)
    {
        // Process online for PayPal payment start

        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($data['stripedata'][0]->secret_key);
        $oResponse = $gateway->purchase(array(
            'amount' => number_format($data['amount'], 2, '.', ''),
            'metadata' => array(
                'ClientID' => '464564'
            ),
            'description' => $data['description'],
            'currency' => $data['currency'],
            'token' => $data['stripeToken']
        ))->send();

        return $oResponse;
    }
    public function process_payment_booking($data)
    {
        $currency = $this->ci->session->userdata('pay_currency');
        $total = $this->ci->session->userdata('totalamount');
        redirect(site_url('gateways/stripe/make_payment_booking?total=' . $total.'&currency='.$currency));
    }
    public function process_payment_xml_booking($data)
    {
        $currency = $this->ci->session->userdata('pay_currency');
        $total = $this->ci->session->userdata('totalamount');
        redirect(site_url('gateways/stripe/make_payment_xml_booking?total=' . $total.'&currency='.$currency));
    }

}
