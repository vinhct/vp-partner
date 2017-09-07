<?php if($role == false): ?>
    <section class="content-header">
        <h1>
            Bạn chưa được phân quyền
        </h1>
    </section>
<?php else: ?>
<section class="content-header">
    <h1>
        Soi cầu tài xỉu
    </h1>
    <label class="pull-right">Tổng xiu: <b style="color: red"><?php echo (2000 - $couttai) ?></b></label>
    <label class="pull-right">Tổng tài: <b style="color: red ;margin-right: 20px;"><?php echo $couttai ?></b></label>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                   <span  style="width: 100%;line-height: 5px">
                   <?php foreach($list as $row): ?>
                       <?php if($row->result == 0) :?>
                           <img src="<?php echo public_url('admin/images/sp_xiu.png') ?>" style="width:25px" title="Xỉu">
                       <?php elseif($row->result == 1):?>
                           <img src="<?php echo public_url('admin/images/sp_tai.png') ?>" style="width:25px" title="Tài">
                       <?php endif; ?>
                   <?php endforeach;?>
                    </span>

                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

