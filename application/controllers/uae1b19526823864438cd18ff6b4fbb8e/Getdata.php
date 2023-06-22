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

    function getQRPerson(){
        $sy = $this->getOnLoad()["sy_id"];
        $data = ["data" => []];
        $dataTemp = [];
        $filter = $this->input->post("v");
        $personId = null;
        // $user_id = $this->session->lnhs_login_id;
        $thisQuery=$this->db->query("SELECT t1.full_name, t1.img_path FROM sy$sy.bs_view_enrollment t1 WHERE t1.other_details->>'learner_uuid'='$filter' LIMIT 1");
        if($thisQuery){
            foreach ($thisQuery->result() as $key => $value) {
                $data["data"][] = [
                    "fullName" => $value->full_name,
                    "description" => 'LEARNER',#$value->description,
                    "pic" => $this->getImg($value->img_path),
                ];
                // $personId = $value->id;
                // $this->QRlog($personId,true,96);
            }
        }
        echo json_encode($data);
    }
}
