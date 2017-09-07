<?php

Class Superajax extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('useragent_model');
        $this->load->model('logadmin_model');
        $this->load->model('sourcegiftcode_model');
        $this->load->helper(array("form", "url"));
        $this->load->library('upload');
    }

    function adminadd()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $quantity = urlencode($this->input->post("quantity"));
        $version = $this->input->post("version");
        $rotate = $this->input->post("rotate");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->config->item('api_url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'c=128&sf=' . $rotate . '&gq=' . $quantity . '&gl=' . $version. '&gs=GCG');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_TIMEOUT,3600);
        $server_output = curl_exec ($ch);
        $data = json_decode($server_output);
        if (isset($data->success)) {
            if ($data->success == true) {
                if ($data->errorCode == 0) {
                    $this->logadmin_model->create($this->logadmingiftcode(15, "", $admin_info->UserName, $quantity, $rotate, ""));
                    echo json_encode("1");
                }
            } else {
                if ($data->errorCode == 1001) {
                    echo json_encode("2");
                }
            }
        } else {
            echo "Bạn không được hack";
        }
        curl_close ($ch);
    }
    function add()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $quantity = urlencode($this->input->post("quantity"));
        $version = $this->input->post("version");
        $rotate = $this->input->post("rotate");
        $source = $this->input->post("nguonxuat");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->config->item('api_url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,'c=129&sf=' . $rotate . '&gq=' . $quantity . '&gl=' . $version. '&gs='.$source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_TIMEOUT,3600);
        $server_output = curl_exec ($ch);
        $data = json_decode($server_output);
        if (isset($data->success)) {
            if ($data->success == true) {
                if ($data->errorCode == 0) {
                    $this->logadmin_model->create($this->logadmingiftcode(16, "", $admin_info->UserName, $quantity, $rotate, ""));
                    echo json_encode("1");
                }
            } else {
                if ($data->errorCode == 10003) {
                    echo json_encode("2");
                }
            }
        } else {
            echo "Bạn không được hack";
        }
        curl_close ($ch);
    }
    function giftcodekho(){
        $rotate = $this->input->post("rotate");
        $fromDate = urlencode($this->input->post("fromDate"));
        $toDate = urlencode($this->input->post("toDate"));
        $pages = $this->input->post("pages");
        $gcuse = $this->input->post("gcuse");
        $displaygc = $this->input->post("displaygc");
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=132&sf=' . $rotate . '&gs=GCG&ts=' . $fromDate . '&te=' . $toDate. '&p=' . $pages . '&ug=' . $gcuse . '&tr=' . $displaygc);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function  giftcodexuat(){
        $nickname = urlencode($this->input->post("nickname"));
        $username = urlencode($this->input->post("username"));
        $giftcode = $this->input->post("giftcode");
        $nguonxuat = $this->input->post("nguonxuat");
        $fromDate = urlencode($this->input->post("fromDate"));
        $toDate = urlencode($this->input->post("toDate"));
        $pages = $this->input->post("pages");
        $gcuse = $this->input->post("gcuse");
        $record = $this->input->post("record");
        $block = $this->input->post("block");
        $rotate = $this->input->post("rotate");
            $datainfo = file_get_contents($this->config->item('api_url') . '?c=133&nn=' . $nickname . '&gc=' . $giftcode . '&un=' . $username . '&gs=' . $nguonxuat . '&ts=' . $fromDate . '&te=' . $toDate . '&sf=' . $rotate . '&p=' . $pages . '&ug=' . $gcuse . '&tr=' . $record.'&bl='.$block);

        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    function huygiftcode(){
        $giftcode = $this->input->post("giftcode");
        $block = $this->input->post("block");
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=134&gc=' . $giftcode . '&bl=' . $block);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
}