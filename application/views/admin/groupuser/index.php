<!-- head -->
<?php if($admin_info->status != "A"): ?>
    <section class="content-header">
        <h1>
            Bạn chưa được phân quyền
        </h1>
    </section>
<?php else: ?>
<section class="content-header" xmlns="http://www.w3.org/1999/html">
    <h1>
        Danh sách nhóm người dùng
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div id="tabs-container">

                        <ul class="tabs-menu">
                            
                            <input type="reset" value="Thêm mới" name="submit"
                                   class="btn btn-success pull-left" id="reset"
                                   onclick="window.location.href = '<?php echo base_url('groupuser/add') ?>'; ">

                        </ul>
                        <div class="tab">
                            
                            
                           
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
                                                <th>Tên nhóm</th>
                                                <th>Ghi chú</th>
                                                <th>Thao tác</th>
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
                                                        <?php echo $row->Name; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->Description; ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url('groupuser/edit/' . $row->Id)?>">
                                                            <img src="<?php echo public_url('admin/images/edit.png')?>">
                                                        </a>
                                                        <a class="verify_action" href="<?php echo base_url('groupuser/delete/' . $row->Id)?>">
                                                            <img src="<?php echo public_url('admin/images/delete.png')?>">
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $i ++; ?>
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