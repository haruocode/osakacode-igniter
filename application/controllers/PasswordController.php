<?php
require("../library/sendgrid-php/sendgrid-php.php");
class PasswordController extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        check_logged() ? show_404() : [];
    }

    public function create(){
        $data = [
          'head_title' => 'パスワードリセット',
          'head_keyword' => 'パスワード,リセット',
          'head_desc' => 'パスワードをリセットします。',
          'token' => $this->security->get_csrf_hash()
        ];
        $this->blade->render('password.create', $data);
    }

    public function email_check(){
        $ajax_return = [
            'error' => 0,
            'msg' => '',
            'success' => 0,
        ];
        if ($this->input->post()){
            $post_data = $this->input->post();
            if (!$this->user_model->check_email_db($post_data['email'])){
                $ajax_return['error'] = 1;
                echo json_encode($ajax_return);
                die();
            } else {
                $key = $this->user_model->create_reset_key($post_data['email']);
                $this->send_email($post_data, $key);
                $ajax_return['success'] = 1;
                echo json_encode($ajax_return);
                die();
            }
        }
    }

    private function send_email($post_data, $key){
        // using SendGrid's PHP Library - https://github.com/sendgrid/sendgrid-php
        $sendgrid = new SendGrid(GRID_USER, GRID_PASS);
        $email    = new SendGrid\Email();

        $email->addTo($post_data['email'])
              ->setFrom("no-reply@mail.com")
              ->setSubject("パスワードのリセット 大阪コード学園")
              ->setHtml('こちらのリンクからパスワードのリセットを行ってください。'. '</br> http://' . $_SERVER['SERVER_NAME'] .'/password/confirm/'.$key);
        $sendgrid->send($email);
    }

    private function send_email2($post_data, $key){
        $this->load->library('email');

        $this->email->from('', 'no-reply@mail.com');
        $this->email->to($post_data['email']);

        $this->email->subject('Get your forgotten Password');
        $this->email->message('Please go to this link to get your password.'. '</br> http://' . $_SERVER['SERVER_NAME'] .'/password/confirm/'.$key);

        $this->email->send();
    }

    public function confirm($key = 1){
        $data_view = [
            'head_title' => 'パスワードリセット確認',
            'head_keyword' => 'パスワード,リセット,確認',
            'head_desc' => 'パスワードリセット確認画面です。',
            'key' => $key,
            'token' => $this->security->get_csrf_hash(),
        ];
        if ($this->user_model->check_reset_key($key)){
            $this->blade->render('password.confirm', $data_view);
        } else {
            show_404();
        }
    }

    public function change_password(){
        if ($this->input->post()){
            $post_data = $this->input->post();
            $this->user_model->update_password($post_data['password'], $post_data['key']);
            header('Location: /home');
        }
    }
}