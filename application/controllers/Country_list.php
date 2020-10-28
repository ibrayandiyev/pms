<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Country_list extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('country_list_model');
    }

    public function index()
    {
        $this->data['country_name_list'] = $this->app_lib->get_table('country_name_list');
        $this->data['sub_page'] = 'country_list/index';
        $this->data['main_menu'] = 'settings';
        $this->data['title'] = 'Country List';
        $this->load->view('layout/index', $this->data);
    }

    public function edit($id = '')
    {
        $this->data['country_name_list'] = $this->app_lib->get_table('country_name_list', $id, true);
        $this->data['sub_page'] = 'country_list/edit';
        $this->data['main_menu'] = 'settings';
        $this->data['title'] = 'Country Name Edit';
        $this->load->view('layout/index', $this->data);
    }

    public function save()
    {
        $this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');
        $data['country_name'] = $this->input->post('country_name');
        $data['country_id'] = $this->input->post('country_id');
        if ($this->form_validation->run() !== false) {
            if ($this->country_list_model->save($data)) {
                set_alert('success', 'Information has been saved successfully');
                $url = base_url('country_list');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                set_alert('error', 'The name already exist');
                $url = base_url('country_list');
                $array = array('status' => 'success', 'url' => $url);
            }

        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $error);
        }
        echo json_encode($array);
    }

    public function delete($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('country_name_list');
    }
}
