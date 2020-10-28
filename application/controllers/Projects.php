<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Projects extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
    }

    public function index()
    {
        redirect(base_url('dashboard'));
    }

    /* project form validation rules */
    protected function project_validation()
    {
        $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required');
        $this->form_validation->set_rules('budget', 'Project Budget', 'trim|required');
        $this->form_validation->set_rules('project_date', 'Project Date', 'trim|required');
        $this->form_validation->set_rules('project_no', 'Project No', 'trim|required');
        $this->form_validation->set_rules('donor_id', 'Donor', 'trim|required');
        $this->form_validation->set_rules('location', 'Location', 'trim');
    }


    /* getting all project list */
    public function view()
    {
        $this->data['title'] = 'Projects';
        $this->data['sub_page'] = 'project/view';
        $this->data['main_menu'] = 'project';
        $this->data['project_list'] = $this->project_model->getList();
        $this->load->view('layout/index', $this->data);
    }


    /* projects all information are prepared and stored in the database here */
    public function create()
    {
        if ($_POST) {
            $this->project_validation();
            if ($this->form_validation->run() !== false) {
                //save all project information in the database
                $post = $this->input->post();
                $id = $this->project_model->save($post);
                $this->session->set_flashdata('employees_tab', 1);
                redirect(base_url('projects/details/' . $id));
            }
        }
        $project_id = 'PRI-' . substr(app_generate_hash(), 3, 7);
        $this->data['project_id'] = $project_id;
        $this->data['title'] = 'Create Project';
        $this->data['sub_page'] = 'project/create';
        $this->data['main_menu'] = 'project';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/summernote/summernote.css',
                'vendor/daterangepicker/daterangepicker.css',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.css',
            ),
            'js' => array(
                'vendor/summernote/summernote.js',
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    /* project documents&employees */
    public function details($id = '')
    {
        $this->data['projectInfo'] = $this->project_model->singleProjectInfo($id);
        $this->data['title'] = 'Employees and Documents';
        $this->data['sub_page'] = 'project/details';
        $this->data['main_menu'] = 'project';
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
    public function update($id = '')
    {
        if ($_POST) {
            $this->project_validation();
            if ($this->form_validation->run() == true) {
                //save all project information in the database
                $this->project_model->save($this->input->post());

                set_alert('success', 'Information has been updated successfully');
                redirect(base_url('projects/update/' . $id));
            }
        }
        $this->data['project_data'] = $this->project_model->singleProjectInfo($id);
        $this->data['title'] = 'Update Project';
        $this->data['sub_page'] = 'project/update';
        $this->data['main_menu'] = 'project';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/summernote/summernote.css',
                'vendor/daterangepicker/daterangepicker.css',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.css',
            ),
            'js' => array(
                'vendor/summernote/summernote.js',
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
                'vendor/bootstrap-fileupload/bootstrap-fileupload.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    // user interface and projects all information are prepared and stored in the database here
    public function delete($id = '')
    {
        $this->db->delete('projects', array('id' => $id));
        $this->db->where('p_id', $id);
        $documents = $this->db->get('project_document')->result_array();
        $this->db->where('project_id', $id);
        $employees = $this->db->get('staffs_projects')->result_array();
        foreach ($employees as $row) {
            $this->employee_delete($row['id']);
        }
        foreach ($documents as $row) {
            $this->document_delete($row['id']);
        }

    }


    protected function document_validation()
    {
        $this->form_validation->set_rules('document_title', 'Document Title', 'trim|required');
        if ($this->uri->segment(2) != 'document_update') {
            if (isset($_FILES['document_file']['name']) && empty($_FILES['document_file']['name'])) {
                $this->form_validation->set_rules('document_file', 'Document File', 'required');
            }
        }
    }

    // project document details are create here / ajax
    public function document_create()
    {
        if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }
        $this->document_validation();
        if ($this->form_validation->run() !== false) {
            $insert_doc = array(
                'p_id' => $this->input->post('p_id'),
                'title' => $this->input->post('document_title'),
                'remarks' => $this->input->post('remarks'),
            );
            // uploading file using codeigniter upload library
            $config['upload_path'] = './uploads/attachments/project/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size'] = '20480';
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if ($this->upload->do_upload("document_file")) {
                $insert_doc['file_name'] = $this->upload->data('orig_name');
                $insert_doc['enc_name'] = $this->upload->data('file_name');
                $this->db->insert('project_document', $insert_doc);
                set_alert('success', 'Information has been saved successfully');
            } else {
                set_alert('error', strip_tags($this->upload->display_errors()));
            }
            $this->session->set_flashdata('documents_tab', 1);
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }
    }

    // project document details are update here / ajax
    public function document_update()
    {
        if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }
        // validate inputs
        $this->document_validation();
        if ($this->form_validation->run() !== false) {
            $document_id = $this->input->post('document_id');
            $insert_doc = array(
                'title' => $this->input->post('document_title'),
                'remarks' => $this->input->post('remarks'),
            );
            if (isset($_FILES["document_file"]) && !empty($_FILES['document_file']['name'])) {
                $config['upload_path'] = './uploads/attachments/project/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '20480';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if ($this->upload->do_upload("document_file")) {
                    $exist_file_name = $this->input->post('exist_file_name');
                    $exist_file_path = FCPATH . 'uploads/attachments/project/' . $exist_file_name;
                    if (file_exists($exist_file_path)) {
                        unlink($exist_file_path);
                    }
                    $insert_doc['file_name'] = $this->upload->data('orig_name');
                    $insert_doc['enc_name'] = $this->upload->data('file_name');
                } else {
                    set_alert('error', strip_tags($this->upload->display_errors()));
                }
            }
            set_alert('success', 'Information has been updated successfully');
            $this->db->where('id', $document_id);
            $this->db->update('project_document', $insert_doc);
            $this->session->set_flashdata('documents_tab', 1);
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }
        
    }

    // project document details are delete here
    public function document_delete($id)
    {
        if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }
        $enc_name = $this->db->select('enc_name')->where('id', $id)->get('project_document')->row()->enc_name;
        $file_name = FCPATH . 'uploads/attachments/project/' . $enc_name;
        if (file_exists($file_name)) {
            unlink($file_name);
        }
        $this->db->where('id', $id);
        $this->db->delete('project_document');
        $this->session->set_flashdata('documents_tab', 1);
    }

    public function document_details()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('project_document');
        $result = $query->row_array();
        echo json_encode($result);
    }

    /* file downloader */
    public function documents_download()
    {
        $encrypt_name = $this->input->get('file');
        $file_name = $this->db->select('file_name')->where('enc_name', $encrypt_name)->get('project_document')->row()->file_name;
        $this->load->helper('download');
        force_download($file_name, file_get_contents('uploads/attachments/project/' . $encrypt_name));
    }

    // Validation for Employee
    protected function employee_validation()
    {
        $this->form_validation->set_rules('employee_id', 'Employee Name', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim');
    }
    // Add Employees
    public function employee_add()
    {   
        if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }

        $this->employee_validation();
        if ($this->form_validation->run() !== false) {
            $insert_emp = array(
                'project_id' => $this->input->post('project_id'),
                'staff_id' => $this->input->post('employee_id'),
                'remarks' => $this->input->post('remarks'),
            );
            $this->db->insert('staffs_projects', $insert_emp);
            set_alert('success', 'Information has been saved successfully');
            $this->session->set_flashdata('employees_tab', 1);
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }

    }

    // employee details are delete here
    public function employee_delete($id)
    {
        if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }

        $this->db->where('id', $id);
        $this->db->delete('staffs_projects');
        $this->session->set_flashdata('employees_tab', 1);
    }

    public function employee_details()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('staffs_projects');
        $result = $query->row_array();
        echo json_encode($result);
    }

    // employee details are update here / ajax
    public function employee_update()
    {
        $this->employee_validation();
        if ($this->form_validation->run() !== false) {
            $id = $this->input->post('e_staffs_projects_id');
            $update_emp = array(
                'staff_id' => $this->input->post('employee_id'),
                'remarks' => $this->input->post('remarks'),
            );
            $this->db->where('id', $id);
            $this->db->update('staffs_projects', $update_emp);
            set_alert('success', 'Information has been updated successfully');
            $this->session->set_flashdata('employees_tab', 1);
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }
        
    }

    /* phase form validation rules */
    protected function phase_validation()
    {
        $this->form_validation->set_rules('project_id', 'Project ID', 'required');
        $this->form_validation->set_rules('phase_no', 'Phase No', 'trim|required|callback_unique_phase');
        $this->form_validation->set_rules('phase_name', 'Phase', 'trim|required');
    }
    
    // project phae user interface and information are controlled here
    public function phase($id = '')
    {
        if ($_POST) {
            $this->phase_validation();
            if ($this->form_validation->run() !== false) {
                $arrayPhase = array(
                    'name' => $this->input->post('phase_name'), 
                    'project_id' => $this->input->post('project_id'),
                    'phase_no' => $this->input->post('phase_no'),
                );
                $this->db->insert('project_phases', $arrayPhase);
                set_alert('success', 'Information has been saved successfully');
                redirect(base_url('projects/phase'));
            }
        }
        $this->data['p_id'] = $id;
        $this->data['phase'] = $this->app_lib->getPhaseList($id);
        $this->data['title'] = 'Phase';
        $this->data['sub_page'] = 'project/phase';
        $this->data['main_menu'] = 'project';
        $this->load->view('layout/index', $this->data);
    }

    public function phase_list($id = '')
    {
        $this->data['phase'] = $this->app_lib->getPhaseList($id);
        $this->data['title'] = 'Phase List';
        $this->data['sub_page'] = 'project/phase_list';
        $this->data['main_menu'] = 'project';
        $this->load->view('layout/index', $this->data);
    }

    public function phase_edit()
    {
        $this->phase_validation();
        if ($this->form_validation->run() !== false) {
            $arrayPhase = array(
                'name' => $this->input->post('phase_name'), 
                'project_id' => $this->input->post('project_id'),
                'phase_no' => $this->input->post('phase_no'),
            );
            $phase_id = $this->input->post('phase_id');
            $this->db->where('id', $phase_id);
            $this->db->update('project_phases', $arrayPhase);
            set_alert('success', 'Information has been updated successfully');
            $array  = array('status' => 'success');
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail','error' => $error);
        }
        echo json_encode($array);
    }

    public function phase_delete($id)
    {

        $this->db->where('id', $id);
        $this->db->delete('project_phases');
    }

    // unique valid phase no verification is done here
    public function unique_phase()
    {
        $phase_no = $this->input->post('phase_no');
        $phase_id = $this->input->post('phase_id');
        if (!empty($phase_id)) {
            $this->db->where_not_in('id', $phase_id);
        }
        $this->db->where('phase_no', $phase_no);
        $q = $this->db->get('project_phases');
        if ($q->num_rows() > 0) {
            $this->form_validation->set_message("unique_phase", 'Already taken');
            return false;
        } else {
            return true;
        }
    }

    // Documents detail for project phases
    public function phase_document($id = '')
    {
        $this->data['phase_id'] = $id;
        $this->data['title'] = 'Employees and Documents';
        $this->data['sub_page'] = 'project/phase_document';
        $this->data['main_menu'] = 'project';
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

    protected function phase_document_validation()
    {
        $this->form_validation->set_rules('phase_document_title', 'Phase document title', 'trim|required');
        if ($this->uri->segment(2) != 'phase_document_update') {
            if (isset($_FILES['phase_document_file']['name']) && empty($_FILES['phase_document_file']['name'])) {
                $this->form_validation->set_rules('phase_document_file', 'Phase document file', 'required');
            }
        }
    }

    // project document details are create here / ajax
    public function phase_document_add()
    {
        $this->phase_document_validation();
        if ($this->form_validation->run() !== false) {
            $insert_doc = array(
                'phase_id' => $this->input->post('phase_id'),
                'title' => $this->input->post('phase_document_title'),
                'remarks' => $this->input->post('remarks'),
            );
            // uploading file using codeigniter upload library
            $config['upload_path'] = './uploads/attachments/project/phase';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size'] = '20480';
            $config['encrypt_name'] = true;
            $this->upload->initialize($config);
            if ($this->upload->do_upload("phase_document_file")) {
                $insert_doc['file_name'] = $this->upload->data('orig_name');
                $insert_doc['enc_name'] = $this->upload->data('file_name');
                $this->db->insert('phase_document', $insert_doc);
                set_alert('success', 'Information has been saved successfully');
            } else {
                set_alert('error', strip_tags($this->upload->display_errors()));
            }
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }
    }

    // project document details are update here / ajax
    public function phase_document_update()
    {
        // validate inputs
        $this->phase_document_validation();
        if ($this->form_validation->run() !== false) {
            $phase_document_id = $this->input->post('phase_document_id');
            $insert_doc = array(
                'title' => $this->input->post('phase_document_title'),
                'remarks' => $this->input->post('remarks'),
            );
            if (isset($_FILES["phase_document_file"]) && !empty($_FILES['phase_document_file']['name'])) {
                $config['upload_path'] = './uploads/attachments/project/phase/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '20480';
                $config['encrypt_name'] = true;
                $this->upload->initialize($config);
                if ($this->upload->do_upload("phase_document_file")) {
                    $exist_file_name = $this->input->post('exist_file_name');
                    $exist_file_path = FCPATH . 'uploads/attachments/project/phase/' . $exist_file_name;
                    if (file_exists($exist_file_path)) {
                        unlink($exist_file_path);
                    }
                    $insert_doc['file_name'] = $this->upload->data('orig_name');
                    $insert_doc['enc_name'] = $this->upload->data('file_name');
                } else {
                    set_alert('error', strip_tags($this->upload->display_errors()));
                }
            }
            set_alert('success', 'Information has been updated successfully');
            $this->db->where('id', $phase_document_id);
            $this->db->update('phase_document', $insert_doc);
            echo json_encode(array('status' => 'success'));
        } else {
            $error = $this->form_validation->error_array();
            echo json_encode(array('status' => 'fail', 'error' => $error));
        }
        
    }

    public function getDescription()
    {
        $id = $this->input->post('project_id');
        if (empty($id)) {
            redirect(base_url(), 'refresh');
        }

        $this->db->where('id', $id);
        $ev = $this->db->get('projects')->row_array();
        $html = "<tbody><tr>";
        $html .= "<td>" . $ev['description'] . "</td>";
        $html .= "</tr></tbody>";
        echo $html;
    }

    // project document details are delete here
    public function phase_document_delete($id)
    {
            $enc_name = $this->db->select('enc_name')->where('id', $id)->get('phase_document')->row()->enc_name;
            $file_name = FCPATH . 'uploads/attachments/project/phase/' . $enc_name;
            if (file_exists($file_name)) {
                unlink($file_name);
            }
            $this->db->where('id', $id);
            $this->db->delete('phase_document');
    }

    public function phase_document_details()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('phase_document');
        $result = $query->row_array();
        echo json_encode($result);
    }

    /* file downloader */
    public function phase_documents_download()
    {
        $encrypt_name = $this->input->get('file');
        $file_name = $this->db->select('file_name')->where('enc_name', $encrypt_name)->get('phase_document')->row()->file_name;
        $this->load->helper('download');
        force_download($file_name, file_get_contents('uploads/attachments/project/phase/' . $encrypt_name));
    }

}
