<?php

Class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('useragent_model');
        $this->load->model('logadmin_model');
        $this->load->model('sourcegiftcode_model');
        $this->load->model('admin_model');
        $this->load->model('groupuser_model');
        $this->load->model('userrole_model');
        $this->load->model('menurole_model');

    }

    function index()
    {
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $input1['where']['isSuper'] = 1;
        $list = $this->admin_model->get_list($input1);
        $this->data['list'] = $list;
        $listadmin = $this->admin_model->get_list_admin();
        $this->data['listadmin'] = $listadmin;
        $input3['where']['parentid'] = -1;
        $listagent = $this->useragent_model->get_list($input3);
        $this->data['listagent'] = $listagent;
        $this->data['temp'] = 'admin/user/index';
        $this->load->view('admin/main', $this->data);

    }
    function congtrutien()
    {    $this->load->library('mcrypt');
        $mcrypt = new MCrypt();

        $encrypted = $mcrypt->encrypt("Text to encrypt");

        $decrypted = $mcrypt->decrypt($encrypted);
        var_dump($encrypted);
        $this->data['temp'] = 'admin/user/congtrutien';
        $this->load->view('admin/main', $this->data);
    }
    function congtienajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $otpselectcong = $this->input->post("otpselectcong");
        $tienchuyen = $this->input->post("tienchuyen");
        $money_type = $this->input->post("money_type");
        $reasonchuyen = $this->input->post("reasonchuyen");
        $maotpcong = $this->input->post("maotpcong");
        $nickname = $this->input->post("nickname");
        $action = $this->input->post("actionname");
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=100&nn=' . $nickname . '&mn=' . $tienchuyen .'&mt=' . $money_type. '&rs=' . urlencode($reasonchuyen). '&otp=' . $maotpcong . '&type=' . $otpselectcong.'&ac='.$action);
        $data = json_decode($datainfo);
        if (isset($data->success)) {
            if ($data->success == true) {
                if ($data->errorCode == 0) {
                    echo json_encode("1");
                    if($action == "Admin")
                    $this->logadmin_model->create($this->logadmingiftcode(12, $nickname, $admin_info->UserName,"",$tienchuyen,$money_type));
                    elseif($action == "EventVP"){
                        $this->logadmin_model->create($this->logadmingiftcode(19, $nickname, $admin_info->UserName,"",$tienchuyen,$money_type));
                    }
                }
            } else {
                if ($data->errorCode == 1001) {
                    echo json_encode("2");
                }elseif($data->errorCode == 1002) {
                    echo json_encode("3");
                }elseif($data->errorCode == 1008) {
                    echo json_encode("4");
                }elseif($data->errorCode == 1021) {
                    echo json_encode("5");
                }elseif($data->errorCode == 2001) {
                    echo json_encode("6");
                }
            }
        }else{
            echo "Bạn không được hack";
        }
    }
    function trutienajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $otpselecttru = $this->input->post("otpselecttru");
        $tienchuyen = $this->input->post("tienchuyen");
        $money_type = $this->input->post("money_type");
        $reasonchuyen = $this->input->post("reasonchuyen");
        $maotptru = $this->input->post("maotptru");
        $nickname = $this->input->post("nickname");
        $action = $this->input->post("actionname");
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=100&nn=' . $nickname . '&mn=' . $tienchuyen .'&mt=' . $money_type. '&rs=' . urlencode($reasonchuyen) . '&otp=' . $maotptru . '&type=' . $otpselecttru."&ac=".$action);
        $data = json_decode($datainfo);
        if (isset($data->success)) {
            if ($data->success == true) {
                if ($data->errorCode == 0) {
                    echo json_encode("1");
                    if($action == "Admin")
                        $this->logadmin_model->create($this->logadmingiftcode(12, $nickname, $admin_info->UserName,"",$tienchuyen,$money_type));
                    elseif($action == "EventVP"){
                        $this->logadmin_model->create($this->logadmingiftcode(19, $nickname, $admin_info->UserName,"",$tienchuyen,$money_type));
                    }
                }
            } else {
                if ($data->errorCode == 1001) {
                    echo json_encode("2");
                }elseif($data->errorCode == 1002) {
                    echo json_encode("3");
                }elseif($data->errorCode == 1008) {
                    echo json_encode("4");
                }elseif($data->errorCode == 1021) {
                    echo json_encode("5");
                }elseif($data->errorCode == 2001) {
                    echo json_encode("6");
                }
            }
        }else{
            echo "Bạn không được hack";
        }
    }

    function getnicknameajax(){
        $nickname = urlencode($this->input->post("nickname"));
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=716&nn=' . $nickname);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    /*
     * Ham chinh sua thong tin quan tri vien
     */


    function logout()
    {
        if ($this->session->userdata('user_AdminIxengClub_login')) {
            $this->session->unset_userdata('user_AdminIxengClub_login');
        }
        redirect(base_url('login'));
    }
    function resetpw(){
        $this->data['temp'] = 'admin/user/resetpw';
        $this->load->view('admin/main', $this->data);
    }
    function resetpwajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $nickname = urlencode($this->input->post("nickname"));
        $type = $this->input->post("type");
        $otp = urlencode($this->input->post("otp"));
        $datainfo = file_get_contents($this->config->item('api_url').'?c=14&nn='.$nickname.'&otp='.$otp.'&type='.$type);
        if(isset($datainfo)) {
            if($datainfo == 0){
                $data = array(
                    'account_name' => $nickname,
                    'username' => $admin_info->UserName,
                    'action' => "Reset password"
                );
                $this->logadmin_model->create($data);
            }
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    function updatevpevent(){
        $this->data['temp'] = 'admin/user/updatevpevent';
        $this->load->view('admin/main', $this->data);
    }
    function updatevpajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $nickname = urlencode($this->input->post("nickname"));
        $type = $this->input->post("type");
        $value = urlencode($this->input->post("value"));
        $otp = urlencode($this->input->post("otp"));
        $typeotp = $this->input->post("typeotp");
        $datainfo = file_get_contents($this->config->item('api_url').'?c=726&nn='.$nickname.'&tu='.$type.'&va='.$value.'&otp='.$otp.'&type='.$typeotp);
        if(isset($datainfo)) {
            if($datainfo == 0){
                if($type == 0){
                    $data = array(
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName,
                        'action' => "Trừ vippoint event",
                        'money' => -$value
                    );
                }else{
                    $data = array(
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName,
                        'action' => "Cộng vippoint event",
                        'money' => $value
                    );
                }

                $this->logadmin_model->create($data);
            }
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function refundbonus(){
        $this->data['temp'] = 'admin/agent/index';
        $this->load->view('admin/main', $this->data);
    }

    function refundajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $otp = urlencode($this->input->post("otp"));
        $type = $this->input->post("type");
        $datainfo = file_get_contents($this->config->item('api_url').'?c=711&otp='.$otp.'&type='.$type);
        if(isset($datainfo)) {
            if($datainfo == 0){
            $data = array(
                'username' => $admin_info->UserName,
                'action' => "Hoàn trả phí đại lý"
            );
            $this->logadmin_model->create($data);}
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    function bonusajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $otp = urlencode($this->input->post("otp"));
        $type = $this->input->post("type");
        $datainfo = file_get_contents($this->config->item('api_url').'?c=724&otp='.$otp.'&type='.$type);
        if(isset($datainfo)) {
            if($datainfo == 0){
                $data = array(
                    'username' => $admin_info->UserName,
                    'action' => "Trả thưởng top doanh số đại lý"
                );
                $this->logadmin_model->create($data);}
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function reportgc(){
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));
        $this->data['listvin'] = $datainfo->giftcode_vin;
        $this->data['listxu'] = $datainfo->giftcode_xu;
        $source = $this->sourcegiftcode_model->get_source_gift_code_marketing_view();
        $this->data['source'] = $source;
        $sourcevh = $this->sourcegiftcode_model->get_source_gift_code_vanhanh_view();
        $this->data['sourcevh'] = $sourcevh;
        $list = $this->useragent_model->get_admin_gift_code();
        $this->data['list'] = $list;
        $this->data['temp'] = 'admin/user/reportgc';
        $this->load->view('admin/main', $this->data);
    }

    function reportgcajax()
    {
        $roomvin = $this->input->post("roomvin");
        $roomxu = $this->input->post("roomxu");
        $nguonxuat = $this->input->post("nguonxuat");
        $fromDate = urlencode($this->input->post("fromDate"));
        $toDate = urlencode($this->input->post("toDate"));
        $money = $this->input->post("money");
        $filterdate = $this->input->post("filterdate");
        $block = $this->input->post("block");
        if($money == 1){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomvin.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=&tt='.$filterdate.'&bl='.$block);
        }
        elseif($money == 0){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomxu.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=&tt='.$filterdate.'&bl='.$block);
        }
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

        function reportgcmktajax(){
            $roomvin = $this->input->post("roomvin");
            $roomxu = $this->input->post("roomxu");
            $nguonxuat = $this->input->post("nguonxuat");
            $fromDate = urlencode($this->input->post("fromDate"));
            $toDate = urlencode($this->input->post("toDate"));
            $money = $this->input->post("money");
            $filterdate = $this->input->post("filterdate");
            $block = $this->input->post("block");
            if($money == 1){
                $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomvin.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=2&tt='.$filterdate.'&bl='.$block);
            }
            elseif($money == 0){
                $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomxu.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=2&tt='.$filterdate.'&bl='.$block);
            }
            if(isset($datainfo)) {
                echo $datainfo;
            }else{
                echo "Bạn không được hack";
            }
        }

    function reportgcvhajax(){
        $roomvin = $this->input->post("roomvin");
        $roomxu = $this->input->post("roomxu");
        $nguonxuat = $this->input->post("nguonxuat");
        $fromDate = urlencode($this->input->post("fromDate"));
        $toDate = urlencode($this->input->post("toDate"));
        $money = $this->input->post("money");
        $filterdate = $this->input->post("filterdate");
        $block = $this->input->post("block");
        if($money == 1){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomvin.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=3&tt='.$filterdate.'&bl='.$block);
        }
        elseif($money == 0){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomxu.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=3&tt='.$filterdate.'&bl='.$block);
        }
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }
    function reportgcdlajax(){
        $roomvin = $this->input->post("roomvin");
        $roomxu = $this->input->post("roomxu");
        $nguonxuat = $this->input->post("nguonxuat");
        $fromDate = urlencode($this->input->post("fromDate"));
        $toDate = urlencode($this->input->post("toDate"));
        $money = $this->input->post("money");
        $filterdate = $this->input->post("filterdate");

        if($money == 1){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomvin.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=1&tt='.$filterdate.'&bl=');
        }
        elseif($money == 0){
            $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=304&gp='.$roomxu.'&ts=' . $fromDate . '&te=' . $toDate . '&mt=' . $money .'&gs=' .$nguonxuat .'&type=1&tt='.$filterdate.'&bl=');
        }
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function edit()
    {
        //lay id cua quan tri vien can chinh sua
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $type = $this->uri->rsegment('4');
        $type = intval($type);
        $this->data['type'] = $type;
        $this->load->library('form_validation');
        $this->load->helper('form');
        //lay thong cua quan trị viên
        $info = $this->admin_model->get_info($id);
        if (!$info) {
            redirect(base_url('home/errorpage'));
        }
        $this->data['info'] = $info;
        if ($this->input->post()) {
            $status = $this->input->post('typechucnang');
            $active = $this->input->post('typeaccount');
            if($active == 1){
                $data = array(
                    'Status' => $status,
                    'isSuper' => $active,
                    'isThuong' => 2
                );
            }elseif($active == 2){
                $data = array(
                    'Status' => $status,
                    'isThuong' => 2
                );
            }

            if ($this->admin_model->update($id, $data)) {
                //tạo ra nội dung thông báo
                $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Cập nhật người dùng thành công</label></div>');
            } else {
                $this->session->set_flashdata('message', 'Không cập nhật được');
            }
            //chuyen tới trang danh sách quản trị viên
            redirect(base_url('user'));

        }

        $this->data['temp'] = 'admin/user/edit';
        $this->load->view('admin/main', $this->data);
    }


    function role()
    {
        $id = $this->uri->rsegment('3');

        $type = $this->uri->rsegment('4');
        //$user_id = intval($id);
        $this->load->library('form_validation');
        $this->load->helper('form');
        if($type == 3){
            $info = $this->useragent_model->get_info($id);
        }else{
            $info = $this->admin_model->get_info($id);
        }

        $this->data['info'] = $info;
        if(!$info){
            redirect(base_url('home/errorpage'));
        }
        $list = $this->get_list_role($id,$type);
        $this->data['list'] = $list;
        if(!$list){
            redirect(base_url('home/errorpage'));
        }
        if ($this->input->post()) {

            $this->load->model('userrole_model');
            $where = array('User_ID' => $id,'Type'=>$type);
            $this->userrole_model->del_rule($where);
            $name = $_POST['chbpr'];
            if (isset($_POST['chbpr'])) {
                foreach ($name as $value) {
                    $data = array(
                        'User_ID' => $id,
                        'Group_ID' => $value,
                        'Type' => $type
                    );
                }
                if ($this->userrole_model->create($data)) {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Cập nhật quyền người dùng thành công</label></div>');
                } else {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(base_url('user'));
            }

        }
        $this->data['temp'] = 'admin/user/role';
        $this->load->view('admin/main', $this->data);
    }

    function get_list_role($id,$type)
    {
        $str = "";
        if($type == 1){
            $input1['where']['type'] = 1;
            $grouproles = $this->groupuser_model->get_list($input1);
        }elseif($type == 2){
            $input2['where']['type'] = 2;
            $grouproles = $this->groupuser_model->get_list($input2);
        }elseif($type == 3){
            $input3['where']['type'] = 3;
            $grouproles = $this->groupuser_model->get_list($input3);
        }

        foreach ($grouproles as $grouprole) {
            $roles = $this->userrole_model->get_list_role_user($id, $grouprole->Id);
            if ($roles != null) {

                $str .= "<ul style='list-style: none'>";
                $str .= " <li><input type='radio' id='chbprcheked'  checked value='$grouprole->Id' name='chbpr[]'> $grouprole->Name</span>";
                $str .= "</li></ul>";
            } else {

                $str .= "<ul style='list-style: none'>";
                $str .= " <li><input type='radio' id='chbprno'  value='$grouprole->Id' name='chbpr[]'> $grouprole->Name</span>";
                $str .= "</li></ul>";
            }

        }

        return $str;
    }
    function add()
    {
        $listrole = $this->groupuser_model->get_list();
        $this->data['listrole'] = $listrole;
        $this->data['temp'] = 'admin/user/add';
        $this->load->view('admin/main', $this->data);
    }
    function getinfoajax(){
        $nickname = urlencode($this->input->post('nickname'));
        $nicknameadmin  = $this->session->userdata('nicknameadmin');
        $access  = $this->session->userdata('accessadmin');
        $options = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Authorization:".base64_encode($access.'|'.$nicknameadmin.'|'.'fU3z7wP0IeFOPntKXcRifUDTGbV8AXyI')
            )
        );
        $context = stream_context_create($options);

        $datainfo = file_get_contents($this->config->item('api_url').'?c=102&nn='.$nickname,false, $context);
        if(isset($datainfo)) {
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function addadmin()
    {
        $info = $this->admin_model->get_info_admin($this->input->post('username'));
        if ($info != false) {
            echo json_encode("1");
            die();
        } else {
            echo json_encode("2");
        }
    }

    function getagent()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $info = $this->useragent_model->get_info_admin($this->input->post('username'));
          $username = urlencode($this->input->post('username'));
        $nickname = urlencode($this->input->post('nickname'));
        $data = array(
            'username' => $username,
            'nickname' =>$nickname,
            'status' => "A",
            'parentid' => -1
        );
        $data1 = array(
            'username' => $admin_info->UserName,
            'account_name' =>$nickname,
            'action' => "Thêm mới tài khoản admin đại lý"
        );
        if ($info != false) {
            echo json_encode("1");
            die();
        } else {
            $this->useragent_model->create($data);
            $this->logadmin_model->create($data1);
            $this->session->set_flashdata('message','<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i>Bạn thêm người dùng thành công</label></div>');
            echo json_encode("2");
        }
    }


    function addadminajax(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $username = urlencode($this->input->post('username'));
        $nickname = urlencode($this->input->post('nickname'));
        $status = urlencode($this->input->post('status'));
        $data = array(
            'UserName' => $username,
            'FullName' =>$nickname,
            'Status' => $status,
            'isThuong'=> 2
        );
        $data1 = array(
            'username' => $admin_info->UserName,
            'account_name' =>$nickname,
            'action' => "Thêm mới tài khoản admin"
        );


        $datainfo = file_get_contents($this->config->item('api_url').'?c=103&nn='.$nickname.'&st=100');
        if(isset($datainfo)) {
                if($datainfo == 0){
                    $this->admin_model->create($data);
                    if ($this->input->post('role') != null) {
                        $where = array('FullName' =>  $this->input->post('nickname'));
                        $user = $this->admin_model->get_info_rule($where);
                        $data2 = array(
                            'User_ID' => $user->ID,
                            'Group_ID' => $this->input->post('role'),
                            'Type' => 2
                        );
                        $this->userrole_model->create($data2);
                    }
                    $this->logadmin_model->create($data1);

                    $this->session->set_flashdata('message','<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i>Bạn thêm người dùng thành công</label></div>');
                }

            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }

    }

    function delgiftcode()
    {
        $datainfo = json_decode(file_get_contents($this->config->item('api') . '?c=10'));

        $this->data['listvin'] = $datainfo->giftcode_vin;
        $source = $this->sourcegiftcode_model->get_source_gift_code_marketing_view();
        $this->data['source'] = $source;
        $sourcevh = $this->sourcegiftcode_model->get_source_gift_code_vanhanh_view();
        $this->data['sourcevh'] = $sourcevh;
        $this->data['temp'] = 'admin/user/delgiftcode';
        $this->load->view('admin/main', $this->data);
    }

    function delgiftcodeajax()
    {    $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $fromdate = urlencode($this->input->post("fromdate"));
        $todate = urlencode($this->input->post("todate"));
        $source = urlencode($this->input->post("nguonxuat"));
        $price = urlencode($this->input->post("roomvin"));

        $datainfo = $this->get_data_curl($this->config->item('api_url').'?c=604&gp='.$price.'&ts=' . $fromdate . '&te=' . $todate .'&gs=' .$source);
        $data = json_decode($datainfo);
        $num = $data->transactions->countGiftCode;
        if(isset($datainfo)) {
           if( $num > 0){
                if($source == "" && $price == ""){
                    $action = "Thu hồi giftcode được tạo từ ngày ".$this->input->post("fromdate")." đến ngày ".$this->input->post("todate")." số lượng: ".$num;
                }else if($source == "" && $price != ""){
                    $action = "Thu hồi giftcode được tạo từ ngày ".$this->input->post("fromdate")." đến ngày ".$this->input->post("todate")." số lượng: ".$num." mệnh giá ".$price." K Vin";
                }
                else if($source != "" && $price == ""){
                    $action = "Thu hồi giftcode được tạo từ ngày ".$this->input->post("fromdate")." đến ngày ".$this->input->post("todate")." số lượng: ".$num." mã ".$source;
                }
                else if($source != "" && $price != ""){
                    $action = "Thu hồi giftcode được tạo từ ngày ".$this->input->post("fromdate")." đến ngày ".$this->input->post("todate")." số lượng: ".$num." mệnh giá ".$price." K Vin , mã ".$source;
                }
               $data = array(
                   'username' => $admin_info->UserName,
                   'account_name' =>$admin_info->FullName,
                   'action' => $action
               );
               $this->logadmin_model->create($data);
           }
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

    function congtientaixiu()
    {
        $this->data['error'] = "";
        if ($this->input->post("ok")) {

            if (file_exists('public/admin/uploads/congtientaixiu.csv')) {
                unlink('public/admin/uploads/congtientaixiu.csv');
                $this->data['error'] = "Bạn xóa file cũ thành công";
            } else {
                $temp = explode(".", $_FILES["filexls"]["name"]);
                $extension = end($temp);
                if ($extension == "csv") {
                    $config = array("");
                    $config['upload_path'] = './public/admin/uploads';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = 1024 * 8;
                    $config['overwrite'] = TRUE;
                    $config['file_name'] = 'congtientaixiu';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('filexls')) {
                        $error = array('error' => $this->upload->display_errors());
                        $this->data['error'] = "Bạn chưa chọn file hoặc không được phân quyền";

                    } else {
                        $this->data['error'] = "";
                        $data = array('upload_data' => $this->upload->data());

                        $this->data['error'] = "Upload file thành công";
                    }
                } else {
                    $this->data['error'] = "Bạn chưa chọn file hoặc không chọn đúng file csv";
                }
            }

        }
        if (file_exists(FCPATH . "public/admin/uploads/congtientaixiu.csv") != false) {
            $this->load->library('csvreader');
            $result = $this->csvreader->parse_file(public_url('admin/uploads/congtientaixiu.csv'));
            $data = array();
            foreach ($result as $row) {
                if (isset($row["Nickname"]) && isset($row["Money"])) {
                    array_push($data,array($row["Nickname"]=> intval($row["Money"])));
                }
            }
            $this->data['listnn'] = json_encode($data);

        } else {
            $this->data['listnn'] = "";
        }
        $this->data['temp'] = 'admin/user/congtientaixiu';
        $this->load->view('admin/main', $this->data);
    }

    function congtientaixiuajax()
    {
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $nickname = $this->input->post("nickname");
        $lydo = urlencode($this->input->post("lydo"));
        $money = urlencode($this->input->post("money"));
        $otp = urlencode($this->input->post("otp"));
        $typeotp = $this->input->post("typeotp");
        $action = $this->input->post("action");
//        $server_output = file_get_contents($this->config->item('api_url')."?c=17&data=".$nickname."&mt=".$money."&rs=".$lydo."&otp=".$otp."&type=".$typeotp);
//        var_dump($server_output);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$this->config->item('api_url'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"c=17&data=".$nickname."&mt=".$money."&rs=".$lydo."&otp=".$otp."&type=".$typeotp."&ac=".$action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_TIMEOUT,3600);

        $server_output = curl_exec ($ch);

        $data = json_decode($server_output);

        if(isset($server_output)) {

            if ($data->errorCode == 0) {
                if($action == "Admin"){
                    $this->logadmin_model->create($this->logadmingiftcode(20, $nickname, $admin_info->UserName,"",0,$money));
                }elseif($action == "EventVP"){
                    $this->logadmin_model->create($this->logadmingiftcode(19, $nickname, $admin_info->UserName,"",0,$money));
                }


                if (file_exists('public/admin/uploads/congtientaixiu.csv')) {

                    unlink('public/admin/uploads/congtientaixiu.csv');
                }
            }
            echo $server_output;
        }else{
            echo "Bạn không được hack";
        }
       curl_close ($ch);

    }


    function delsecuser()
    {
        $this->data['temp'] = 'admin/user/delsecuser';
        $this->load->view('admin/main', $this->data);
    }
    function  huybaomat(){
        $admin_login = $this->session->userdata('user_AdminIxengClub_login');
        $admin_info = $this->admin_model->get_info($admin_login);
        $nickname = $this->input->post('nickname');
        $ac = $this->input->post('ac');
        $type = $this->input->post('type');
        $otp = $this->input->post('otp');
        $action = $this->input->post('action');
        $datainfo = file_get_contents($this->config->item('api_url') . '?c=22&nn=' . urlencode($nickname) . '&otp=' . $otp . '&type=' . $type.'&ac='.$ac.'&tu='.$action);
        $data = json_decode($datainfo);
        if(isset($datainfo)) {

            if ($data->errorCode == 0) {
                if($ac == 4 && $action == 0){
                    $data = array(
                        'action' => "Hủy bảo mật điện thoại",
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName
                    );

                }elseif($ac == 5 && $action == 0){
                    $data = array(
                        'action' => "Hủy bảo mật email",
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName
                    );

                }elseif($ac == 5 && $action == 1){
                    $data = array(
                        'action' => "Đăng ký bảo mật email",
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName
                    );

                }elseif($ac == 4 && $action == 1){
                    $data = array(
                        'action' => "Đăng ký bảo mật điện thoại",
                        'account_name' => $nickname,
                        'username' => $admin_info->UserName
                    );

                }
                $this->logadmin_model->create($data);
            }
            echo $datainfo;
        }else{
            echo "Bạn không được hack";
        }
    }

}