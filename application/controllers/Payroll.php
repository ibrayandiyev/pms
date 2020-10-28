<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Payroll extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($_POST) {
            $this->payroll_validation();
            if ($this->form_validation->run() !== false) {

                $insertData = array(
                    'project_id' => $this->input->post('project_id'),
                    'staff_id' => $this->input->post('staff_id'),
                    'salary_amount' => $this->input->post('salary_amount'),
                    'salary_type_id' => $this->input->post('salary_type_id'),
                    'paid_amount' => $this->input->post('paid_amount'),
                    'description' => $this->input->post('description'),
                    'date' => $this->input->post('date')
                );

                if (isset($_FILES["document_file"]) && !empty($_FILES['document_file']['name'])) {
                    $config['upload_path'] = './uploads/attachments/payroll/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['max_size'] = '20480';
                    $config['encrypt_name'] = true;
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload("document_file")) {
                        $insertData['file_name'] = $this->upload->data('orig_name');
                        $insertData['enc_name'] = $this->upload->data('file_name');
                    }
                }
                if (is_supervisor_loggedin()) {
                    $insertData['supervisor_id'] = get_loggedin_user_id();
                }
                $this->db->insert('payroll', $insertData);
                set_alert('success', 'Information has been saved successfully');
                $url = base_url('payroll');
                $array = array('status' => 'success', 'url' => $url, 'error' => '');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'url' => '', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        
        $this->db->select('payroll.*, staff.name as employee_name, staff.employee_no as employee_no, projects.project_name as project_name, projects.project_no as project_no, salary_types.name as salary_type');
        $this->db->from('payroll');
        $this->db->join('projects', 'projects.id = payroll.project_id', 'left');
        $this->db->join('staff', 'staff.id = payroll.staff_id', 'left');
        $this->db->join('salary_types', 'salary_types.id = payroll.salary_type_id', 'left');
        if (is_supervisor_loggedin()) {
            $this->db->where('payroll.supervisor_id', get_loggedin_user_id());
        }
        $result = $this->db->get()->result();
        
        $this->data['payrolls'] = $result;
        $this->data['title'] = 'Payroll';
        $this->data['sub_page'] = 'payroll/index';
        $this->data['main_menu'] = 'payroll';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/summernote/summernote.css',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.css',
            ),
            'js' => array(
                'vendor/summernote/summernote.js',
                'vendor/moment/moment.js',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    public function payroll_validation()
    {
        $this->form_validation->set_rules('project_id', 'Project ID', 'required');
        $this->form_validation->set_rules('staff_id', 'Employee Name', 'trim|required');
        $this->form_validation->set_rules('salary_amount', 'Salary', 'trim|required');
        $this->form_validation->set_rules('salary_type_id', 'Salary Type', 'trim|required');
        $this->form_validation->set_rules('paid_amount', 'Paid Amount', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim');
    }

    public function payroll_update($id = '')
    {
        if ($_POST) {
            $this->payroll_validation();
            if ($this->form_validation->run() !== false) {

                $updateData = array(
                    'project_id' => $this->input->post('project_id'),
                    'staff_id' => $this->input->post('staff_id'),
                    'salary_amount' => $this->input->post('salary_amount'),
                    'salary_type_id' => $this->input->post('salary_type_id'),
                    'paid_amount' => $this->input->post('paid_amount'),
                    'updated_at' => $this->input->post('date'),
                    'description' => $this->input->post('description'),
                );

                if (isset($_FILES["document_file"]) && !empty($_FILES['document_file']['name'])) {
                    $config['upload_path'] = './uploads/attachments/payroll/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['max_size'] = '20480';
                    $config['encrypt_name'] = true;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload("document_file")) {
                        $exist_file_name = $this->input->post('exist_file_name');
                        $exist_file_path = FCPATH . 'uploads/attachments/payroll/' . $exist_file_name;
                        if (file_exists($exist_file_path)) {
                            unlink($exist_file_path);
                        }
                        $updateData['file_name'] = $this->upload->data('orig_name');
                        $updateData['enc_name'] = $this->upload->data('file_name');
                    } else {
                        set_alert('error', strip_tags($this->upload->display_errors()));
                    }
                }
                $payroll_id = $this->input->post('payroll_id');
                $this->db->where('id', $payroll_id);
                $this->db->update('payroll', $updateData);
                set_alert('success', 'Information has been updated successfully');
                $url = base_url('payroll');
                $array = array('status' => 'success', 'url' => $url, 'error' => '');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'url' => '', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        
        $result = $this->db->get_where('payroll', array('id' => $id))->row();
        $this->data['payroll'] = $result;
        $this->data['title'] = 'Payroll';
        $this->data['sub_page'] = 'payroll/edit';
        $this->data['main_menu'] = 'Payroll Update';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/summernote/summernote.css',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.css',
            ),
            'js' => array(
                'vendor/summernote/summernote.js',
                'vendor/moment/moment.js',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }
    public function delete($id = '')
    {
        $enc_name = $this->db->select('enc_name')->where('id', $id)->get('payroll')->row()->enc_name;
        $file_name = FCPATH . 'uploads/attachments/payroll/' . $enc_name;
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $this->db->where('id', $id);
        $this->db->delete('payroll');

    }

    /* file downloader */
    public function documents_download()
    {
        $encrypt_name = $this->input->get('file');
        $file_name = $this->db->select('file_name')->where('enc_name', $encrypt_name)->get('payroll')->row()->file_name;
        $this->load->helper('download');
        force_download($file_name, file_get_contents('uploads/attachments/payroll/' . $encrypt_name));
    }

    public function getDetails()
    {
        $id = $this->input->post('payroll_id');
        if (empty($id)) {
            redirect(base_url(), 'refresh');
        }

        $this->db->where('id', $id);
        $ev = $this->db->get('payroll')->row_array();
        $html = "<tbody><tr>";
        $html .= "<td>Description</td>";
        $html .= "</tr><tr>";
        $html .= "<td>" . $ev['description'] . "</td>";
        $html .= "</tr></tbody>";
        echo $html;
    }

    // payroll search report
    public function search_report()
    {
        if (isset($_POST['search'])) {

            $staff_id = $this->input->post('staff_id');
            $project_id = $this->input->post('project_id');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            // $month = date("m", strtotime($month_year));
            // $year = date("Y", strtotime($month_year));
    
            $this->db->select('payroll.*, staff.name as employee_name, staff.employee_no as employee_no, projects.project_name as project_name, projects.project_no as project_no, salary_types.name as salary_type');
            $this->db->from('payroll');
            $this->db->join('projects', 'projects.id = payroll.project_id', 'left');
            $this->db->join('staff', 'staff.id = payroll.staff_id', 'left');
            $this->db->join('salary_types', 'salary_types.id = payroll.salary_type_id', 'left');
            $array_where = array('payroll.date >= ' => $start, 'payroll.date <= ' => $end);
            $this->db->where($array_where);
            if (is_supervisor_loggedin()) {
                $this->db->where('supervisor_id', get_loggedin_user_id());
            }
            if (is_donor_loggedin()) {
                $this->db->where('projects.donor_id', get_loggedin_user_id());
            }
            if (!empty($project_id)) {
                $this->db->where('payroll.project_id', $project_id);
            }
            if (!empty($staff_id)) {
                $this->db->where('payroll.staff_id', $staff_id);
            }
            $result = $this->db->get()->result();
            
            $this->data['payrolls'] = $result;
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

        $this->data['sub_page'] = 'payroll/search_report';
        $this->data['main_menu'] = 'payroll_search_report';
        $this->data['title'] = 'Payroll';
        $this->load->view('layout/index', $this->data);
    }
}