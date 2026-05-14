
		<div class="modal fade" id="modal_chk_transfer" tabindex="-1" role="dialog" aria-labelledby="modal_chk_transfer" style="padding:0px;">
			<div class="modal-dialog modal_chk_transfer" role="document">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
                <span class="hr_transfer">โอนเรื่องร้องเรียน</span>
              <div class="close_modal" style="float: right; padding-bottom: 10px; padding-right: 10px;">
                <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true">
                <i class="ditp-icon icon-ico-ditp-20" aria-hidden="true"></i>
              </a>
              </div>
            </div>
          </div>
					<div class="modal-body">
						<div class="row" style="margin-bottom:30px;">
							<div class="box-add-modal-group">

						</div>
					</div>
          <div class="row">

            <div class="col-md-3">สำนัก <span style="color:red;">*</span></div>
            <div class="col-md-9">
              <select class="selectpicker form-control" name="office_type">

                <option value=""> -- เลือกสำนัก -- </option>
                <?php
								if($_SESSION['admin']['office'] == "0"){
									?>
									<option value="0" data-content="<span class='text'>สำนักสารสนเทศและการบริการการค้าระหว่างประเทศ <font style='color:#e37220'>(โอนกลับ)</font></span>"> </option>
									<?php
								}
                if(count($caseOpn_cls->office==0)){
                  $caseOpn_cls->office = $caseOpn_cls->office(0);
                }
                foreach($caseOpn_cls->office as $office){
									if($office['office_id']!=$rs_case["case"]["office_id"]){
									?>
	                  <option value="<?php echo $office['office_id']?>"> <?php echo $office['office_name']?></option>
	                <?php
									}
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row" style="margin-top:20px;">
            <div class="col-md-3">รายละเอียด <span style="color:red;">*</span></div>
            <div class="col-md-9">
              <textarea class="form-control" name="note_detail"></textarea>
            </div>
          </div>


					<!--  -->


					<div class="panel panel-timeline" style="margin-top:30px;">
				    <div class="panel-body panel-pad-20">
				      <div class="row">
				        <div class="col-xs-12">
				          <h3 class="title-hero col-xs-12">
				            <span>ข้อมูลการโอน</span>
				          </h3>
				        </div>
				      </div>
							<?php
							if(count($rs_case["case_transfer"])==0){
				        ?>
				        <div class="row">
				          <div class="col-md-12">
				            <ul class="chat-box">
				              <li class="no-gutter" style="padding-top:0;">

				                <div class="col-xs-12">
				                  <p style="text-align:center; color:#ccc;">ไม่มีรายการโอนเรื่องร้อนเรียน</p>
				                </div>
				              </li>
				            </ul>
				          </div>
				        </div>
				        <?php
				      }else{
								foreach ($rs_case["case_transfer"] as $case_transfer) {
									?>
									<div class="row">
				            <div class="col-xs-12">
				              <ul class="chat-box">
				                <li class="no-gutter">
				                  <div class="col-xs-3" style="text-align:center">
				                    <div class="status-badge img-circle">
				                      <img src="<?php echo $case_transfer["emp_img_path_s"]; ?>" style="<?php echo $caseLst_cls->getPositionImage($case_transfer["emp_img_path_s"],50) ?>" alt="<?php echo $case_transfer["emp_img_path_s"]; ?>">
				                    </div>
				                  </div>

				                  <div class="col-xs-9">
				                    <p class="col-xs-12 p-emp">
				                      ผู้โอน : <?php echo $case_transfer["emp_firstname"] ?> <?php echo $case_transfer["emp_lastname"] ?><br />
															สำนัก : <?php echo $case_transfer["office_name_short"] ?>
														</p>
				                    <p class="col-xs-12 p-date">
															<?php echo date('d/m/Y h:i A', strtotime($case_transfer["transfer_date"])); ?>
														</p>

				                    <p class="col-xs-12 p-message"><font style="color:#000;">โอนจาก: </font><?php echo $caseOpn_cls->office_data($case_transfer["transfer_officeID_for"])["office_name_short"] ?> ไปยัง <?php echo $caseOpn_cls->office_data($case_transfer["transfer_officeID_to"])["office_name_short"] ?></p>
														<table class="col-xs-12 p-message" style="text-align: left;">
															<tr>
																<td style="padding-left:10px; width:80px; vertical-align:top;">
																	<font style="color:#000;">รายละเอียด: </font>
																</td>
																	<td style=" vertical-align:top;">
																		<?php echo $case_transfer["transfer_detail"] ?>
																	</td>
															</tr>
														</table>
				                  </div>
				                </li>
				              </ul>
				            </div>
				          </div>
									<?php
								}
							}
							?>
            </div>
					</div>


				</div>
        <div class="modal-footer modal-footer" style="text-align: right;">
          <button type="button" class="btn btn-success" onclick="saveTransfer_Log(<?=$rs_case["case"]["case_id"]?>,<?=$_SESSION["admin"]["office"]?>);">ยืนยัน</button>
        </div>
			</div>
		</div>
	</div>
