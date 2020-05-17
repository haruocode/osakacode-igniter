<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Payjp\Payjp;
class Payment
{
    protected $secret_key = '';
    protected $webpay;
    public static $public_key = '';
    public $id;

    function __construct() {
        //$this->webpay = new WebPay($this->secret_key);
        Payjp::setApiKey($this->secret_key);
    }

    /**
     * @return string customer_id of webpay
     */
    public function create_customer($card_token) {
        $customer_info = array(
          'card'        => $card_token,             //トークンID
          'description' => 'test'                   //備考
        );
        return \Payjp\Customer::create($customer_info);
    }

    /**
     * Creating a new recurring billing
     */
    public function create_recursion($amount, $currency, $customer_id, $period, $description = NULL) {

        $id = time();
        $subscription_info = array(
          'customer'  => $customer_id, //一意の顧客ID
          'plan'      => 'monthly'     //トークンID(現在payjpは月額プランのみ)
        );
        return \Payjp\Subscription::create($subscription_info);
    }

    /** test recursion */

    public function test_recursion($user_object, $time){
        return $this->webpay->recursion->create([
            'amount' => 999,
            'currency' => 'jpy',
            'customer' => $user_object,
            'period' => 'month',
            'first_scheduled' => $time
        ]);
    }

    /**
     * @return charge_id of the transaction
     */

    public function create_charge($amount, $currency, $customer, $description = NULL){
        return $this->webpay->charge->create([
            'amount' => $amount,
            'currency' => $currency,
            'customer' => $customer,
            'description' => $description
        ]);

        
    }

    /**
     * Adding a new card
     */
    public function add_card($user_object, $token) {
        $cu = \Payjp\Customer::retrieve($user_object);
        return $cu->cards->create(array('card' => $token));
    }

    /**
     * Update default card
     */
    public function update_default_card($customer_id, $card_id) {
	$cu = \Payjp\Customer::retrieve($customer_id);
	$cu->default_card = $card_id;
	return $cu->save();
    }

    /**
     * @return a NULL recursion
     */
    
    public function delete_recursion($recursion_id){
        $su = \Payjp\Subscription::retrieve($recursion_id);
	    $su->delete();
    }

    /**
     * @return the detail of a charge
     */
    
    public function retrieve_charge($charge_id){
        return $this->webpay->charge->retrieve($charge_id);
    }

    public function retrieve_recursion($recursion_id){
        return \Payjp\Subscription::retrieve($recursion_id);
    }

}