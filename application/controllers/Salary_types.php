<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @filename : Salary_types.php
 */

class Salary_types extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('salary_type_model');
    }

    // new salary type add
    public function index()
    {
        if (isset($_POST['save'])) {
            $rules = array(
                array(
                    'field' => 'salary_type',
                    'label' => 'Salary Type',
                    'rules' => 'required',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['validation_error'] = true;
            } else {
                // update information in the database
                $data = $this->input->post();
                $this->salary_type_model->save_types($data);
                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('salary_types'));
            }
        }
        $this->data['salary_types'] = $this->salary_type_model->getSalaryTypeList();
        $this->data['title'] = 'Salary Type';
        $this->data['sub_page'] = 'employee/salary_type';
        $this->data['main_menu'] = 'employee';
        $this->load->view('layout/index', $this->data);
    }

    // type edit
    public function edit($id)
    {
        if (isset($_POST['save'])) {
            $rules = array(
                array(
                    'field' => 'salary_type',
                    'label' => 'Salary Type',
                    'rules' => 'required',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == false) {
                $this->data['validation_error'] = true;
            } else {
                // SAVE TYPE INFORMATION IN THE DATABASE
                $data = $this->input->post();
                $this->salary_type_model->save_types($data);
                set_alert('success', 'Information has been updated successfully');
                redirect(base_url('salary_types'));
            }
        }
        $this->data['salary_type'] = $this->salary_type_model->get('salary_types', array('id' => $id), true);
        $this->data['title'] = 'SalaryType';
        $this->data['sub_page'] = 'employee/salary_type_edit';
        $this->data['main_menu'] = 'employee';
        $this->load->view('layout/index', $this->data);
    }


    // type delete in DB
    public function delete($type_id)
    {
        $this->db->where('id', $type_id);
        $this->db->delete('salary_types');
    }

}
