<?php

class AdminAuthController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }

    private function checkLogin() {
        $username = $this->session->userdata('admin');
        $password = $this->session->userdata('password');
        if($username && $password) {
            return true;
        }
        redirect(admin_login());
        return false;
    }
}