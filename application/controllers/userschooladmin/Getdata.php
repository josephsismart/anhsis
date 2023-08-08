<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('BASEPATH') or exit('No direct script access allowed');

class Getdata extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redirect();
        $this->load->model('mainModel');
        $this->load->helper('date');
        date_default_timezone_set("Asia/Manila");
    }

    function getRegionList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->RegionList($filter, 1);
        echo json_encode($data);
    }

    function getProvinceList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->ProvinceList($filter, 1);
        echo json_encode($data);
    }

    function getCityMunList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->CityMunList($filter, 1);
        echo json_encode($data);
    }

    function getBarangayList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->BarangayList($filter);
        echo json_encode($data);
    }

    function getPurokList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PurokList($filter);
        echo json_encode($data);
    }

    function getGradeSubjectList()
    {
        $v = $this->input->post("v");
        $data = ["data" => []];
        $filter  = $v == '' || $v == null ? 0 : $v;
        $sy = $this->getOnLoad()["sy_id"];
        $thisQuery = $this->db->query("SELECT t1.*,t2.sbjct_cc FROM building_sectioning.view_subjectlist_grdlvl t1
                                        LEFT JOIN (
                                        SELECT t1.gradelvl_id,t1.subject_id, COUNT(1) sbjct_cc FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                        WHERE t1.schl_yr_id=$sy AND t1.schoolpersonnel_id IS NOT NULL
                                        GROUP BY t1.subject_id,t1.gradelvl_id) t2 ON t1.subject_id=t2.subject_id AND t1.gradelvl_id=t2.gradelvl_id
                                        WHERE t1.gradelvl_id=$filter AND t1.schl_yr_id=$sy");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "subject_id" => (int) $value->subject_id,
                "item" => $value->subject,
                "cc" => $value->sbjct_cc,
            ];
        }
        echo json_encode($data);
    }

    function getDepartmentList()
    {
        $school_id = $this->session->schoolmis_login_school_id;
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM profile.tbl_school_department t1
                                        WHERE t1.school_id=$school_id
                                        ORDER BY t1.department_name");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->department_name,
            ];
        }
        echo json_encode($data);
    }

    function getRoleList()
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM account.tbl_role t1
                                        WHERE t1.visible=1
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        echo json_encode($data);
    }

    function getPartyList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PartyList($filter);
        echo json_encode($data);
    }

    function getPartyTypeList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->PartyTypeList($filter);
        echo json_encode($data);
    }

    function getStatusList()
    {
        $v = $this->input->post("v");
        $filter = $v == '' || $v == null ? 0 : $v;
        $data = $this->StatusList($filter);
        echo json_encode($data);
    }

    function getPersonnelInfo()
    {
        $requestData = $_REQUEST;
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        // Calculate pagination parameters using the separate function
        list($limit, $offset) = $this->calculatePagination($requestData);

        // Query to get total record count
        $thisQuery = $this->db->query("SELECT COUNT(*) AS total FROM profile.view_schoolpersonnel WHERE CONCAT(employee_type,full_name,personal_title,sex,user_description,username,dept_name,(CASE WHEN is_active_schl_personnel = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END)) ILIKE '%$searchValue%'");
        $totalRecords = $thisQuery->row()->total;

        $query = $this->db->query("SELECT * FROM profile.view_schoolpersonnel WHERE CONCAT(employee_type,full_name,personal_title,sex,user_description,username,dept_name,(CASE WHEN is_active_schl_personnel = 1 THEN 'ACTIVE' ELSE 'INACTIVE' END)) ILIKE '%$searchValue%'
                                    ORDER BY schoolpersonnel_id DESC
                                    LIMIT $limit OFFSET $offset
                                    ");

        $data = array();
        $cc = $offset + 1;
        foreach ($query->result() as $key => $value) {
            $other_details = json_decode($value->other_details, true);
            $img = $this->getImg($value->img_path);
            $id = $value->schoolpersonnel_id;
            $is_a_v = $value->is_active_schl_personnel;
            $is_active = $is_a_v < 1 ? "<span class='badge bg-danger'>INACTIVE</span>" : "<span class='badge bg-success'>ACTIVE</span>";
            if ($value->birthdate) {
                $birthDate = date_create($value->birthdate);
                $birthDate = strtoupper(date_format($birthDate, "M d, Y"));
            } else {
                $birthDate = "-";
            }
            $img_path = $this->getImg($value->img_path);
            $data1 = [
                "personId" => $value->person_id,
                "personnelId" => $id,
                "partyType" => $value->personalTitleId,
                "firstName" => $value->first_name,
                "middleName" => $value->middle_name,
                "lastName" => $value->last_name,
                "extName" => $value->suffix,
                // "sex" => $value->sex_bool == 't' ? 1 : 0,
                "sex" => $value->sex_bool,
                "birthdate" => $value->birthdate,
                "homeAddress" => $value->address_info,
                "is_active" => $is_a_v,
                "cty" => $value->citymun_id,
                "brgy" => $value->barangay_id,
                "personName" => $value->full_name,
                "basicInfoId" => $value->person_id,

                "emptype" => $value->employeeTypeId,
                "personaltitle" => $value->personalTitleId,
                "empstatus" => $value->status_id,
                "employeeID" => $other_details["employee_id"],
                
                "img_path" => $img_path,
            ];
            $data2 = [
                "userId" => $value->user_id,
                "basicInfoId" => $value->person_id,
                "personnelId" => $id,
                "email" => $value->username,
                "role" => $value->role_id,
                "department" => $value->school_department_id,
            ];
            $arr1 = json_encode($data1);
            $arr2 = json_encode($data2);
            $data[] = array(
                $cc++,
                // "<span class='badge'>" . $value->employee_type . "</span>",
                "<div class='row'>".
                
                
                "<div class='col-6'>
                    <div class='d-flex'>
                        <div class='image'>
                            <img class='img-circle size-50 elevation-2 mr-2' src='$img' alt='user image'>
                        </div>
                        <div class='info'>
                            <span class='badge text-md'>$value->full_name, <span class='badge font-weight-light'>$value->sex</span></span>
                            <span class='badge pl-2'>$value->personal_title $is_active</span>".
                            ($value->dept_name?"<span class='badge text-info'><b>" . $value->dept_name . "</b></span>":"").
                        "</div>
                    </div>
                </div>

                
                <div class='col-6'>
                    <button type='button' class='btn btn-xs py-0 text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='getDetails(\"PersonnelInfo\",$arr1,1);delay(\"PersonnelInfo\",$value->barangay_id,\"brgy\");delay(\"PersonnelInfo\",$value->personalTitleId,\"personaltitle\");$(\"#form_save_dataPersonnelInfo [name=firstName]\").focus();$(\"#back-to-top\").trigger(\"click\");'>Edit Information</a>
                        " . ($value->level ? "" :
                    "<a class='dropdown-item btn' onclick='clear_form(\"PersonnelAccount\");getDetails(\"PersonnelAccount\",$arr1,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Create User Account</a>") .
                    "</div>
                </div></div>",
                $value->level ?
                    "<div class='row'><div class='col-6'><span class='badge text-sm'>$value->username</span><br/>
                    <span class='badge'>" . $value->user_description . "</span><br/>".
                "</div>
                <div class='col-6'>
                    <button type='button' class='btn btn-xs py-0 text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='clear_form(\"PersonnelAccount\");getDetails(\"PersonnelAccount\",$arr2,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Edit Account</a>
                    </div>
                </div></div>" : "-",
                
                "<span class='badge'>" . $value->employee_type . "</span><br/>
                <span class='badge'>" . $value->status . "</span>",
            );
        }// Prepare the response data in the required format
        $response = array(
            'draw' => intval($requestData['draw']),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
            'data' => $data,
        );
        echo json_encode($response);
    }

    // function getProfileSample()
    // {
    //     $requestData = $_REQUEST;

    //     $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

    //     // Paging
    //     $limit = isset($requestData['length']) ? intval($requestData['length']) : 10;
    //     $offset = isset($requestData['start']) ? intval($requestData['start']) : 0;
    //     $page = $offset / $limit + 1; // Current page number

    //     // Query to get total record count
    //     $thisQuery = $this->db->query("SELECT COUNT(*) AS total FROM profile.view_basicinfo WHERE full_name ILIKE '%$searchValue%'");
    //     $totalRecords = $thisQuery->row()->total;

    //     // Query to get data with pagination
    //     $query = $this->db->query("SELECT * FROM profile.view_basicinfo WHERE full_name ILIKE '%$searchValue%' LIMIT $limit OFFSET $offset");

    //     $data = array();
    //     $cc = $offset + 1;
    //     foreach ($query->result() as $key => $value) {
    //         // Your existing code to process each row's data

    //         // ...

    //         $data[] = array(
    //             $cc++,
    //             $value->full_name,
    //             // Other columns' data goes here
    //             // For example: $value->column_name, etc.
    //         );
    //     }

    //     // Prepare the response data in the required format
    //     $response = array(
    //         'draw' => intval($requestData['draw']),
    //         'recordsTotal' => intval($totalRecords),
    //         'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
    //         'data' => $data,
    //     );

    //     echo json_encode($response);
    // }

    function getSubjectList()
    {
        $requestData = $_REQUEST;
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        // Calculate pagination parameters using the separate function
        list($limit, $offset) = $this->calculatePagination($requestData);

        // Query to get total record count
        $thisQuery = $this->db->query("SELECT COUNT(1) AS total FROM global.tbl_party WHERE party_type_id=17 AND CONCAT(description,abbr,(CASE WHEN is_active = 't' THEN 'ACTIVE' ELSE 'INACTIVE' END)) ILIKE '%$searchValue%'");
        $totalRecords = $thisQuery->row()->total;

        $data = array();
        $cc = $offset + 1;
        $query = $this->db->query("SELECT * FROM global.tbl_party
                                        WHERE party_type_id=17 AND CONCAT(description,abbr,(CASE WHEN is_active = 't' THEN 'ACTIVE' ELSE 'INACTIVE' END)) ILIKE '%$searchValue%'
                                        ORDER BY order_by ASC
                                        LIMIT $limit OFFSET $offset");

        foreach ($query->result() as $key => $value) {
            $dscrpt = $value->description;
            $active = $value->is_active != 't' ? "<span class='badge bg-danger'>INACTIVE</span>" : "<span class='badge bg-success'>ACTIVE</span>";
            $order = $value->order_by;
            $prtyindex = $value->party_index;
            $abbr = $value->abbr;
            $ppid = $value->parent_party_id;
            $data[] = [
                // $order . ".",
                $cc++,
                "<b>" . $dscrpt . "</b> ". $active,
                $abbr
            ];
        }
        $response = array(
            'draw' => intval($requestData['draw']),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
            'data' => $data,
        );
        echo json_encode($response);
    }

    function getSbjctAssPrsnnl()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $lst = $this->SchoolPersonnelList(null);
        $grdlvl = (int)$this->input->post("grdlvl");
        $rmid = (int)$this->input->post("rmid");
        $data = ["data" => []];

        $thisQuery = $this->db->query("SELECT t1.* FROM building_sectioning.view_subject_grdlvl_personnel_assgnmnt t1
                                        WHERE t1.gradelvl_id=$grdlvl AND t1.room_section_id=$rmid AND t1.schl_yr_id=$sy");

        foreach ($thisQuery->result() as $key => $value) {
            $sbjctid = $value->subject_id;
            $p_id = $value->schoolpersonnel_id;
            $sbjct_abbr = $value->subject_abbr;
            $sbjct = $value->subject;
            $fn = $value->full_name;
            $a = $value->advisory;
            $s = $a == 't' ? 'checked' : '';
            $opt = "<option value=''>SELECT</option>";
            for ($i = 0; $i < count($lst["data"]); $i++) {
                $id = $lst["data"][$i]["id"];
                $item = $lst["data"][$i]["item"];
                $slctd = $id === $p_id ? "selected" : "";
                $opt .= "<option value=" . $id . " " . $slctd . ">" . $item . "</option>";
            }
            $data["data"][] = [
                "<b>" . $sbjct_abbr . "</b> - <small><i>$sbjct</i></small><input type='text' value='" . $sbjctid . "' name='sbjct[]' hidden/>",
                "<div class='row'><div class='col-11'>" .
                    "<select class='form-control selectSbjctAssPrsnnl' name='schlpersonnel[]' type='select' style='width:100%;'>" .
                    $opt . "</select></div>" .
                    '<div class="col-1"><div class="custom-control custom-radio float-right mr-n3">
                    <input class="custom-control-input custom-radio" type="radio" value="' . $sbjctid . '" id="customRadio2' . $sbjctid . '" name="advisory" ' . $s . '>
                    <label for="customRadio2' . $sbjctid . '" class="custom-control-label" style="cursor:pointer;"></label>
                </div></div></div>',
            ];
        }
        echo json_encode($data);
    }

    function getDeptInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $data2 = [];
        $thisQuery = $this->db->query("SELECT t1.*,t2.full_name FROM profile.tbl_school_department t1
                                        LEFT JOIN profile.view_schoolpersonnel t2 ON t1.department_head_person_id=t2.schoolpersonnel_id
                                        ORDER BY t1.department_name");
        
        $requestData = $_REQUEST;
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        // Calculate pagination parameters using the separate function
        list($limit, $offset) = $this->calculatePagination($requestData);

        // Query to get total record count
        $thisQuery = $this->db->query("SELECT count(1) as total FROM profile.tbl_school_department t1
                                        LEFT JOIN profile.view_schoolpersonnel t2 ON t1.department_head_person_id=t2.schoolpersonnel_id 
                                        WHERE CONCAT(t1.department_name,t2.full_name) 
                                        ILIKE '%$searchValue%'
                                        ");
        $totalRecords = $thisQuery->row()->total;

        $query = $this->db->query("SELECT t1.*,t2.full_name FROM profile.tbl_school_department t1
                                    LEFT JOIN profile.view_schoolpersonnel t2 ON t1.department_head_person_id=t2.schoolpersonnel_id
                                    WHERE CONCAT(t1.department_name,t2.full_name) 
                                    ILIKE '%$searchValue%'
                                    ORDER BY t1.department_name
                                    LIMIT $limit OFFSET $offset");

        $data = array();
        $cc = $offset + 1;
        foreach ($query->result() as $key => $value) {
            $duuid = $value->uuid;
            $dept_name = $value->department_name;
            $abbr = $value->abbr;
            $full_name = $value->full_name;
            $data2 = [
                "duuid" => $duuid,
                "name" => $dept_name,
                "abbr" => $abbr,
            ];
            $arr = json_encode($data2);

            $data[] = [
                $cc++,
                "<div class='row'><div class='col-11'>
                    <span class='badge text-sm pb-0'>$dept_name</span>
                    <small>$abbr</i></small><br/>
                    " . ($full_name ? "<small class='ml-2 mr-2 text-success'><b> $full_name </b></small>" : " - ") . "
                </div>
                <div class='col-1'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='getDetails(\"DeptInfo\",$arr,1)'>Edit Information</a>
                    </div>
                </div></div>",
            ];
        }
        $response = array(
            'draw' => intval($requestData['draw']),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
            'data' => $data,
        );
        echo json_encode($response);
    }

    function getGateInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        // $data = ["data" => []];
        $data2 = [];
        // $c = 1;
        // $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_party t1 WHERE t1.party_type_id=20 ORDER BY t1.description");


        $requestData = $_REQUEST;
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        // Calculate pagination parameters using the separate function
        list($limit, $offset) = $this->calculatePagination($requestData);

        // Query to get total record count
        $thisQuery = $this->db->query("SELECT COUNT(*) AS total FROM global.tbl_party WHERE party_type_id=20 AND CONCAT(description,abbr) ILIKE '%$searchValue%'");
        $totalRecords = $thisQuery->row()->total;

        $query = $this->db->query("SELECT * FROM global.tbl_party WHERE party_type_id=20 AND CONCAT(description,abbr) ILIKE '%$searchValue%'
                                    ORDER BY description
                                    LIMIT $limit OFFSET $offset
                                    ");

        $data = array();
        $cc = $offset + 1;
        foreach ($query->result() as $key => $value) {
            $uuid = $value->party_index;
            $dept_name = $value->description;
            $abbr = $value->abbr;
            $data2 = [
                "uuid" => $uuid,
                "name" => $dept_name,
                "abbr" => $abbr,
            ];
            $arr = json_encode($data2);

            $data[] = array(
                $cc++,
                "<div class='row'><div class='col-11'>
                    <span class='badge text-sm pb-0'>$dept_name</span>
                    <small>$abbr</i></small>" .
                    "</div>
                <div class='col-1'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='getDetails(\"DeptInfo\",$arr,1)'>Edit Information</a>
                    </div>
                </div></div>",
            );
        }
        $response = array(
            'draw' => intval($requestData['draw']),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
            'data' => $data,
        );
        echo json_encode($response);
    }

    function getGradeSecInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $data = ["data" => []];
        $data2 = [];
        $requestData = $_REQUEST;
        $searchValue = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

        // Calculate pagination parameters using the separate function
        list($limit, $offset) = $this->calculatePagination($requestData);

        // Query to get total record count
        $thisQuery = $this->db->query("SELECT COUNT(1) AS total FROM building_sectioning.view_room_section t1
                                        LEFT JOIN (SELECT t1.room_section_id,t1.schl_yr_id, SUM(CASE WHEN t1.sex_bool='t' THEN 1 ELSE 0 END) AS male,
                                        SUM(CASE WHEN t1.sex_bool='f' THEN 1 ELSE 0 END) AS female, SUM(1) AS total_enrollee
                                        FROM sy$sy.bs_view_enrollment t1
                                        GROUP by t1.room_section_id,t1.schl_yr_id) t2 ON t1.id=t2.room_section_id
                                        AND t1.schl_yr_id=t2.schl_yr_id
                                        WHERE t1.schl_yr_id=$sy AND CONCAT(grade,grd_lvl_id,id,sctn_nm,program,grd_lvl_group_id,sched,schedule_id,code,full_name,male,female,(CASE WHEN total_enrollee<1 THEN 'NO ENROLLEE' ELSE '' END)) ILIKE '%$searchValue%'");
        $totalRecords = $thisQuery->row()->total;

        $data = array();
        $cc = $offset + 1;

        $query = $this->db->query("SELECT t1.*,t2.male,t2.female,t2.total_enrollee FROM building_sectioning.view_room_section t1
                                        LEFT JOIN (SELECT t1.room_section_id,t1.schl_yr_id, SUM(CASE WHEN t1.sex_bool='t' THEN 1 ELSE 0 END) AS male,
                                        SUM(CASE WHEN t1.sex_bool='f' THEN 1 ELSE 0 END) AS female, SUM(1) AS total_enrollee
                                        FROM sy$sy.bs_view_enrollment t1
                                        GROUP by t1.room_section_id,t1.schl_yr_id) t2 ON t1.id=t2.room_section_id
                                        AND t1.schl_yr_id=t2.schl_yr_id
                                        WHERE t1.schl_yr_id=$sy AND CONCAT(grade,grd_lvl_id,id,sctn_nm,program,grd_lvl_group_id,sched,schedule_id,code,full_name,male,female,(CASE WHEN total_enrollee<1 THEN 'NO ENROLLEE' ELSE '' END)) ILIKE '%$searchValue%'
                                        ORDER BY t1.order_by DESC
                                        LIMIT $limit OFFSET $offset");

        foreach ($query->result() as $key => $value) {
            // $stat = $value->isactive;
            $g = $value->grade;
            $gid = $value->grd_lvl_id;
            $rmsecid = $value->id;
            $s = $value->sctn_nm;
            $p = $value->program;
            $g_group_id = $value->grd_lvl_group_id;
            $schd = $value->sched;
            $sched = $value->schedule_id;
            $code = $value->code;
            $advsry = $value->full_name;
            $male = number_format($value->male) ?? "-";
            $female = number_format($value->female) ?? "-";
            $t_enrollee = number_format($value->total_enrollee) ?? "-";
            $data1 = [
                "id" => $rmsecid,
                "room_id" => 1,
                "gradelevel" => $g_group_id,
                "grade" => $gid,
                "schl_yr_id" => $sy,
                "sectionName" => $s,
                "programName" => $p,
                "sched" => $sched,
            ];

            $data2 = [
                "rmsecid" => $value->id,
            ];
            $arr1 = json_encode($data1);
            $arr2 = json_encode($data2);

            $data[] = array(
                $cc++,
                "<div class='row'><div class='col-11'>
                    <span class='badge text-sm pb-0'>$g - $s <i>$p</i></span>
                    <small>$code<i> - $schd</i></small><br/>
                    " . ($advsry ? "<small class='ml-2 mr-2 text-success'><b> $advsry </b> - </small>" : "<b>NO ADVISORY</b> - ") . "
                    " . ($t_enrollee < 1 ? "<b>NO ENROLLEE</b>" :
                    "<small><b class='text-primary'>M: " . $male . "</b> + <b class='text-pink'>F: " . $female . "</b> = <b class='text-sm'>" . $t_enrollee . "</b></small>") . "
                </div>
                <div class='col-1'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='getSbjctAssPrsnnlFN(\"SbjctAssPrsnnl\"," . $gid . "," . $rmsecid . ");getDetails(\"SbjctAssPrsnnl\",$arr2);'>Subject Assignment</a>
                        <a class='dropdown-item btn' onclick='getDetails(\"GradeSecInfo\",$arr1,1);delay(\"GradeSecInfo\",$gid,\"grade\");'>Edit Information</a>
                    </div>
                </div></div>",
            );
        }
        $response = array(
            'draw' => intval($requestData['draw']),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalRecords), // For simplicity, assuming no filtering is applied
            'data' => $data,
        );
        echo json_encode($response);
    }

    function getSYInfo()
    {
        $data = ["data" => []];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_sy t1 ORDER BY t1.from DESC");
        foreach ($thisQuery->result() as $key => $value) {
            $stat = $value->is_active;
            $ebg = $value->enrollment_stat == 't' ? "bg-success" : "bg-gray";
            $gbg = $value->grading_stat == 't' ? "bg-success" : "bg-gray";
            $vbg = $value->view_grades == 't' ? "bg-success" : "bg-gray";
            $edit = $value->edit_student;
            $unenroll = $value->unenroll;
            $input_grades_qrtr = $value->input_grades_qrtr;
            $igqstr = (string)$value->input_grades_qrtr;

            $edl = $this->dateFormat($value->enrollment_deadline);
            $gdl = $this->dateFormat($value->grading_deadline);
            $vgu = $this->dateFormat($value->view_grades_until);


            $data1 = [
                "qrtrid" => $value->id,
                "quarter" => $value->qrtr,
                "enrollment" => $value->enrollment_stat == 't' ? true : false,
                "enrolldl" => $value->enrollment_deadline,
                "grading" => $value->grading_stat == 't' ? true : false,
                "gradingdl" => $value->grading_deadline,
                "viewing" => $value->view_grades == 't' ? true : false,
                "viewing_date" => $value->view_grades_until,
                "edit" => $value->edit_student == 't' ? true : false,
                "unenroll" => $value->unenroll == 't' ? true : false,
                "customQ1" => strpos($igqstr, '1') !== false ? true : false,
                "customQ2" => strpos($igqstr, '2') !== false ? true : false,
                "customQ3" => strpos($igqstr, '3') !== false ? true : false,
                "customQ4" => strpos($igqstr, '4') !== false ? true : false,

            ];
            $arr1 = json_encode($data1);

            $data["data"][] = [
                "<div class='col-1 float-right'>
                    <button type='button' class='btn btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <a class='dropdown-item btn' onclick='getDetails(\"QuarterInfo\",$arr1,1);$(\"#modalQuarterInfo\").modal(\"show\");'>Edit Details</a>
                    </div>
                </div>",

                "<span class='badge text-md " . ($stat == "t" ? "bg-info" : "bg-gray") . "'>$value->description 
                    <span class='badge text-md bg-yellow'>" . $this->getOnLoad()["qrtrR"] . "</span>
                    <span class='badge text-xs bg-white'>" . ($edit == 'f' ? '' : " <i class='fa fa-pen'></i>") . "</span>
                    <span class='badge text-xs bg-white'>" . ($unenroll == 'f' ? '' : " <i class='fa fa-trash-alt text-danger'></i>") . "</span>
                    " . $input_grades_qrtr . "
                </span>",

                "<span class='badge text-xs " . $ebg . " '>ENRLMNT <br/>" . $edl . "</span>
                <span class='badge text-xs " . $gbg . "'>INPUT GRDS <br/>" . $gdl . "</span>
                <span class='badge text-xs " . $vbg . "'>VIEW GRDS <br/>" . $vgu . "</span>",
            ];
        }
        echo json_encode($data);
    }
}
