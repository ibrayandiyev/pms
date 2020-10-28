<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profile_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator staff all information
    public function staffUpdate($data)
    {
        $update_data = array(
            'name' => $data['name'],
            'sex' => $data['sex'],
            'religion' => $data['religion'],
            'blood_group' => $data['blood_group'],
            'birthday' => $data["birthday"],
            'mobileno' => $data['mobile_no'],
            'present_address' => $data['present_address'],
            'permanent_address' => $data['permanent_address'],
            'photo' => $this->uploadImage('staff'),
            'email' => $data['email'],
            'facebook_url' => $data['facebook'],
            'linkedin_url' => $data['linkedin'],
            'twitter_url' => $data['twitter'],
        );
        if (is_admin_loggedin()) {
            $update_data['joining_date'] = date("Y-m-d", strtotime($data['joining_date']));
            $update_data['designation'] = $data['designation_id'];
            $update_data['department'] = $data['department_id'];
            $update_data['qualification'] = $data['qualification'];
        }
        // UPDATE ALL INFORMATION IN THE DATABASE
        $this->db->where('id', get_loggedin_user_id());
        $this->db->update('staff', $update_data);

        // UPDATE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
        $this->db->where('user_id', get_loggedin_user_id());
        $this->db->where_not_in('role', array(6,7));
        $this->db->update('login_credential', array('username' => $data['username']));
    }

    public function supervisorUpdate($data)
    {
        $update_data = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'photo' => $this->uploadImage('supervisor'),
        );

        // update supervisor all information in the database
        $this->db->where('id', get_loggedin_user_id());
        $this->db->update('supervisor', $update_data);

        // update login credential information in the database
        $this->db->where('user_id', get_loggedin_user_id());
        $this->db->where('role', 2);
        $this->db->update('login_credential', array('username' => $data['username']));
    }

    public function donorUpdate($data)
    {
        $update_data = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country_name' => $data['country_name'],
            'photo' => $this->uploadImage('donor'),
        );

        // update supervisor all information in the database
        $this->db->where('id', get_loggedin_user_id());
        $this->db->update('donor', $update_data);

        // update login credential information in the database
        $this->db->where('user_id', get_loggedin_user_id());
        $this->db->where('role', 3);
        $this->db->update('login_credential', array('username' => $data['username']));
    }

    // moderator admin all information
    public function adminUpdate($data)
    {
        $update_data = array(
            'name' => $data['name'],
            'email' => $data['email'],
            'photo' => $this->uploadImage('admin'),
        );

        // UPDATE ALL INFORMATION IN THE DATABASE
        $this->db->where('id', get_loggedin_user_id());
        $this->db->update('administrator', $update_data);

        // UPDATE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
        $this->db->where('user_id', get_loggedin_user_id());
        $this->db->where_in('role', array(0, 1));
        $this->db->update('login_credential', array('username' => $data['username']));
    }
}
