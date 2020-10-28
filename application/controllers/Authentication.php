<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends Authentication_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

    /* email is okey lets check the password now */
    public function index()
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'));
        }

        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'email',
                    'label' => "Email",
                    'rules' => 'trim|required',
                ),
                array(
                    'field' => 'password',
                    'label' => "Password",
                    'rules' => 'trim|required',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() !== false) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                // username is okey lets check the password now
                $login_credential = $this->authentication_model->login_credential($email, $password);
                if ($login_credential) {
                    if ($login_credential->active) {
                        if ($login_credential->role == 0) {
                            $userType = 'superadmin';
                        } elseif ($login_credential->role == 1) {
                            $userType = 'admin';
                        } elseif($login_credential->role == 2) {
                            $userType = 'supervisor';
                        } elseif($login_credential->role == 3) {
                            $userType = 'donor';
                        } else {
                            $userType = 'staff';
                        }
                        $getUser = $this->application_model->getUserNameByRoleID($login_credential->role, $login_credential->user_id);
                        $getConfig = $this->db->get_where('global_settings', array('id' => 1))->row_array();
                        // get logger name
                        $sessionData = array(
                            'name' => $getUser['name'],
                            'logger_photo' => $getUser['photo'],
                            'loggedin_id' => $login_credential->id,
                            'loggedin_userid' => $login_credential->user_id,
                            'loggedin_role_id' => $login_credential->role,
                            'loggedin_type' => $userType,
                            'loggedin' => true,
                        );
                        $this->session->set_userdata($sessionData);
                        $this->db->update('login_credential', array('last_login' => date('Y-m-d H:i:s')), array('id' => $login_credential->id));
                        // browser detect
                        if ($this->agent->is_browser('Chrome')) {
                            $this->db->set('stats_value', 'stats_value+1', FALSE);
                            $this->db->set('visits', 'visits+1', FALSE);
                            $this->db->where('id', 1);
                            $this->db->update('user_urgent');
                        } elseif ($this->agent->is_browser('Firefox')) {
                            $this->db->set('stats_value', 'stats_value+1', FALSE);
                            $this->db->set('visits', 'visits+1', FALSE);
                            $this->db->where('id', 3);
                            $this->db->update('user_urgent');
                        } elseif ($this->agent->is_browser('Internet Explorer')) {
                            $this->db->set('stats_value', 'stats_value+1', FALSE);
                            $this->db->set('visits', 'visits+1', FALSE);
                            $this->db->where('id', 2);
                            $this->db->update('user_urgent');
                        } elseif ($this->agent->is_browser('Safari')) {
                            $this->db->set('stats_value', 'stats_value+1', FALSE);
                            $this->db->set('visits', 'visits+1', FALSE);
                            $this->db->where('id', 4);
                            $this->db->update('user_urgent');
                        } else {

                        }

                        // is logged in
                        if ($this->session->has_userdata('redirect_url')) {
                            redirect($this->session->userdata('redirect_url'));
                        } else {
                            redirect(base_url('dashboard'));
                        }

                    } else {
                        set_alert('error', 'Inactive Account');
                        redirect(base_url('authentication'));
                    }
                } else {
                    set_alert('error', 'Username or Password is Incorrect');
                    redirect(base_url('authentication'));
                }

            }
        }
        $this->load->view('authentication/login', $this->data);
    }

    // forgot password
    // public function forgot()
    // {
    //     if (is_loggedin()) {
    //         redirect(base_url('dashboard'), 'refresh');
    //     }

    //     if ($_POST) {
    //         $config = array(
    //             array(
    //                 'field' => 'username',
    //                 'label' => 'Email',
    //                 'rules' => 'trim|required',
    //             ),
    //         );
    //         $this->form_validation->set_rules($config);
    //         if ($this->form_validation->run() !== false) {
    //             $username = $this->input->post('username');
    //             $res = $this->authentication_model->lose_password($username);
    //             if ($res == true) {
    //                 $this->session->set_flashdata('reset_res', 'true');
    //                 redirect(base_url('authentication/forgot'));
    //             } else {
    //                 $this->session->set_flashdata('reset_res', 'false');
    //                 redirect(base_url('authentication/forgot'));
    //             }
    //         }
    //     }
    //     $this->load->view('authentication/forgot', $this->data);
    // }

    /* password reset */
    public function pwreset()
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'), 'refresh');
        }

        $key = $this->input->get('key');
        if (!empty($key)) {
            $query = $this->db->get_where('reset_password', array('key' => $key));
            if ($query->num_rows() > 0) {
                if ($this->input->post()) {
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[c_password]');
                    $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|min_length[4]');
                    if ($this->form_validation->run() !== false) {
                        $password = $this->app_lib->pass_hashed($this->input->post('password'));
                        $this->db->where('id', $query->row()->login_credential_id);
                        $this->db->update('login_credential', array('password' => $password));
                        $this->db->where('login_credential_id', $query->row()->login_credential_id);
                        $this->db->delete('reset_password');
                        set_alert('success', 'Password Reset Successfully');
                        redirect(base_url('authentication'));
                    }
                }
                $this->load->view('authentication/pwreset', $this->data);
            } else {
                set_alert('error', 'Token Has Expired');
                redirect(base_url('authentication'));
            }
        } else {
            set_alert('error', 'Token Has Expired');
            redirect(base_url('authentication'));
        }
    }

    /* session logout */
    public function logout()
    {
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('logger_photo');
        $this->session->unset_userdata('loggedin_id');
        $this->session->unset_userdata('loggedin_userid');
        $this->session->unset_userdata('loggedin_type');
        $this->session->unset_userdata('loggedin');
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
}
