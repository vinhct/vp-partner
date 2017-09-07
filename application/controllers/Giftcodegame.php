<?php

Class Giftcodegame extends MY_Controller
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
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));
        $this->data['listversion'] = $datainfo->giftcode_version;
        $this->data['listrotate'] = $datainfo->number_quay;
        $this->data['temp'] = 'admin/giftcodegame/adminadd';
        $this->load->view('admin/main', $this->data);
    }
    function add()
    {
        $source = $this->sourcegiftcode_model->get_source_gift_code_minigame();
        $this->data['source'] = $source;
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));
        $this->data['listversion'] = $datainfo->giftcode_version;
        $this->data['listrotate'] = $datainfo->number_quay;
        $this->data['temp'] = 'admin/giftcodegame/add';
        $this->load->view('admin/main', $this->data);
    }
    function giftcodekho()
    {
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));

        $this->data['listrotate'] = $datainfo->number_quay;
        $this->data['temp'] = 'admin/giftcodegame/giftcodekho';
        $this->load->view('admin/main', $this->data);
    }
    function giftcodexuat()
    {
        $source = $this->sourcegiftcode_model->get_source_gift_code_minigame_view();
        $this->data['source'] = $source;
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));
        $this->data['listrotate'] = $datainfo->number_quay;
        $this->data['listversion'] = $datainfo->giftcode_version;
        $this->data['temp'] = 'admin/giftcodegame/giftcodexuat';
        $this->load->view('admin/main', $this->data);
    }
}