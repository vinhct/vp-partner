<?php if($admin_info->status == "A"): ?>
<section class="content-header">
    <h1>
        Cập nhật nhóm người dùng
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <form id="form" class="form" enctype="multipart/form-data" method="post" action="">
                    <fieldset>
                        <div class="box-body">
                            <div class="form-group ">
                                <div class="row">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tên nhóm:</label>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="param_name" value="<?php echo $info->Name ?>" name="name">
                                    </div>
                                    <div class="col-sm-4"><label class="control-label" for="inputError"
                                                                 style="color: #ff0000"><?php echo form_error('name') ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label">Ghi chú:</label>

                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" value="<?php echo $info->Description ?>" id="param_description" name="description">
                                    </div>
                                    <div class="col-sm-4"><label class="control-label" for="inputError"
                                                                 style="color: #ff0000"><?php echo form_error('description') ?></label>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 control-label">Loại nhóm</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="typegroup">
                                         
                                            <option value="3" <?php if($info->Type == 3) { echo 'selected'; } ?>>Nhóm đối tác</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-1">
                                        <input type="reset" value="Phân quyền"
                                               class="btn btn-success pull-left"  onclick="window.location.href = '<?php echo base_url('groupuser/role/'.$info->Id.'/'.$info->Type) ?>'; ">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" value="Cập nhật" name="submit"
                                               class="btn btn-success pull-left"  >
                                    </div>
                                    <div class="col-sm-4"></div>
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
<script>


</script>