<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Administrator_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator administrator all information
    public function save($data)
    {
        $inser_data1 = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'joining_date' => $data['joining_date'],
            'photo' => $this->uploadImage('admin')
        );
        
        if (!isset($data['admin_id']) && empty($data['admin_id'])) {
            // save administrator information in the database
            $this->db->insert('administrator', $inser_data1);
            $admin_id = $this->db->insert_id();
            // save guardian login credential information in the database
            $username = $data['username'];
            $password = $data['password'];

            $inser_data2 = array(
                'username' => $username,
                'role' => 1,
                'active' => 1,
                'user_id' => $admin_id,
                'password' => $this->app_lib->pass_hashed($password),
            );
            $this->db->insert('login_credential', $inser_data2);
            
            // send account activate email
            $emailData = array(
                'name' => $data['name'],
                'username' => $username,
                'password' => $password,
                'user_role' => 1,
                'email' => $data['email'],
            );
            return $admin_id;
        } else {
            $this->db->where('id', $data['admin_id']);
            $this->db->update('administrator', $inser_data1);
            // update login credential information in the database
            $this->db->where(array('role' => 1, 'user_id' => $data['admin_id']));
            $this->db->update('login_credential', array('username' => $data['username']));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getSingleAdmin($id)
    {
        $this->db->select('administrator.*,login_credential.role as role_id,login_credential.active,login_credential.username,login_credential.id as login_id, roles.name as role');
        $this->db->from('administrator');
        $this->db->join('login_credential', 'login_credential.user_id = administrator.id and (login_credential.role = "1" or login_credential.role = "0")', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where('administrator.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get administrator all details
    public function getAdminList($active = 1)
    {
        $this->db->select('administrator.*,login_credential.active as active, login_credential.username as username');
        $this->db->from('administrator');
        $this->db->join('login_credential', 'login_credential.user_id = administrator.id and login_credential.role = "1"', 'left');
        $this->db->where('login_credential.active', $active);
        $this->db->order_by('administrator.id', 'ASC');
        return $this->db->get()->result();
    }
}
