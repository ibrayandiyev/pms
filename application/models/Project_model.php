<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Project_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator project all information
    public function save($data, $id = null)
    {
        $inser_data1 = array(
            'project_id' => $data['project_id'],
            'project_name' => $data['project_name'],
            'donor_id' => $data['donor_id'],
            'project_date' => $data['project_date'],
            'description' => $data['description'],
            'location' => $data["location"],
            'budget' => $data['budget'],
            'project_no' => $data['project_no'],
        );


        if (!isset($data['p_id']) && empty($data['p_id'])) {
            // SAVE PROJECT INFORMATION IN THE DATABASE
            $this->db->insert('projects', $inser_data1);
            $id = $this->db->insert_id();
            return $id;
        } else {
            // UPDATE ALL INFORMATION IN THE DATABASE
            $this->db->where('id', $data['p_id']);
            $this->db->update('projects', $inser_data1);
        }
    }


    public function singleProjectInfo($id = '')
    {
        $this->db->select('projects.*, donor.name as donor_name');
        $this->db->from('projects');
        $this->db->join('donor', 'donor.id = projects.donor_id', 'left');
        $this->db->where('projects.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get project all list
    public function getList($active = 1)
    {
        $this->db->select('projects.*, donor.name as donor_name');
        $this->db->from('projects');
        $this->db->join('donor', 'donor.id = projects.donor_id', 'left');
        if (is_donor_loggedin()) {
            $this->db->where('projects.donor_id', get_loggedin_user_id());
        }
        $this->db->where('projects.active', $active);
        $this->db->order_by('projects.id', 'DESC');
        return $this->db->get()->result();
    }
}
