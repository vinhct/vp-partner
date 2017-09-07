<?php if($admin_info->Status != "A"): ?>
    <section class="content-header">
        <h1>
            Bạn chưa được phân quyền
        </h1>
    </section>
<?php else: ?>
<section class="content-header" xmlns="http://www.w3.org/1999/html">
    <h1>
        Danh sách người dùng
    </h1>
</section>
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-body">
<div id="tabs-container">

<ul class="tabs-menu">
    <li class="current"><a href="#tab-1">Tài khoản Super</a></li>
    <li><a href="#tab-2">Tài khoản admin</a></li>
    <li><a href="#tab-3">Tài khoản đại lý</a></li>
    <input type="reset" value="Thêm mới" name="submit"
           class="btn btn-success pull-left" id="reset"
           onclick="window.location.href = '<?php echo base_url('user/add') ?>'; ">

</ul>
<div class="tab">
<div id="tab-1" class="tab-content">
    <div class="row">
        <div class="col-sm-12">
            <?php if (isset($message) && $message): ?>
                <?php echo $message ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên đăng nhập</th>
                    <th>Nick name</th>
                    <th>Nhóm</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php
                foreach ($list as $row): ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $row->UserName; ?>
                        </td>
                        <td>
                            <?php echo $row->FullName; ?>
                        </td>
                        <td>
                            <?php if ($row->Status == "A"): ?>
                                <?php echo "Administrator"; ?>
                            <?php elseif ($row->Status == "W"): ?>
                                <?php echo "Vận hành"; ?>
                            <?php
                            elseif
                            ($row->Status == "S"
                            ): ?>
                                <?php echo "Chăm sóc khách hàng"; ?>
                            <?php
                            elseif ($row->Status == "M"): ?>
                                <?php echo "Marketing"; ?>
                            <?php
                            elseif ($row->Status == "L"): ?>
                                <?php echo "Lãnh đạo"; ?>
                            <?php
                            elseif ($row->Status == "D"): ?>
                                <?php echo "Chăm sóc đại lý"; ?>
                            <?php
                            elseif ($row->Status == "Q"): ?>
                                <?php echo "Quản lý chung"; ?>
                            <?php
                            elseif ($row->Status == "K"): ?>
                                <?php echo "Kế toán"; ?>
                            <?php
                            elseif ($row->Status == "C"): ?>
                                <?php echo "Developer"; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('user/edit/' . $row->ID.'/'.$row->isSuper) ?>">
                                <img src="<?php echo public_url('admin/images/edit.png') ?>">
                            </a>

                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="tab-2" class="tab-content">
    <div class="row">

        <div class="col-sm-12">
            <?php if (isset($message) && $message): ?>
                <?php echo $message ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên đăng nhập</th>
                    <th>Nick name</th>
                    <th>Nhóm</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php
                if(!empty($listadmin)):
                foreach ($listadmin as $row): ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $row->UserName; ?>
                        </td>
                        <td>
                            <?php echo $row->FullName; ?>
                        </td>
                        <td>
                            <?php echo $row->Name ?>


                        </td>
                        <td>
                            <a href="<?php echo base_url('user/edit/' . $row->ID.'/'.$row->isThuong) ?>">
                                <img src="<?php echo public_url('admin/images/edit.png') ?>">
                            </a>

                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<div id="tab-3" class="tab-content">
    <div class="row">
        <div class="col-sm-12">

            <?php if (isset($message) && $message): ?>
                <?php echo $message ?>
            <?php endif; ?>

        </div>
        <div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên đăng nhập</th>
                    <th>Nick name</th>
                    <th>Nhóm</th>
                    <th>Phân quyền</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php
                foreach ($listagent as $row): ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $row->username; ?>
                        </td>
                        <td>
                            <?php echo $row->nickname; ?>
                        </td>
                        <td>
                            <?php if ($row->status == "A"): ?>
                                <?php echo "Administrator"; ?>
                            <?php
                            elseif ($row->status == "D"): ?>
                                <?php echo "Đại lý cấp 1"; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('user/role/'. $row->id.'/3') ?>">
                                <img src="<?php echo public_url('admin/images/edit.png') ?>">
                            </a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

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
<?php endif; ?>
<style>

    .moneyhtml {
        text-align: right;
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

    $(".tabs-menu a").click(function (event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
    $(".successful").click(function () {
        $(".successful").hide();
    });
    $('a.verify_action').click(function () {
        if (!confirm('Bạn chắc chắn muốn xóa ?')) {
            return false;
        }
    });


</script>