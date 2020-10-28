<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_credential_id($user_id, $staff = 'staff')
    {
        $this->CI->db->select('id');
        if ($staff == 'staff') {
            $this->CI->db->where_not_in('role', array(6, 7));
        } elseif ($staff == 'donor') {
            $this->CI->db->where('role', 4);
        } elseif ($staff == 'supervisor') {
            $this->CI->db->where('role', 3);
        } elseif ($staff == 'admin') {
            $this->CI->db->where('role', 2);
        }
        $this->CI->db->where('user_id', $user_id);
        $result = $this->CI->db->get('login_credential')->row_array();
        return $result['id'];
    }

    function get_table($table, $id = NULL, $single = FALSE)
    {
        if ($single == TRUE) {
            $method = 'row_array';
        } else {
            $this->CI->db->order_by('id', 'ASC');
            $method = 'result_array';
        }
        if ($id != NULL) {
            $this->CI->db->where('id', $id);
        }
        $query = $this->CI->db->get($table);
        return $query->$method();
    }

    function getTable($table, $where = "", $single = FALSE)
    {
        if ($where != NULL) {
            $this->CI->db->where($where);
        }
        if ($single == TRUE) {
            $method = "row_array";
        } else {
            $this->CI->db->order_by("id", "asc");
            $method = "result_array";
        }
        $this->CI->db->select("t.*,p.project_name as p_name, p.project_id as p_id");
        $this->CI->db->from("$table as t");
        $this->CI->db->join("projects as p", "p.id = t.project_id", "left");
        $query = $this->CI->db->get();
        return $query->$method();
    }

    public function pass_hashed($password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $hashed;
    }

    public function verify_password($password, $encrypt_password)
    {
        $hashed = password_verify($password, $encrypt_password);
        return $hashed;
    }


    public function getProjectList()
    {
        $arrayData = array("" => 'Select');
        $result = $this->CI->db->get('projects')->result();
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->project_name . $row->project_no;
        }
        return $arrayData;
    }

    public function getAccountList()
    {
        $arrayData = array("" => 'Select');
        $result = $this->CI->db->get('accounts')->result();
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->name;
        }
        return $arrayData;
    }

    public function getPhaseList($id)
    {
        $this->CI->db->select('project_phases.*, projects.project_name as p_name, projects.project_no as p_no');
        $this->CI->db->from('project_phases');
        $this->CI->db->join('projects', 'projects.id = project_phases.project_id', 'left');
        if (is_donor_loggedin()) {
            $this->CI->db->where('projects.donor_id', get_loggedin_user_id());
        }
        if (!empty($id)) {
            $this->CI->db->where('projects.id', $id);
        }
        $result = $this->CI->db->get()->result_array();
    
        return $result;
    }

    public function getSelectList($table, $all = '')
    {
        $arrayData = array("" => 'Select');
        if ($all == 'all') {
            $arrayData['all'] = 'All Select';
        }
        $result = $this->CI->db->get($table)->result();
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->name;
        }
        return $arrayData;
    }

    public function getStaffTypes()
    {
        $staffTypesList = $this->CI->db->get('staff_types')->result();
        $type_array = array('' => 'select');
        foreach ($staffTypesList as $row) {
            $type_array[$row->id] = $row->name;
        }
        return $type_array;
    }

    public function getSalaryTypes()
    {
        $salaryTypesList = $this->CI->db->get('salary_types')->result();
        $salary_array = array('' => 'select');
        foreach ($salaryTypesList as $row) {
            $salary_array[$row->id] = $row->name;
        }
        return $salary_array;
    }

    public function getCountryList()
    {
        $countryNameList = $this->CI->db->get('country_name_list')->result();
        $country_name_array = array('' => 'select');
        foreach ($countryNameList as $row) {
            $country_name_array[$row->name] = $row->name;
        }
        return $country_name_array;
    }

    public function getDonorList()
    {
        $donors = $this->CI->db->get('donor')->result();
        $donor_list = array('' => 'select');
        foreach ($donors as $row) {
            $donor_list[$row->id] = $row->name;
        }
        return $donor_list;
    }

    public function getEmployeeList()
    {
        $employees = $this->CI->db->get('staff')->result();
        $employee_list = array('' => 'select');
        foreach ($employees as $row) {
            $employee_list[$row->id] = $row->name;
        }
        return $employee_list;
    }

    public function getEmployeeIDList()
    {
        $employees = $this->CI->db->get('staff')->result();
        $employee_list = array('' => 'select');
        foreach ($employees as $row) {
            $employee_list[$row->id] = $row->name . $row->employee_no;
        }
        return $employee_list;
    }

    public function generateCSRF()
    {
        return '<input type="hidden" name="' . $this->CI->security->get_csrf_token_name() . '" value="' . $this->CI->security->get_csrf_hash() . '" />';
    }

    public function getMonthslist($m)
    {
        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July ',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        return $months[$m];
    }

    public function getDateformat()
    {
        $date = array(
            "Y-m-d" => "yyyy-mm-dd",
            "Y/m/d" => "yyyy/mm/dd",
            "Y.m.d" => "yyyy.mm.dd",
            "d-M-Y" => "dd-mmm-yyyy",
            "d/M/Y" => "dd/mmm/yyyy",
            "d.M.Y" => "dd.mmm.yyyy",
            "d-m-Y" => "dd-mm-yyyy",
            "d/m/Y" => "dd/mm/yyyy",
            "d.m.Y" => "dd.mm.yyyy",
            "m-d-Y" => "mm-dd-yyyy",
            "m/d/Y" => "mm/dd/yyyy",
            "m.d.Y" => "mm.dd.yyyy",
        );
        return $date;
    }


    function timezone_list()
    {
        static $timezones = null;
        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));
                foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }
            array_multisort($offsets, $timezones);
        }
        return $timezones;
    }

    function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}
