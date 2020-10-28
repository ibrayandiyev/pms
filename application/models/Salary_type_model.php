<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Salary_type_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getSalaryTypeList()
    {
        $this->db->select('*');
        $r = $this->db->get('salary_types')->result_array();
        return $r;  
    }

    // type save and update function
    public function save_types($data)
    {
        $insertData = array(
            'name' => $data['salary_type'],
            'unit' => $data['salary_unit'],
        );

        if (!isset($data['id']) && empty($data['id'])) {
            $this->db->insert('salary_types', $insertData);
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('salary_types', $insertData);
        }
    }
}
