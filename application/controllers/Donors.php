<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Ibragim Yandiyev
 * @filename : Donors.php
 * @copyright : 
 */

class Donors extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('donor_model');
    }

    public function index()
    {
        redirect(base_url('donors/view'));
    }

    /* donor form validation rules */
    protected function donor_validation()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('country_name', 'Country Name', 'trim');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
        
        $this->form_validation->set_rules('user_photo', 'Profile Picture', array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));

        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_unique_username');

        if (!isset($_POST['donor_id'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');
        }

    }

    /* donors list user interface  */
    public function view()
    {
        $this->data['title'] = 'Donors List';
        $this->data['sub_page'] = 'donors/view';
        $this->data['main_menu'] = 'donors';
        $this->load->view('layout/index', $this->data);
    }

    /* user all information are prepared and stored in the database here */
    public function add()
    {
        if ($this->input->post('submit') == 'save') {
            $this->donor_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all donor information in the database
                $donorID = $this->donor_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('donors/add'));
            }
        }
        $this->data['title'] = 'Add Donor';
        $this->data['sub_page'] = 'donors/add';
        $this->data['main_menu'] = 'donors';
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

    /* donor deactivate list user interface  */
    public function disable_authentication()
    {

        if (isset($_POST['auth'])) {
            $inactivatedDonorList = $this->input->post('views_bulk_operations');
            if (isset($inactivatedDonorList)) {
                foreach ($inactivatedDonorList as $id) {
                    $this->db->where(array('role' => 3, 'user_id' => $id));
                    $this->db->update('login_credential', array('active' => 1));
                }
                set_alert('success', 'Information has been updated successfully');
            } else {
                set_alert('error', 'Please select at least one item');
            }
            redirect(base_url('donors/disable_authentication'));
        }
        $this->data['donorslist'] = $this->donor_model->getDonorList('', 0);
        $this->data['title'] = 'Deactivate Account';
        $this->data['sub_page'] = 'donors/disable_authentication';
        $this->data['main_menu'] = 'donors';
        $this->load->view('layout/index', $this->data);
    }

    /* donor detail preview and information are controlled here */
    public function edit($id = '')
    {
        if (isset($_POST['update'])) {
            $this->donor_validation();
            if ($this->form_validation->run() == true) {
                $post = $this->input->post();
                //save all donor information in the database
                $this->donor_model->save($post);

                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('donors/edit/' . $id));
            }
        }
        $this->data['donor'] = $this->donor_model->getSingleDonor($id);
        $this->data['title'] = 'Donor Profile Edit';
        $this->data['main_menu'] = 'donors';
        $this->data['sub_page'] = 'donors/edit';
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

    /* donors delete  */
    public function delete($id = '')
    {
        // delete from donor
        $this->db->where('id', $id);
        $this->db->delete('donor');
        if ($this->db->affected_rows() > 0) {
            $this->db->where(array('user_id' => $id, 'role' => 3));
            $this->db->delete('login_credential');
        }
    }

    // unique valid username verification is done here
    public function unique_username($username)
    {
        if (empty($username)) {
            return true;
        }
        $donor_id = $this->input->post('donor_id');
        if (!empty($donor_id)) {
            $login_id = $this->app_lib->get_credential_id($donor_id, 'donor');
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
            $donorID = $this->input->post('donor_id');
            $password = $this->input->post('password');
            if (!isset($_POST['authentication'])) {
                $this->db->where('role', 3);
                $this->db->where('user_id', $donorID);
                $this->db->update('login_credential', array('password' => $this->app_lib->pass_hashed($password)));
            } else {
                $this->db->where('role', 3);
                $this->db->where('user_id', $donorID);
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
