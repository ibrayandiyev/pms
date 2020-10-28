<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accounting_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // account save and update function
    public function saveAccounts($data)
    {
        $obal = (empty($data['opening_balance']) ? 0 : $data['opening_balance']);
        $insert_account = array(
            'name' => $data['account_name'],
            'number' => $data['account_number'],
            'description' => $data['description'],
            'date' => $data['date'],
            'updated_at' => date('Y-m-d H:i:s')
        );
        if (isset($data['account_id']) && !empty($data['account_id'])) {
            $this->db->where('id', $data['account_id']);
            $this->db->update('accounts', $insert_account);
        } else {
            $insert_account['balance'] = $obal;
            $this->db->insert('accounts', $insert_account);
        }
    }

    // duplicate account name check in db
    public function unique_account_name($name)
    {
        $account_id = $this->input->post('account_id');
        if (!empty($account_id)) {
            $this->db->where_not_in('id', $account_id);
        }

        $this->db->where('name', $name);
        $query = $this->db->get('accounts');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message("unique_account_name", 'Already Taken');
            return false;
        } else {
            return true;
        }
    }
}
