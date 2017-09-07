<?php

Class Groupuser extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('groupuser_model');
        $this->load->model('menurole_model');
        $this->load->model('userrole_model');


    }
    /*
     * Lay danh sach admin
     */
    function index()
    {
            $input1['where']['type'] = 1;
            $list = $this->groupuser_model->get_list($input1);
            $this->data['list'] = $list;
            $input2['where']['type'] = 2;
            $listadmin = $this->groupuser_model->get_list($input2);
            $this->data['listadmin'] = $listadmin;
            $input3['where']['type'] = 3;
            $listagent = $this->groupuser_model->get_list($input3);
            $this->data['listagent'] = $listagent;

            $message = $this->session->flashdata('message');
            $this->data['message'] = $message;
            $this->data['temp'] = 'admin/groupuser/index';
            $this->load->view('admin/main', $this->data);

    }

    /*
         * Thêm mới quản trị viên
         */
    function add()
    {
            $this->load->library('form_validation');
            $this->load->helper('form');
            //neu ma co du lieu post len thi kiem tra
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'Tên nhóm người dùng', 'required');
                //nhập liệu chính xác
                if ($this->form_validation->run()) {
                    //them vao csdl
                    $name = $this->input->post('name');
                    $description = $this->input->post('description');
                    $type = $this->input->post('typegroup');
                    $data = array(
                        'name' => $name,
                        'description' => $description,
                        'type' => $type
                    );
                    if ($this->groupuser_model->create($data)) {
                        //tạo ra nội dung thông báo
                        $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Thêm nhóm người dùng thành công</label></div>');
                    } else {
                        $this->session->set_flashdata('message', 'Không thêm được');
                    }

                    redirect(base_url('groupuser'));
                }
            }
            $this->data['temp'] = 'admin/groupuser/add';
            $this->load->view('admin/main', $this->data);
    }
    function edit()
    {
            $id = $this->uri->rsegment('3');
            $id = intval($id);
            $this->load->library('form_validation');
            $this->load->helper('form');
            $info = $this->groupuser_model->get_info($id);
            if (!$info) {
                redirect(base_url('home/errorpage'));
            }
            $this->data['info'] = $info;
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'Tên nhóm', 'required');
                if ($this->form_validation->run()) {
                    $name = $this->input->post('name');
                    $description = $this->input->post('description');
                    $type = $this->input->post('typegroup');
                    $data = array(
                        'name' => $name,
                        'description' => $description,
                        'type' => $type

                    );
                    if ($this->groupuser_model->update($id, $data)) {
                        //tạo ra nội dung thông báo
                        $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Cập nhật nhóm người dùng thành công</label></div>');
                    } else {
                        $this->session->set_flashdata('message', 'Không cập nhật được');
                    }
                    //chuyen tới trang danh sách quản trị viên
                    redirect(base_url('groupuser'));
                }
            }
            $this->data['temp'] = 'admin/groupuser/edit';
            $this->load->view('admin/main', $this->data);
    }
//xóa dữ liệu nhóm người dùng
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        //lay thong tin cua quan tri vien
        $info = $this->groupuser_model->get_info($id);
        $infomenu = $this->menurole_model->get_list_group_role($id);
        $infouser = $this->userrole_model->get_list_group($id);

        if (!$info) {
            redirect(base_url('home/errorpage'));
        }
        //thuc hiện xóa
        if($infomenu != false){
            $this->session->set_flashdata('message', '<div class="form-group has-error successful"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>Bạn không được xóa vì nhóm người dùng tồn tại user và menu</label></div>');
        }elseif($infouser != false){
            $this->session->set_flashdata('message', '<div class="form-group has-error successful"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>Bạn không được xóa vì nhóm người dùng tồn tại user và menu</label></div>');
        }
        else{
        $this->groupuser_model->delete($id);
        $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Xóa nhóm người dùng thành công thành công</label></div>');
        }
        redirect(base_url('groupuser'));
    }
    function  role()
    {
        //load model
        $this->load->model('admin_model');
        $this->load->model('menu_model');
        $group_id = $this->uri->rsegment('3');
        $group_id = intval($group_id);
        $info = $this->groupuser_model->get_info($group_id);
        $this->data['info'] = $info;
        if(!$info){
            redirect(base_url('home/errorpage'));
        }
        $type_group = intval($this->uri->rsegment('4'));
        $list = $this->get_list_role($group_id,$type_group);
        if(!$list){
            redirect(base_url('home/errorpage'));
        }
        $this->data['list'] = $list;
        //lây user_id của session khi login vào
        if ($this->input->post()) {
            $where = array('Group_ID' => $group_id);
            $this->menurole_model->del_rule($where);
            //lay thong cua menu role
            $name = $_POST['rolegroup'];
            foreach ($name as $menu_item) {
                $data = array(
                    'Menu_ID' => $menu_item,
                    'Group_ID' => $group_id,
                    'Type' => $type_group

                );
                $this->menurole_model->Create($data);
            }
            $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Cập nhật quyền truy cập thành công</label></div>');
            redirect(base_url('groupuser'));
        }
        $this->data['temp'] = 'admin/groupuser/role';
        $this->load->view('admin/main', $this->data);
    }
    //danh sach menu trang index
    function get_list_role($menuid,$typemenu)
    {
        $str = "";
        $this->load->model('menu_model');
        if($typemenu == 1) {
            $roles = $this->menu_model->get_category();
            foreach ($roles as $role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $role->id);
                $str .= "<ul style='list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  checked value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role($menuid, $role->id);
                    $str .= "</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role($menuid, $role->id);
                    $str .= "</li>";
                }
                $str .= "</ul>";
            }
        }elseif($typemenu ==2){
            $roles = $this->menu_model->get_menu_admin();
            foreach ($roles as $role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $role->id);
                $str .= "<ul style='list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  checked value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role_admin($menuid, $role->id);
                    $str .= "</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role_admin($menuid, $role->id);
                    $str .= "</li>";
                }
                $str .= "</ul>";
            }
        }elseif($typemenu == 3){
            $roles = $this->menu_model->get_menu_agent();
            foreach ($roles as $role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $role->id);
                $str .= "<ul style='list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  checked value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role_agent($menuid, $role->id);
                    $str .= "</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\"  value='$role->id' > $role->Name";
                    $str .= $this->get_sub_list_role_agent($menuid, $role->id);
                    $str .= "</li>";
                }
                $str .= "</ul>";
            }
        }
        return $str;
    }
    function get_sub_list_role($menuid, $roleid)
    {
        $str = "";
        //$sub_roles = $this->menu_model->get_list_role_group_user_sub($roleid,$menuid);
        $sub_roles = $this->menu_model->get_subcategory($roleid);
        if ($sub_roles) {
            $stt = 1;
            foreach ($sub_roles as $sub_role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $sub_role->id);
                //kiem tra get subcategory co ton ai hay

                $str .= "<ul style='margin-left: 25px;list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" checked value='$sub_role->id'>$sub_role->Name</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" value='$sub_role->id'>$sub_role->Name</li>";
                }
                $str .= "</ul>";
            }
            return $str;
        }
    }

    function get_sub_list_role_admin($menuid, $roleid)
    {
        $str = "";
        //$sub_roles = $this->menu_model->get_list_role_group_user_sub($roleid,$menuid);
        $sub_roles = $this->menu_model->get_menu_sub_admin($roleid);
        if ($sub_roles) {
            $stt = 1;
            foreach ($sub_roles as $sub_role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $sub_role->id);
                //kiem tra get subcategory co ton ai hay

                $str .= "<ul style='margin-left: 25px;list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" checked value='$sub_role->id'>$sub_role->Name</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" value='$sub_role->id'>$sub_role->Name</li>";
                }
                $str .= "</ul>";
            }
            return $str;
        }
    }
    function get_sub_list_role_agent($menuid, $roleid)
    {
        $str = "";
        //$sub_roles = $this->menu_model->get_list_role_group_user_sub($roleid,$menuid);
        $sub_roles = $this->menu_model->get_menu_sub_agent($roleid);
        if ($sub_roles) {
            $stt = 1;
            foreach ($sub_roles as $sub_role) {
                $roles1 = $this->menurole_model->get_list_role_menu($menuid, $sub_role->id);
                //kiem tra get subcategory co ton ai hay

                $str .= "<ul style='margin-left: 25px;list-style: none'>";
                if ($roles1 != null) {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" checked value='$sub_role->id'>$sub_role->Name</li>";
                } else {
                    $str .= " <li><input type='checkbox' name=\"rolegroup[]\" value='$sub_role->id'>$sub_role->Name</li>";
                }
                $str .= "</ul>";
            }
            return $str;
        }
    }
}
