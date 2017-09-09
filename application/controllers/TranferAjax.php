<?php

Class TranferAjax extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('useragent_model');
        $this->load->model('logadmin_model');
        $this->load->helper(array("form", "url"));
        $this->load->library('upload');
    }

   function getTheVTC(){
            $fromdate = $this->input->post('fromdate');
            $todate = $this->input->post('todate');
            $tranid = $this->input->post('tranid');
            $nickname = $this->input->post('nickname');
            $price = $this->input->post('price');
            $status = $this->input->post('status');
             $page = $this->input->post('p');
            $optinfo = $this->curl->simple_get($this->config->item('api_url') . '?c=163&nn='.$nickname.'&tid='.$tranid.'&pri='. $price.'&ts='.$fromdate.'&te='. $todate.'&p='.$page.'&st='. $status);
            if ($optinfo) {
                echo $optinfo;
            } else {
                echo "1001";
            }
        }
}
