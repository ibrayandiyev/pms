<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model');
        $this->load->model('crud_model');
    }

    public function index()
    {
        redirect(base_url('dashboard'));
    }

    /* staff form validation rules */
    protected function employee_validation()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('employee_no', 'Employee NO', 'trim|required|callback_unique_employee_no');
        $this->form_validation->set_rules('staff_type_id', 'Staff Type', 'trim|required');
        $this->form_validation->set_rules('joining_date', 'Joining Date', 'trim|required');
        $this->form_validation->set_rules('salary', 'Salary', 'trim');
        $this->form_validation->set_rules('user_photo', 'profile_picture',array(array('handle_upload', array($this->application_model, 'profilePicUpload'))));
    }


    /* getting all employee list */
    //public function view($staff_type_id = '')
    public function view()
    {   
        // if (empty($staff_type_id)) {
        //     $staff_type_id = $this->db->select('id')->order_by('id','asc')->limit(1)->get('staff_types')->row('id');
        // }
        // $this->data['staff_type_id'] = $staff_type_id;
        $this->data['title'] = 'Employee';
        $this->data['sub_page'] = 'employee/view';
        $this->data['main_menu'] = 'employee';
        // $this->data['stafflist'] = $this->employee_model->getStaffList($staff_type_id);
        $this->data['stafflist'] = $this->employee_model->getStaffList();
        $this->load->view('layout/index', $this->data);
    }

    /* employees all information are prepared and stored in the database here */
    public function add()
    {
        if ($_POST) {
            $this->employee_validation();
            if ($this->form_validation->run() !== false) {
                //save all employee information in the database
                $post = $this->input->post();
                if ($staff_id = $this->employee_model->save($post)) {
                    $insert_doc['staff_id'] = $staff_id;
                    if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                        // uploading file using codeigniter upload library
                        $config['upload_path'] = './uploads/attachments/documents/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                        $config['max_size'] = '10240';
                        $config['encrypt_name'] = true;
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload("attachment_file")) {
                            $insert_doc['file_name'] = $this->upload->data('orig_name');
                            $insert_doc['enc_name'] = $this->upload->data('file_name');
                            $this->db->insert('staff_documents', $insert_doc);
                        } else {
                            set_alert('error', strip_tags($this->upload->display_errors()));
                            redirect(base_url('employee/add'));
                        }
                    }
                }
                
                set_alert('success', 'Information has been saved successfully');

                redirect(base_url('employee/view/' . $post['staff_type_id']));
            }
        }
        $employee_id = 'EMP' . substr(app_generate_hash(), 3, 7);
        $this->data['employee_id'] = $employee_id;
        $this->data['title'] = 'Add Employee';
        $this->data['sub_page'] = 'employee/add';
        $this->data['main_menu'] = 'employee';
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

    /* profile preview and information are controlled here */
    public function profile($id = '')
    {
        if ($this->input->post('submit') == 'update') {
            $this->employee_validation();
            if ($this->form_validation->run() == true) {
                //save all employee information in the database
                
                if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                    $config['upload_path'] = './uploads/attachments/documents/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    $config['max_size'] = '10240';
                    $config['encrypt_name'] = true;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload("attachment_file")) {
                        $exist_file_name = $this->input->post('exist_file_name');
                        $exist_file_path = FCPATH . 'uploads/attachments/documents/' . $exist_file_name;
                        if (file_exists($exist_file_path)) {
                            unlink($exist_file_path);
                        }
                        $insert_doc['file_name'] = $this->upload->data('orig_name');
                        $insert_doc['enc_name'] = $this->upload->data('file_name');
                    } else {
                        set_alert('error', strip_tags($this->upload->display_errors()));
                        redirect(base_url('employee/profile/' . $id));
                    }
                    $this->db->where('staff_id', $id);
                    $this->db->update('staff_documents', $insert_doc);
                }

                $this->employee_model->save($this->input->post());
                set_alert('success', 'Information has been updated successfully');
                redirect(base_url('employee/profile/' . $id));
            }
        }
        $this->data['staff'] = $this->employee_model->getSingleStaff($id);
        $this->data['title'] = 'Employee Profile';
        $this->data['sub_page'] = 'employee/profile';
        $this->data['main_menu'] = 'employee';
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

    // user interface and employees all information are prepared and stored in the database here
    public function delete($id = '')
    {
        if ($enc_name = $this->db->select('enc_name')->where('staff_id', $id)->get('staff_documents')->row()->enc_name) {

            $file_name = FCPATH . 'uploads/attachments/documents/' . $enc_name;
            if (file_exists($file_name)) {
                unlink($file_name);
            }
            $this->db->where('staff_id', $id);
            $this->db->delete('staff_documents');
        }
        $this->db->delete('staff', array('id' => $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        }
    }

    /* file downloader */
    public function documents_download()
    {
        $encrypt_name = $this->input->get('file');
        $file_name = $this->db->select('file_name')->where('enc_name', $encrypt_name)->get('staff_documents')->row()->file_name;
        $this->load->helper('download');
        force_download($file_name, file_get_contents('uploads/attachments/documents/' . $encrypt_name));
    }

    // unique valid employee no verification is done here
    public function unique_employee_no()
    {
        $employee_no = $this->input->post('employee_no');
        $id = $this->uri->segment(3);
        if (!empty($id)) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('employee_no', $employee_no);
        $q = $this->db->get('staff');
        if ($q->num_rows() > 0) {
            $this->form_validation->set_message("unique_employee_no", 'Already taken');
            return false;
        } else {
            return true;
        }
    }
}
