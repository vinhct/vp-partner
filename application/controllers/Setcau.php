<?php
Class Setcau extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('logadmin_model');
        $this->load->library('mcrypt');



    }

    function index()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $strStart = date('2017-04-04 10:41:00');
        $strEnd = date('2017-04-05 11:59:00');
        $str =  date('Y-m-d H:i:s');
        $mcrypt = new MCrypt();
        $this->load->helper("url");
        // you can change the location of your file wherever you want
        $list = file('public/admin/taixiu.dat');
        $list = array_filter($list);
//        if($str <= $strEnd && $str >= $strStart){
//            $file = 'public/admin/taixiu.dat';
//            $MyFile = file('public/admin/abcs.txt');
//            $MyFile = array_filter($MyFile);
//            foreach ($MyFile as $value) {
//                file_put_contents($file, $mcrypt->encrypt(trim($value))."\n", FILE_APPEND);
//            }
//
//
//        }
        krsort($list);
        $counttai = 0;
        foreach ($list as $li) {
            $li = $mcrypt->decrypt(trim($li));

            $counttai += substr_count($li, 1);
        }

        $this->data['counttai'] = $counttai;
        $countxiu = 0;
        foreach ($list as $li) {
            $li = $mcrypt->decrypt(trim($li));
            $countxiu += substr_count($li, 0);
        }
        $this->data['countxiu'] = $countxiu;
        $this->data['total_rows'] = count(array_filter($list));
        $this->data['list'] = $list;
        $this->data['mcrypt'] = $mcrypt;
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['temp'] = 'admin/setcau/index';
        $this->load->view('admin/main', $this->data);
    }

    function setcauedit()
    {
        $mcrypt = new MCrypt();
        $id = $this->uri->rsegment('3');
        $this->load->helper("url");
        // you can change the location of your file wherever you want
        $list = file('public/admin/taixiu.dat');

        $this->data['mcrypt'] = $mcrypt;
        $this->data['list'] = $list[$id];
        $this->data['key'] = $id;
        //   $this->data['temp'] = 'admin/logminigame/setcau';
        $this->load->view('admin/setcau/setcauedit', $this->data);
    }

    function setcauadd()
    {
        $this->load->view('admin/setcau/setcauadd', $this->data);
    }

    function getcauadd()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $code = $this->input->post('code');

        if ($code == null) {
            echo "Bạn chưa nhập cầu tài xỉu";
            die();
        } else {
            $mcrypt = new MCrypt();
            $encrypted = $mcrypt->encrypt($code);
            $MyFile = file('public/admin/taixiu.dat');
            foreach ($MyFile as $item) {
                $item = (preg_replace("/\r|\n/", "", $item));
                if ($encrypted == $item) {
                    echo "Bạn nhập trùng cầu tài xỉu rồi";
                    die();
                }
            }
        }
        file_put_contents('public/admin/taixiu.dat', $encrypted . "\n", FILE_APPEND);
        $data = array(
            'action' => " Thêm cầu tài xỉu",
            'username' => $admin_info->UserName
        );
        $this->logadmin_model->create($data);
        $this->session->set_flashdata('message', ' <div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Bạn thêm cầu tài xỉu thành công</label></div>');
        echo "Bạn thêm cầu tài xỉu thành công";
    }

    function getcauedit()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $mcrypt = new MCrypt();
        $code = $this->input->post('code');
        $encrypted = $mcrypt->encrypt($code);
        $key = $this->input->post('key');
        $MyFile = file('public/admin/taixiu.dat');
        foreach ($MyFile as $item) {

            $item = (preg_replace("/\r|\n/", "", $item));
            if ($encrypted == $item) {
                echo "Bạn nhập trùng cầu tài xỉu rồi";
                die();
            }
        }
        if ($MyFile[$key] != "") {
            $arr2 = array($key => $encrypted . "\n");
            $abc = array_replace_recursive($MyFile, $arr2);
            file_put_contents('public/admin/taixiu.dat', $abc);
            $data = array(
                'action' => " Sửa cầu tài xỉu",
                'username' => $admin_info->UserName
            );
            $this->logadmin_model->create($data);
            $this->session->set_flashdata('message', ' <div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Bạn sửa cầu tài xỉu thành công</label></div>');
            echo "Bạn sửa cầu tài xỉu thành công";
        }
    }

    function delete()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $id = $this->uri->rsegment('3');
        $MyFile = file('public/admin/taixiu.dat');
        $arr2 = array($id => "");
        $abc = array_replace_recursive($MyFile, $arr2);
        file_put_contents('public/admin/taixiu.dat', $abc);
        $data = array(
            'action' => " Xóa cầu tài xỉu",
            'username' => $admin_info->UserName
        );
        $this->logadmin_model->create($data);
        $this->session->set_flashdata('message', ' <div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Bạn xóa cầu tài xỉu thành công</label></div>');
        redirect(base_url('setcau'));

    }
}
