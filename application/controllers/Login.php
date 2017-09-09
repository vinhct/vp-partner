<?php

Class Login extends MY_controller
{
    function index()
    {
       $this->data['errors'] = '';
        $this->data['message'] = '';
        $this->data['flag'] = '';
        $this->data['nickname'] = '';
        $this->data['vintotal'] = '';
        $this->data['temp'] = 'admin/index';
        $this->load->view('admin/login/index', $this->data);
    }

    function  loginTest(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        try {
            var_dump($this->config->item('api_url') . '?c=701&un=' . $username . '&pw=' . md5($password));
            $userinfo = file_get_contents($this->config->item('api_url') . '?c=701&un=' . $username . '&pw=' . md5($password));

            if($userinfo){
            $data = json_decode($userinfo);
            if ($data->success) {
                $info = json_decode(base64_decode($data->sessionKey));
                $nickname = $info->nickname;
                $vinTotal = $info->vinTotal;
                $vippoint = $info->vippoint;
                $vippointSave = $info->vippointSave;
                  $accessToken =  $data->accessToken;

                $message = '';
                $flag = 0;
                if ($data->errorCode == 1001) {
                    $message = 'Bạn không có quyền truy cập';
                } else if ($data->errorCode == 1005) {
                    $message = 'Tên đăng nhập không tồn tại';
                } else if ($data->errorCode == 1007) {
                    $message = 'Mật khẩu không chính xác';
                } else if ($data->errorCode == 1009) {
                    $message = 'Tài khoản bị khóa';
                } elseif ($data->errorCode == 0) {
                    $flag = 1;
                    $this->infouser($nickname, $vinTotal,$vippoint,$vippointSave,$accessToken);
                    redirect(base_url());
                }
                $this->data['vintotal'] = $vinTotal;
                $this->data['nickname'] = $nickname;
                $this->data['flag'] = $flag;
                $this->data['errors'] = $message;
            } else {
                if ($data->errorCode == 1001) {
                    $message = 'Bạn không có quyền truy cập';
                } else if ($data->errorCode == 1005) {
                    $message = 'Tên đăng nhập không tồn tại';
                } else if ($data->errorCode == 1007) {
                    $message = 'Mật khẩu không chính xác';
                } else if ($data->errorCode == 1009) {
                    $message = 'Tài khoản bị khóa';
                }
                $this->data['errors'] = $message;
                $this->data['vintotal'] = '';
                $this->data['nickname'] = '';
                $this->data['flag'] = '0';
            }
        }
            else{
                $this->data['errors'] = "Hệ thống bị gián đoạn";
                $this->data['vintotal'] = '';
                $this->data['nickname'] = '';
                $this->data['flag'] = '0';

            }
        }
        catch(Exception $e){
            echo"1001";
        }
        $this->data['temp'] = 'admin/login/index';
        $this->load->view('admin/login/index', $this->data);

    }
    
    private function _get_user_info()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        $this->load->model('admin_model');
        $where = array('UserName' => $username, 'Password' => $password);
        $user = $this->admin_model->get_info_rule($where);
        return $user;
    }
    /*
     * Kiem tra username va password co chinh xac khong
     */
    function check_login()
    {
        $user = $this->_get_user_info();
        if ($user) {
            return true;
        }
        $this->form_validation->set_message(__FUNCTION__, 'Không đăng nhập thành công');
        return false;
    }
   function infouser($nickname, $vin,$vippoint,$vippointsave,$accessToken)
    {
         $this->load->model('useragent_model');
        $where = array('nickname' => $nickname, 'active' => 1);
        $user = $this->useragent_model->get_info_rule($where);
        if ($user == false) {
            echo json_encode("Tài khoản chưa được phân quyền hoặc đang bị khóa");
        } else {

            $this->session->set_userdata("vin", $vin);
            $this->session->set_userdata("vippoint", $vippoint);
            $this->session->set_userdata("vippointsave", $vippointsave);
            $this->session->set_userdata('user_admindaily_login', $user->id);
              $this->session->set_userdata('accessToken', $accessToken);
              $this->session->set_userdata("nickname", $nickname);
        }
    }
    function log_login_admin($username,$action,$status){
        $this->load->model('admin_model');
        $this->load->model('log_loginadmin_model');
        $where = array('UserName' => $username);
        $user = $this->admin_model->get_info_rule($where);
        if($user == true){
            $username = $user->UserName;
            $nickname = $user->FullName;
        }else{
            $nickname = "";
        }
        $data = array(
            'username' =>$username,
            'nickname' => $nickname,
            'ip' => $this->get_client_ip(),
            'status'=>$status,
            'agent' => $_SERVER['HTTP_USER_AGENT'],
            'action' => $action,
            'tool' => "Super Admin"

        );
        $this->log_loginadmin_model->create($data);

    }

}