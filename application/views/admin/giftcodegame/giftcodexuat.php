<?php if($role == false): ?>
    <section class="content-header">
        <h1>
            Bạn chưa được phân quyền
        </h1>
    </section>
<?php else: ?>
    <section class="content-header">
        <h1>
            Danh sách giftcode minigame đã xuất
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <h4 id="resultsearch" style="color: red"></h4>
                        <form action="<?php echo base_url('giftcodegame/giftcodexuat') ?>" method="post">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-1 control-label">Nguồn xuất:</label>
                                    <div class="col-sm-2">
                                        <select id="nguonxuat" class="form-control" name="nguonxuat">
                                            <option value="" <?php if($this->input->post("nguonxuat")== ""){echo "selected";}  ?>>Chọn</option>
                                            <?php foreach($source as $row): ?>
                                                <option value="<?php echo $row->key ?>" <?php if($this->input->post("nguonxuat")==  $row->key){echo "selected";}  ?>><?php echo $row->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <label id="labelvin" class="col-sm-1 control-label">Hiển thị</label>
                                    <div class="col-sm-2">
                                        <select  class="form-control" id="record" name="record">

                                            <option value="50" <?php if($this->input->post("record")== "50"){echo "selected";}  ?>>50</option>
                                            <option value="100" <?php if($this->input->post("record")== "100"){echo "selected";}  ?>>100</option>
                                            <option value="200" <?php if($this->input->post("record")== "200"){echo "selected";}  ?>>200</option>
                                            <option value="500" <?php if($this->input->post("record")== "500"){echo "selected";}  ?>>500</option>
                                            <option value="1000" <?php if($this->input->post("record")== "1000"){echo "selected";}  ?>>1000</option>
                                            <option value="2000" <?php if($this->input->post("record")== "2000"){echo "selected";}  ?>>2000</option>
                                            <option value="5000" <?php if($this->input->post("record")== "5000"){echo "selected";}  ?>>5000</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-1 control-label">Từ ngày:</label>

                                    <div class="col-sm-2">
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" id="fromDate" name="fromDate" value="<?php echo  $this->input->post("fromDate")?>"> <span
                                                class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                        </div>
                                    </div>
                                    <label class="col-sm-1 control-label">Đến ngày:</label>

                                    <div class="col-sm-2">
                                        <div class="input-group date" id="datetimepicker2">
                                            <input type="text" class="form-control" id="toDate" name="toDate"  value="<?php echo $this->input->post("toDate")?>"> <span
                                                class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">

                                    <label id="labelvin" class="col-sm-1 control-label">Giftcode</label>

                                    <div class="col-sm-2">
                                        <input class="form-control" id="giftcode" name="giftcode" value="<?php echo $this->input->post("giftcode")?>" >
                                    </div>
                                    <label id="labelvin" class="col-sm-1 control-label">Khóa</label>
                                    <div class="col-sm-2">
                                        <select name="blockgc" class="form-control" id="blockgc">

                                            <option value="" <?php if($this->input->post("blockgc")== ""){echo "selected";}  ?>>Chọn</option>
                                            <option value="1" <?php if($this->input->post("blockgc")== "1"){echo "selected";}  ?>>Đã khóa</option>
                                            <option value="0" <?php if($this->input->post("blockgc")== "0"){echo "selected";}  ?>>Chưa khóa</option>

                                        </select>
                                    </div>
                                    <label id="labelvin" class="col-sm-1 control-label">Trạng thái</label>
                                    <div class="col-sm-2">
                                        <select name="gcuse" class="form-control" id="gcuse">

                                            <option value="" <?php if($this->input->post("gcuse")== ""){echo "selected";}  ?>>Chọn</option>
                                            <option value="1" <?php if($this->input->post("gcuse")== "1"){echo "selected";}  ?>>Đã sử dụng</option>
                                            <option value="0" <?php if($this->input->post("gcuse")== "0"){echo "selected";}  ?>>Chưa sử dụng</option>

                                        </select>
                                    </div>
                                    <label id="labelvin" class="col-sm-1 control-label">Số lượt quay</label>
                                    <div class="col-sm-2">
                                        <select name="rotategc" class="form-control" id="rotategc">

                                            <option value="" <?php if($this->input->post("rotategc")== ""){echo "selected";}  ?>>Chọn</option>
                                            <?php foreach($listrotate as $key => $row): ?>
                                                <option value="<?php echo $row ?>" <?php if ($this->input->post("rotategc") == $row) {
                                                    echo "selected";
                                                } ?>><?php echo $row." lượt quay" ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label id="labelvin" class="col-sm-1 control-label">Nickname</label>

                                    <div class="col-sm-2">
                                        <input class="form-control" id="nickname" name="nickname" value="<?php echo $this->input->post("nickname")?>" >
                                    </div>
                                    <label id="labelvin" class="col-sm-1 control-label">Username</label>

                                    <div class="col-sm-2">
                                        <input class="form-control" id="username" name="username" value="<?php echo $this->input->post("username")?>" >
                                    </div>
                                    <div class="col-sm-1"><input type="submit" value="Tìm kiếm" name="submit"
                                                                 class="btn btn-success pull-right" id="search_tran"></div>
                                    <div class="col-sm-1"><input type="reset" value="Reset" name="submit"
                                                                 class="btn btn-success pull-left" id="reset"
                                                                 onclick="window.location.href = '<?php echo base_url('giftcodegame/giftcodexuat') ?>'; ">
                                    </div>
                                    <div class="col-sm-1"><input type="button" value="Xuất Exel" name="submit"
                                                                 class="btn btn-success pull-left" id="exportexel" ></div>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Số lượt quay</th>
                                    <th>Giftcode</th>
                                    <th>Nickname</th>
                                    <th>Số lượng</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày sử dụng</th>
                                    <th>Trạng thái</th>
                                    <th>Khóa giftcode</th>
                                </tr>
                                </thead>
                                <tbody id="logaction">

                                </tbody>
                            </table>

                            <div id="spinner" class="spinner" style="display:none;">
                                <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>"
                                     alt="Loading"/>
                            </div>
                            <div class="text-center pull-right">
                                <ul id="pagination-demo" class="pagination-lg"></ul>

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
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

</style>


<script>
$(function () {
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
    $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
});
$("#exportexel").click(function () {
    $("#example2").table2excel({
        exclude: ".noExl",
        name: "Excel Document Name",
        filename: "listgiftcode",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true
    });
});
$("#search_tran").click(function () {
    var fromDatetime = $("#fromDate").val();
    var toDatetime = $("#toDate").val();
    if (fromDatetime > toDatetime) {
        alert('Ngày kết thúc phải lớn hơn ngày bắt đầu')
        return false;
    }
});
function resultgiftcodevin(stt, rotate, giftcode,nickname, quantity, createtime,usetime,status,block) {
    var rs = "";
    rs += "<tr>";
    rs += "<td>" + stt + "</td>";
    rs += "<td>" + rotate + "</td>";
    rs += "<td>" + giftcode + "</td>";
    rs += "<td>" + nickname + "</td>";
    rs += "<td>" + quantity + "</td>";
    rs += "<td>" + createtime + "</td>";
    rs += "<td>" + usetime + "</td>";
    if(status == 1){
        rs += "<td>" + "Đã sử dụng" + "</td>";
    }else{
        rs += "<td>" + "Chưa sử dụng" + "</td>";
    }

    if(block == 1 ){
        rs += "<td style='text-align:center'>" +  "<input type='button'  id='blockcode' value='Đã khóa' class='btn btn-success pull-righ'  onclick=\"huygiftcode('"+giftcode+"',0)\" >" + "</td>";}
    else{
        rs += "<td style='text-align:center'>" +  "<input type='button'  id='opencode' value='Chưa khóa' class='btn btn-success pull-righ' onclick=\"huygiftcode('"+giftcode+"',1)\" >" + "</td>";
    }
    rs += "</tr>";
    return rs;
}
$(document).ready(function () {
    var result = "";
    var oldpage = 0;
    $('#pagination-demo').css("display", "block");
    $("#spinner").show();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('superajax/giftcodexuat') ?>",
            data: {
                nickname: $("#nickname").val(),
                username: $("#username").val(),
                giftcode : $("#giftcode").val(),
                nguonxuat: $("#nguonxuat").val(),
                fromDate: $("#fromDate").val(),
                toDate: $("#toDate").val(),
                pages: 1,
                gcuse: $("#gcuse").val(),
                record:  $("#record").val(),
                rotate : $("#rotategc").val(),
                block : $("#blockgc").val()
            },

            dataType: 'json',
            success: function (result) {
                $("#spinner").hide();
                if(result.transactions == ""){
                    $("#resultsearch").html("Không tìm thấy kết quả")
                }else {
                    var totalPage = result.total;
                    var countrow = result.totalRecord;
                    $("#num").html(countrow);
                    stt = 1;
                    $.each(result.transactions, function (index, value) {
                        result += resultgiftcodevin(stt, value.surfing, value.giftCodeFull, value.nickName, value.quantity, value.timeLog,value.updateTime, value.useGiftCode,value.block);
                        stt++;
                    });
                    $('#logaction').html(result);
                    $('#pagination-demo').twbsPagination({
                        totalPages: totalPage,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            if (oldpage > 0) {
                                $("#spinner").show();
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('superajax/giftcodexuat') ?>",
                                    data: {
                                        nickname: $("#nickname").val(),
                                        username: $("#username").val(),
                                        giftcode : $("#giftcode").val(),
                                        nguonxuat: $("#nguonxuat").val(),
                                        fromDate: $("#fromDate").val(),
                                        toDate: $("#toDate").val(),
                                        pages: page,
                                        gcuse: $("#gcuse").val(),
                                        record:  $("#record").val(),
                                        rotate : $("#rotategc").val(),
                                        block : $("#blockgc").val()
                                    },
                                    dataType: 'json',
                                    success: function (result) {
                                        $("#spinner").hide();
                                        stt = 1;
                                        $.each(result.transactions, function (index, value) {
                                            result += resultgiftcodevin(stt, value.surfing,value.giftCodeFull, value.nickName, value.quantity, value.timeLog,value.updateTime,value.useGiftCode,value.block);
                                            stt++;
                                        });
                                        $('#logaction').html(result);
                                    }
                                });
                            }
                            oldpage = page;
                        }
                    });
                }
            }
        });
});

function huygiftcode(giftcode,blockgc){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('superajax/huygiftcode')?>",
        data: {
            giftcode: giftcode,
            block: blockgc
        },

        dataType: 'json',
        success: function (result) {
            var baseurl = "<?php echo base_url('giftcodegame/giftcodexuat')?>";
          //  window.location.href = baseurl;
        }
    });
}
</script>
`