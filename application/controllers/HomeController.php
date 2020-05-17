<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('series_model','series');
    }
    
	public function index()
	{
        $data_view = [
            'head_keyword' => 'プログラミング,動画,無料,学習,チュートリアル,入門',
            'head_desc' => '文系向けのプログラミング入門無料動画サイト「大阪コード学園」',
            'class_body' => 'home',
            'list_series' => $this->getFeatureSeries(8),
            'list_skills' => $this->getFeatureSkills(4)
        ];
		$this->blade->render('front.index',$data_view);
	}

	protected function getFeatureSeries($limit = 8)
    {
        $list_series = $this->series
                        ->with_lessons('fields:*count*')
                        ->where('featured',1)
                        ->order_by('id')
                        ->limit($limit)
                        ->get_all();
        return $list_series ? $list_series : [];
    }

    protected function getFeatureSkills($limit = 4)
    {
        return [];
    }
}
