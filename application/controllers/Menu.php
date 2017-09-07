<?php

Class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('menurole_model');
    }

    /*
     * Lay danh sach admin
     */
    function index()
    {
        $listsuper = $this->get_list_menu();
        $this->data['listsuper'] = $listsuper;

        $listadmin = $this->get_list_menu_admin();
        $this->data['listadmin'] = $listadmin;
        $listagent = $this->get_list_menu_agent();
        $this->data['listagent'] = $listagent;

        //lay tổng số bản ghi
        $total = $this->menu_model->get_total();
        $this->data['total'] = $total;
        //lay nội dung của biến message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        $this->data['temp'] = 'admin/menu/index';
        $this->load->view('admin/main', $this->data);
    }

    /*
         * Thêm mới quản trị viên
         */
    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $list = $this->get_category();

        $this->data['list'] = $list;
        //neu ma co du lieu post len thi kiem tra
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên menu', 'required');
            $this->form_validation->set_rules('param', 'Số thứ tự', 'required');
            $this->form_validation->set_rules('link', 'Đường dẫn', 'required');
            //nhập liệu chính xác
            if ($this->form_validation->run()) {
                //them vao csdl
                $name = $this->input->post('name');
                $param = $this->input->post('param');
                $link = $this->input->post('link');
                $parent_id = $this->input->post('ParentID');
                $typemenu = $this->input->post('typemenu');
                if ($typemenu == 1) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isSuper' => 1,
                    );
                }
                if ($typemenu == 2) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isThuong' => 1,
                    );
                }
                if ($typemenu == 3) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isDaily' => 1,
                    );
                }
                if ($this->menu_model->create($data)) {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Thêm menu thành công</label></div>');
                } else {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(base_url('menu'));


            }
        }
        $this->data['temp'] = 'admin/menu/add';
        $this->load->view('admin/main', $this->data);
    }

    function edit()
    {
        //lay id cua quan tri vien can chinh sua
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $info = $this->menu_model->get_info($id);
        if (!$info) {

            redirect(base_url('home/errorpage'));
        }
        $list = $this->get_category_edit($id);
        $this->data['list'] = $list;
        $this->load->library('form_validation');
        $this->load->helper('form');
        //lay thong cua quan trị viên

        $this->data['info'] = $info;

        if ($this->input->post()) {

            $this->form_validation->set_rules('name', 'Tên nhóm', 'required');
            $this->form_validation->set_rules('param', 'Tham số trang', 'required');
            $this->form_validation->set_rules('link', 'Đường dẫn', 'required');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $param = $this->input->post('param');
                $link = $this->input->post('link');
                $parent_id = $this->input->post('ParentID');
                $typemenu = $this->input->post('typemenu');
                if ($typemenu == 1) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isSuper' => 1,
                        'isThuong' => 0,
                        'isDaily' => 0
                    );
                } elseif ($typemenu == 2) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isThuong' => 1,
                        'isDaily' => 0,
                        'isSuper' => 0

                    );
                } elseif ($typemenu == 3) {
                    $data = array(
                        'name' => $name,
                        'param' => $param,
                        'link' => $link,
                        'parrent_id' => $parent_id,
                        'isDaily' => 1,
                        'isSuper' => 0,
                        'isThuong' => 0

                    );
                }


                if ($this->menu_model->update($id, $data)) {
                    //tạo ra nội dung thông báo
                    $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Cập nhật menu thành công</label></div>');
                } else {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                //chuyen tới trang danh sách quản trị viên
                redirect(base_url('menu'));
            }
        }
        $this->data['temp'] = 'admin/menu/edit';
        $this->load->view('admin/main', $this->data);

    }

//xóa dữ liệu nhóm người dùng
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        //lay thong tin cua quan tri vien
        $info = $this->menu_model->get_info($id);
        $listmenu = $this->menu_model->get_menu_parentid($id);
        $listmenuroel = $this->menurole_model->get_list_menu_role($id);

        if (!$info) {
            redirect(base_url('home/errorpage'));
        }
        //thuc hiện xóa
        if ($listmenu != false) {
            $this->session->set_flashdata('message', '<div class="form-group has-error successful"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>Bạn không được xóa vì tồn tại menu con</label></div>');
        } elseif ($listmenuroel != false) {
            $this->session->set_flashdata('message', '<div class="form-group has-error successful"><label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>Bạn không được xóa vì menu vẫn còn trong nhóm</label></div>');
        } else {
            $this->menu_model->delete($id);
            $this->session->set_flashdata('message', '<div class="form-group has-success successful"><label class="control-label" for="inputSuccess"><i class="fa fa-check"></i> Xóa menu thành công</label></div>');
        }


        redirect(base_url('menu'));
    }

//select category
    function get_category()
    {
        $str = "";
        $this->load->model('menu_model');
        $categorys = $this->menu_model->get_category();
        $menuadmin = $this->menu_model->get_menu_admin();
        $menuagent = $this->menu_model->get_menu_agent();
        $str .= "<select id='ParentID' name='ParentID' class='form-control'>";
        if ($categorys != null) {
            $str .= "<option value='-1' style='color: #0000ff' >Root</option>";
            foreach ($categorys as $category) {

                $str .= "<option value='$category->id' >";
                $str .= $category->Name;
                $str .= $this->get_subcategory($category->id, $i = 0);
                $str .= "</option>";
            }
        } else {
            $str .= "<option value='-1' >Root</option>";
        }

        if ($menuadmin != null) {
            $str .= "<option value='-1' style='color: #0000ff' >Root</option>";
            foreach ($menuadmin as $category) {

                $str .= "<option value='$category->id' >";
                $str .= $category->Name;
                $str .= $this->get_sub_menuadmin($category->id, $i = 0);
                $str .= "</option>";
            }
        } else {
            $str .= "<option value='-1' >Root</option>";
        }
        if ($menuagent != null) {
            $str .= "<option value='-1' style='color: #0000ff' >Root</option>";
            foreach ($menuagent as $category) {

                $str .= "<option value='$category->id' >";
                $str .= $category->Name;
                $str .= $this->get_sub_menuagent($category->id, $i = 0);
                $str .= "</option>";
            }
        } else {
            $str .= "<option value='-1' >Root</option>";
        }

        $str .= "</select>";
        return $str;
    }

    function get_subcategory($category_ids, $i = 0)
    {
        $str = "";
        $sub_categorys = $this->menu_model->get_subcategory($category_ids);
        $sub_menuadmin = $this->menu_model->get_menu_sub_admin($category_ids);
        $sub_menuagent = $this->menu_model->get_menu_sub_agent($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_categorys) {
            foreach ($sub_categorys as $sub_category) {
                //kiem tra con parent hay ko
                $str .= "<option value='$sub_category->id'>";
                $str .= "........... " . $sub_category->Name;
                $str .= "</option>";
            }
        }
        return $str;
    }

    function get_sub_menuadmin($category_ids, $i = 0)
    {
        $str = "";
        $sub_menuadmin = $this->menu_model->get_menu_sub_admin($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_menuadmin) {
            foreach ($sub_menuadmin as $sub_category) {
                //kiem tra con parent hay ko
                $str .= "<option value='$sub_category->id'>";
                $str .= "........... " . $sub_category->Name;
                $str .= "</option>";
            }
        }
        return $str;
    }

    function get_sub_menuagent($category_ids, $i = 0)
    {
        $str = "";
        $sub_menuagent = $this->menu_model->get_menu_sub_agent($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_menuagent) {
            foreach ($sub_menuagent as $sub_category) {
                //kiem tra con parent hay ko
                $str .= "<option value='$sub_category->id'>";
                $str .= "........... " . $sub_category->Name;
                $str .= "</option>";
            }
        }
        return $str;
    }

    //danh sach menu trang index
    function get_list_menu()
    {
        $str = "";
        $this->load->model('menu_model');
        $categorys = $this->menu_model->get_category();
        $stt = 1;
        if($categorys!=null){
        foreach ($categorys as $category) {
            $str .= "<tr>";
            $str .= "<td class=\"textC\">$stt</td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Name . "> $category->Name</span></td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Param . "> $category->Param</span></td>";
            $str .= " <td class=\"option\">";
            $str .= "           <a href=" . base_url('menu/edit/' . $category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
            $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
            $str .= "       </a>";
            $str .= "     <a href=" . base_url('menu/delete/' . $category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
            $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
            $str .= "     </a>";
            $str .= " </td>";
            $str .= "</tr>";
            $str .= $this->get_sub_list_menu($category->id, $i = 0);
            $stt++;
        }
        }
        return $str;
    }

    function get_sub_list_menu($category_ids, $i = 0)
    {
        $str = "";
        $sub_categorys = $this->menu_model->get_subcategory($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_categorys) {
            $stt = 1;
            foreach ($sub_categorys as $sub_category) {
                $str .= "<tr>";
                //kiem tra con parent hay ko
                $str .= "<td class=\"textC\">$stt</td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Name . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Name</span></td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Param . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Param</span></td>";
                $str .= " <td class=\"option\">";
                $str .= "           <a href=" . base_url('menu/edit/' . $sub_category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
                $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
                $str .= "       </a>";
                $str .= "     <a href=" . base_url('menu/delete/' . $sub_category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
                $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
                $str .= "     </a>";
                $str .= " </td>";
                $str .= "</tr>";

                if ($sub_category->id) {
                    $str .= $this->get_sub_list_menu($sub_category->id, $i++);
                }
                $stt++;
            }

        }
        return $str;
    }

    function get_list_menu_admin()
    {
        $str = "";
        $this->load->model('menu_model');
        $categorys = $this->menu_model->get_menu_admin();
        $stt = 1;
        if($categorys!=null){
        foreach ($categorys as $category) {
            $str .= "<tr>";
            $str .= "<td class=\"textC\">$stt</td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Name . "> $category->Name</span></td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Param . "> $category->Param</span></td>";
            $str .= " <td class=\"option\">";
            $str .= "           <a href=" . base_url('menu/edit/' . $category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
            $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
            $str .= "       </a>";
            $str .= "     <a href=" . base_url('menu/delete/' . $category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
            $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
            $str .= "     </a>";
            $str .= " </td>";
            $str .= "</tr>";
            $str .= $this->get_sub_list_menu_admin($category->id, $i = 0);
            $stt++;
        }
    }
        return $str;
    }

    function get_sub_list_menu_admin($category_ids, $i = 0)
    {
        $str = "";
        $sub_categorys = $this->menu_model->get_menu_sub_admin($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_categorys) {
            $stt = 1;
            foreach ($sub_categorys as $sub_category) {
                $str .= "<tr>";
                //kiem tra con parent hay ko
                $str .= "<td class=\"textC\">$stt</td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Name . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Name</span></td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Param . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Param</span></td>";
                $str .= " <td class=\"option\">";
                $str .= "           <a href=" . base_url('menu/edit/' . $sub_category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
                $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
                $str .= "       </a>";
                $str .= "     <a href=" . base_url('menu/delete/' . $sub_category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
                $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
                $str .= "     </a>";
                $str .= " </td>";
                $str .= "</tr>";

                if ($sub_category->id) {
                    $str .= $this->get_sub_list_menu_admin($sub_category->id, $i++);
                }
                $stt++;
            }

        }
        return $str;
    }

    function get_list_menu_agent()
    {
        $str = "";
        $this->load->model('menu_model');
        $categorys = $this->menu_model->get_menu_agent();
        $stt = 1;
        if($categorys!=null){
        foreach ($categorys as $category) {
            $str .= "<tr>";
            $str .= "<td class=\"textC\">$stt</td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Name . "> $category->Name</span></td>";
            $str .= " <td><span class=\"tipS\" original-title=" . $category->Param . "> $category->Param</span></td>";
            $str .= " <td class=\"option\">";
            $str .= "           <a href=" . base_url('menu/edit/' . $category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
            $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
            $str .= "       </a>";
            $str .= "     <a href=" . base_url('menu/delete/' . $category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
            $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
            $str .= "     </a>";
            $str .= " </td>";
            $str .= "</tr>";
            $str .= $this->get_sub_list_menu_agent($category->id, $i = 0);
            $stt++;
        }
        }
        return $str;
    }

    function get_sub_list_menu_agent($category_ids, $i = 0)
    {
        $str = "";
        $sub_categorys = $this->menu_model->get_menu_sub_agent($category_ids);
        //kiem tra get subcategory co ton ai hay
        if ($sub_categorys) {
            $stt = 1;
            foreach ($sub_categorys as $sub_category) {
                $str .= "<tr>";
                //kiem tra con parent hay ko
                $str .= "<td class=\"textC\">$stt</td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Name . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Name</span></td>";
                $str .= " <td><span class=\"tipS\" original-title=" . $sub_category->Param . "> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;$sub_category->Param</span></td>";
                $str .= " <td class=\"option\">";
                $str .= "           <a href=" . base_url('menu/edit/' . $sub_category->id) . " class=\"tipS \" original-title=\"Chỉnh sửa\">";
                $str .= "      <img src=" . public_url('admin') . "/images/edit.png>";
                $str .= "       </a>";
                $str .= "     <a href=" . base_url('menu/delete/' . $sub_category->id) . " class=\"tipS verify_action\" original-title=\"Xóa\">";
                $str .= "     <img src=" . public_url('admin') . "/images/delete.png>";
                $str .= "     </a>";
                $str .= " </td>";
                $str .= "</tr>";

                if ($sub_category->id) {
                    $str .= $this->get_sub_list_menu_agent($sub_category->id, $i++);
                }
                $stt++;
            }

        }
        return $str;
    }

    function get_category_edit($id)
    {
        $str = "";
        $this->load->model('menu_model');
        $categorys = $this->menu_model->get_category();
        $menuadmin = $this->menu_model->get_menu_admin();
        $menuagent = $this->menu_model->get_menu_agent();
        $str .= "<select id='ParentID' name='ParentID' class='form-control'>";
        if ($categorys != null) {
            $str .= "<option value='-1' style='color: #0000ff' >Root</option>";
            foreach ($categorys as $category) {
                $sub_categorys = $this->menu_model->get_subcategory($category->id);
                $menu_select = $this->menu_model->get_info($id);
                if ($menu_select->Parrent_ID == $category->id) {
                    $str .= "<option value='$category->id' selected>";
                    $str .= $category->Name;
                    $str .= "</option>";
                } else {
                    $str .= "<option value='$category->id'>";
                    $str .= $category->Name;
                    $str .= "</option>";
                }
                if (!empty($sub_categorys)) {
                    foreach ($sub_categorys as $sub_category) {
                        $str .= "<option value='$sub_category->id'>";
                        $str .= "........... " . $sub_category->Name;
                        $str .= "</option>";
                    }
                }
            }
        } else {
            $str .= "<option value='-1'  style='color: #0000ff' >Root</option>";
        }

        if ($menuadmin != null) {
            $str .= "<option value='-1'  style='color: #0000ff' >Root</option>";
            foreach ($menuadmin as $category) {
                $sub_categorys = $this->menu_model->get_menu_sub_admin($category->id);
                $menu_select = $this->menu_model->get_info($id);
                if ($menu_select->Parrent_ID == $category->id) {
                    $str .= "<option value='$category->id' selected>";
                    $str .= $category->Name;
                    $str .= "</option>";
                } else {
                    $str .= "<option value='$category->id'>";
                    $str .= $category->Name;
                    $str .= "</option>";
                }
                if (!empty($sub_categorys)) {
                    foreach ($sub_categorys as $sub_category) {
                        $str .= "<option value='$sub_category->id'>";
                        $str .= "........... " . $sub_category->Name;
                        $str .= "</option>";
                    }
                }
            }
        } else {
            $str .= "<option value='-1'  style='color: #0000ff' >Root</option>";
        }
        if ($menuagent != null) {
            $str .= "<option value='-1'  style='color: #0000ff' >Root</option>";
            foreach ($menuagent as $category) {
                $sub_categorys = $this->menu_model->get_menu_sub_agent($category->id);
                $menu_select = $this->menu_model->get_info($id);
                if ($menu_select->Parrent_ID == $category->id) {
                    $str .= "<option value='$category->id' selected>";
                    $str .= $category->Name;
                    $str .= "</option>";
                } else {
                    $str .= "<option value='$category->id'>";
                    $str .= $category->Name;
                    $str .= "</option>";
                }
                if (!empty($sub_categorys)) {
                    foreach ($sub_categorys as $sub_category) {
                        $str .= "<option value='$sub_category->id'>";
                        $str .= "........... " . $sub_category->Name;
                        $str .= "</option>";
                    }
                }
            }
        } else {
            $str .= "<option value='-1'  style='color: #0000ff' >Root</option>";
        }
        $str .= "</select>";
        return $str;
    }
}
