<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FaqController extends MY_Controller
{
  public function __construct()
  {
      parent::__construct();
      $this->load->model('series_model','series');
      $this->load->model('user_model','user');
  }

  public function index()
  {
    $data = [];
    $data['head_title'] = 'よくある質問';
    $data['head_keyword'] = 'よくある質問,FAQ';
    $data['head_desc'] = 'よくある質問の回答です。';
    $this->blade->render('front.faq', $data);
  }
}