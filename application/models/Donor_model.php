<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Donor_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator donors all information
    public function save($data)
    {
        $inser_data1 = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country_name' => $data['country_name'],
            'description' => $data['description'],
            'joining_date' => $data['joining_date'],
            'photo' => $this->uploadImage('donor')
        );
        
        if (!isset($data['donor_id']) && empty($data['donor_id'])) {
            // save donor information in the database
            $this->db->insert('donor', $inser_data1);
            $donor_id = $this->db->insert_id();
            // save guardian login credential information in the database
            $username = $data['username'];
            $password = $data['password'];

            $inser_data2 = array(
                'username' => $username,
                'role' => 3,
                'active' => 1,
                'user_id' => $donor_id,
                'password' => $this->app_lib->pass_hashed($password),
            );
            $this->db->insert('login_credential', $inser_data2);
            
            // send account activate email
            $emailData = array(
                'name' => $data['name'],
                'username' => $username,
                'password' => $password,
                'user_role' => 3,
                'email' => $data['email'],
            );
            return $donor_id;
        } else {
            $this->db->where('id', $data['donor_id']);
            $this->db->update('donor', $inser_data1);
            // update login credential information in the database
            $this->db->where(array('role' => 3, 'user_id' => $data['donor_id']));
            $this->db->update('login_credential', array('username' => $data['username']));
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getSingleDonor($id)
    {
        $this->db->select('donor.*,login_credential.role as role_id,login_credential.active,login_credential.username,login_credential.id as login_id, roles.name as role');
        $this->db->from('donor');
        $this->db->join('login_credential', 'login_credential.user_id = donor.id and login_credential.role = "3"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where('donor.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get donor all details
    public function getDonorList($active = 1)
    {
        $this->db->select('donor.*,login_credential.active as active, login_credential.username as username');
        $this->db->from('donor');
        $this->db->join('login_credential', 'login_credential.user_id = donor.id and login_credential.role = "3"', 'inner');
        $this->db->where('login_credential.active', $active);
        $this->db->order_by('donor.id', 'ASC');
        return $this->db->get()->result();
    }
}
