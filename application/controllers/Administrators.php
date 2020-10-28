<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Ibragim Yandiyev
 * @filename : Administrators.php
 * @copyright : 
 */

class Administrators extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('administrator_model');
    }

    public function index()
    {
        redirect(base_url('administrators/view'));
    }

    /* administrator form validation rules */
    protected function admin_validation()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        
        $this->form_validation->set_rules('user_photo', 'Profile Picture', array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_unique_username');

        if (!isset($_POST['admin_id'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');
        }

    }

    /* administrators list user interface  */
    public function view()
    {

        $this->data['title'] = 'Administrators List';
        $this->data['sub_page'] = 'administrators/view';
        $this->data['main_menu'] = 'administrators';
        $this->load->view('layout/index', $this->data);
    }

    /* user all information are prepared and stored in the database here */
    public function add()
    {
        if ($this->input->post('submit') == 'save') {
            $this->admin_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all doadministrator information in the database
                $adminID = $this->administrator_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('administrators/add'));
            }
        }
        $this->data['title'] = 'Add Administrator';
        $this->data['sub_page'] = 'administrators/add';
        $this->data['main_menu'] = 'administrators';
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

    /* administrator deactivate list user interface  */
    public function disable_authentication()
    {

        if (isset($_POST['auth'])) {
            $inactivatedAdminList = $this->input->post('views_bulk_operations');
            if (isset($inactivatedAdminList)) {
                foreach ($inactivatedAdminList as $id) {
                    $this->db->where(array('role' => 1, 'user_id' => $id));
                    $this->db->update('login_credential', array('active' => 1));
                }
                set_alert('success', 'Information has been updated successfully');
            } else {
                set_alert('error', 'Please select at least one item');
            }
            redirect(base_url('administrators/disable_authentication'));
        }
        $this->data['adminlist'] = $this->administrator_model->getAdminList('', 0);
        $this->data['title'] = 'Deactivate Account';
        $this->data['sub_page'] = 'administrators/disable_authentication';
        $this->data['main_menu'] = 'administrators';
        $this->load->view('layout/index', $this->data);
    }

    /* administrator detail preview and information are controlled here */
    public function edit($id = '')
    {
        if (isset($_POST['update'])) {
            $this->admin_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all administrator information in the database
                $this->administrator_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('administrators/edit/' . $id));
            }
        }
        $this->data['admin'] = $this->administrator_model->getSingleAdmin($id);
        $this->data['title'] = 'administrator Profile Edit';
        $this->data['main_menu'] = 'administrators';
        $this->data['sub_page'] = 'administrators/edit';
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

    /* administrators delete  */
    public function delete($id = '')
    {
        // delete from administrator
        $this->db->where('id', $id);
        $this->db->delete('administrator');
        if ($this->db->affected_rows() > 0) {
            $this->db->where(array('user_id' => $id, 'role' => 1));
            $this->db->delete('login_credential');
        }
    }

    // unique valid username verification is done here
    public function unique_username($username)
    {
        if (empty($username)) {
            return true;
        }
        $admin_id = $this->input->post('admin_id');
        if (!empty($admin_id)) {
            $login_id = $this->app_lib->get_credential_id($admin_id, 'admin');
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
            $adminID = $this->input->post('admin_id');
            $password = $this->input->post('password');
            if (!isset($_POST['authentication'])) {
                $this->db->where('role', 1);
                $this->db->where('user_id', $adminID);
                $this->db->update('login_credential', array('password' => $this->app_lib->pass_hashed($password)));
            } else {
                $this->db->where('role', 1);
                $this->db->where('user_id', $adminID);
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
