<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Backup extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helpers('download');
    }

    public function index()
    {
        if (!is_superadmin_loggedin()) {
            access_denied();
        }
        $this->data['sub_page'] = 'database_backup/index';
        $this->data['main_menu'] = 'settings';
        $this->data['title'] = 'Database Backup';
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

    /* create database backup */
    public function create()
    {
        if (!is_superadmin_loggedin()) {
            access_denied();
        }
        $this->load->dbutil();
        $options = array(
            'format' => 'zip', // gzip, zip, txt
            'add_drop' => true, // Whether to add DROP TABLE statements to backup file
            'add_insert' => true, // Whether to add INSERT data to backup file
            'filename' => 'DB-backup_' . date('Y-m-d_H-i'),
        );

        $backup = $this->dbutil->backup($options);
        if (!write_file('./uploads/db_backup/DB-backup_' . date('Y-m-d_H-i') . '.zip', $backup)) {
            set_alert('error', 'Database Backup Failed');
        } else {
            set_alert('success', 'Database Backup Completed');
        }
        redirect(base_url('backup'));
    }

    public function download()
    {
        $file = $this->input->get('file');
        $this->data = file_get_contents('./uploads/db_backup/' . $file);
        force_download($file, $this->data);
        redirect(base_url('backup'));
    }

    public function delete_file($file)
    {
        if (!is_superadmin_loggedin()) {
            access_denied();
        }
        unlink('./uploads/db_backup/' . $file);
    }

    public function restore_file()
    {
        if (!is_superadmin_loggedin()) {
            ajax_access_denied();
        }
		if (isset($_FILES["uploaded_file"]) && empty($_FILES['uploaded_file']['name'])) {
			$this->form_validation->set_rules('uploaded_file', 'File Upload', 'required');
		} else {
			$this->form_validation->set_rules('uploaded_file', 'File Upload', 'trim');
		}
        if ($this->form_validation->run() == true) {
            $this->load->helper('unzip');
            $config['upload_path'] = './uploads/db_temp/';
            $config['allowed_types'] = 'zip';
            $config['overwrite'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploaded_file')) {
                $error = $this->upload->display_errors('', ' ');
                set_alert('error', $error);
                redirect(base_url('backup'));
            } else {
                $data = array('upload_data' => $this->upload->data());
                $backup = "uploads/db_temp/" . $data['upload_data']['file_name'];

            }
            if (!unzip($backup, "uploads/db_temp/", true, true)) {
                set_alert('error', "Backup Restore Error");
                redirect(base_url('backup'));
            } else {
                $this->load->dbforge();
                $backup = str_replace('.zip', '', $backup);
                $file_content = file_get_contents($backup . ".sql");
                $this->db->query('USE ' . $this->db->database . ';');
                foreach (explode(";\n", $file_content) as $sql) {
                    $sql = trim($sql);
                    if ($sql) {
                        $this->db->query($sql);
                    }
                }
                set_alert('success', "Backup Restore Successfully");
            }
            unlink($backup . '.sql');
            unlink($backup . '.zip');
            $array  = array('status' => 'success',);
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $error);
        }
        echo json_encode($array);
    }
}
