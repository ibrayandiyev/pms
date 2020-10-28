<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounting extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounting_model');
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );
    }

    /* account form validation rules */
    protected function account_validation()
    {
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('account_name', 'Account Name', array('trim','required',array('unique_account_name',
        array($this->accounting_model, 'unique_account_name'))));
        $this->form_validation->set_rules('opening_balance','Opening Balance', 'trim|numeric');
    }

    public function index()
    {
        if ($_POST) {
            $this->account_validation();
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                $this->accounting_model->saveAccounts($data);
                set_alert('success', 'Information has been saved successfully');
                $url    = $_SERVER['HTTP_REFERER'];
                $array  = array('status' => 'success');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['accountslist'] =  $this->app_lib->get_table('accounts');
        $this->data['sub_page'] = 'accounting/index';
        $this->data['main_menu'] = 'accounting';
        $this->data['title'] = 'Account';
        $this->load->view('layout/index', $this->data);
    }

    // update existing account if passed id
    public function edit($id = '')
    {
        if ($_POST) {
            $this->account_validation();
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();
                $this->accounting_model->saveAccounts($data);
                set_alert('success', 'Information has been updated successfully');
                $url    = base_url('accounting');
                $array  = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['account'] = $this->app_lib->get_table('accounts', $id, true);
        $this->data['sub_page'] = 'accounting/edit';
        $this->data['main_menu'] = 'accounting';
        $this->data['title'] = 'Account';
        $this->load->view('layout/index', $this->data);
    }

    // delete account from database
    public function delete($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('accounts');
    }
}
