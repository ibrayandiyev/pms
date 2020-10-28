<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model');
    }

    public function getDataByTypeID()
    {
        $html = "";
        $employee_id = $this->input->post('employee_id');
        $staff_type_id = $this->input->post('staff_type_id');
        if (!empty($staff_type_id)) {
            $this->db->select('*');
            $this->db->from('staff');
            $this->db->where('active', 1);
            $this->db->where('staff_type_id', $staff_type_id);
            $result = $this->db->get()->result_array();
            if (count($result)) {
                $html .= "<option value=''>" . 'Select' . "</option>";
                foreach ($result as $row) {
                    $html .= '<option value="' . $row['id'] . '"' . ($row['id'] == $employee_id) ? 'selected' : '' . '>' . '</option>';
                }
            } else {
                $html .= '<option value="">' . 'No Information Available' . '</option>';
            }
        } else {
            $html .= '<option value="">' . 'Select Staff Type First' . '</option>';
        }
        echo $html;
    }

    // get staff all details
    public function getEmployeeList()
    {
        $html = "";
        $role_id = $this->input->post('role');
        $designation = $this->input->post('designation');
        $department = $this->input->post('department');
        $selected_id = (isset($_POST['staff_id']) ? $_POST['staff_id'] : 0);
        $this->db->select('staff.*,staff_designation.name as des_name,staff_department.name as dep_name,login_credential.role as role_id, roles.name as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        $this->db->where('login_credential.role', $role_id);
        $this->db->where('login_credential.active', 1);
        if ($designation != '') {
            $this->db->where('staff.designation', $designation);
        }

        if ($department != '') {
            $this->db->where('staff.department', $department);
        }

        $result = $this->db->get()->result_array();
        if (count($result)) {
            $html .= "<option value=''>Select</option>";
            foreach ($result as $row) {
                $selected = ($row['id'] == $selected_id ? 'selected' : '');
                $html .= "<option value='" . $row['id'] . "' " . $selected . ">" . $row['name'] . " (" . $row['staff_id'] . ")</option>";
            }
        } else {
            $html .= '<option value="">No information available</option>';
        }
        echo $html;
    }

    public function phase_details()
    {

        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('project_phases');
        $result = $query->row_array();
        echo json_encode($result);
    }
}
