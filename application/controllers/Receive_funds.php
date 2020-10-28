<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Receive_funds extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('receive_funds_model');
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
        $this->data['receivefundslist'] = $this->receive_funds_model->getReceiveFundsList();
        $this->data['sub_page'] = 'receive_funds/index';
        $this->data['main_menu'] = 'receive_funds';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->data['title'] = 'Receive Funds';
        $this->load->view('layout/index', $this->data);
    }

    public function save()
    {
        if ($_POST) {
            $this->form_validation->set_rules('project_id', 'Project', 'trim|required');
            $this->form_validation->set_rules('account_id', 'Account', 'trim');
            $this->form_validation->set_rules('transaction_no', 'Transaction No', 'trim');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                //save data into table
                $insert_id = $this->receive_funds_model->save($post);
                if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                    $ext = pathinfo($_FILES["attachment_file"]["name"], PATHINFO_EXTENSION);
                    $file_name = $insert_id . '.' . $ext;
                    move_uploaded_file($_FILES["attachment_file"]["tmp_name"], "./uploads/attachments/receive_funds/" . $file_name);
                    $this->db->where('id', $insert_id);
                    $this->db->update('receive_funds', array('attachments' => $file_name));
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


    public function edit($id = '')
    {
        if ($_POST) {
            $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                // update data into table
                $update_id = $this->expense_model->save($post);
                set_alert('success', 'Information has been updated successfully');
                $url    = base_url('receive_funds');
                $array  = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['receivefund'] = $this->app_lib->get_table('receive_funds',$id, true);
        $this->data['sub_page'] = 'receive_funds/edit';
        $this->data['main_menu'] = 'receive_funds';
        $this->data['title'] = 'Receive Fund Edit';
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

    public function delete($id)
    {
        $q = $this->db->where('id', $id)->get('receive_funds')->row_array();
        
        $filepath = FCPATH . 'uploads/attachments/receive_funds/' . $q['attachments'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        $this->db->where('id', $id);
        $this->db->delete('receive_funds');
    }

    public function search_reports()
    {
        if (isset($_POST['search'])) {
            $project_id = $this->input->post('project_id');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));

            $this->db->select('receive_funds.*, projects.project_name as project_name, projects.project_no as project_no, accounts.name as account_name');
            $this->db->from('receive_funds');
            $this->db->join('projects', 'projects.id = receive_funds.project_id', 'left');
            $this->db->join('accounts', 'accounts.id = receive_funds.account_id', 'left');
            $array_where = array('receive_funds.date >= ' => $start, 'receive_funds.date <= ' => $end);
            $this->db->where($array_where);
            if (is_donor_loggedin()) {
                $this->db->where('projects.donor_id', get_loggedin_user_id());
            }
            if (!empty($project_id)) {
                $this->db->where('receive_funds.project_id', $project_id);
            }
            $result = $this->db->get()->result();
            
            $this->data['receivefunds'] = $result;
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

        $this->data['sub_page'] = 'receive_funds/search_report';
        $this->data['main_menu'] = 'receive_funds_search_report';
        $this->data['title'] = 'Receive Funds Reports';
        $this->load->view('layout/index', $this->data);

    }
}
