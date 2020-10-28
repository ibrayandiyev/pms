<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserCounter($table, $active = '')
    {
        $this->db->select('*');
        $this->db->from("$table as t");
        $this->db->join('login_credential', 'login_credential.user_id = t.id', 'left');
        if ($active == 'active') {
            $this->db->where('login_credential.active', 1);
        } elseif($active == 'total') {
            $this->db->where_in('login_credential.active', array(0, 1));
        }

        if ($table == 'administrator') {
            $this->db->where('login_credential.role', 1);
        } elseif ($table == 'supervisor') {
            $this->db->where('login_credential.role', 2);
        } elseif ($table == 'donor') {
            $this->db->where('login_credential.role', 3);
        }
        $re =  $this->db->get()->num_rows();
        return $re;
    }

}
