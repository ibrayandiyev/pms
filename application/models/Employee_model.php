<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Employee_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator employee all information
    public function save($data, $id = null)
    {
        $inser_data1 = array(
            'employee_id' => $data['employee_id'],
            'employee_no' => $data['employee_no'],
            'name' => $data['name'],
            'staff_type_id' => $data['staff_type_id'],
            'salary_type_id' => $data['salary_type_id'],
            'photo' => $this->uploadImage('staff'),
            'joining_date' => date("Y-m-d", strtotime($data['joining_date'])),
        );

        if (!isset($data['staff_id']) && empty($data['staff_id'])) {
            // SAVE EMPLOYEE INFORMATION IN THE DATABASE
            $this->db->insert('staff', $inser_data1);
            $staff_id = $this->db->insert_id();

            return $staff_id;
        } else {
            // UPDATE ALL INFORMATION IN THE DATABASE
            $this->db->where('id', $data['staff_id']);
            $this->db->update('staff', $inser_data1);
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    // GET SINGLE EMPLOYEE DETAILS
    public function getSingleStaff($id = '')
    {
        $this->db->select('staff.*, staff_documents.*, staff_types.id as staff_type_id, staff_types.name as staff_type, salary_types.name as salary_type, salary_types.id as salary_type_id');
        $this->db->from('staff');
        $this->db->join('staff_types', 'staff_types.id = staff.staff_type_id', 'left');
        $this->db->join('staff_documents', 'staff_documents.staff_id = staff.id', 'left');
        $this->db->join('salary_types', 'salary_types.id = staff.salary_type_id', 'left');
        $this->db->where('staff.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get staff all list
    // public function getStaffList($staff_type_id, $active = 1)
    public function getStaffList($active = 1)
    {
        $this->db->select('staff.*,salary_types.name as salary_type,staff_types.name as staff_type, staff_documents.enc_name as enc_name');
        $this->db->from('staff');
        $this->db->join('staff_types', 'staff_types.id = staff.staff_type_id', 'left');
        $this->db->join('staff_documents', 'staff_documents.staff_id = staff.id', 'left');
        $this->db->join('salary_types', 'salary_types.id = staff.salary_type_id', 'left');
        if (is_donor_loggedin()) {
            $this->db->join('staffs_projects', 'staffs_projects.staff_id = staff.id', 'left');
            $this->db->join('projects', 'projects.id = staffs_projects.project_id', 'left');
            $this->db->where('projects.donor_id', get_loggedin_user_id());
        }
        $this->db->where('staff.active', $active);
        // $this->db->where('staff.staff_type_id', $staff_type_id);
        $this->db->order_by('staff.id', 'ASC');
        return $this->db->get()->result();
    }

}
