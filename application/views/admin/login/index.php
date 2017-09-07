<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Vinplay | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo public_url("admin") ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo public_url("admin") ?>/dist/css/AdminLTE.min.css">
    <script src="<?php echo public_url('admin') ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="<?php echo public_url('admin') ?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo public_url('admin') ?>/plugins/jQuery/jquery.md5.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="<?php echo public_url('admin') ?>/images/logo.png"/>
        <h2><b>Admin Đối tác</b></h2>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <input type="hidden" id="nickname">
        <div class="box box-info">
            <div class="form-group has-error">
                <div class="col-sm-12">
                    <label class="control-label pull-left" id="validate-text"
                           for="inputError"><?php echo $errors ?></label>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="login-vin" action="<?php echo base_url('login/loginTest') ?>"
                  method="post" novalidate="novalidate">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Username</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="param_username" name="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="param_password" name="password" placeholder="Password">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" value="Login" id = "login" class="btn btn-success pull-right">
                     <div id="flag" style="display: none"><?php echo $flag ?></div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
