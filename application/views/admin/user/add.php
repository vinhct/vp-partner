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

                        <div class="tab">
                              <form id="form" class="form" enctype="multipart/form-data" method="post" action="add">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                </div>
                                                <label for="inputEmail3" class="col-sm-3 control-label" id="errorstatusagent"
                                                       style="color: red"><?php echo $error?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                </div>
                                                <label class="col-sm-1 control-label">Username:</label>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="username" name="username" >
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
                                                    <input type="text" class="form-control" id="nickname" name="nickname" >
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
                                                <label class="col-sm-1 control-label">Nhóm:</label>

                                                <div class="col-sm-2">
                                                <select id='groupuser' name='groupuser' class='form-control'>
                                               <?php echo $groupuser?> 
                                               
                                                    </select>
                                                </div>
                                            </div>
                                        </div>       

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-2">
                                                    <input type="submit" value="Thêm mới"
                                                           class="btn btn-success pull-left" id="create" name="create">
                                                </div>
                                                <div class="col-sm-4"></div>
                                            </div>
                                        </div>
                                        </form>
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
                nickname: $("#txtnicknameagent").val(),
                groupid: $("#groupuser").val()
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
                else if (resagent == 3) {
                     $("#errorstatusagent").html("Tài khoản không tồn tại. Vui lòng kiểm tra lại");
                }
            }
        });
    });


</script>
