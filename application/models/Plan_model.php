<?php

class Plan_model extends MY_Model
{
    public function __construct()
    {
        $this->load->database();
        parent:: __construct();
    }

    public function get_all_plans()
    {
        $query = $this->db->get('plans');
        return $query->result_array();
    }

    public function check_plan($plan_id)
    {
		return !!$this->count(['id'=>$plan_id]);
    }

    public function get_plan_detail($plan_id){
        if ($plan_id == NULL) {
            return NULL;
        }
        
        return $this->where('id',$plan_id)->get();
    }

}