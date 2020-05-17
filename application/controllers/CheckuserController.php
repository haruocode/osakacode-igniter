<?php
/**
 * Created by PhpStorm.
 * User: tuand
 * Date: 1/18/2016
 * Time: 10:42 AM
 */

class CheckuserController extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function run(){
        echo "START CHECK AT : ".date('Y-m-d H:i:s');
        $users = $this->user_model->get_user_active();
        foreach ($users as $user) {
            echo " check user_id =".$user->id;
            $card_info = [];
            $card_info = $this->user_model->get_card_info($user->id)[0];
            if ($card_info && $card_info->recursion_id){
                echo " do check ";
                $recursion_detail = $this->payment->retrieve_recursion($card_info->recursion_id);
                if ($recursion_detail->status != 'active') {
                    echo " do remove ";
                    $this->user_model->remove_recursion($user->id);
                }else{
                    echo " OK ";
                }
            }else{
                echo " do remove ";
                $this->user_model->remove_recursion($user->id);
            }
            
        }
    }

    public function test($time){
        echo "start check";
        echo $this->payment->test_recursion('cus_apw3dS7AQat9c80', $time);
    }

    public function check(){
        echo "start check payment:  ";
        $card_info = $this->user_model->get_card_info(5)[0];
        $recursion_detail = $this->payment->retrieve_recursion($card_info->recursion_id);
        var_dump($recursion_detail);
        if ($recursion_detail->status == 'suspended') {
            // $this->user_model->remove_recursion($user->id);
            echo "支払いが失敗しました";
        }
    }

}