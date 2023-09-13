<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public $global_requestid = null;
    public $global_requestid_personnel = null;

    public function system()
    {
        $data = [
            "system_title"  => "Agusan National High School Information System",
            // "system_title"  => "Agusan National High School",
            "system_logo"   => base_url("dist/img/media/icons/icon.png"),
            "system_svg"    => base_url("dist/img/media/icons/icon_svg.png"),
            "system_op"    => base_url("dist/img/media/icons/icon_op.png"),
            "system_svg_1x1"    => base_url("dist/img/media/icons/1x1.png"),
            "system_bg_l_front_id"    => base_url("dist/img/media/bg/id/2023/learner/v2/v2_front.png"),
            "system_bg_l_back_id"    => base_url("dist/img/media/bg/id/2023/learner/v2/v2_back.png"),
            "system_bg_nt_front_id"    => base_url("dist/img/media/bg/id/2023/non-teaching/v1/v1_front.png"),
            "system_bg_nt_back_id"    => base_url("dist/img/media/bg/id/2023/non-teaching/v1/v1_back.png"),
            "system_bg_t_front_id"    => base_url("dist/img/media/bg/id/2023/teaching/v1/v1_front.png"),
            "system_bg_t_back_id"    => base_url("dist/img/media/bg/id/2023/teaching/v1/v1_back.png"),
            "system_esig"    => base_url("dist/img/media/esig/roa.png"),

            "system_deped_1x1"    => base_url("dist/img/media/icons/deped_1x1.png"),
            "system_depeddiv_1x1"    => base_url("dist/img/media/icons/depeddiv_1x1.png"),

        ];
        return $data;
    }

    public function public_create_page($data = [])
    {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        if ($level != "") {
            if ($defaultPassword == 't') {
                return $this->load->view('interface/userpassword/layout/Page', $data, false);
            } else {
                return $this->load->view('interface/' . $uri . '/layout/Page', $data, false);
            }
        }
    }

    public function user_create_page($data = [])
    {
        return $this->load->view('interface/user/layout/Page', $data, false);
    }

    public function redirect()
    {
        $login = $this->session->schoolmis_login_id;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if (!$login) {
            redirect(base_url('/'));
        }
        if (isset($login) && $this->uri->segment(1) != $uri) {
            if ($defaultPassword == 1) {
                redirect(base_url('userpassword/changepassword'));
            } else {
                redirect(base_url($uri . '/' . $landing));
            }
        }
    }

    public function redirect2()
    {
        $login = $this->session->schoolmis_login_id;
        if (!$login) {
            redirect(base_url('/'));
        }
    }

    public function redirect_home()
    {
        $level = $this->session->schoolmis_login_level;
        $defaultPassword = $this->session->schoolmis_change_password;
        $uri = $this->session->schoolmis_login_uri;
        $landing = $this->session->schoolmis_login_landing;
        if (isset($this->session->schoolmis_login_id) && $this->uri->segment(1) == "" || $this->uri->segment(1) == "login" || $this->uri->segment(1) == "map") {
            if ($level != "") {
                if ($defaultPassword == 1) {
                    redirect(base_url('userpassword/changepassword'));
                } else {
                    redirect(base_url($uri . '/' . $landing));
                }
            }
        }
    }

    public function redirect_session()
    {
        $login = $this->session->schoolmis_login_id;
        if (!$login) {
            redirect(base_url('/'));
        }
    }

    public function submitGradesBtn($a, $b, $mm, $d, $f)
    {
        $c = $this->clean($mm);
        $e = "";
        $g = 'data-toggle="tooltip" data-placement="bottom" data-html="true" title="<em>Message:</em> <b>' . $c . '</b>"';
        $h = '<i class="fa fa-envelope float-right text-yellow"></i>';
        if ($a && $a != "RECHECK") {
            $e = '<span class="badge w-100 text-sm ' . ($a == 'APPROVED' ? 'bg-success' : 'bg-navy') . '" ' . ($c ? $g : '') . '>'
                . ($a == 'APPROVED' ? '<i class="fa fa-check-circle"></i> ' : '')
                . $a . ' Q' . $f . ' - ' . $b . '%
                ' . ($c ? $h : '') . '
                </span>';
        } else if ($a || $b) {
            $e = '<button onclick="preSbmitGrades(' . $d . ',' . $f . ',' . $b . ')" type="button" class="btn btn-block btn-xs btn-info float-right ml-1" ' . ($c ? $g : '') . '>
                    <i class="fa fa-paper-plane"></i> <b>' . ($a == "RECHECK" ? $a : "SUBMIT") . ' Q' . $f . ' - ' . $b . '%</b>
                    ' . ($c ? $h : '') . '
                    </button>';
        } else {
            $e = null;
        }
        return $e;
    }

    public function apprvGradesBtn($a, $b, $mm, $d, $f, $g)
    {
        $c = $this->clean($mm);
        $e = "";
        $h = 'data-toggle="tooltip" data-placement="bottom" data-html="true" title="<em>Message:</em> <b>' . $c . '</b>"';
        $i = '<i class="fa fa-envelope float-right text-yellow"></i>';

        if ($a == "FOR APPROVAL") {
            $e =    '<button  ' . ($c ? $h : '') . ' ' .
                "onclick='preSbmitGrades(\"$a\"," . $b . ",\"$c\"," . $d . "," . $f . "," . $g . ")' "
                . 'type="button" class="btn btn-block btn-xs btn-info">
                            <b> Q' . $f . ' - ' . $b . '%</b> APPROVE/RECHECK
                            ' . ($c ? $i : '') . '
                    </button>';
        } else if ($a == "APPROVED") {
            $e =    '<button  ' . ($c ? $h : '') . ' ' .
                "onclick='preSbmitGrades(\"$a\"," . $b . ",\"$c\"," . $d . "," . $f . "," . $g . ")' "
                . 'type="button" class="btn btn-block btn-xs btn-success">
                            <i class="fa fa-thumbs-up"></i>  <b> Q' . $f . ' - ' . $b . '%</b> APPROVED
                            ' . ($c ? $i : '') . '
                    </button>';
        } else if ($a == "RECHECK") {
            $e =    '<button  ' . ($c ? $h : '') . ' '
                . 'type="button" class="btn btn-block btn-xs bg-navy" style="cursor:default;">
                            <b> Q' . $f . ' - ' . $b . '%</b> RECHECK
                            ' . ($c ? $i : '') . '
                    </button>';
        } else {
            $e = null;
        }
        return $e;
    }

    public function removeCharacter($text)
    {
        return preg_replace("/[^0-9]/", "", $text);
    }

    public function clean($string)
    {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

    public function returnNull($a)
    {
        $return = !$a ? NULL : $a;
        return $return;
    }

    public function returnEmptyArr($a)
    {
        $return = !$a ? 0 : count($a);
        return $return;
    }

    public function returnZero($a)
    {
        $return = !$a ? 0 : $a;
        return $return;
    }

    public function returnDashed($a)
    {
        $return = ($a == 0 ? '--' : $a);
        return $return;
    }

    public function returnDDashed($a)
    {
        $return = ($a == 0 ? '--' : ($a == NULL ? '--' : $a));
        return $return;
    }

    public function returnBtnHonor($a, $b)
    {
        $return = $b ? "<button class='btn btn-xs px-0 my-n2' onclick='$(\"#modalHonor\").modal(\"show\");showTableHonors(" . json_encode($a) . ");'>"
            . $this->returnDashed($b) . "</button>" : "-";
        return $return;
    }

    public function RegionList($filter, $default)
    {
        $data = ["data" => []];
        // $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_region t1 ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->regional_designation,
            ];
        }
        return $data;
    }

    public function ProvinceList($filter, $default)
    {
        $data = ["data" => []];
        $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_province t1 WHERE t1.region_id=$filter ORDER BY t1.id");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function CityMunList($filter, $default)
    {
        $data = ["data" => []];
        $orby = $default ? "t1.id," : "";
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_citymun t1 WHERE t1.province_id=$filter ORDER BY $orby t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function BarangayList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_barangay t1 WHERE t1.citymun_id=$filter ORDER BY t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function PurokList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM address.tbl_purok t1 WHERE t1.barangay_id=$filter ORDER BY t1.description");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function getBarangay_City($brgy, $city)
    {
        $brgy_id = 160202038;#160202054;
        if (strtoUpper($city) == 'BUTUAN CITY (CAPITAL)') {
            $query = $this->db->query("SELECT t1.id FROM address.tbl_barangay t1 WHERE t1.citymun_id=160201
                                        AND orig_desc ILIKE '%$brgy%' LIMIT 1");
            if ($query->num_rows() > 0) {
                $brgy_id = $query->row()->id;
            } else {
                $brgy_id = 160202038;#160202054;
            }
        } else {
            $query = $this->db->query("SELECT t2.id FROM address.tbl_citymun t1 
                                        LEFT JOIN address.tbl_barangay t2 ON t1.id=t2.citymun_id
                                        WHERE t1.description ILIKE '%$city%' AND t2.orig_desc ILIKE '%$brgy%' LIMIT 1");
            if ($query->num_rows() > 0) {
                $brgy_id = $query->row()->id;
            } else {
                $brgy_id = 160202038;#160202054;
            }
        }
        return $brgy_id;
    }

    public function allow_schema()
    {
        $this->db->query("GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA account TO xnyiyspvjvppjz;

                            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA address TO xnyiyspvjvppjz;
                            
                            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA building_sectioning TO xnyiyspvjvppjz;
                            
                            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA global TO xnyiyspvjvppjz;
                            
                            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA profile TO xnyiyspvjvppjz;
                            
                            GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO xnyiyspvjvppjz;");


        // $this->db->query("GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA account TO xnyiyspvjvppjz;

        // GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA address TO xnyiyspvjvppjz;

        // GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA building_sectioning TO xnyiyspvjvppjz;

        // GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA global TO xnyiyspvjvppjz;

        // GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA profile TO xnyiyspvjvppjz;

        // GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO xnyiyspvjvppjz;");
    }

    public function PartyList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_party t1 
                                        WHERE t1.party_type_id=$filter 
                                        AND t1.is_active=true
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function PartyTypeList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_partytype t1 
                                        WHERE t1.group_id=$filter 
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function SchoolPersonnelList($filter)
    {
        $w = $filter ? "WHERE t1.employeeTypeId=$filter" : "";
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM profile.view_schoolpersonnel t1 $w ORDER BY t1.first_name");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->schoolpersonnel_id,
                "item" => $value->full_name,
            ];
        }
        return $data;
    }

    public function StatusList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_status t1 
                                        WHERE t1.status_type_id=$filter 
                                        AND t1.is_active=true
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function GradesSectionList($filter)
    {
        $data = ["data" => []];
        $thisQuery = $this->db->query("SELECT * FROM global.tbl_status t1 
                                        WHERE t1.status_type_id=$filter 
                                        AND t1.is_active=true
                                        ORDER BY t1.order_by");
        foreach ($thisQuery->result() as $key => $value) {
            $data["data"][] = [
                "id" => $value->id,
                "item" => $value->description,
            ];
        }
        return $data;
    }

    public function getOnLoad()
    {
        $query = $this->db->query("SELECT * FROM global.tbl_sy t1 WHERE t1.is_active=true");
        $row = $query->row();
        $sy_id = $row->id;
        $sy = $row->description;
        $qrtr = $row->qrtr;
        $enroll_stat = $row->enrollment_stat;
        $enroll_dl = $row->enrollment_deadline;
        $grade_stat = $row->grading_stat;
        $grade_dl = $row->grading_deadline;
        $edit = $row->edit_student;
        $unenroll = $row->unenroll;
        $v_grades = $row->view_grades;
        $v_grades_date = $row->view_grades_until;
        $input_grades_qrtr = $row->input_grades_qrtr;
        $qrtrR = $qrtr == 1 ? "1st" : ($qrtr == 2 ? "2nd" : ($qrtr == 3 ? "3rd" : ($qrtr == 4 ? "4th" : "--")));
        $edl = "";
        $edl1 = "";
        $gdl = "";
        $gdl1 = "";
        $vgd = "";
        if ($enroll_dl) {
            $edl = $this->dateFormat($enroll_dl);
            $edl1 = "<br/>" . $edl;
        }
        if ($grade_dl) {
            $gdl = $this->dateFormat($grade_dl);
            $gdl1 = "<br/>" . $gdl;
        }
        if ($v_grades == 't') {
            $vgd = $this->dateFormat($v_grades_date);
        }

        $data = [
            "sy_id" => $sy_id,
            "sy" => $sy,
            "qrtr" => $qrtr,
            "qrtrR" => $qrtrR,
            "enroll_stat" => $enroll_stat,
            "enroll_dl" => $enroll_dl,
            "grade_stat" => $grade_stat,
            "grade_dl" => $grade_dl,
            "edl" => $edl1,
            "gdl" => $gdl1,
            "edit" => $edit,
            "unenroll" => $unenroll,
            "v_grades" => $v_grades,
            "vgd" => $vgd,
            "input_grades_qrtr" => $input_grades_qrtr,
            // "sy_qrtr_e_g" => "<b>SY:</b> " . $sy . " | <b>Q:</b> " . $qrtrR,
            "sy_qrtr_e_g" => "<b>SY:</b> " . $sy . " | <b>Q:</b> |" . $qrtrR .
                "<div class='d-none d-sm-block d-lg-block'>" .
                ($enroll_stat == 't' ? " <small class='text-success text-bold' style='white-space: nowrap;'><b>ENR: </b>" . $edl . "</small>" : "") .
                ($grade_stat == 't' ? " | <small class='text-success text-bold' style='white-space: nowrap;'><b>GRD: </b>" . $gdl . "</small>" : "") .
                "</div>",
        ];
        return $data;
    }

    public function getSHdboard()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $query = $this->db->query("SELECT SUM(CASE WHEN t1.sex_bool=TRUE THEN 1 END) AS male,
                                    SUM(CASE WHEN t1.sex_bool=FALSE THEN 1 END) AS female
                                    FROM sy$sy.bs_view_enrollment t1
                                    WHERE t1.status_id=5");

        $query1 = $this->db->query("SELECT SUM(CASE WHEN t1.sex_bool=TRUE THEN 1 END) AS male,
                                    SUM(CASE WHEN t1.sex_bool=FALSE THEN 1 END) AS female
                                    FROM profile.view_schoolpersonnel t1
                                    WHERE t1.person_id != 1197 
                                    AND t1.person_id != 1 
                                    AND t1.person_id != 1431 
                                    AND t1.person_id != 1102 
                                    -- AND t1.is_active=TRUE
                                    AND t1.is_active_schl_personnel>0");

        $query2 = $this->db->query("SELECT t1.role_id,t1.user_description, COUNT(1) AS cc FROM account.view_useraccount t1
                                    GROUP BY t1.user_description,t1.role_id");

        $row = $query->row();
        $row1 = $query1->row();
        $emale =  number_format($row->male);
        $efmale =  number_format($row->female);
        $tenroll =  number_format($row->male + $row->female);

        $tpmale =  number_format($row1->male);
        $tpfemale =  number_format($row1->female);
        $ttpenroll =  number_format($row1->male + $row1->female);

        foreach ($query2->result() as $key => $value) {
            $r = $value->role_id;
            if ($r == 3) {
                $dephead = (int) $value->cc;
            }
            if ($r == 7) {
                $teacher = (int) $value->cc;
            }
            if ($r == 8) {
                $learner = (int) $value->cc;
            }
        }

        $data = [
            "emale" => $emale,
            "efmale" => $efmale,
            "tenroll" => $tenroll,

            "tpmale" => $tpmale,
            "tpfemale" => $tpfemale,
            "ttpenroll" => $ttpenroll,

            "dephead" => $dephead,
            "teacher" => $teacher,
            "learner" => $learner,
        ];
        return $data;
    }

    public function filterAndFormatDate($date) {
        // Define an array of possible date format patterns
        $dateFormats = array('m-d-Y', 'm/d/Y');
    
        foreach ($dateFormats as $format) {
            $parsedDate = DateTime::createFromFormat($format, $date);
            if ($parsedDate !== false) {
                // Successfully parsed the date, now format it as 'Y-m-d'
                return $parsedDate->format('Y-m-d');
            }
        }
    
        // Return null if none of the formats matched
        return "2001-10-10";
    }

    public function get_ip()
    {
        $ip = "";
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        if ($ip == "::1") {
            $ip = "127.0.0.1";
        }
        return $ip;
    }

    public function confirmPassword($a)
    {
        $pwd = md5($a);
        $login_id = $this->session->schoolmis_login_id;
        $query = $this->db->query("SELECT 1 AS pwd FROM tbl_user WHERE id=$login_id AND password='$pwd' LIMIT 1");
        return $query->row("pwd");
    }

    public function now()
    {
        date_default_timezone_set("Asia/Manila");
        $now = date("Y-m-d H:i:s");
        return $now;
    }

    public function do_upload($input_name, $upload_path, $file_name)
    {
        $path = "";
        // $num = mt_rand(1, 1000000);

        $config['upload_path']      = $upload_path;
        $config['allowed_types']    = 'pdf|docx|xls|ppt|jpg|png|jpeg|txt';
        $config['max_size']         = '100000';
        $config['overwrite']        = true;
        $config['file_name']        = $file_name;
        // $config['max_width']         = '5000';
        // $config['max_height']        = '5000';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $upload = $this->upload->do_upload($input_name);
        if ($upload) {
            $path = $file_name;
        }
        return $path;
    }

    public function userlog($action)
    {
        $login_id = $this->session->schoolmis_login_id;
        $login_alias = $this->session->schoolmis_login_uname;
        $now = $this->now();
        $action = addslashes($action);
        $ip = $this->get_ip();
        $data = [
            "date" => $now,
            "action" => $action,
            "user_id" => $login_id,
            "user_name" => $login_alias,
            "ip" => $ip,
        ];
        if ($login_id) {
            $this->db->insert("global.tbl_userlogs", $data);
        }
    }

    public function calculatePagination($requestData)
    {
        $limit = isset($requestData['length']) ? intval($requestData['length']) : 10;
        $offset = isset($requestData['start']) ? intval($requestData['start']) : 0;
        return array($limit, $offset);
    }

    public function scanlog($x, $type, $scanned_id, $io, $g_name, $g_id)
    {
        $exist = false;
        $query = $this->db->query("SELECT EXISTS (
                                    SELECT 1
                                    FROM pg_tables
                                    WHERE schemaname = 'logs' AND tablename = 'tbl_scan_logs$x'
                                ) AS t;");
        if ($query->num_rows() > 0) {
            $exist =  $query->row()->t;
        } else {
            $q = "";
            $qq = "";
            $q  = $this->db->query("CREATE SEQUENCE logs.tbl_scan_logs_seq$x
                                    INCREMENT BY 1
                                    MINVALUE 1
                                    MAXVALUE 9223372036854775807
                                    START 1
                                    CACHE 1
                                    NO CYCLE;");
            if ($q) {
                $qq = $this->db->query("CREATE TABLE logs.tbl_scan_logs$x (
                                            id int8 NOT NULL DEFAULT nextval('logs.tbl_scan_logs_seq$x'::regclass),
                                            date timestamp NOT NULL DEFAULT now(),
                                            action text NOT NULL,
                                            scan_data text NULL,
                                            scanned_by text NOT NULL,
                                            gate_scanned text NOT NULL,
                                            ip text NULL,
                                            CONSTRAINT tbl_userlogs_pkey PRIMARY KEY (id)
                                        );");
            }
            if ($qq) {
                $exist = true;
            }
        }
        if ($exist == true) {
            $login_id = $this->session->schoolmis_login_id;
            $login_alias = $this->session->schoolmis_login_uname;
            $now = $this->now();
            // $action = $action; //addslashes($action);
            $ip = $this->get_ip();
            $data = [
                "date" => $now,
                "action" => '{"IO":"' . $io . '"}',
                "scan_data" => '{"tpye":"' . $type . '","id":"' . $scanned_id . '"}',
                "scanned_by" => '{"user":"' . $login_alias . '","id":"' . $login_id . '"}',
                "gate_scanned" => '{"name":"' . $g_name . '","id":"' . $g_id . '"}',
                "ip" => $ip,
            ];
            if ($login_id) {
                $this->db->insert("logs.tbl_scan_logs$x", $data);
            }
        }
    }

    public function learnerlog($action)
    {
        $sy = $this->getOnLoad()["sy_id"];
        $login_id = $this->session->schoolmis_login_id;
        $login_alias = $this->session->schoolmis_login_uname;
        $now = $this->now();
        $action = addslashes($action);
        $ip = $this->get_ip();
        $data = [
            "date_time" => $now,
            "action" => $action,
            "user_id" => $login_id,
            "user_name" => $login_alias,
            "ip" => $ip,
        ];
        if ($login_id) {
            $this->db->insert("sy$sy.g_tbl_userlogs_learner", $data);
        }
    }

    public function basicInfoChecker($f, $m, $l, $b, $s)
    {
        $sex = $s == 1 ? 'true' : 'false';
        $query = $this->db->query("SELECT t1.id FROM profile.tbl_basicinfo t1
                                    WHERE t1.first_name='$f' AND t1.middle_name='$m' AND t1.last_name='$l' AND t1.birthdate='$b' AND t1.sex=$sex");
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function learnerChecker($lrn, $binfoId)
    {
        $where = !$binfoId && $lrn ? "WHERE t1.lrn='$lrn'" : ($binfoId && !$lrn ? "WHERE t1.basic_info_id=$binfoId" : "WHERE t1.lrn='$lrn' AND t1.basic_info_id=$binfoId");
        $query = $this->db->query("SELECT t1.id FROM profile.tbl_learners t1 $where");
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function enrollmentChecker($a, $b)
    {
        $sy = $this->getOnLoad()["sy_id"];
        echo ($a);
        echo ('<br/>');
        if (!$b) {
            $query = $this->db->query("SELECT t1.id FROM sy$sy.bs_tbl_learner_enrollment t1 WHERE t1.learner_id=$a");
        } else {
            $query = $this->db->query("SELECT t2.basic_info_id AS id FROM sy$sy.bs_tbl_learner_enrollment t1 
                                        LEFT JOIN profile.tbl_learners t2 ON t1.learner_id = t2.id 
                                        WHERE t1.learner_id=$a");
        }
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            return false;
        }
    }

    public function gradeColor($a)
    {

        if ($a) {
            $grade = (int) $a;
            $color = "";
            if ($grade >= 90) {
                $color = "success";
            } else if ($grade >= 80) {
                $color = "orange";
            } else if ($grade > 0) {
                $color = "danger";
            }
            return "<b class='text-lg text-" . $color . "'>" . $a . "</b>";
        } else {
            return "--";
        }
    }

    public function uploadImg($pic, $id, $path_)
    {
        $s = $this->getOnLoad()["sy"];
        $newImageName = null;
        // if (isset($_FILES['pic'])) {
        // Add a flag to check if the upload process has already been executed
        $isUploaded = false;
        if (isset($pic) && !$isUploaded) {
            //$thisPic=$this->do_blob($_FILES['pic']);
            // dist/img/icons
            // dist/img/media/learner/2022-2023
            // Create the directory if it doesn't exist
            $config['upload_path'] = "dist/img/media/$path_/" . $s . "/";

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('pic')) {
                $myPic = null;
            } else {
                $isUploaded = true;
                $upData = $this->upload->data();
                $myPic = $this->upload->data();
                $config['image_library'] = 'gd2';
                $config['encrypt_name'] = true;



                $config['source_image'] = $config['upload_path'] . $myPic['file_name'];
                // $config['create_thumb'] = false;
                // $config['maintain_ratio'] = true;
                // $config['quality'] = '60%';
                // $config['width'] = 166;
                // $config['height'] = 166;

                // $config['new_image'] = "dist/img/media/learner/2022-2023/" . $myPic['file_name'];

                // $this->load->library('image_lib', $config);
                // $this->image_lib->resize();

                // Determine the file extension
                $extension = pathinfo($myPic['file_name'], PATHINFO_EXTENSION);

                // Modify the image name here
                $newImageName = $id . "." . $extension;
                $config['new_image'] = "dist/img/media/$path_/$s/$newImageName";

                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
            }
            return $config['upload_path'] . $newImageName;
        }
    }

    public function getImg($a)
    {
        // Check if the provided path is a URL
        if (filter_var($a, FILTER_VALIDATE_URL)) {
            $pathExists = get_headers($a);
            if ($pathExists && strpos($pathExists[0], '200')) {
                return $a;
            }
        } else {
            // Check if the provided path is a local file
            $localPath = realpath($a);
            if ($localPath && is_file($localPath)) {
                // Check if the file is an image
                $imageInfo = getimagesize($localPath);
                if ($imageInfo !== false) {
                    return base_url() . $a;
                }
            }
        }

        // Return the default image URL
        return base_url('dist/img/media/icons/1x1.png');
    }

    public function avg4($a, $b, $c, $d)
    {
        if ($a && $b && $c && $d) {
            $t = $a + $b + $c + $d;
            return round($t / 4, 0);
        } else {
            return 0;
        }
    }

    public function dateFormat($a)
    {
        $b = "-";
        if ($a != null) {
            $c = date_create($a);
            $b = date_format($c, "M d, Y");
        }
        return strtoUpper($b);
    }

    // public function font_id($a)
    // {
    //     $count = strlen($a);
    //     if ($count >= 15) {
    //         $s = 8;
    //     } else if ($count >= 12) {
    //         $s = 12;
    //     }
    //     return strtoUpper("<p style='font-size: " . $s . "px'>" . $a . "</p>");
    // }

    function font_idz($text, $minFontSize, $maxFontSize, $maxLength)
    {
        $textLength = strlen($text);
        $fontSize = $minFontSize;

        // Calculate the font size based on the text length
        if ($textLength > 0) {
            $fontSize = $minFontSize + (($maxFontSize - $minFontSize) * ($textLength / $maxLength));
        }

        // Return the font size
        // return $fontSize;
        // <u>&emsp;'+advisory+'&emsp;</u>
        return strtoUpper("<u style='font-size: " . $fontSize . "px'>" . $text . "</u>");
    }

    function font_id2($text, $minFontSize, $maxFontSize, $maxWidth)
    {
        $fontSize = $maxFontSize;

        // Create a temporary image to calculate text dimensions
        $image = imagecreatetruecolor(1, 1);

        // Calculate the width of the text at the maximum font size
        $textWidth = imagefontwidth($fontSize) * strlen($text);

        // Reduce the font size until it fits within the maximum width
        while ($textWidth > $maxWidth && $fontSize > $minFontSize) {
            $fontSize--;
            $textWidth = imagefontwidth($fontSize) * strlen($text);
        }

        // Destroy the temporary image
        imagedestroy($image);

        return strtoUpper("<u style='font-size: " . $fontSize . "px'>" . $text . "</u>");
    }

    function font_id($text, $minFontSize, $maxFontSize)
    {
        $len = strlen($text);

        if ($len <= 19) {
            $fontSize = $maxFontSize;
        } elseif ($len <= 25) {
            $fontSize = $minFontSize;
        } elseif ($len <= 28) {
            $fontSize = $minFontSize;
        } elseif ($len <= 32) {
            $fontSize = $minFontSize;
        } elseif ($len <= 36) {
            $fontSize = $minFontSize;
        } else {
            $fontSize = $maxFontSize - ($len % $maxFontSize);
        }

        return "<u style='font-size: " . $fontSize . "px'>" . $text . "</u>";
    }

    public function grades_input($lrn, $q, $qrtr)
    {
        $id = $lrn . $qrtr;
        return  "<center><input style='width:50px;text-align:center'
                         onclick='maxInput(\"gradeLearner$id\")' onkeyup='maxInput(\"gradeLearner$id\");'
                         style='text-align:center;' type='number' class='form-control' 
                         name='gradeLearner" . $qrtr . "[]' value='$q' 
                         placeholder='--' nr='1' 
                         id='gradeLearner$id'/></center>";
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */