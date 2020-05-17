<?php
require("../library/sendgrid-php/sendgrid-php.php");
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('series_model','series');
        $this->load->model('user_model','user');
    }

    public function index()
    {
    	if($this->input->post() == NULL) {
            $data = [
            'head_title' => 'お問い合わせ',
            'head_keyword' => 'プログラミング,問い合わせ,質問',
            'head_desc' => 'サイトへのご質問、ご要望はこちらからお問い合わせください。',
            'title' => '大阪コード学園サポート',
            'username' => $this->session->userdata('username'),
            'email' => $this->session->userdata('email'),
            ];

            $this->blade->render('front.contact', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $question = $this->input->post('question');

            if($this->send_mail($name, $email, $question)) {                
                $this->session->set_tempdata('sendMess', TRUE, 5);
                header('Location: home');
            } else {
                echo 
                    "<script language='javascript'>
                    alert('メールを送信しました。返信までしばらくお待ちください。');
                    window.location.href='/home';
                    </script>";
            }
        }
    }

    protected function send_mail($name, $email_user, $question){
        // using SendGrid's PHP Library - https://github.com/sendgrid/sendgrid-php
        $sendgrid = new SendGrid(GRID_USER, GRID_PASS);
        $email    = new SendGrid\Email();

        // Parameters for email
        $data = [
            'name' => $name,
            'email' => $email_user,
            'question' => $question,
        ];

        // Content of the email
        $content = $this->load->view('email/customer_message.php', $data, TRUE);

        $email->addTo(RECEIVER_EMAIL)
              ->setFrom("no-reply@mail.com")
              ->setSubject("会員様からお問い合わせがありました")
              ->setHtml($content);

        if(!$sendgrid->send($email)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    protected function send_mail2($name, $email, $question)
    {
        $this->load->helper('email');
        $this->load->library('email');

        // Parameters for email
        $data = [
            'name' => $name,
            'email' => $email,
            'question' => $question,
        ];

        // Content of the email
        $content = $this->load->view('email/customer_message.php', $data, TRUE);

        $this->email->from('', 'no-reply@mail.com');
        $this->email->to(RECEIVER_EMAIL);

        $this->email->subject('会員様からお問い合わせがありました');
        $this->email->message($content);

        if(!$this->email->send()) {
            echo 
                    "<script language='javascript'>
                    alert('メール送信に失敗しました。再度お試し下さい。');
                    window.location.href='/contact';
                    </script>";
        } else {
            echo 
                    "<script language='javascript'>
                    alert('メールを送信しました。返信までしばらくお待ちください。');
                    window.location.href='/home';
                    </script>";
        }
    }
}