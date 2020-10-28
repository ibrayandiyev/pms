<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Application_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function profilePicUpload()
    {
        if (isset($_FILES["user_photo"]) && !empty($_FILES['user_photo']['name'])) {
            $file_size = $_FILES["user_photo"]["size"];
            $file_name = $_FILES["user_photo"]["name"];
            $allowedExts = array('jpg', 'jpeg', 'png');
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if ($files = filesize($_FILES['user_photo']['tmp_name'])) {
                if (!in_array(strtolower($extension), $allowedExts)) {
                    $this->form_validation->set_message('handle_upload', 'This file type is not allowed');
                    return false;
                }
                if ($file_size > 2097152) {
                    $this->form_validation->set_message('handle_upload', 'File size shoud be less than' . " 2048KB.");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', 'Error reading the file');
                return false;
            }
            return true;
        }
    }

    public function getUserNameByRoleID($roleID, $userID = '')
    {
        if ($roleID == 0 || $roleID == 1) {
            $sql = "SELECT name,email,photo FROM administrator WHERE id = " . $this->db->escape($userID);
            return $this->db->query($sql)->row_array();
        } elseif ($roleID == 2) {
            $sql = "SELECT name,email,photo FROM supervisor WHERE id = " . $this->db->escape($userID);
            return $this->db->query($sql)->row_array();
        } elseif ($roleID == 3) {
            $sql = "SELECT name,email,photo FROM donor WHERE id = " . $this->db->escape($userID);
            return $this->db->query($sql)->row_array();
        } else {

        }
    }

}
