<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Country_list_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {
	    if (isset($data['country_id'])) {
            $this->db->where('id', $data['country_id']);
            $this->db->update('country_name_list', array('name' => $data['country_name']));
            return true;
	    } else {
            $query = $this->db->get_where('country_name_list', array('name' => $data['country_name']));
            $count = $query->num_rows();
            if ($count == 0)
            {
                $this->db->insert('country_name_list', array('name' => $data['country_name']));
                return true;
            }
            return false;
        }
    }
}