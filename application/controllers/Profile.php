<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Profile extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('donor_model');
        $this->load->model('supervisor_model');
        $this->load->model('administrator_model');
        $this->load->model('profile_model');
    }

    public function index()
    {
        $userID = get_loggedin_user_id();
        $loggedinRoleID = loggedin_role_id();
        if ($loggedinRoleID == 0 || $loggedinRoleID == 1) {
            if ($_POST) {
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_unique_username');
                $this->form_validation->set_rules('user_photo', 'Profile Picture',array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));
                if ($this->form_validation->run() == true) {
                    $data = $this->input->post();
                    $this->profile_model->adminUpdate($data);
                    set_alert('success', 'Information has been updated successfully');
                    redirect(base_url('profile')); 
                }
            }
            $this->data['admin'] = $this->administrator_model->getSingleAdmin($userID);
            $this->data['sub_page'] = 'profile/admin';
        } elseif ($loggedinRoleID == 2) {
            if ($_POST) {
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
                $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_username');
                $this->form_validation->set_rules('user_photo', 'profile_picture',array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));
                if ($this->form_validation->run() == true) {
                    $data = $this->input->post();
                    $this->profile_model->supervisorUpdate($data);
                    set_alert('success', 'Information has been updated successfully');
                    redirect(base_url('profile'));
                }
            }
            $this->data['supervisor'] = $this->supervisor_model->getSingleSupervisor($userID);
            $this->data['sub_page'] = 'profile/supervisor';
        } elseif ($loggedinRoleID == 3) {
            if ($_POST) {
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
                $this->form_validation->set_rules('username', 'Username', 'required|callback_unique_username');
                $this->form_validation->set_rules('user_photo', 'profile_picture',array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));
                if ($this->form_validation->run() == true) {
                    $data = $this->input->post();
                    $this->profile_model->donorUpdate($data);
                    set_alert('success', 'Information has been updated successfully');
                    redirect(base_url('profile'));
                }
            }
            $this->data['donor'] = $this->donor_model->getSingleDonor($userID);
            $this->data['sub_page'] = 'profile/donor';
        } else {

        }

        $this->data['title'] = 'Profile Edit';
        $this->data['main_menu'] = 'profile';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    // unique valid username verification is done here
    public function unique_username($username)
    {
        if (empty($username)) {
            return true;
        }
        $this->db->where_not_in('id', get_loggedin_id());
        $this->db->where('username', $username);
        $query = $this->db->get('login_credential');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message("unique_username", 'Username has already been used');
            return false;
        } else {
            return true;
        }
    }


    // when user change his password
    public function password()
    {
        if ($_POST) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|min_length[4]|callback_check_validate_password');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[4]|matches[new_password]');
            if ($this->form_validation->run() !== false) {
                $new_password = $this->input->post('new_password');
                $this->db->where('id', get_loggedin_id());
                $this->db->update('login_credential', array('password' => $this->app_lib->pass_hashed($new_password)));
                set_alert('success', 'Password has been changed');
                redirect(base_url('profile/password'));
            }
        }

        $this->data['sub_page'] = 'profile/password_change';
        $this->data['main_menu'] = 'profile';
        $this->data['title'] = 'Profile';
        $this->load->view('layout/index', $this->data);
    }

    // current password verification is done here
    public function check_validate_password($password)
    {
        if ($password) {
            $getPassword = $this->db->select('password')
                ->where('id', get_loggedin_id())
                ->get('login_credential')->row()->password;
            $getVerify = $this->app_lib->verify_password($password, $getPassword);
            if ($getVerify) {
                return true;
            } else {
                $this->form_validation->set_message("check_validate_password", 'Current password is invalid');
                return false;
            }
        }
    }
}
