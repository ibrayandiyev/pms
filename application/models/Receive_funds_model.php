<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receive_funds_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {
        $project_id = $data['project_id'];
        $account_id = $data['account_id'];
        $date = $data['date'];
        $amount = $data['amount'];
        $transaction_no = $data['transaction_no'];
        $description = $data['description'];

        $insertReceiveFunds = array(
            'project_id' => $project_id,
            'account_id' => $account_id,
            'transaction_no' => $transaction_no,
            'amount' => $amount,
            'description' => $description,
            'date' => date("Y-m-d", strtotime($date)),
        );

        if (isset($data['receive_fund_old_id']) && !empty($data['receive_fund_old_id'])) {
            $update_id = $data['receive_fund_old_id'];
            if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                $ext = pathinfo($_FILES["attachment_file"]["name"], PATHINFO_EXTENSION);
                $file_name = $update_id . '.' . $ext;
                move_uploaded_file($_FILES["attachment_file"]["tmp_name"], "./uploads/attachments/receive_funds/" . $file_name);
                $this->db->where('id', $update_id);
                $this->db->update('receive_funds', array('attachments' => $file_name));
            }
            $this->db->where('id', $update_id);
            $this->db->update('receive_funds', $insertReceiveFunds);
        } else {
            $this->db->insert('receive_funds', $insertReceiveFunds);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

    }

    public function getReceiveFundsList()
    {
        $this->db->select('receive_funds.*, projects.project_name as project_name, projects.project_no as project_no, accounts.name as account_name');
        $this->db->from('receive_funds');
        $this->db->join('projects', 'projects.id = receive_funds.project_id', 'left');
        $this->db->join('accounts', 'accounts.id = receive_funds.account_id', 'left');
        return $this->db->get()->result_array();
    }

}
