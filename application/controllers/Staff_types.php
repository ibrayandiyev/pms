<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @filename : Staff_types.php
 */

class Staff_types extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('staff_type_model');
    }

    // new staff type add
    public function index()
    {
        if (isset($_POST['save'])) {
            $rules = array(
                array(
                    'field' => 'staff_type',
                    'label' => 'Staff Type',
                    'rules' => 'required|callback_unique_name',
                ),
                array(
                    'field' => 'add_date',
                    'label' => 'Add Date',
                    'rules' => 'required|trim',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['validation_error'] = true;
            } else {
                // update information in the database
                $data = $this->input->post();
                $this->staff_type_model->save_types($data);
                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('staff_types'));
            }
        }
        $this->data['staff_types'] = $this->staff_type_model->getStaffTypeList();
        $this->data['title'] = 'Staff Type';
        $this->data['sub_page'] = 'employee/staff_type';
        $this->data['main_menu'] = 'employee';
        $this->load->view('layout/index', $this->data);
    }

    // type edit
    public function edit($id)
    {
        if (isset($_POST['save'])) {
            $rules = array(
                array(
                    'field' => 'staff_type',
                    'label' => 'Staff Type',
                    'rules' => 'required|callback_unique_name',
                ),
                array(
                    'field' => 'update_date',
                    'label' => 'Update Date',
                    'rules' => 'required|trim',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['validation_error'] = true;
            } else {
                // SAVE TYPE INFORMATION IN THE DATABASE
                $data = $this->input->post();
                $this->staff_type_model->save_types($data);
                set_alert('success', 'Information has been updated successfully');
                redirect(base_url('staff_types'));
            }
        }
        $this->data['staff_type'] = $this->staff_type_model->get('staff_types', array('id' => $id), true);
        $this->data['title'] = 'Staff Type';
        $this->data['sub_page'] = 'employee/staff_type_edit';
        $this->data['main_menu'] = 'employee';
        $this->load->view('layout/index', $this->data);
    }

    // check unique name
    public function unique_name($name)
    {
        $id = $this->input->post('id');
        if (isset($id)) {
            $where = array('name' => $name, 'id != ' => $id);
        } else {
            $where = array('name' => $name);
        }
        $q = $this->db->get_where('staff_types', $where);
        if ($q->num_rows() > 0) {
            $this->form_validation->set_message("unique_name", 'Already Taken');
            return false;
        } else {
            return true;
        }
    }

    // type delete in DB
    public function delete($type_id)
    {
        $this->db->where('id', $type_id);
        $this->db->delete('staff_types');
    }

}
