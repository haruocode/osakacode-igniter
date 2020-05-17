<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionController extends MY_Controller
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
    $data['head_title'] = '特定商取引に関する法律に基づく表記';
    $data['head_keyword'] = '特定商取引に関する法律に基づく表記';
    $data['head_desc'] = '特定商取引に関する法律に基づく表記';
    $this->blade->render('front.transaction', $data);
  }
}