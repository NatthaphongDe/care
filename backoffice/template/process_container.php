
<?php
if($_GET["method"]=="getProcess_form"){
  include("../../config/config.php");
  include("../class/main.class.php");
  include("../class/employee.class.php");
  include("../class/case.class.php");

  $caseOpn_cls = new case_open();
  $caseDtl_cls = new case_detail();
  $member_cls = new member_base();

  $caseDtl_cls->case_id = $_GET["caseId"];

  // --ดึงข้อมูล Case --//
  $rs_case = $caseDtl_cls->getData_detailcase();
  if(count($caseDtl_cls->processType==0)){ //เช็คการนำเข้าข้อมูล "ช่องทางการร้องเรียน" จากฐานข้อมูล
    $caseDtl_cls->processType = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section);
  }
  ?>
  <!-- กระบวนการดำเนินการ (ติดต่อผู้ร้องเรียน)-->
    <div class="panel panel-form-6 panel-process" >
      <div class="panel-body">
        <div class="card">
          <div class="card-header col-sm-12 col-md-12" role="tab" id="heading_process_idx">
            <a data-toggle="collapse" class="btn-collape-process no-gutter" href="#collapse_process_idx" aria-expanded="true" aria-controls="collapse_process_idx">
              <div class="col-lg-5">
                <?php
                $statusBtn = 'btn-countdown-time-pending';
                ?>
                <button type="button" class="btn btn-round disabled btn-check-success"><!--<i class="glyph-icon icon-check"></i>--></button><button type="button" class="btn ra-100 btn-countdown-time <?php echo $statusBtn ?>" style="margin-top-3px; display:none;" rel="<?php echo $case_processInit_idx[$i]["process_save_datetime_ctd"] ?>">In Process | <span class="clock" id="clock<?php echo $case_processInit_idx[$i]["process_id"] ?>">xx วัน xx:xx นาที</span></button>
              </div>
              <span class="col-md-12 col-lg-6 title-process span-title"></span>
              <i class="glyph-icon icon-angle-up icon-collape"></i>
            </a>
          </div>
          <?php
          if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
            ?>
            <div id="collapse_process_idx" class="collapse in" aria-labelledby="headingOne">
              <form class="frm_case_process" name="frm_case_process" enctype="multipart/form-data" method="post" action="/" target="iframe-data">
                <div class="card-block"  id="card-block-idx">
                  <input type="hidden" name="case_id" value="<?php echo $rs_case["case"]["case_id"] ?>" />
                  <input type="hidden" name="process_id" value="0" />
                  <input type="hidden" name="process_elm" value="collapse_process_idx" />
                  <div class="panel-body" style="padding:10px;">
                    <div class="row">
                      <label class="col-lg-4 control-label required">ประเภทกระบวนการ </label>
                      <div class="col-lg-8">
                          <select name="process_type_id" class="select-type-process select-picker" data-live-search="true"  data-width="100%">
                            <option value="" selected style="color:#777">--- กรุณาเลือกประเภทกระบวนการ ---</option>
                            <?php
                            $process_deptType = $caseDtl_cls->caseProcessTypeList(null,$caseDtl_cls->admin_section,"dept_type");
                            foreach($caseDtl_cls->processType as $key => $value){
                                ?>
                                <option value="<?php echo $key ?>" rel="<?php echo $process_deptType[$key] ?>">
                                  <?php echo $value ?>
                                </option>
                                <?php
                            }
                            ?>
                          </select>
                      </div>
                    </div>
                  </div>
                    <?php
                    $departmentList = $caseDtl_cls->departmentList();
                    //print_r($departmentList["ct"]);
                    ?>
                  <div class="panel-body panel-department" style="padding:10px; display:none;">
                    <div class="row">
                      <label class="col-lg-4 control-label required">หน่วยงานผู้ติดต่อ</label>
                      <div class="col-lg-8">
                        <select class="process_dept_id_demo" style="display:none;">
                          <option value="" selected rel="0" style="color:#777">--- กรุณาเลือกหน่วยงานผู้ติดต่อ ---</option>
                          <?php
                          $optDept = '';
                          foreach($departmentList["ctn"] as $ctnList){
                              $optDept .= '<option data-content="<span style=\'padding-left:0px;\'>'.$ctnList["name"].'</span>" disabled rel="'.$ctnList["dept_type"].'"></option>';
                                foreach($departmentList["ct"] as $ctList){
                                  if($ctList["continent_code"]==$ctnList["code"]){
                                    $optDept .= '<option data-content="<span style=\'padding-left:20px;\'><h style=\'display:none;\'>'.$ctnList["name"].'</h>'.$ctList["name"].'</span>" disabled rel="'.$ctList["dept_type"].'"></option>';
                                    foreach($departmentList["dept"] as $deptList){
                                      if($deptList["dept_type"]==$ctList["dept_type"] && $deptList["country_id"]==$ctList["id"]){

                                        $optDept .= '<option value="'.$deptList["dept_id"].'" data-content="<span style=\'padding-left:40px;\'><h style=\'display:none;\'>'.$ctnList["name"].'/'.$ctList["name"].'</h>'.$deptList["dept_name"].'</span>"  rel="'.$deptList["dept_type"].'">
                                          '.$deptList["dept_name"].'
                                        </option>';
                                      }
                                    }
                                  }
                                }
                          }
                          foreach($departmentList["dept"] as $deptList){
                            if($deptList["dept_type"]!="3"){
                              $optDept .= '<option value="'.$deptList["dept_id"].'"  rel="'.$deptList["dept_type"].'">
                                '.$deptList["dept_name"].'
                              </option>';
                            }
                          }
                          echo $optDept;
                          ?>
                        </select>

                        <select name="process_dept_id" class="custom-select select-type-dept process_dept_id select-picker" data-live-search="true"  data-width="100%">
                          <option value="" rel="0" selected style="color:#777">--- กรุณาเลือกหน่วยงานผู้ติดต่อ ---</option>
                          <?php
                          $optDept = '';
                          foreach($departmentList["ctn"] as $ctnList){
                              $optDept .= '<option data-content="<span style=\'padding-left:0px;\'>'.$ctnList["name"].'</span>" disabled rel="'.$ctnList["dept_type"].'"></option>';
                                foreach($departmentList["ct"] as $ctList){
                                  if($ctList["continent_code"]==$ctnList["code"]){
                                    $optDept .= '<option data-content="<span style=\'padding-left:20px;\'><h style=\'display:none;\'>'.$ctnList["name"].'</h>'.$ctList["name"].'</span>" disabled rel="'.$ctList["dept_type"].'"></option>';
                                    foreach($departmentList["dept"] as $deptList){
                                      if($deptList["dept_type"]==$ctList["dept_type"] && $deptList["country_id"]==$ctList["id"]){

                                        $optDept .= '<option value="'.$deptList["dept_id"].'" data-content="<span style=\'padding-left:40px;\'><h style=\'display:none;\'>'.$ctnList["name"].'/'.$ctList["name"].'</h>'.$deptList["dept_name"].'</span>"  rel="'.$deptList["dept_type"].'">
                                          '.$deptList["dept_name"].'
                                        </option>';
                                      }
                                    }
                                  }
                                }
                          }
                          foreach($departmentList["dept"] as $deptList){
                            if($deptList["dept_type"]!="3"){
                              $optDept .= '<option value="'.$deptList["dept_id"].'"  rel="'.$deptList["dept_type"].'">
                                '.$deptList["dept_name"].'
                              </option>';
                            }
                          }
                          echo $optDept;
                          ?>
                        </select>
                      </div>
                    </div>
                    <?php
                    foreach($departmentList["dept"] as $deptList){
                      if($case_processInit_idx[$i]["dept_id"]==$deptList["dept_id"]){
                        $dept_type = $deptList["dept_type"];
                        $dept_affiliation = $deptList["dept_affiliation"];
                        $dept_director = $deptList["dept_director"];
                        $dept_assistant = $deptList["dept_assistant"];
                        $dept_tel = $deptList["dept_tel"];
                        $dept_fax = $deptList["dept_fax"];
                        $dept_email = $deptList["dept_email"];
                        $dept_address = $deptList["dept_address"];
                      }
                    }
                    ?>
                    <script>
                    $(function(){
                      $(".typeDept").hide();
                      $(".typeDept_<?php echo $dept_type ?>").show();
                    });
                    </script>
                    <div class="row no-gutter panel-department-data">
                      <div class="col-lg-12 no-gutter no-margin">
                        <div class="row typeDept typeDept_2">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray ">
                                สั่งกัด
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                              <?php echo $dept_affiliation ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                ชื่อผู้อำนวยการ
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_director">
                                <?php echo $dept_director ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                ชื่อผู้ช่วย/ผู้ประสานงาน
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_assistant">
                                <?php echo $dept_assistant ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                หมายเลขโทรศัพท์
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_tel">
                                <?php echo $dept_tel ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                หมายเลขแฟกซ์
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_fax">
                                <?php echo $dept_fax ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_1 typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                อีเมล
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_email">
                                <?php echo $dept_email ?>
                              </label>
                          </div>
                        </div>
                        <div class="row typeDept typeDept_2 typeDept_3">
                          <div class="form-group col-lg-4">
                              <label class="control-label text-data-light text-data-gray">
                                ที่อยู่
                              </label>
                          </div>
                          <div class="form-group col-lg-8">
                              <label class="control-label typeDept_text text-data-light" id="dept_address">
                                <?php echo $dept_address ?>
                              </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-12 no-gutter no-margin new-dep-1" style="display: none;">
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            ชื่อ
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['applnt_firstname']."  ".$rs_case['case_feild']['applnt_lastname']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            E-Mail
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['applnt_email']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            เบอร์โทรศัพท์
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['applnt_tel']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            เบอร์โทรศัพท์มือถือ
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['applnt_mobile']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            ที่อยู่ติดต่อ
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['applnt_address']; ?>
                          </label>
                      </div>
                    </div>
                  </div>


                  <div class="col-lg-12 no-gutter no-margin new-dep-2" style="display: none;">
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            ชื่อบริษัท
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['complnt_name']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            ชื่อที่ติดต่อ
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['complnt_contact_name']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            E-Mail
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['complnt_contact_email']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            เบอร์โทรศัพท์
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['complnt_contact_tel']; ?>
                          </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-lg-4">
                          <label class="control-label text-data-light text-data-gray ">
                            ที่อยู่ติดต่อ
                          </label>
                      </div>
                      <div class="form-group col-lg-8">
                          <label class="control-label typeDept_text text-data-light" id="dept_affiliation">
                            <?php echo $rs_case['case_feild']['complnt_contact_address']; ?>
                          </label>
                      </div>
                    </div>
                  </div>


                  <div class="row panel-pad-10 groupDocument" id="groupDocument_type_2"  style="margin-bottom:0px;" >
                    <div class="col-lg-12 panel-body-bg2">
                      <div class="row">
                        <div class="form-group col-lg-2">
                            <label class="control-label text-data-light text-data-gray">
                              หมายเลขเอกสารออก
                            </label>
                            <input type="hidden" name="procPropMail_type_2[]" value="2" />
                        </div>
                          <div class="form-group col-lg-3">
                            <input type="text" class="form-control" name="procPropMail_number_2[]"  />
                          </div>
                          <div class="form-group col-lg-3">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                  <span class="fileinput-new">Browse</span>
                                  <span class="fileinput-exists">Change</span>
                                  <input type="file" class="procPropMail_file" name="procPropMail_file_2[]">
                                </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_2[]" >
                              <span class="input-group-addon input-group-addon-calendar bg-black">
                                <i class="glyph-icon icon-calendar"></i>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-lg-2">
                            <div class="input-group">
                            <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_2[]" >
                              <span class="input-group-addon bg-black">
                                <i class="glyph-icon icon-clock-o"></i>
                              </span>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-lg-2">
                            <label class="control-label text-data-light text-data-gray">
                              ชื่อเรื่อง
                            </label>
                        </div>
                        <div class="form-group col-lg-10">
                          <input type="text" class="form-control" name="process_title_2"  />
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-lg-2">
                            <label class="control-label text-data-light text-data-gray">
                              ถึง
                            </label>
                        </div>
                        <div class="form-group col-lg-10">
                          <input type="text" class="form-control" name="process_to_2"  />
                        </div>
                      </div>
                      <hr />

                        <div class="row no-gutter row_tel_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropTel2" class="procPropTel procProp" value="1">
                                <label>
                                  โทรศัพท์
                                </label>
                              </div>
                            </div>
                            <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropTel_id_2[]" />
                              <input type="text" class="form-control" name="procPropTel_number_2[]" />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_2[]"  >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_2[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <a href="javascript:void(0)" class="btn-add-tel" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      <hr />
                        <div class="row no-gutter row_fax_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropFax2" class="procPropFax procProp" value="1">
                                <label>
                                  FAX
                                </label>
                              </div>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropFax_id_2[]" />
                              <input type="text" class="form-control" name="procPropFax_number_2[]"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_2[]" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropFax_time_2[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <a href="javascript:void(0)" class="btn-add-fax" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      <hr />
                        <div class="row no-gutter row_email_proc row_proc">
                          <div class="col-lg-12">

                            <div class="col-md-12 no-gutter">
                              <div class="form-group col-lg-2">
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropEmail2" class="procPropEmail procProp" value="1">
                                  <label>
                                    EMAIL
                                  </label>
                                </div>
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <input type="hidden" class="form-control" name="procPropEmail_id_2[]" />
                                <label class="control-label text-data-light text-data-size16 text-data-gray required">ถึง</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <input type="text" class="form-control procPropEmail_address" name="procPropEmail_address_2[]" placeholder="email@gmail.com"  />
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-md-12 no-gutter">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">เรื่อง</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <input type="text" class="form-control procPropEmail_subject" name="procPropEmail_subject_2[]"  />
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-md-12 no-gutter">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ข้อความ</label>
                              </div>
                              <div class="form-group col-lg-7">
                                <textarea name="procPropEmail_message_2[]" rows="3" id="ckeditor_idx" class="ckeditor form-control textarea-no-resize procPropEmail_message" placeholder="..."></textarea>
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-md-12 no-gutter" style="margin-bottom:0;">
                              <div class="form-group col-md-2 hidden-xs hidden-sm hidden-md">
                              </div>
                              <div class="form-group col-lg-2" style="margin-bottom:0;">
                                <label class="control-label text-data-light text-data-size16 text-data-gray">ไฟล์แนบ</label>
                              </div>
                              <div class="form-group col-sm-12 col-md-12 col-lg-7 contain-email-file">
                                <input type="file" name="procPropEmail_file_2[]" id="procPropEmail_file_idx" class=" form-control procPropEmail_file" multiple />
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                            <div class="col-md-12 no-gutter contain-email-btn1">
                              <input type="hidden" class="form-control procPropEmail_datetime" name="procPropEmail_datetime_2[]" value=""  />
                              <div class="col-lg-8 hidden-xs hidden-sm hidden-md "></div>
                              <div class="col-lg-3">
                                <button type="button" class="btn btn-default btn-send-email" rel="2">
                                  <i class="glyph-icon icon-envelope-o"></i>
                                  Send
                                </button>
                              </div>
                              <div class="col-md-1 hidden-xs hidden-sm hidden-md ">
                              </div>
                            </div>
                          </div>
                        </div>
                      <hr />
                        <div class="row no-gutter row_tracking_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropMail2" class="procPropMail procProp" value="1">
                                <label>
                                  จดหมาย
                                </label>
                              </div>
                            </div>

                            <div class="form-group col-lg-2">
                              <label class="control-label text-data-light text-data-size16 text-data-gray">Tracking number</label>
                            </div>
                            <div class="form-group col-lg-3">
                              <input type="hidden" class="form-control" name="procPropMail_id_2[]" />
                              <input type="text" class="form-control" name="procPropMail_tracking_2[]"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_tracking_2[]" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_tracking_2[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <a href="javascript:void(0)" class="btn-add-tracking" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                            </div>

                          </div>
                        </div>
                      <hr />
                        <div class="row no-gutter row_offcletter_proc row_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropOffcLetter2" class="procPropOffcLetter procProp" value="1">
                                <label>
                                  หนังสือราชการ
                                </label>
                              </div>
                            </div>
                            <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropOffcLetter_id_2[]" />
                              <input type="text" class="form-control" name="procPropOffcLetter_number_2[]"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_2[]" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker" name="procPropOffcLetter_time_2[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <a href="javascript:void(0)" class="btn-add-offcletter" rel="2">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row panel-pad-10 groupDocument" id="groupDocument_type_1" >
                      <div class="col-lg-12 panel-body-bg2">
                        <div class="row">
                          <div class="form-group col-lg-2">
                              <label class="control-label text-data-light text-data-gray">
                                หมายเลขเอกสารเข้า
                              </label>
                              <input type="hidden" name="procPropMail_type_1[]" value="1" />
                          </div>
                            <div class="form-group col-lg-3">
                              <input type="text" class="form-control" name="procPropMail_number_1[]"  />
                            </div>
                            <div class="form-group col-lg-3">
                              <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                  <div class="form-control" data-trigger="fileinput">
                                      <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                      <span class="fileinput-filename"></span>
                                  </div>
                                  <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Browse</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" class="procPropMail_file" name="procPropDoc_file_1[]">
                                  </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropMail_date_1[]" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropMail_time_1[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-lg-2">
                              <label class="control-label text-data-light text-data-gray">
                                ชื่อเรื่อง
                              </label>
                          </div>
                          <div class="form-group col-lg-10">
                            <input type="text" class="form-control" name="process_title_1"  />
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-lg-2">
                              <label class="control-label text-data-light text-data-gray">
                                ถึง
                              </label>
                          </div>
                          <div class="form-group col-lg-10">
                            <input type="text" class="form-control" name="process_to_1"  />
                          </div>
                        </div>
                        <hr />
                          <div class="row no-gutter row_tel_proc row_proc">
                            <div class="col-lg-12">
                              <div class="form-group col-lg-2">
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropTel1" class="procPropTel procProp" value="1">
                                  <label>
                                    โทรศัพท์
                                  </label>
                                </div>
                              </div>
                              <div class="form-group col-lg-5">
                                <input type="hidden" class="form-control" name="procPropTel_id_1[]" />
                                <input type="text" class="form-control" name="procPropTel_number_1[]"  />
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropTel_date_1[]" >
                                  <span class="input-group-addon input-group-addon-calendar bg-black">
                                    <i class="glyph-icon icon-calendar"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-timepicker"  name="procPropTel_time_1[]" >
                                  <span class="input-group-addon bg-black">
                                    <i class="glyph-icon icon-clock-o"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-1">
                                <a href="javascript:void(0)" class="btn-add-tel" rel="1">
                                  <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        <hr />
                          <div class="row no-gutter row_fax_proc row_proc">
                            <div class="col-lg-12">
                              <div class="form-group col-lg-2">
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropFax1" class="procPropFax procProp" value="1">
                                  <label>
                                    FAX
                                  </label>
                                </div>
                              </div>
                              <div class="form-group col-lg-5">
                              <input type="hidden" class="form-control" name="procPropFax_id_1[]" />
                                <input type="text" class="form-control" name="procPropFax_number_1[]"  />
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropFax_date_1[]" >
                                  <span class="input-group-addon input-group-addon-calendar bg-black">
                                    <i class="glyph-icon icon-calendar"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-timepicker"  name="procPropFax_time_1[]" >
                                  <span class="input-group-addon bg-black">
                                    <i class="glyph-icon icon-clock-o"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-1">
                                <a href="javascript:void(0)" class="btn-add-fax" rel="1">
                                  <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        <hr />
                        <div class="row no-gutter row_email1_proc">
                          <div class="col-lg-12">
                            <div class="form-group col-lg-2">
                              <div class="checkbox checkbox-padleft-20">
                                <input type="checkbox" name="procPropEmail1" class="procPropEmail procProp" value="1">
                                <label>
                                  Email
                                </label>
                              </div>
                            </div>
                            <div class="form-group col-lg-5">
                            <input type="hidden" class="form-control" name="procPropEmail_id_1[]"  />
                              <input type="text" class="form-control" name="procPropEmail_number_1[]"  />
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropEmail_date_1[]" >
                                <span class="input-group-addon input-group-addon-calendar bg-black">
                                  <i class="glyph-icon icon-calendar"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-2">
                              <div class="input-group">
                              <input type="text" class="form-control bootstrap-timepicker"  name="procPropEmail_time_1[]" >
                                <span class="input-group-addon bg-black">
                                  <i class="glyph-icon icon-clock-o"></i>
                                </span>
                              </div>
                            </div>
                            <div class="form-group col-lg-1">
                              <a href="javascript:void(0);" class="btn-add-email1" rel="1">
                                <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                        <hr />
                          <div class="row no-gutter row_tracking_proc row_proc">
                            <div class="col-lg-12">
                              <div class="form-group col-lg-2">
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox"  name="procPropMail1" class="procPropMail procProp" value="1">
                                  <input type="hidden" class="form-control" name="procPropMail_id_1[]" />
                                  <label>
                                    จดหมาย
                                  </label>
                                </div>
                              </div>

                            </div>
                          </div>
                        <hr />
                          <div class="row no-gutter row_offcletter_proc row_proc">
                            <div class="col-lg-12">
                              <div class="form-group col-lg-2">
                                <div class="checkbox checkbox-padleft-20">
                                  <input type="checkbox" name="procPropOffcLetter1" class="procPropOffcLetter procProp" value="1">
                                  <label>
                                    หนังสือราชการ
                                  </label>
                                </div>
                              </div>
                              <div class="form-group col-lg-5">
                                <input type="hidden" class="form-control" name="procPropOffcLetter_id_1[]" />
                                <input type="text" class="form-control" name="procPropOffcLetter_number_1[]"  />
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-datepicker-process" readonly name="procPropOffcLetter_date_1[]" >
                                  <span class="input-group-addon input-group-addon-calendar bg-black">
                                    <i class="glyph-icon icon-calendar"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-2">
                                <div class="input-group">
                                <input type="text" class="form-control bootstrap-timepicker"  name="procPropOffcLetter_time_1[]" >
                                  <span class="input-group-addon bg-black">
                                    <i class="glyph-icon icon-clock-o"></i>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-lg-1">
                                <a href="javascript:void(0)" class="btn-add-offcletter" rel="1">
                                  <i class="ditp-icon icon-ico-ditp-21 icon-add-channel"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group col-lg-2">
                            <label class="text-data-light text-data-gray">
                              หมายเหตุ
                            </label>
                        </div>
                        <div class="col-lg-10">
                          <textarea name="process_note" rows="3" class="form-control textarea-no-resize"></textarea>
                        </div>
                      </div>
                    </div>

                    <input type="hidden" class="removeProcessTelId" name="removeProcessTelId" value="" />
                    <input type="hidden" class="removeProcessFaxId" name="removeProcessFaxId" value="" />
                    <input type="hidden" class="removeProcessMailId" name="removeProcessMailId" value="" />
                    <input type="hidden" class="removeProcessOffcletterId" name="removeProcessOffcletterId" value="" />
                    <?php
                    if($rs_case["case"]["my_case_assign"]==1){
                      ?>
                      <div class="form-group col-sm-12 div-text-center">
                        <?php
                        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"save_process")[3]==1 && $_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
                          ?>
                          <button type="button" class="btn btn-success btn-float-center btn-save-process-list" style="margin-top:10px;">บันทึก</button>
                          <?php
                        }
                        ?>
                        <button type="button" class="btn btn-warning btn-float-center btn-cancle-process-list" style="margin-top:10px;">ยกเลิก</button>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>

  <!-- /กระบวนการดำเนินการ (ติดต่อผู้ร้องเรียน)-->

  <?php
}
 ?>
