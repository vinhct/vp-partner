<?php

Class MY_Controller extends CI_Controller
{
    //bien gui du lieu sang ben view
    public $data = array();

    function __construct()
    {
        //ke thua tu CI_Controller
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $controller = $this->uri->segment(1);


        switch ($controller) {
            case 'admin' : {
                $this->load->helper('language');
                $this->lang->load('admin/common');
//                $admin_login = $this->session->userdata('user_admindaily_login');
//                $this->data['login'] = $admin_login;
                $this->load->helper('admin');
                $this->_check_login();
                break;
            }

            default: {
                $this->load->helper('language');
                $this->lang->load('admin/common');
                $this->load->model('useragent_model');
                $this->load->model('userrole_model');
                $this->load->model('menurole_model');
                $this->load->model('menu_model');
                $linkapi = $this->config->item("api_url");
                $this->data['linkapi'] = $linkapi;
                $daily = $this->config->item("daily");
                $this->data['daily'] = $daily;
                $fee1 = $this->config->item("fee1");
                $fee2 = $this->config->item("fee2");
                $this->data['fee1'] = $fee1;
                $this->data['fee2'] = $fee2;
                $vin = $this->session->userdata('vin');
                $this->data['vin'] = $vin;
                $vippoint = $this->session->userdata('vippoint');
                $this->data['vippoint'] = $vippoint;
                $vippointsave = $this->session->userdata('vippointsave');
                $this->data['vippointsave'] = $vippointsave;
                $admin_login = $this->session->userdata('user_admindaily_login');
                $this->data['login'] = $admin_login;
                if ($admin_login) {
                    $admin_info = $this->useragent_model->get_info($admin_login);
                    $this->data['admin_info'] = $admin_info;
                    $userid = $admin_info->id;
                    $link1 = $this->uri->rsegment('1');
                    $link2 = $this->uri->rsegment('2');
                    if ($link2 != "index") {
                        if ($this->menu_model->get_menu_id($link1 . '/' . $link2)) {
                            $menu_id = $this->menu_model->get_menu_id($link1 . '/' . $link2);
                            $this->data['role'] = $this->get_role_user($admin_login, $menu_id[0]->id);
                        } else {
                            $this->data['role'] = false;
                        }
                    } else if ($link2 == "index") {
                        if ($this->menu_model->get_menu_id($link1)) {
                            $menu_id = $this->menu_model->get_menu_id($link1);
                            $this->data['role'] = $this->get_role_user($admin_login, $menu_id[0]->id);
                        } else {

                            $this->data['role'] = false;
                        }
                    }
                    $list = $this->GetMenuLeftByUser($userid);
                    $this->data['menu_list'] = $list;
                }
                $this->load->helper('admin');
                $this->_check_login();
            }
        }
    }

    function GetMenuLeftByUser($user_id)
    {
        $str = "";
        //lấy group_id theo userid
        $list_group_id = $this->userrole_model->get_list_role_by_userid($user_id);
        if (!empty($list_group_id)) {
            foreach ($list_group_id as $group_id_item) {
                //lấy danh sách các menu_id theo group id
                $list_menu = $this->menurole_model->get_list_menu_id_by_group($group_id_item->Group_ID);
                if (!empty($list_menu)) {
                    //lấy ra tên menu theo menu id
                    foreach ($list_menu as $menu_item) {
                        $list_name = $this->menu_model->get_list_menu_name_by_menu_id($menu_item->Menu_ID);
                        if (!empty($list_name)) {
                            foreach ($list_name as $menu_name_item) {
                                $list_menu_child = $this->menu_model->get_list_menu_name_by_parrent_id($menu_item->Menu_ID, $group_id_item->Group_ID);
                                $str .= "<li>";
                                $str .= "<a href=" . base_url($menu_name_item->Link) . "><i class=\"fa fa-dashboard\"></i><span>" . $menu_name_item->Name . "</span></a>";
                                if (!empty($list_menu_child)) {
                                    $str .= "<ul class=\"treeview-menu\">";
                                    foreach ($list_menu_child as $menu_child) {
                                        $str .= "<li><a href=" . base_url($menu_child->Link) . "><i class=\"fa fa-circle-o\"></i>$menu_child->Name</a></li>";
                                    }
                                    $str .= "</ul>";
                                }
                                $str .= " </li>";

                            }
                        }
                    }
                }
            }
        }
        return $str;
    }

    /*
     * Kiem tra trang thai dang nhap cua admin
     */
    private function _check_login()
    {
        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);

        $login = $this->session->userdata('user_admindaily_login');
        //neu ma chua dang nhap,ma truy cap 1 controller khac login
        if (!$login && $controller != 'login') {
            redirect(base_url('login'));
        }
        //neu ma admin da dang nhap thi khong cho phep vao trang login nua.
        if ($login && $controller == 'login') {
            redirect(base_url(''));
        }
    }

    function get_role_user($user_id, $menu_id)
    {
        $this->load->model('userrole_model');
        $role = $this->userrole_model->get_list_role_menu($user_id, $menu_id);
        return $role;
    }

    function Check_Url_Admin($current_url)
    {
        $this->load->model('accesslink_model');
        //lấy id của user đăng nhập
        $admin_login = $this->session->userdata('user_id_login');
        //lấy tất cả các link của user đó
        $list_link = $this->accesslink_model->get_list_linkacess_userid($admin_login);

        //lấy url hiện tại
        $stack = array();
        foreach ($list_link as $item) {
            array_push($stack, $item->Link);
        }
        if (in_array($current_url, $stack)) {
            return true;
        } else {
            return false;
        }
    }

    function create_slug($str)
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    public function init_pagination($base_url, $total_rows, $per_page = 100, $segment)
    {
        $ci =& get_instance();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config["uri_segment"] = $segment;
        $config['next_link'] = 'Trang kế tiếp';
        $config['prev_link'] = 'Trang trước';
        $ci->pagination->initialize($config);
        return $config;
    }

    function dateDiff($start, $end)
    {
        date_default_timezone_set('Asia/Bangkok');
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }


    function rand_string($length)
    {
        $str = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    function logadmindata($ac, $nn, $us)
    {
        $data = array('action' => $this->actionadmin($ac),
            'account_name' => $nn,
            'username' => $us);
        return $data;
    }

    function logadmingiftcode($ac, $nn, $us, $q, $mo, $ty)
    {
        $data = array(
            'action' => $this->actionadmin($ac),
            'account_name' => $nn,
            'username' => $us,
            'quantity' => $q,
            'money' => $mo,
            'money_type' => $ty
        );
        return $data;
    }

    function actionadmin($count)
    {
        switch ($count) {
            case 1:
                $strresult = "Thêm mới tài khoản đại lý";
                break;
            case 2:
                $strresult = "Sửa thông tin tài khoản đại lý";
                break;
            case 3:
                $strresult = "Xóa tài khoản đại lý";
                break;
            case 4:
                $strresult = "Đổi mật khẩu tài khoản đại lý";
                break;
            case 5:
                $strresult = "Đổi mật khẩu admin đại lý";
                break;
            case 6:
                $strresult = "Tạo kho gift code";
                break;
            case 7:
                $strresult = "Chuyển giftcode cho đại lý";
                break;
            case 8:
                $strresult = "Thêm cầu tài xỉu";
                break;
            case 9:
                $strresult = "Sửa cầu tài xỉu";
                break;
            case 10:
                $strresult = "Xóa cầu tài xỉu";
                break;
            case 11:
                $strresult = "Đại lý xuất giftcode";
                break;
            case 12:
                $strresult = "Làm lại đại lý";
                break;
        }
        return $strresult;
    }

    function  checkRoleMenu()
    {
        $admin_login = $this->session->userdata('user_admindaily_login');
        if ($admin_login) {
            $link1 = $this->uri->rsegment('1');
            $link2 = $this->uri->rsegment('2');
            if ($link2 != "index") {
                if ($this->menu_model->get_menu_id($link1 . '/' . $link2)) {
                    $menu_id = $this->menu_model->get_menu_id($link1 . '/' . $link2);
                    $result = $this->get_role_user($admin_login, $menu_id[0]->id);
                } else {
                    $result = false;
                }
            } else if ($link2 == "index") {
                if ($this->menu_model->get_menu_id($link1)) {
                    $menu_id = $this->menu_model->get_menu_id($link1);
                    $result = $this->get_role_user($admin_login, $menu_id[0]->id);
                } else {

                    $result = false;
                }
            }
        }
        return $result;
    }
}
