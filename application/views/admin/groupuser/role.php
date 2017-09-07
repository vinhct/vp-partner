<?php if($admin_info->Status == "A"): ?>
<section class="content-header">
    <h1>
        Phân quyền nhóm người dùng
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
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-3"> <?php echo $list; ?></div>

                                </div>
                            </div>



                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-1"></div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            $("input[type='checkbox']").change(function () {
                $(this).siblings('ul')
                    .find("input[type='checkbox']")
                    .prop('checked', this.checked);
            });
        });
    });
</script>