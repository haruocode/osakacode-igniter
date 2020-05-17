<?php
namespace Solid\Services;

class UserHistoryService implements HistoryService
{
    private $user_model;
    private $session;

    /**
     * @param mixed $user_model
     */
    public function setUserModel(\MY_Model $user_model)
    {
        $this->user_model = $user_model;
    }

    /**
     * @param mixed $session
     */
    public function setSession(\CI_Session $session)
    {
        $this->session = $session;
    }


    public function lastLogin()
    {
        if (!check_logged()) {
            return false;
        }
        $last_login = null;
        if($this->session instanceof \CI_Session) {
            $user_id = $this->session->userdata('id');
            if($this->user_model instanceof \User_history_model) {
                $last_login = $this->user_model->fields('last_login')
                    ->where(['user_id' => $user_id])
                    ->get();
            }
        }
        return $last_login ? $last_login->last_login : null;
    }

    public function writeLog()
    {
        if (!check_logged()) {
            return false;
        }
        if($this->user_model instanceof \User_history_model) {
            if($this->session instanceof \CI_Session) {
                $user_id = $this->session->userdata('id');
                return $this->user_model->update_last_login($user_id);
            }
        }
        return false;
    }
}