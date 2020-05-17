<?php
class LoginController extends MY_Controller {
    //TODO need refactor
    private $admin = 'super_admin';
    private $password = 'de147aa90';


    public function login()
    {
        $this->blade->render('admin.login');
    }

    public function postLogin()
    {
        $redirectUrl = $this->input->get('redirect');
        $redirectUrl = $redirectUrl || '/';
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->admin === $username && $this->password === $password) {
            $this->setSession();
            redirect($redirectUrl);
        }else{
            $this->blade->render('admin.login');
        }
    }

    private function setSession()
    {
        $this->session->set_userdata([
            'admin'=>$this->admin,
            'password'=>$this->password
        ]);
    }
}