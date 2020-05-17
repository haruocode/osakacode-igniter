<?php

/**
 * @property \CI_Migration $migration
 * @property \CI_Loader    $load
 * @property \CI_Config    $config
 */
class MigrateController extends AdminAuthController
{
    public function index()
    {
        $this->load->library('migration');
        $this->load->config('migration');

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }else{
//            echo $this->config->item('migration_version');
            $this->showVersion();
        }
    }
    private function showVersion() {
        echo 'current: ' . $this->config->item('migration_version') . '<br>';
        echo 'database: ' . $this->getDbVersion() . '<br>';
        echo 'latest: ' . $this->getLatestVersion() . '<br>';
    }
    private function getLatestVersion()
    {
        $files = $this->migration->find_migrations();

        if ($files === []) {
            return 'null';
        }

        end($files);
        return key($files);
    }
    private function getDbVersion()
    {
        $row = $this->db->select('version')->get($this->config->item('migration_table'))->row();
        return $row ? $row->version : '0';
    }

}