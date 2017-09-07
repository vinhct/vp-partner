
<?php if($admin_info->Status == "A"): ?>
<section class="content-header">
    <h1>
        Cập nhật người dùng
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
                                    <label class="col-sm-1 control-label">User name</label>

                                    <div class="col-sm-2">
                                        <input type="text" readonly id="param_username" name="username"
                                               value="<?php echo $info->UserName ?>"
                                               class="form-control">
                                    </div>
                                    <label class="control-label"
                                           for="inputError"><?php echo form_error('username') ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Nick name</label>

                                    <div class="col-sm-2">
                                        <input type="text" value="<?php echo $info->FullName ?>" id="param_name"
                                               readonly name="name"
                                               class="form-control">
                                    </div>
                                    <label class="control-label"
                                           for="inputError"><?php echo form_error('name') ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Chức năng</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" id="selectchucnang" name="typechucnang">
                                            <option value="W" <?php if ($info->Status == "W") {
                                                echo "selected";
                                            } ?>>Vận hành
                                            </option>
                                            <option value="M" <?php if ($info->Status == "M") {
                                                echo "selected";
                                            } ?>>Maketing
                                            </option>
                                            <option value="S" <?php if ($info->Status == "S") {
                                                echo "selected";
                                            } ?>>Chăm sóc khách hàng
                                            </option>
                                            <option value="L" <?php if ($info->Status == "L") {
                                                echo "selected";
                                            } ?>>Lãnh đạo
                                            </option>
                                            <option value="D" <?php if ($info->Status == "D") {
                                                echo "selected";
                                            } ?>>Chăm sóc đại lý
                                            </option>
                                            <option value="Q" <?php if ($info->Status == "Q") {
                                                echo "selected";
                                            } ?>>Quản lý chung
                                            </option>
                                            <option value="K" <?php if ($info->Status == "K") {
                                                echo "selected";
                                            } ?>>Kế toán
                                            </option>
                                            <option value="C" <?php if ($info->Status == "C") {
                                                echo "selected";
                                            } ?>>Developer
                                            </option>
                                            <option value="A" <?php if ($info->Status == "A") {
                                                echo "selected";
                                            } ?>>Administrator
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <label class="col-sm-1 control-label">Tài khoản</label>

                                    <div class="col-sm-2">
                                        <select class="form-control" id="selectaccount" name="typeaccount">
                                            <?php if ($type == 1) : ?>
                                                <option value="1" <?php if ($info->isSuper == "1") {
                                                    echo "selected";
                                                } ?>>Tài khoản super
                                                </option>
                                                <option value="2">Tài khoản admin</option>
                                            <?php elseif ($type == 2): ?>
                                                <option value="1">Tài khoản super</option>
                                                <option value="2" <?php if ($info->isThuong == "2") {
                                                    echo "selected";
                                                } ?>>Tài khoản admin
                                                </option>
                                            <?php
                                            else: ?>
                                                <option value="1">Tài khoản super</option>
                                                <option value="2">Tài khoản admin</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-1">
                                        <?php if ($type == 1) : ?>
                                            <input type="reset" value="Phân quyền"
                                                   class="btn btn-success pull-left"
                                                   onclick="window.location.href = '<?php echo base_url('user/role/' . $info->ID . '/' . $info->isSuper) ?>'; ">
                                        <?php elseif ($type == 2): ?>
                                            <input type="reset" value="Phân quyền"
                                                   class="btn btn-success pull-left"
                                                   onclick="window.location.href = '<?php echo base_url('user/role/' . $info->ID . '/' . $info->isThuong) ?>'; ">
                                        <?php endif; ?>
                                    </div>
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
</script>