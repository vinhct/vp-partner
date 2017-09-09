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
        $input['where']['parentid'] = -1;
        $listagent = $this->useragent_model->get_list($input);
        $this->data['listagent'] = $listagent;
        $this->data['temp'] = 'admin/user/index';
        $this->load->view('admin/main', $this->data);

    }
    
    function logout()
    {
        if ($this->session->userdata('user_admindaily_login')) {
            $this->session->unset_userdata('user_admindaily_login');
        }
        redirect(base_url('login'));
    }
    function resetpw(){
        $this->data['temp'] = 'admin/user/resetpw';
        $this->load->view('admin/main', $this->data);
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
    function get_list_role_select()
    {
        $str = "";
        $input3['where']['type'] = 3;
        $grouproles = $this->groupuser_model->get_list($input3);
        foreach ($grouproles as $grouprole) {
                $str .= "<option value='$grouprole->Name:$grouprole->Id'>$grouprole->Name</option>";
        }
        return $str;
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
        $group =$this->get_list_role_select();
         $this->data['groupuser'] = $group;
        $this->data['listrole'] = $listrole;
        $this->data['temp'] = 'admin/user/add';
         $this->data['error'] = '';
         if( isset($_POST['create']) )
        {

            $info = $this->useragent_model->get_info_admin($this->input->post('username'));
            $username = urlencode($this->input->post('username'));
            $nickname = urlencode($this->input->post('nickname'));
            if($username==null || $username=='' )
            {
                $this->data["error"]="UserName không được để trống";
            }
            else if($nickname==null|| $nickname==''){
                $this->data["error"]="Nickname không được để trống";
            }
            else{
                $groupid= $this->input->post('groupuser');
                $type = explode(':', $groupid);
                if($type[0]=="Quản trị"){
                    $data = array(
                        'username' => $username,
                        'nickname' =>$nickname,
                        'status' => "A",
                        'parentid' => -1
                    );
                }
                else{
                    $data = array(
                        'username' => $username,
                        'nickname' =>$nickname,
                        'status' => "P",
                        'parentid' => -1
                    );
                }
                $data1 = array(
                    'username' => $username,
                    'account_name' =>$nickname,
                    'action' => "Thêm mới tài khoản đối tác"
                );
                if ($info != false) {
                    $this->data["error"]="Tài khoản đã tồn tại";
                  
              
                } else {
                    $optinfo = readURLAPI($this->config->item('api_url') . '?c=103&nn='.$nickname.'&st=100');
                    $obj = json_decode($optinfo);
                    if($obj->{'success'}){
                        $this->useragent_model->create($data);
                        $this->logadmin_model->create($data1);
                        //get ra id của bảng useragent
                        $id =$this->useragent_model->get_max_id();
                        //cập nhật bảng userrole
                        $data_role = array(
                        'User_ID' => $id,
                        'Group_ID' =>$type[1],
                        'Type' => "3",
                    );
                         $this->userrole_model->create($data_role);
                       $this->data["error"]="Thêm mới tài khoản thành công";
                      redirect(base_url('user'));
                    }
                    else{
                      $this->data["error"]="Tài khoản không tồn tại. Vui lòng kiểm tra lại";
                    
                    }
                }
            }
        }
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

    function delete($id,$status,$nickname)
    {
         $this->useragent_model->delete($id);
         $this->userrole_model->delete_user($id);
         if($status=="P"){
              $optinfo = readURLAPI($this->config->item('api_url') . '?c=103&nn='.$nickname.'&st=0');
         }
         $this->data["error"]="Xóa tài khoản thành công";
          redirect(base_url('user'));
    }


}