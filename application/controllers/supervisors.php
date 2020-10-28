<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Ibragim Yandiyev
 * @filename : Supervisors.php
 * @copyright : 
 */

class Supervisors extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('supervisor_model');
    }

    public function index()
    {
        redirect(base_url('supervisors/view'));
    }

    /* supervisor form validation rules */
    protected function supervisor_validation()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        
        $this->form_validation->set_rules('user_photo', 'Profile Picture', array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_unique_username');

        if (!isset($_POST['supervisor_id'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');
        }

    }

    /* supervisors list user interface  */
    public function view()
    {
        $this->data['title'] = 'Supervisors List';
        $this->data['sub_page'] = 'supervisors/view';
        $this->data['main_menu'] = 'supervisors';
        $this->load->view('layout/index', $this->data);
    }

    /* user all information are prepared and stored in the database here */
    public function add()
    {
        if ($this->input->post('submit') == 'save') {
            $this->supervisor_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all do supervisor information in the database
                $supervisorID = $this->supervisor_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('supervisors/add'));
            }
        }
        $this->data['title'] = 'Add Supervisor';
        $this->data['sub_page'] = 'supervisors/add';
        $this->data['main_menu'] = 'supervisors';
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

    /* supervisor deactivate list user interface  */
    public function disable_authentication()
    {

        if (isset($_POST['auth'])) {
            $inactivatedSupervisorList = $this->input->post('views_bulk_operations');
            if (isset($inactivatedSupervisorList)) {
                foreach ($inactivatedSupervisorList as $id) {
                    $this->db->where(array('role' => 2, 'user_id' => $id));
                    $this->db->update('login_credential', array('active' => 1));
                }
                set_alert('success', 'Information has been updated successfully');
            } else {
                set_alert('error', 'Please select at least one item');
            }
            redirect(base_url('supervisors/disable_authentication'));
        }
        $this->data['supervisorslist'] = $this->supervisor_model->getSupervisorList('', 0);
        $this->data['title'] = 'Deactivate Account';
        $this->data['sub_page'] = 'supervisors/disable_authentication';
        $this->data['main_menu'] = 'supervisors';
        $this->load->view('layout/index', $this->data);
    }

    /* supervisor detail preview and information are controlled here */
    public function edit($id = '')
    {
        if (isset($_POST['update'])) {
            $this->supervisor_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all supervisor information in the database
                $this->supervisor_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('supervisors/edit/' . $id));
            }
        }
        $this->data['supervisor'] = $this->supervisor_model->getSingleSupervisor($id);
        $this->data['title'] = 'supervisor Profile Edit';
        $this->data['main_menu'] = 'supervisors';
        $this->data['sub_page'] = 'supervisors/edit';
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

    /* supervisors delete  */
    public function delete($id = '')
    {
        // delete from supervisor
        $this->db->where('id', $id);
        $this->db->delete('supervisor');
        if ($this->db->affected_rows() > 0) {
            $this->db->where(array('user_id' => $id, 'role' => 2));
            $this->db->delete('login_credential');
        }
    }

    // unique valid username verification is done here
    public function unique_username($username)
    {
        if (empty($username)) {
            return true;
        }
        $supervisor_id = $this->input->post('supervisor_id');
        if (!empty($supervisor_id)) {
            $login_id = $this->app_lib->get_credential_id($supervisor_id, 'supervisor');
            $this->db->where_not_in('id', $login_id);
        }
        $this->db->where('username', $username);
        $query = $this->db->get('login_credential');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message("unique_username", 'Already Taken');
            return false;
        } else {
            return true;
        }
    }

    /* password change here */
    public function change_password()
    {

        if (!isset($_POST['authentication'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim');
        }
        if ($this->form_validation->run() !== false) {
            $supervisorID = $this->input->post('supervisor_id');
            $password = $this->input->post('password');
            if (!isset($_POST['authentication'])) {
                $this->db->where('role', 2);
                $this->db->where('user_id', $supervisorID);
                $this->db->update('login_credential', array('password' => $this->app_lib->pass_hashed($password)));
            } else {
                $this->db->where('role', 2);
                $this->db->where('user_id', $supervisorID);
                $this->db->update('login_credential', array('active' => 0));
            }
            set_alert('success', 'Information has been updated successfully');
            $array = array('status' => 'success');
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $error);
        }
        echo json_encode($array);
    }

}
