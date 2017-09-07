<?php if($admin_info->status == "A"): ?>
<section class="content-header">
    <h1>
        Thêm mới người dùng
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="tabs-container">

                        <ul class="tabs-menu">
                            <li class="current"><a href="#tab-1">Tài khoản Admin</a></li>
                            <li><a href="#tab-2">Tài khoản đại lý</a></li>

                        </ul>
                        <div class="tab">
                            <div id="tab-1" class="tab-content">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 control-label" id="errorstatus"
                                               style="color: red"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-2">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-1 control-label">Nick name:</label>

                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" placeholder="Nhập nickname"
                                                   id="param_name">
                                        </div>
                                        <div class="col-sm-1">
                                            <input type="button" value="Tìm kiếm" class="btn btn-success pull-left"
                                                   id="abc1111">
                                        </div>
                                    </div>
                                </div>
                                <div id="info_user" style="display: none">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <label class="col-sm-1 control-label">Username:</label>

                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" readonly id="txtusername">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <label class="col-sm-1 control-label">Nickname:</label>

                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="txtnickname" readonly>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <label class="col-sm-1 control-label">Bộ phận</label>

                                            <div class="col-sm-2">
                                                <select class="form-control" id="selectchucnang">
                                                    <option value="W">Vận hành</option>
                                                    <option value="M">Maketing</option>
                                                    <option value="S">Chăm sóc khách hàng</option>
                                                    <option value="L">Lãnh đạo</option>
                                                    <option value="D">Chăm sóc đại lý</option>
                                                    <option value="Q">Quản lý chung</option>
                                                    <option value="K">Kế toán</option>
                                                    <option value="C">Developer</option>
                                                    <option value="A">Administrator</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>
                                            <label class="col-sm-1 control-label">Phân quyền</label>

                                            <div class="col-sm-2">
                                                <select class="form-control" id="selectrole">
                                                    <option value="">Chọn</option>
                                                    <?php foreach ($listrole as $row): ?>
                                                        <option value="<?php echo $row->Id ?>"><?php echo $row->Name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-2">
                                                <input type="button" value="Thêm mới" id="setadmin"
                                                       class="btn btn-success pull-left">
                                            </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="tab-2" class="tab-content">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-3 control-label" id="errorstatusagent"
                                               style="color: red"></label>
                                    </div>
                                </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <label class="col-sm-1 control-label">Username:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="txtusernameagent">
                                                </div>
                                                <div class="col-sm-4"><label class="control-label" for="inputError"
                                                                             style="color: #ff0000"></label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <label class="col-sm-1 control-label">Nickname:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="txtnicknameagent">
                                                </div>
                                                <div class="col-sm-4"><label class="control-label" for="inputError"
                                                                             style="color: #ff0000"></label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-2">
                                                    <input type="button" value="Thêm mới"
                                                           class="btn btn-success pull-left" id="setagent">
                                                </div>
                                                <div class="col-sm-4"></div>
                                            </div>
                                        </div>

                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
<div id="spinner" class="spinner" style="display:none;">
    <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>" alt="Loading"/>
</div>

<?php else: ?>
    <section class="content-header">
        <h1>
            Bạn không được phân quyền
        </h1>
    </section>
<?php endif; ?>


<style>

    .spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -50px; /* half width of the spinner gif */
        margin-top: -50px; /* half height of the spinner gif */
        text-align: center;
        z-index: 1234;
        overflow: auto;
        width: 100px; /* width of the spinner gif */
        height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
    }


    .tabs-menu {
        height: 30px;
        /*float: left;*/
        clear: both;
        list-style: none;
    }

    .tabs-menu li {
        height: 35px;
        line-height: 35px;
        float: left;
        margin-right: 10px;
        margin-bottom: 15px;
        background-color: #00a65a;
        border-top: 1px solid #d4d4d1;
        border-right: 1px solid #d4d4d1;
        border-left: 1px solid #d4d4d1;
    }

    .tabs-menu li.current {
        position: relative;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d1;
        z-index: 5;
    }

    .tabs-menu li a {
        padding: 10px;
        text-transform: uppercase;
        color: #fff;
        text-decoration: none;
    }

    .tabs-menu .current a {
        color: #00a65a;
    }

    .tab {
        border: 1px solid #d4d4d1;
        background-color: #fff;
        float: left;
        margin-bottom: 20px;
        width: 100%;
    }

    .tab-content {
        width: 100%;
        padding: 20px;
        display: none;
    }

    #tab-1 {
        display: block;
    }

    td {
        word-break: break-all;
    }

    thead {
        font-size: 12px;
    }

    .spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        margin-left: -50px; /* half width of the spinner gif */
        margin-top: -50px; /* half height of the spinner gif */
        text-align: center;
        z-index: 1234;
        overflow: auto;
        width: 100px; /* width of the spinner gif */
        height: 102px; /*hight of the spinner gif +2px to fix IE8 issue */
    }</style>
<script>

    $("#abc1111").click(function () {

        if ($("#param_name").val() == "") {
            $("#info_user").css("display", "none");
            $("#errorstatus").html("Bạn chưa nhập nick name");
            return false;
        }
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/getinfoajax')?>",
            data: {
                nickname: $("#param_name").val()
            },
            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if (result.user != null) {
                    $("#info_user").css("display", "block");
                    $("#errorstatus").html("");
                    $("#txtusername").val(result.user.username);
                    $("#txtnickname").val(result.user.nickname);
                } else if (result.user == null) {
                    $("#errorstatus").html("Nick name đã được đăng ký hoặc không tồn tại");
                    $("#info_user").css("display", "none")
                }
            }
        });
    });


</script>
<script>
    $("#setadmin").click(function () {
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/addadmin')?>",
            dataType: 'json',
            data: {
                username: $("#txtusername").val()
            },
            success: function (res) {
                $("#spinner").hide();
                if (res == 1) {
                    $("#errorstatus").html("Tài khoản đã tồn tại");
                } else if (res == 2) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url("/user/addadminajax"); ?>",
                        dataType: 'json',
                        data: {
                            username: $("#txtusername").val(),
                            nickname: $("#txtnickname").val(),
                            status: $("#selectchucnang").val(),
                            role: $("#selectrole").val()
                        },
                        success: function (response) {
                            if (response.errorCode == 0) {
                                var baseurl = "<?php echo base_url('user') ?>";
                                window.location.href = baseurl;
                            } else if (response.errorCode == 1001) {
                                $("#errorstatus").html("Hệ thống gián đoạn");
                            }
                        }
                    });

                }
            }
        });

    });

    $(".tabs-menu a").click(function (event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });

</script>
<script>

    $("#setagent").click(function () {

        if ($("#txtusernameagent").val() == "") {
            $("#errorstatusagent").html("Bạn chưa nhập username");
            return false;
        }
        if ($("#txtnicknameagent").val() == "") {
            $("#errorstatusagent").html("Bạn chưa nhập nickname");
            return false;
        }
        $("#spinner").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('user/getagent')?>",
            data: {
                username: $("#txtusernameagent").val(),
                nickname: $("#txtnicknameagent").val()
            },
            dataType: 'json',
            success: function (resagent) {
                $("#spinner").hide();
                if (resagent == 1) {
                    $("#errorstatusagent").html("Tài khoản đã tồn tại");
                } else if (resagent == 2) {
                    var baseurl = "<?php echo base_url('user') ?>";
                    window.location.href = baseurl;
                }
            }
        });
    });


</script>
