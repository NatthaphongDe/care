<?php
if($type_size_windows=="desktop"){
  // print_r($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"form")[1]);
  ?>
  <div id="page-sidebar" class="bg-gradient-7 font-inverse page-sidebar-desktop">
    <div class="scroll-sidebar">


      <div id="header-logo" class="logo-bg">
        <a href="index.php" class="logo-content-big" title="DITP">
          <img src="img/logo-DITP.png" class="logo-ditp" />
        </a>
        <a href="index.php" class="logo-content-small" title="DITP">
          <img src="img/logo-DITP.png" class="logo-ditp" />
        </a>
      </div>
      <ul id="sidebar-menu" class="sidebar-menu">
        <?php
        if( ($member_cls->checkPrivilege( $_SESSION["admin"]["empPosition"],"dashboard/dashboard")[1]==1 || $_SESSION["admin"]["empPosition"] == 1) && $_SESSION["admin"]["office"] == 0 ){
          // if( ($_SESSION["admin"]["login_as"] == 1 && $_SESSION["admin"]["office"] == 0) || $_SESSION["admin"]["office"] == 0 ){
        ?>
          <li class="no-menu">
            <a href="/backoffice/index.php?page=dashboard/dashboard" title="Dashboard"  class="<?php echo $class_sfActive_dashboard ?>">
              <i class="ditp-icon icon-ico-ditp-01"></i>
              <span>Dashboard </span>
            </a>
          </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"case_list")[1]==1 || $_SESSION["admin"]["empPosition"]==6 || $_SESSION["admin"]["empPosition"]==7 || $_SESSION["admin"]["empPosition"]==8){
        ?>
        <li class="no-menu">
          <a href="index.php?page=case_list" title="เรื่องร้องเรียนทั้งหมด" class="<?php echo $class_sfActive_case ?>">
            <i class="ditp-icon icon-ico-ditp-02"></i>
            <span>เรื่องร้องเรียนทั้งหมด </span>
          </a>

        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"knowledge/knowledge")[1]==1){
        ?>
        <li class="no-menu">
          <a href="/backoffice/setting/index.php?page=knowledge/knowledge" title="เรื่องร้องเรียนทั้งหมด" class="<?php echo $class_sfActive_knowledge ?>">
            <i class="ditp-icon icon-ico-ditp-41"></i>
            <span>องค์ความรู้เรื่องร้องเรียน</span>
          </a>
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"Individual/contact_thai")[1]==1
        || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"corporate/corporate_thai")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_Individual ?>">
          <a href="#" title="ฐานข้อมูลผู้ติดต่อ" class="sf-with-ul <?php echo $class_sfActive_Individual ?>">
              <i class="ditp-icon icon-ico-ditp-42"></i>
              <span>ฐานข้อมูลผู้ติดต่อ</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_Individual ?>">
              <ul>
                <?php
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"Individual/contact_thai")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=Individual/contact_thai" title="บุคคลธรรมดาในไทย">บุคคลธรรมดาในไทย</a></li>
                  <li><a href="/backoffice/setting/index.php?page=Individual/contact_inter" title="บุคคลธรรมดาในต่างประเทศ">บุคคลธรรมดาในต่างประเทศ</a></li>
                  <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"corporate/corporate_thai")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=corporate/corporate_thai" title="นิติบุคคลในไทย">นิติบุคคลในไทย</a></li>
                  <li><a href="/backoffice/setting/index.php?page=corporate/corporate_inter" title="นิติบุคคลในต่างประเทศ">นิติบุคคลในต่างประเทศ</a></li>
                  <?php
                }
                ?>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/application")[1]==1
          || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/management_admin")[1]==1
          || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/group")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_admin ?>">
          <a href="#" title="จัดการผู้ใช้" class="sf-with-ul <?php echo $class_sfActive_admin ?>">
              <i class="ditp-icon icon-ico-ditp-04"></i>
              <span>จัดการผู้ใช้</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_admin ?>">
            <ul>
                <?php
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/application")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=user/application" title="สมาชิก DITP Application">DITP Application member</a></li>
                  <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/management_admin")[1]==1){
                ?>
                  <li><a href="/backoffice/setting/index.php?page=user/management_admin" title="การจัดการผู้ดูแลระบบ">DITP care user</a></li>
                <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/group")[1]==1){
                  ?>
                    <li><a href="/backoffice/setting/index.php?page=user/group" title="การจัดการกลุ่มผู้ดูแลระบบ">Group Management</a></li>
                  <?php
                }
                ?>
            </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        // if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"channel")[1]==1){
          if( ($member_cls->checkPrivilege( $_SESSION["admin"]["empPosition"],"dashboard/dashboard")[1]==1 || $_SESSION["admin"]["empPosition"] == 1) && $_SESSION["admin"]["office"] == 0 ){
        ?>
        <li class="<?php echo $class_sfHover_setting ?>">
          <a href="#" title="ตั้งค่าระบบ" class="sf-with-ul <?php echo $class_sfActive_setting ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ตั้งค่าระบบ</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting ?>">
            <ul>
            <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"report/report_issue")[1]==1){ ?>
              <li><a href="/backoffice/setting/index.php?page=complaint" title="ประเภทเรื่องร้องเรียน">ประเภทเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=department" title="หน่วยงาน">หน่วยงาน</a></li>
              <?php } else{ ?>
              <li><a href="/backoffice/setting/index.php?page=complaint" title="ประเภทเรื่องร้องเรียน">ประเภทเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=process" title="ประเภทกระบวนการ">ประเภทกระบวนการ</a></li>
              <li><a href="/backoffice/setting/index.php?page=channel" title="ช่องทางการรับเรื่องร้องเรียน">ช่องทางการรับเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=product" title="ประเภทสินค้า">สินค้า</a></li>
              <li><a href="/backoffice/setting/index.php?page=incorrect" title="ประเภทความผิด">ประเภทความผิด</a></li>
              <li><a href="/backoffice/setting/index.php?page=department" title="หน่วยงาน">หน่วยงาน</a></li>
              <li><a href="/backoffice/setting/index.php?page=country" title="ประเภทสินค้า">ประเทศ</a></li>
              <li><a href="/backoffice/setting/index.php?page=blacklist" title="Blacklist">Blacklist</a></li>
              <li><a href="/backoffice/setting/index.php?page=priority" title="Priority">Priority</a></li>
              <?php } ?>
            </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"noti_complaint")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_setting2 ?>">
          <a href="#" title="ตั้งค่าการแจ้งเตือน" class="sf-with-ul <?php echo $class_sfActive_setting2 ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ตั้งค่าการแจ้งเตือน</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting2 ?>">
              <ul>
                  <li><a href="/backoffice/setting/index.php?page=noti_complaint" title="การแจ้งเตือนผู้ร้องเรียน">การแจ้งเตือนผู้ร้องเรียน</a></li>
                  <li><a href="/backoffice/setting/index.php?page=noti_user" title="การแจ้งเตือนผู้ใช้ระบบ">การแจ้งเตือนผู้ใช้ระบบ</a></li>
                  <li><a href="/backoffice/setting/index.php?page=holiday" title="ตั้งค่าวันหยุดราชการ">ตั้งค่าวันหยุดราชการ</a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"form")[1]==2){
        ?>
        <li class="no-menu">
          <a href="/backoffice/setting/index.php?page=form" title="ระบบจัดการฟอร์ม" class="<?php echo $class_sfActive_from ?>">
                <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ระบบจัดการฟอร์ม</span>
          </a>
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"channel")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_setting_fnt ?>">
          <a href="#" title="ระบบจัดการ Frontend" class="sf-with-ul <?php echo $class_sfActive_setting_fnt ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ระบบจัดการ Frontend</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting_fnt ?>">
              <ul>
                    <li><a href="/backoffice/setting/index.php?page=banner" title="Banner">Banner</a></li>
                    <li><a href="/backoffice/setting/index.php?page=complaint_procedure" title="ขั้นตอนการร้องเรียน">ขั้นตอนการร้องเรียน</a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"report/report_issue")[1]==1){
        ?>

        <li class="<?php echo $class_sfHover_report ?>">
          <a href="#" title="Report" class="sf-with-ul <?php echo $class_sfActive_report ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>Report</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_report ?>">
              <ul>
                  <li><a href="index.php?page=report/report_issue" title="รายงานการดำเนินการ" class="<?=$active_report_issue;?>">รายงานการดำเนินการ</a></li>
                  <li><a href="index.php?page=report/report_cost" title="รายงานมูลค่าความเสียหาย" class="<?=$active_report_cost;?>">รายงานมูลค่าความเสียหาย</a></li>
                  <li><a href="index.php?page=report/report_country" title="รายงานมูลค่าความเสียหาย" class="<?=$active_report_country;?>">สถิติเรื่องร้องเรียนแยกตามประเทศผู้ร้องเรียน</a></li>
                  <li><a href="index.php?page=report/report_compare" title="รายงานมูลค่าความเสียหาย" class="<?=$active_compare;?>">สถิติเปรียบเทียบเรื่องร้องเรียน </a></li>
                  <li><a href="index.php?page=report/report_product" title="รายงานมูลค่าความเสียหาย" class="<?=$active_product;?>">สถิติเรื่องร้องเรียนแยกตามประเภทสินค้า </a></li>
                  <li><a href="index.php?page=report/report_country_thai" title="รายงานมูลค่าความเสียหาย" class="<?=$active_country_thai;?>">สถิติเรื่องร้องเรียนที่ต่างประเทศร้องเรียนประเทศไทย </a></li>
                  <li><a href="index.php?page=report/report_blacklist" title="รายงานสถานะการเฝ้าระวัง" class="<?=$active_report_blacklist;?>">รายงานสถานะการเฝ้าระวัง </a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($_SESSION["admin"]["empPosition"]!=6 && $_SESSION["admin"]["empPosition"]!=7 && $_SESSION["admin"]["empPosition"]!=8){
        ?>

        <li class="no-menu">
          <a href="index.php?page=question" title="กรอกแบบสอบถามการใช้งาน" class="<?php echo $class_sfActive_question ?>">
              <i class="ditp-icon icon-ico-ditp-27" aria-hidden="true"></i>
              <span style="margin-bottom:20px;">กรอกแบบสอบถามการใช้งาน</span>
          </a>
        </li>
        <?php
        }
        ?>

        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"admin_questionAW")[1]==1
        || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAW")[1]==1
      || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAP")[1]==1){ ?>
        <li class="<?php echo $class_sfHover_report_question ?>">
          <a href="#" title="รายงานแบบสอบถาม" class="sf-with-ul <?php echo $class_sfActive_report_question ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>รายงานแบบสอบถาม</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_report_question ?>">
            <ul>
              <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"admin_questionAW")[1]==1) { ?>
              <li><a href="index.php?page=admin_questionAW" title="รายงานแบบสอบถามการใช้งานของแอดมิน" class="<?php echo $active_admin_questionAW ?>">รายงานแบบสอบถามการใช้งานของแอดมิน</a></li>
              <?php }
              if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAW")[1]==1) {
              ?>
              <li><a href="index.php?page=frontend_questionAW" title="รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( Web )" class="<?php echo $active_frontend_questionAW ?>" >รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( Web )</a></li>
              <?php }
              if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAP")[1]==1) {
              ?>
              <!-- <li><a href="index.php?page=frontend_questionAP" title="รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( App )" class="<?php // echo $active_frontend_questionAP ?>" >รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( App )</a></li> -->
              <?php } ?>
            </ul>
          </div>
        </li>
      <?php } ?>
      </ul><!-- #sidebar-menu -->

    </div>
  </div>
  <?php
}else if($type_size_windows=="mobile"){
  ?>
  <div id="page-sidebar" class="bg-gradient-7 font-inverse page-sidebar-mobile hidden-md hidden-lg" style="margin:0;">
    <div class="scroll-sidebar">


      <div id="header-logo" class="logo-bg">
        <a href="index.html" class="logo-content-big" title="DITP">
          <img src="img/logo-DITP.png" class="logo-ditp" />
        </a>
        <a href="index.html" class="logo-content-small" title="DITP">
          <img src="img/logo-DITP.png" class="logo-ditp" />
        </a>
      </div>

      <ul id="sidebar-menu" class="sidebar-menu">
        <?php
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"dashboard/dashboard")[1]==1){
        ?>
          <li class="no-menu">
            <a href="index.php?page=dashboard/dashboard" title="Dashboard"  class="<?php echo $class_sfActive_dashboard ?>">
              <i class="ditp-icon icon-ico-ditp-01"></i>
              <span>Dashboard</span>
            </a>
          </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"case_list")[1]==1){
        ?>
        <li class="no-menu">
          <a href="index.php?page=case_list" title="เรื่องร้องเรียนทั้งหมด" class="<?php echo $class_sfActive_case ?>">
            <i class="ditp-icon icon-ico-ditp-02"></i>
            <span>เรื่องร้องเรียนทั้งหมด x</span>
          </a>

        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"knowledge/knowledge")[1]==1){
        ?>
        <li class="no-menu">
          <a href="/backoffice/setting/index.php?page=knowledge/knowledge" title="เรื่องร้องเรียนทั้งหมด" class="<?php echo $class_sfActive_knowledge ?>">
            <i class="ditp-icon icon-ico-ditp-41"></i>
            <span>องค์ความรู้เรื่องร้องเรียน</span>
          </a>
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"Individual/contact_thai")[1]==1
        || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"corporate/corporate_thai")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_Individual ?>">
          <a href="#" title="ฐานข้อมูลผู้ติดต่อ" class="sf-with-ul <?php echo $class_sfActive_Individual ?>">
              <i class="ditp-icon icon-ico-ditp-42"></i>
              <span>ฐานข้อมูลผู้ติดต่อ</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_Individual ?>">
              <ul>
                <?php
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"Individual/contact_thai")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=Individual/contact_thai" title="บุคคลธรรมดาในไทย">บุคคลธรรมดาในไทย</a></li>
                  <li><a href="/backoffice/setting/index.php?page=Individual/contact_inter" title="บุคคลธรรมดาในต่างประเทศ">บุคคลธรรมดาในต่างประเทศ</a></li>
                  <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"corporate/corporate_thai")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=corporate/corporate_thai" title="นิติบุคคลในไทย">นิติบุคคลในไทย</a></li>
                  <li><a href="/backoffice/setting/index.php?page=corporate/corporate_inter" title="นิติบุคคลในต่างประเทศ">นิติบุคคลในต่างประเทศ</a></li>
                  <?php
                }
                ?>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/application")[1]==1
          || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/management_admin")[1]==1
          || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/group")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_admin ?>">
          <a href="#" title="จัดการผู้ใช้" class="sf-with-ul <?php echo $class_sfActive_admin ?>">
              <i class="ditp-icon icon-ico-ditp-04"></i>
              <span>จัดการผู้ใช้</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_admin ?>">
            <ul>
                <?php
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/application")[1]==1){
                  ?>
                  <li><a href="/backoffice/setting/index.php?page=user/application" title="สมาชิก DITP Application">DITP Application member</a></li>
                  <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/management_admin")[1]==1){
                ?>
                  <li><a href="/backoffice/setting/index.php?page=user/management_admin" title="การจัดการผู้ดูแลระบบ">DITP care user</a></li>
                <?php
                }
                if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"user/group")[1]==1){
                  ?>
                    <li><a href="/backoffice/setting/index.php?page=user/group" title="การจัดการกลุ่มผู้ดูแลระบบ">Group Management</a></li>
                  <?php
                }
                ?>
            </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        // if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"channel")[1]==1){
          if( ($member_cls->checkPrivilege( $_SESSION["admin"]["empPosition"],"dashboard/dashboard")[1]==1 || $_SESSION["admin"]["empPosition"] == 1) && $_SESSION["admin"]["office"] == 0 ){
        ?>
        <li class="<?php echo $class_sfHover_setting ?>">
          <a href="#" title="ตั้งค่าระบบ" class="sf-with-ul <?php echo $class_sfActive_setting ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ตั้งค่าระบบ</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting ?>">
            <ul>
            <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"report/report_issue")[1]==1){ ?>
              <li><a href="/backoffice/setting/index.php?page=complaint" title="ประเภทเรื่องร้องเรียน">ประเภทเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=department" title="หน่วยงาน">หน่วยงาน</a></li>
              <?php } else{ ?>
              <li><a href="/backoffice/setting/index.php?page=complaint" title="ประเภทเรื่องร้องเรียน">ประเภทเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=process" title="ประเภทกระบวนการ">ประเภทกระบวนการ</a></li>
              <li><a href="/backoffice/setting/index.php?page=channel" title="ช่องทางการรับเรื่องร้องเรียน">ช่องทางการรับเรื่องร้องเรียน</a></li>
              <li><a href="/backoffice/setting/index.php?page=product" title="ประเภทสินค้า">สินค้า</a></li>
              <li><a href="/backoffice/setting/index.php?page=incorrect" title="ประเภทความผิด">ประเภทความผิด</a></li>
              <li><a href="/backoffice/setting/index.php?page=department" title="หน่วยงาน">หน่วยงาน</a></li>
              <li><a href="/backoffice/setting/index.php?page=country" title="ประเภทสินค้า">ประเทศ</a></li>
              <li><a href="/backoffice/setting/index.php?page=blacklist" title="Blacklist">Blacklist</a></li>
              <li><a href="/backoffice/setting/index.php?page=priority" title="Priority">Priority</a></li>
              <?php } ?>
            </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"noti_complaint")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_setting2 ?>">
          <a href="#" title="ตั้งค่าการแจ้งเตือน" class="sf-with-ul <?php echo $class_sfActive_setting2 ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ตั้งค่าการแจ้งเตือน</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting2 ?>">
              <ul>
                  <li><a href="/backoffice/setting/index.php?page=noti_complaint" title="การแจ้งเตือนผู้ร้องเรียน">การแจ้งเตือนผู้ร้องเรียน</a></li>
                  <li><a href="/backoffice/setting/index.php?page=noti_user" title="การแจ้งเตือนผู้ใช้ระบบ">การแจ้งเตือนผู้ใช้ระบบ</a></li>
                  <li><a href="/backoffice/setting/index.php?page=holiday" title="ตั้งค่าวันหยุดราชการ">ตั้งค่าวันหยุดราชการ</a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"form")[1]==1){
        ?>
        <li class="no-menu">
          <a href="/backoffice/setting/index.php?page=form" title="ระบบจัดการฟอร์ม" class="<?php echo $class_sfActive_from ?>">
                <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ระบบจัดการฟอร์ม</span>
          </a>
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"channel")[1]==1){
        ?>
        <li class="<?php echo $class_sfHover_setting_fnt ?>">
          <a href="#" title="ระบบจัดการ Frontend" class="sf-with-ul <?php echo $class_sfActive_setting_fnt ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>ระบบจัดการ Frontend</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_setting_fnt ?>">
              <ul>
                    <li><a href="/backoffice/setting/index.php?page=banner" title="Banner">Banner</a></li>
                    <li><a href="/backoffice/setting/index.php?page=complaint_procedure" title="ขั้นตอนการร้องเรียน">ขั้นตอนการร้องเรียน</a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"report/report_issue")[1]==1){
        ?>

        <li class="<?php echo $class_sfHover_report ?>">
          <a href="#" title="Report" class="sf-with-ul <?php echo $class_sfActive_report ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>Report</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_report ?>">
              <ul>
                  <li><a href="index.php?page=report/report_issue" title="รายงานการดำเนินการ" class="<?=$active_report_issue;?>">รายงานการดำเนินการ</a></li>
                  <li><a href="index.php?page=report/report_cost" title="รายงานมูลค่าความเสียหาย" class="<?=$active_report_cost;?>">รายงานมูลค่าความเสียหาย</a></li>
                  <li><a href="index.php?page=report/report_country" title="รายงานมูลค่าความเสียหาย" class="<?=$active_report_country;?>">สถิติเรื่องร้องเรียนแยกตามประเทศผู้ร้องเรียน</a></li>
                  <li><a href="index.php?page=report/report_compare" title="รายงานมูลค่าความเสียหาย" class="<?=$active_compare;?>">สถิติเปรียบเทียบเรื่องร้องเรียน </a></li>
                  <li><a href="index.php?page=report/report_product" title="รายงานมูลค่าความเสียหาย" class="<?=$active_product;?>">สถิติเรื่องร้องเรียนแยกตามประเภทสินค้า </a></li>
                  <li><a href="index.php?page=report/report_country_thai" title="รายงานมูลค่าความเสียหาย" class="<?=$active_country_thai;?>">สถิติเรื่องร้องเรียนที่ต่างประเทศร้องเรียนประเทศไทย </a></li>
                  <li><a href="index.php?page=report/report_blacklist" title="รายงานสถานะการเฝ้าระวัง" class="<?=$active_report_blacklist;?>">รายงานสถานะการเฝ้าระวัง </a></li>
              </ul>
          </div><!-- .sidebar-submenu -->
        </li>
        <?php
        }
        ?>
        <li class="no-menu">
          <a href="index.php?page=question" title="กรอกแบบสอบถามการใช้งาน" class="<?php echo $class_sfActive_question ?>">
              <i class="ditp-icon icon-ico-ditp-27" aria-hidden="true"></i>
              <span style="margin-bottom:20px;">กรอกแบบสอบถามการใช้งาน</span>
          </a>
        </li>

        <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"admin_questionAW")[1]==1
        || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAW")[1]==1
        || $member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAP")[1]==1){ ?>
        <li class="<?php echo $class_sfHover_report_question ?>">
          <a href="#" title="รายงานแบบสอบถาม" class="sf-with-ul <?php echo $class_sfActive_report_question ?>">
              <i class="ditp-icon icon-ico-ditp-05"></i>
              <span>รายงานแบบสอบถาม</span>
          </a>
          <div class="sidebar-submenu" style="<?php echo $subMenuOpen_report_question ?>">
            <ul>
              <?php if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"admin_questionAW")[1]==1) { ?>
              <li><a href="index.php?page=admin_questionAW" title="รายงานแบบสอบถามการใช้งานของแอดมิน" class="<?php echo $active_admin_questionAW ?>">รายงานแบบสอบถามการใช้งานของแอดมิน</a></li>
              <?php }
              if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAW")[1]==1) {
              ?>
              <li><a href="index.php?page=frontend_questionAW" title="รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( Web )" class="<?php echo $active_frontend_questionAW ?>" >รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( Web )</a></li>
              <?php }
              if($member_cls->checkPrivilege($_SESSION["admin"]["empPosition"],"frontend_questionAP")[1]==1) {
              ?>
              <!-- <li><a href="index.php?page=frontend_questionAP" title="รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( App )" class="<?php // echo $active_frontend_questionAP ?>" >รายงานแบบสอบถามการใช้งานของผู้ประกอบการ ( App )</a></li> -->
              <?php } ?>
            </ul>
          </div>
        </li>
        <?php } ?>
      </ul><!-- #sidebar-menu -->



    </div>
  </div>
  <?php
}
?>
