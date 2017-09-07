<?php if($admin_info->status == "A"): ?>
<section class="content-header">
    <h1>
        Sửa menu
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form id="form" class="form" enctype="multipart/form-data" method="post" action="">
                        <fieldset>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <label class="col-sm-2  control-label" style="color: red" id="errorvin"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Tên menu</label>

                                    <div class="col-sm-2">
                                        <input type="text" id="param_name" value="<?php echo $info->Name ?>" name="name"
                                               class="form-control">
                                    </div>
                                    <label class="control-label"
                                           for="inputError"><?php echo form_error('name') ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Số thứ tự</label>

                                    <div class="col-sm-2">
                                        <input type="text" value="<?php echo $info->Param ?>" id="param_param"
                                               name="param" class="form-control">
                                    </div>
                                    <label class="control-label"
                                           for="inputError"><?php echo form_error('param') ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Đường dẫn</label>


                                    <div class="col-sm-2">
                                        <input type="text" value="<?php echo $info->Link ?>" id="param_link" name="link"
                                               class="form-control">
                                    </div>

                                    <label class="control-label"
                                           for="inputError"><?php echo form_error('link') ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Danh mục cha</label>

                                    <div class="col-sm-2">
                                        <?php echo $list; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Loại menu</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" name="typemenu">
                                           
                                            <option value="3" <?php if($info->isDaily == 1 ) {echo "selected"; }?>>Menu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-1">
                                        <input type="submit" value="Cập nhật" class="btn btn-success pull-left">
                                    </div>

                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
</section>
<?php else: ?>
    <section class="content-header">
        <h1>
            Bạn không được phân quyền
        </h1>
    </section>
<?php endif; ?>
<style>


</style>

<script>
    $(document).ready(function () {
        $("#param_param").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });

</script>