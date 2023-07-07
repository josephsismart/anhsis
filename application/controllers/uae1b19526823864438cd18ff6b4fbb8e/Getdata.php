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

    function getQRPerson()
    {
        $sy = $this->getOnLoad()["sy_id"];
        $data = ["data" => []];
        $dataTemp = [];
        $filter = $this->input->post("v");
        $g_name =  $this->input->post("g_nm");
        $g_id = $this->input->post("g_id");
        $personId = null;
        $where = "";
        // $v = $filter != "" ? $filter[0] : null;
        // if ($v) {
        $v = $filter[0];
        $where = $v == '7' ? " WHERE t1.in2='$filter'" : ($v == '6' ? " WHERE t1.out2='$filter'" : " WHERE t1.in='zzzzz'");
        $z = ($v == '7' ? 'IN' : 'OUT');
        $io = "<b class='text-" . ($v == '7' ? 'success' : 'danger') . "'>" . $z . "</b>";
        // $user_id = $this->session->lnhs_login_id;
        $thisQuery = $this->db->query("SELECT  t1.full_name, t1.img_path, t1.type FROM profile.view_gete_pass t1 $where LIMIT 1"); #sy$sy. bs_view_enrollment t1 $where LIMIT 1");
        if ($thisQuery) {
            foreach ($thisQuery->result() as $key => $value) {
                $data["data"][] = [
                    "fullName" => $value->full_name,
                    "description" => $value->type . " " . $io,
                    "pic" => $this->getImg($value->img_path),
                ];
                // $personId = $value->id;
                $this->scanlog($sy, $value->type, $filter, $z, $g_name, $g_id);
            }
        }
        // }
        // echo ($where);
        echo json_encode($data);
    }
}
