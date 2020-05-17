<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require BASEPATH . '../vendor/autoload.php';

/**
 * Class MY_Controller
 * @property Blade $blade
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Encryption encryption
 * @property CI_DB $db
 */
class MY_Controller extends CI_Controller {

    public $is_pjax = false;
    public $current_menu = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('blade');
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('payment');
        $this->load->helper('translate');
        $this->load->helper('form');
        $this->load->helper('template');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('common');
        $this->load->helper('generate_url');
        $this->load->helper('rewrite_url');
        $this->load->helper('api_url');
        $this->output->enable_profiler($this->config->item('enable_profiler'));

        $this->encryption->initialize([
            'cipher' => 'aes-256',
            'mode' => 'ctr',
            'key' => hex2bin('124d65cd6a939e1116425c5d47f8a2e9')
        ]);

        //check pjax
        if($this->input->is_ajax_request()) {
            $headers = $this->input->request_headers();
            if(isset($headers['X-PJAX'])) {
                $this->is_pjax = true;
            }
        }
    }

    protected function _attachLessonStatus(&$list_lessons)
    {
        if (check_logged() && $list_lessons) {
            $user_id = $this->session->userdata('id');
            $array_id = [];
            foreach ($list_lessons as $lesson) {
                $array_id[] = $lesson->id;
            }
            if(!$array_id) {
                return true;
            }
            $result = $this->db->select('lesson_id,status')
                ->from('users_lessons')
                ->where(['user_id' => $user_id])
                ->where_in('lesson_id', $array_id)
                ->get();
            if ($result) {
                foreach ($result->result() as $row) {
                    $list_lessons[$row->lesson_id]->status = $row->status;
                }
            }
            return true;
        }
        return false;
    }

    protected function _attachLessonWatchLaterStatus(&$list_lessons) {
        if (check_logged() && $list_lessons) {
            $user_id = intval($this->session->userdata('id'));
            $array_id = [];
            foreach ($list_lessons as $lesson) {
                $array_id[] = $lesson->id;
            }
            $result = $this->db->select('object_id')
                ->from('playlist')
                ->where([
                    'user_id' => $user_id,
                    'object_type'=>PLAYLIST_OBJECT_TYPE_LESSON,
                    'playlist_type'=>PLAYLIST_WATCH_LATER_TYPE
                ])
                ->where_in('object_id', $array_id)
                ->get();
            if ($result) {
                foreach ($result->result() as $row) {
                    $list_lessons[$row->object_id]->in_watch_later = 1;
                }
            }
        }
        return false;
    }
    protected function checkUserLogin() {
        return !!($this->session->userdata('id'));
    }
    protected function _saveFileFromTmpUpload($filename) {
        if(!$filename) {
            return;
        }
        $pathDir = generate_image_dir_upload($filename,'original');
        return copy(TEMP_UPLOAD_DIR . '/' .$filename,$pathDir . $filename);
    }
}
require_once APPPATH . 'controllers/admin/AdminAuthController.php';