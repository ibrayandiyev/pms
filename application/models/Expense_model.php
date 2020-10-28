<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // expense save function
    public function save($data)
    {
        $project_id = $data['project_id'];
        $expense_title = $data['expense_title'];
        $account = $data['account'];
        $category = $data['category'];
        $transaction_date = $data['transaction_date'];
        $amount = $data['amount'];
        $account_no = $data['account_no'];
        $description = $data['description'];
        $supervisor_id = '';
        if (is_supervisor_loggedin()) {
            $supervisor_id = get_loggedin_user_id();
        }

        $insertTransaction = array(
            'project_id' => $project_id,
            'title' => $expense_title,
            'type' => $account,
            'category' => $category,
            'amount' => $amount,
            'account_no' => $account_no,
            'description' => $description,
            'date' => date("Y-m-d", strtotime($transaction_date)),
            'supervisor_id' => $supervisor_id
        );
        $this->db->insert('transactions', $insertTransaction);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    // expense update function
    public function expenseEdit($data)
    {
        $project_id = $data['project_id'];
        $expense_title = $data['expense_title'];
        $account = $data['account'];
        $category = $data['category'];
        $transaction_date = $data['transaction_date'];
        $amount = $data['amount'];
        $account_no = $data['account_no'];
        $description = $data['description'];

        $insertTransaction = array(
            'project_id' => $project_id,
            'title' => $expense_title,
            'type' => $account,
            'category' => $category,
            'amount' => $amount,
            'account_no' => $account_no,
            'description' => $description,
            'date' => date("Y-m-d", strtotime($transaction_date)),
        );

        if (isset($data['expense_old_id']) && !empty($data['expense_old_id'])) {
            $update_id = $data['expense_old_id'];
            if (isset($_FILES["attachment_file"]) && !empty($_FILES['attachment_file']['name'])) {
                $ext = pathinfo($_FILES["attachment_file"]["name"], PATHINFO_EXTENSION);
                $file_name = $update_id . '.' . $ext;
                move_uploaded_file($_FILES["attachment_file"]["tmp_name"], "./uploads/attachments/transactions/" . $file_name);
                $this->db->where('id', $update_id);
                $this->db->update('transactions', array('attachments' => $file_name));
            }

            $this->db->where('id', $update_id);
            $this->db->update('transactions', $insertTransaction);
        }
    }

    // get expense list function
    public function getExpenseList()
    {
        
        $this->db->select('transactions.*, projects.project_name as project_name, projects.project_no as project_no');
        $this->db->from('transactions');
        $this->db->join('projects', 'projects.id = transactions.project_id', 'left');
        if (is_supervisor_loggedin()) {
            $this->db->where('supervisor_id', get_loggedin_user_id());
        }
        return $this->db->get()->result_array();
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
