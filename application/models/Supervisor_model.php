<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Supervisor_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator supervisor all information
    public function save($data)
    {
        $inser_data1 = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'joining_date' => $data['joining_date'],
            'photo' => $this->uploadImage('supervisor')
        );
        
        if (!isset($data['supervisor_id']) && empty($data['supervisor_id'])) {
            // save supervisor information in the database
            $this->db->insert('supervisor', $inser_data1);
            $supervisor_id = $this->db->insert_id();
            // save guardian login credential information in the database
            $username = $data['username'];
            $password = $data['password'];

            $inser_data2 = array(
                'username' => $username,
                'role' => 2,
                'active' => 1,
                'user_id' => $supervisor_id,
                'password' => $this->app_lib->pass_hashed($password),
            );
            $this->db->insert('login_credential', $inser_data2);
            
            // send account activate email
            $emailData = array(
                'name' => $data['name'],
                'username' => $username,
                'password' => $password,
                'user_role' => 2,
                'email' => $data['email'],
            );
            return $supervisor_id;
        } else {
            $this->db->where('id', $data['supervisor_id']);
            $this->db->update('supervisor', $inser_data1);
            // update login credential information in the database
            $this->db->where(array('role' => 2, 'user_id' => $data['supervisor_id']));
            $this->db->update('login_credential', array('username' => $data['username']));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getSingleSupervisor($id)
    {
        $this->db->select('supervisor.*,login_credential.role as role_id,login_credential.active,login_credential.username,login_credential.id as login_id, roles.name as role');
        $this->db->from('supervisor');
        $this->db->join('login_credential', 'login_credential.user_id = supervisor.id and login_credential.role = "2"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where('supervisor.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get supervisor all details
    public function getSupervisorList($active = 1)
    {
        $this->db->select('supervisor.*,login_credential.active as active, login_credential.username as username');
        $this->db->from('supervisor');
        $this->db->join('login_credential', 'login_credential.user_id = supervisor.id and login_credential.role = "2"', 'inner');
        $this->db->where('login_credential.active', $active);
        $this->db->order_by('supervisor.id', 'ASC');
        return $this->db->get()->result();
    }
}
