<section class="content-header">
	<h1>
	Lịch sử nạp vin qua VTC
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-body">
					
					<form id="form" class="form" enctype="multipart/form-data" method="post" action="add">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-2">
								</div>
								<label class="col-sm-1 control-label">Từ ngày:</label>
								<div class="col-sm-2">
									<div class="input-group date" id="datetimepicker1">
										<input type="text" class="form-control" id="fromdate" name="fromdate" value="<?php echo $start_time?>">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="col-sm-4"><label class="control-label" for="inputError" style="color: #ff0000"></label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-2">
							</div>
							<label class="col-sm-1 control-label">Đến ngày:</label>
							<div class="col-sm-2">
								<div class="input-group date" id="datetimepicker2">
									<input type="text" class="form-control" id="todate" name="todate" value="<?php echo $end_time?>">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
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
						<label class="col-sm-1 control-label">Mã giao dịch:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="tranid" name="tranid" >
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
						</div>
						<label class="col-sm-1 control-label">NickName:</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id="nickname" name="nickname" >
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
						</div>
						<label class="col-sm-1 control-label">Mệnh giá:</label>
						<div class="col-sm-2">
							<select id="price" name="price" class="form-control">
								<option value="">Chọn</option>
								<option value="10000">10K</option>
								<option value="20000">20K</option>
								<option value="50000">50K</option>
								<option value="100000">100K </option>
								<option value="200000">200K</option>
								<option value="500000">500K</option>
								<option value="1000000">1M</option>
								<option value="2000000">2M</option>
							</select>
						</div>
					</div>
				</div >
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
						</div>
						<label class="col-sm-1 control-label">Trạng thái:</label>
						<div class="col-sm-2">
							<select id="status" name="status" class="form-control">
								<option value="">Chọn</option>
								<option value="0">Thành công</option>
								<option value="1">Đang xử lý</option>
								<option value="-1">Thất bại</option>
								
							</select>
						</div>
					</div>
				</div >
				<div class="form-group">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-2">
							<input type="button" value="Tìm kiếm"
							class="btn btn-success pull-left" id="search" name="search">
						</div>
						<div class="col-sm-4"></div>
					</div>
				</div>
			</form>
						<div style="width: 100%;float: left;color: #ff0000;" id="error"></div>
                    <div class="col-sm-12">
                        
 						<div id="logaction"></div>
                        <div id="spinner" class="spinner" style="display:none;">
                            <img id="img-spinner" src="<?php echo public_url('admin/images/gif-load.gif') ?>"
                                 alt="Loading"/>
                        </div>
                        <div class="text-center pull-right">
                            <ul id="pagination-demo" class="pagination-lg"></ul>
                            <ul id="pagination-demosearch" class="pagination-lg"></ul>
                        </div>
                        <div id="resultsearch" class="callout callout-danger" style="display: none">
				          
				        </div>	
                    </div>
		</div>
	 </div>
   </div>
</div>
</section>
<script type="text/javascript">
	$(function () {
		$('#datetimepicker1').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		$('#datetimepicker2').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss'
		});
		});
	$("#search").click(function(){

		 getthenap();
	});
	$(document).ready(function(){
		 getthenap();
	});
	function getthenap(){
		$("#resultsearch").html("");
		var result="";
		var stt=1;
		$.ajax({
            type: "POST",
            url: "<?php echo base_url('TranferAjax/getTheVTC') ?>",
            data: {
                nickname: $("#nickname").val(),
                fromdate: $("#fromdate").val().replace(/[-:  +]/g, ''),
                todate: $("#todate").val().replace(/[-:  +]/g, ''),
                status: $("#status").val(),
                tranid: $("#tranid").val(),
                price: $("#price").val(),
                p: 1
            },
            dataType: 'json',
            success: function (response) {
                $("#spinner").hide();
				$("#error").html("");
				$("#resultsearch").hide();
				if(response.trans!=""){
				result+='<table id="sum_table" class="table table-bordered table-hover" style="table-layout: fixed;word-wrap: break-word;">';
				result+='<thead>';
				result+=' <tr class="titlerow">';
				result+='  <td>STT</td>';
				result+='  <td>Mã giao dịch</td>';
				result+=' <td>Nick name</td>';
				result+='  <td>Mệnh giá</td>';
				result+='  <td>Mã lỗi</td>';
				result+='  <td>Mô tả</td>';
				result+='  <td>Thời gian yêu cầu</td>';
				result+='  <td>Thời gian đáp ứng</td>';
				result+='</tr>';
				result+=' </thead>';
				result+=' <tbody id="logaction">';
	               $.each(response.trans, function (index, value) {
	               		result+=resultvtc(stt,value.transId,value.nickName,value.price,value.responseCode,value.description,value.timeRequest,value.timeResponse);
	               		stt++;
	               });
				result+='</tbody>';
				result+='   </table>';
	               $("#logaction").html(result);
	                $('#pagination-demo').css("display", "block");
                    $('#pagination-demo').twbsPagination({
                        totalPages: 10,
                        visiblePages: 5,
                        onPageClick: function (event, page) {
                            oldpage = page;
                            if (page > 0) {
                                var result = "";
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url('TranferAjax/getTheVTC') ?>",
                                    data: {
                                        nickname: $("#nickname").val(),
						                fromdate: $("#fromdate").val().replace(/[-:  +]/g, ''),
						                todate: $("#todate").val().replace(/[-:  +]/g, ''),
						                status: $("#status").val(),
						                tranid: $("#tranid").val(),
						                price: $("#price").val(),
                                        p: page
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        $("#spinner").hide();
										$("#error").html("");
										$("#resultsearch").hide();
                                        stt = 1;
                                        result+='<table id="sum_table" class="table table-bordered table-hover" style="table-layout: fixed;word-wrap: break-word;">';
										result+='<thead>';
										result+=' <tr class="titlerow">';
										result+='  <td>STT</td>';
										result+='  <td>Mã giao dịch</td>';
										result+=' <td>Nick name</td>';
										result+='  <td>Mệnh giá</td>';
										result+='  <td>Mã lỗi</td>';
										result+='  <td>Mô tả</td>';
										result+='  <td>Thời gian yêu cầu</td>';
										result+='  <td>Thời gian đáp ứng</td>';
										result+='</tr>';
										result+=' </thead>';
										result+=' <tbody id="logaction">';
                                        $.each(response.trans, function (index, value) {
                                            result+=resultvtc(stt,value.transId,value.nickName,value.price,value.responseCode,value.description,value.timeRequest,value.timeResponse);
	               							stt++;
                                        });
                                        result+='</tbody>';
										result+='   </table>';
                                        $('#logaction').html(result);
                                        $('#pagination-demo').css("display", "block");
                                    }
									,error: function(){
										$("#spinner").hide();
										$("#error").html("Kết nối không ổn định.Vui lòng thử lại sau");          
									},
									timeout:30000
                                });
                            }
                        }
                    });
            	}
            	else{
            		$("#resultsearch").show();
            		 $('#pagination-demo').css("display", "none");
                    $("#resultsearch").html("Không tìm thấy kết quả");
                    $('#logaction').html(result);
            	}
            }
			,error: function(){
				$("#spinner").hide();
				$("#error").html("Kết nối không ổn định.Vui lòng thử lại sau");          
			},
			timeout:30000
        });

	}
	function resultvtc(stt, tranid, nickname, price, errorCode, description,createDate, updateDate) {
        var rs = "";
        rs += "<tr>";
        rs += "<td>" + stt + "</td>";
        rs += "<td >" + tranid + "</td>";
        rs += "<td >" + nickname + "</td>";
        rs += "<td>" +commaSeparateNumber(price) + "</td>";
        rs += "<td>" + errorCode + "</td>";
        rs += "<td>" + description + "</td>";
        rs += "<td>" + createDate + "</td>";
        rs += "<td>" + updateDate + "</td>";
        rs += "</tr>";
        return rs;
    }
     function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }
</script>