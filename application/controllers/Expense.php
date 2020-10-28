<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Expense extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('expense_model');
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

    public function index()
    {
        $this->data['expenselist'] = $this->expense_model->getExpenseList();
        $this->data['sub_page'] = 'expense/index';
        $this->data['main_menu'] = 'expense';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->data['title'] = 'Expense';
        $this->load->view('layout/index', $this->data);
    }

    public function expense_save()
    {
        if ($_POST) {
            $this->form_validation->set_rules('project_id', 'Project', 'trim|required');
            $this->form_validation->set_rules('expense_title', 'Expense Title', 'trim');
            $this->form_validation->set_rules('account', 'Account', 'trim');
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
            $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('account_no', 'Account No', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                //save data into table
                $insert_id = $this->expense_model->save($post);
                if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                    $ext = pathinfo($_FILES["attachment_file"]["name"], PATHINFO_EXTENSION);
                    $file_name = $insert_id . '.' . $ext;
                    move_uploaded_file($_FILES["attachment_file"]["tmp_name"], "./uploads/attachments/transactions/" . $file_name);
                    $this->db->where('id', $insert_id);
                    $this->db->update('transactions', array('attachments' => $file_name));
                }
                set_alert('success', 'Information has been saved successfully');
                $array  = array('status' => 'success',  'error' => '');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
        }
    }


    // this function is used to expense data update
    public function expense_edit($id = '')
    {
        if ($_POST) {
            $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                // update data into table
                $update_id = $this->expense_model->expenseEdit($post);
                set_alert('success', 'Information has been updated successfully');
                $url    = base_url('expense');
                $array  = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['expense'] = $this->app_lib->getTable('transactions', array('t.id' => $id), true);
        $this->data['sub_page'] = 'expense/edit';
        $this->data['main_menu'] = 'expense';
        $this->data['title'] = 'Expense Edit';
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

    // delete expense by id
    public function expense_delete($id)
    {
        $q = $this->db->where('id', $id)->get('transactions')->row_array();
        
        $filepath = FCPATH . 'uploads/attachments/transactions/' . $q['attachments'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        $this->db->where('id', $id);
        $this->db->delete('transactions');
    }

    public function transitions_reports()
    {
        if (isset($_POST['search'])) {
            $project_id = $this->input->post('project_id');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));

            $this->db->select('transactions.*, projects.project_name as project_name, projects.project_no as project_no');
            $this->db->from('transactions');
            $this->db->join('projects', 'projects.id = transactions.project_id', 'left');
            $array_where = array('transactions.date >= ' => $start, 'transactions.date <= ' => $end);
            $this->db->where($array_where);
            if (is_supervisor_loggedin()) {
                $this->db->where('transactions.supervisor_id', get_loggedin_user_id());
            }
            if (is_donor_loggedin()) {
                $this->db->where('projects.donor_id', get_loggedin_user_id());
            }
            if (!empty($project_id)) {
                $this->db->where('transactions.project_id', $project_id);
            }
            $result = $this->db->get()->result();
            
            $this->data['transactions'] = $result;
        }

        $this->data['headerelements']   = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );

        $this->data['sub_page'] = 'expense/search_report';
        $this->data['main_menu'] = 'expense_search_report';
        $this->data['title'] = 'Transactions';
        $this->load->view('layout/index', $this->data);

    }

}
