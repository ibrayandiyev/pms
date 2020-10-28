<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff_type_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getStaffTypeList()
    {
        $this->db->select('*');
        $r = $this->db->get('staff_types')->result_array();
        return $r;  
    }

    // type save and update function
    public function save_types($data)
    {
        
        if (!isset($data['id']) && empty($data['id'])) {

            $insertData = array(
                'name' => $data['staff_type'],
                'prefix' => strtolower(str_replace(' ', '', $data['staff_type'])),
                'add_date' => $data['add_date'],
            );

            $this->db->insert('staff_types', $insertData);
        } else {

            $insertData = array(
                'name' => $data['staff_type'],
                'prefix' => strtolower(str_replace(' ', '', $data['staff_type'])),
                'update_date' => $data['update_date'],
            );

            $this->db->where('id', $data['id']);
            $this->db->update('staff_types', $insertData);
        }
    }
}
