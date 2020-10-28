<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author url : https://www.freelancer.com/u/ibragim5555
 * @filename : Dashboard.php
 */

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('donor_model');
        $this->load->model('supervisor_model');
    }

    public function index()
    {
        if (is_superadmin_loggedin() || is_admin_loggedin()) {
            $this->data['title'] ='ADMIN DASHBOARD';
            $this->data['sub_page'] = 'dashboard/index';
        } elseif (is_supervisor_loggedin() || is_donor_loggedin()) {
            $userID = get_loggedin_user_id();
            if (is_supervisor_loggedin()) {
                $this->data['supervisor'] = $this->supervisor_model->getSingleSupervisor($userID);
                $this->data['title'] = 'Welcome To' . " " . $this->session->userdata('name');
            } else {
                $this->data['donor'] = $this->donor_model->getSingleDonor($userID);
                $this->data['title'] = 'Welcome To' . " " . $this->session->userdata('name');
            }
            $this->data['sub_page'] = 'userrole/dashboard';
        } else {

        }

        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/fullcalendar/fullcalendar.css',
            ),
            'js' => array(
                'dist/fullcalendar-data.js',
                'dist/fullcalendar.min.js',
                'vendor/chartjs/chart.min.js',
                'vendor/echarts/echarts.common.min.js',
                'vendor/moment/moment.js',
                'vendor/fullcalendar/fullcalendar.js',
            ),
        );
        $this->data['user_urgent'] = $this->db->get('user_urgent')->result();
        $this->data['main_menu'] = 'dashboard';
        $this->load->view('layout/index', $this->data);
    }
}