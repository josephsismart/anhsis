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
        parse_str($this->input->post("a"), $filter);
        $limit = isset($filter['limit']) ? $filter['limit'] : 10;
        $emp_type_id = isset($filter['emptype']) ? 'WHERE t1."employeeTypeId"=' . $filter['emptype'] . '' : 'WHERE t1."employeeTypeId"=4';
        $data = ["data" => []];
        // $thisQuery = $this->db->query("SELECT * FROM profile.view_schoolpersonnel ORDER BY schoolpersonnel_id DESC");
        $thisQuery = $this->db->query("SELECT t1.* FROM profile.view_schoolpersonnel t1
                                        $emp_type_id
                                        ORDER BY t1.schoolpersonnel_id DESC LIMIT $limit");
        $cc = 1;
        foreach ($thisQuery->result() as $key => $value) {
            $other_details = json_decode($value->other_details, true);
            $id = $value->schoolpersonnel_id;
            $is_a_v = $value->is_active_schl_personnel;
            $is_active = $is_a_v < 1 ? "<span class='badge bg-danger'>INACTIVE</span>" : "";
            if ($value->birthdate) {
                $birthDate = date_create($value->birthdate);
                $birthDate = strtoupper(date_format($birthDate, "M d, Y"));
            } else {
                $birthDate = "-";
            }
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
            $data["data"][] = [
                $cc++,
                "<span class='badge'>" . $value->employee_type . "</span><br/>
                <span class='badge'>" . $value->status . "</span>",
                "<div class='row'><div class='col-6'>
                    <span class='badge text-md'>$value->full_name</span><span class='badge'>" . $value->personal_title . "</span>" . $is_active . "<br/>
                    <span class='badge'>" . $value->address_details . "</span>,
                    <span class='badge font-weight-light'>" . $value->sex . "</span>, 
                    <span class='badge font-weight-light'>" . $birthDate . "</span>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn mt-3 btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <button class='dropdown-item' onclick='getDetails(\"PersonnelInfo\",$arr1,1);delay($value->barangay_id,\"brgy\");delay($value->personalTitleId,\"personaltitle\")'>Edit Information</button>
                        " . ($value->level ? "" :
                    "<button class='dropdown-item' onclick='clear_form(\"form_save_dataPersonnelAccount\");getDetails(\"PersonnelAccount\",$arr1,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Create User Account</button>") .
                    "</div>
                </div></div>",
                $value->level ?
                    "<div class='row'><div class='col-6'><span class='badge text-sm'>$value->username</span><br/>
                    <span class='badge'>" . $value->user_description . "</span><br/>
                    <span class='badge text-info'><b>" . $value->dept_name . "</b></span><br/>
                </div>
                <div class='col-6'>
                    <button type='button' class='btn mt-3 btn-xs text-sm float-right btn-outline-secondary rounded-circle border-0' data-toggle='dropdown' aria-expanded='true'>
                        <span class='fa fa-ellipsis-h'></span>
                    </button>
                    <div class='dropdown-menu'>
                        <button class='dropdown-item' onclick='clear_form(\"form_save_dataPersonnelAccount\");getDetails(\"PersonnelAccount\",$arr2,1);$(\"#modalPersonnelAccount\").modal(\"show\");'>Edit Account</button>
                    </div>
                </div></div>" : "-",
            ];
        }
        echo json_encode($data);
    }

    function getSubjectList()
    {
        $data = ["data" => []];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.* FROM global.tbl_party t1
                                        WHERE t1.group_by=11 ORDER BY t1.order_by ASC");

        foreach ($thisQuery->result() as $key => $value) {
            $dscrpt = $value->description;
            $active = $value->is_active == 't' ? true : false;
            $order = $value->order_by;
            $prtyindex = $value->party_index;
            $abbr = $value->abbr;
            $ppid = $value->parent_party_id;
            $data["data"][] = [
                $order . ".",
                "<b>" . $dscrpt . "</b>",
                $abbr
            ];
        }
        echo json_encode($data);
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
        $data = ["data" => []];
        $data2 = [];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.*,t2.full_name FROM profile.tbl_school_department t1
                                        LEFT JOIN profile.view_schoolpersonnel t2 ON t1.department_head_person_id=t2.schoolpersonnel_id
                                        ORDER BY t1.department_name");
        foreach ($thisQuery->result() as $key => $value) {
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

            $data["data"][] = [
                $c++,
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
                        <a class='dropdown-item' href='#' onclick='getDetails(\"DeptInfo\",$arr,1)'>Edit Information</a>
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
    }

    function getGradeSecInfo()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $data = ["data" => []];
        $data2 = [];
        $c = 1;
        $thisQuery = $this->db->query("SELECT t1.*,t2.male,t2.female,t2.total_enrollee FROM building_sectioning.view_room_section t1
                                        LEFT JOIN (SELECT t1.room_section_id,t1.schl_yr_id, SUM(CASE WHEN t1.sex_bool='t' THEN 1 ELSE 0 END) AS male,
                                        SUM(CASE WHEN t1.sex_bool='f' THEN 1 ELSE 0 END) AS female, SUM(1) AS total_enrollee
                                        FROM sy$sy.bs_view_enrollment t1
                                        GROUP by t1.room_section_id,t1.schl_yr_id) t2 ON t1.id=t2.room_section_id
                                        AND t1.schl_yr_id=t2.schl_yr_id
                                        WHERE t1.schl_yr_id=$sy
                                        ORDER BY t1.order_by DESC
        -- SELECT t1.* FROM building_sectioning.view_room_section t1
                                        -- WHERE t1.schl_yr_id=$sy
                                        ");
        foreach ($thisQuery->result() as $key => $value) {
            // $stat = $value->isactive;
            $g = $value->grade;
            $gid = $value->grd_lvl_id;
            $rmsecid = $value->id;
            $s = $value->sctn_nm;
            $schd = $value->sched;
            $code = $value->code;
            $advsry = $value->full_name;
            $male = number_format($value->male) ?? "-";
            $female = number_format($value->female) ?? "-";
            $t_enrollee = number_format($value->total_enrollee) ?? "-";
            $data2 = [
                "rmsecid" => $value->id,
            ];
            $arr = json_encode($data2);

            $data["data"][] = [
                $c++,
                "<div class='row'><div class='col-11'>
                    <span class='badge text-sm pb-0'>$g - $s</span>
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
                        <a class='dropdown-item' href='#' onclick='getSbjctAssPrsnnlFN(\"SbjctAssPrsnnl\"," . $gid . "," . $rmsecid . ");getDetails(\"SbjctAssPrsnnl\",$arr);'>Subject Assignment</a>
                        <!-- <a class='dropdown-item' href='#' onclick='getDetails(\"MemberUser\",1)'>Edit Information</a> -->
                    </div>
                </div></div>",
            ];
        }
        echo json_encode($data);
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
                        <button class='dropdown-item' onclick='getDetails(\"QuarterInfo\",$arr1,1);$(\"#modalQuarterInfo\").modal(\"show\");'>Edit Details</button>
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
