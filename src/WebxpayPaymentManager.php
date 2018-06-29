<?php
namespace Isurindu\WebxpayLaravel;

use Illuminate\Support\Traits\Macroable;

class WebxpayPaymentManager
{
    use Macroable;

    protected $_order_id;
    protected $_price;
    protected $_first_name;
    protected $_last_name;
    protected $_email;
    protected $_contact_number;
    protected $_address_line_one;
    protected $_address_line_two;
    protected $_city;
    protected $_state;
    protected $_postal_code;
    protected $_country;
    protected $_process_currency;
    protected $_cms;
    protected $_custom_fields;

    protected $_url = 'https://webxpay.com/index.php?route=checkout/billing';

    /** init param */
    protected function _initParams($data)
    {
        foreach ($data as $key => $value) {
            $this->{"_".$key} = $value;
        }
    }
    /**
     * Create Payment Request
     *
     * @param array $data
     * @return void
     */
    public function redirect(array $data)
    {
        $this->_initParams($data);

        // dd($this->_first_name);
        $rsa = new \Crypt_RSA();
        $rsa->loadKey(config('webxpay.publickey'));

        // unique_order_id|total_amount
        $plaintext = "{$this->_order_id}|{$this->_price}";
        $encrypt = $rsa->encrypt($plaintext);
        //encode for data passing
        $payment = base64_encode($encrypt);


        $fields = [
            'first_name'=>$this->_first_name,
            'last_name'=>$this->_last_name,
            'email'=>$this->_email,
            'contact_number'=>$this->_contact_number,
            'address_line_one'=>$this->_address_line_one,
            'address_line_two'=>$this->_address_line_two,
            'city'=>$this->_city,
            'state'=>$this->_state,
            'postal_code'=>$this->_postal_code,
            'country'=>$this->_country,
            'process_currency'=>$this->_process_currency,
            'cms'=>$this->_cms,
            'custom_fields'=>$this->_custom_fields,
            'secret_key'=>config('webxpay.secret_key'),
            'payment'=>$payment,
        ];

        $url = $this->_url;
        return view('webxpay::payform', compact('fields', 'url'));
    }
    
    public function verify()
    {
        $rsa = new \Crypt_RSA();
        //decode & get POST parameters
        $payment = base64_decode($_POST ["payment"]);
        $signature = base64_decode($_POST ["signature"]);
        $custom_fields = base64_decode($_POST ["custom_fields"]);
        //load public key for signature matching
        $rsa->loadKey(config('webxpay.publickey'));

        //verify signature
        $signature_status = $rsa->verify($payment, $signature) ? true : false;
        //get payment response in segments
        //payment format: order_id|order_refference_number|date_time_transaction|payment_gateway_used|status_code|comment;
        $responseVariables = explode('|', $payment);

        //display values
        $custom_fields_varible = explode('|', $custom_fields);
       

        return [
            'signature_status'=>$signature_status,
            'response'=>$responseVariables,
            'custom_fields'=>$custom_fields_varible,
        ];
    }
}
