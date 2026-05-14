<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css");

    .new_careinfo {
        font-size: 18px;
        font-stretch: normal;
        font-style: normal;
        line-height: normal;
        font-family: 'Kanit', sans-serif;
    }

    .new_careinfo .fa-ul {
        margin-left: 0px;
    }

    .new_careinfo .fa-ul .fa-li {
        top: 0.5em;
        left: -1.9em;
    }

    .careinfo-header {
        text-align: center;
        margin-bottom: 2rem;
        margin-top: 2rem;
    }

    .careinfo-header .text-style-1 {
        font-size: 25px;
        font-weight: 500;
        letter-spacing: 1px;
        text-align: center;
        color: #0e4e3e;
    }

    .careinfo-header .text-style-2 {
        color: #29ad8c;
    }

    .careinfo-header .text_style-3 {
        color: #175747;
        font-weight: normal;
    }

    .new_careinfo .careinfo_content-1 {
        background-color: #ceffe5;
    }

    .new_careinfo .careinfo_content-2 {
        background-color: #c1ffde;
    }

    .new_careinfo .careinfo_content-3 {
        background-color: #fff7dc;
    }

    .new_careinfo .careinfo_content-4 {
        background-color: #fff1c5;
    }

    .new_careinfo .careinfo_content-5 {
        background-color: #fdbebe;
    }

    .careinfo_content-1 .text-style-1,
    .careinfo_content-3 .text-style-1,
    .careinfo_content-5 .text-style-1 {
        font-weight: 500;
        text-align: left;
    }

    .careinfo_content-1 .content-1 {
        padding: 3rem;
    }

    .careinfo_content-2 .content-1 {
        padding: 1rem;
    }

    .careinfo_content-3 .content-1 {
        padding: 3rem;
    }

    .careinfo_content-4 .content-1 {
        padding: 3rem;
    }

    .careinfo_content-5 .content-1 {
        padding: 3rem;
    }

    .careinfo_content-1 .content-1-right,
    .careinfo_content-2 .content-1-right,
    .careinfo_content-3 .content-1-right,
    .careinfo_content-4 .content-1-right,
    .careinfo_content-5 .content-1-right {
        font-weight: 300;
    }

    .careinfo_content-2 .content-1-right,
    .careinfo_content-4 .content-1-right {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: 20vh;
    }

    .careinfo_content-1 ul,
    .careinfo_content-2 ul,
    .careinfo_content-3 ul,
    .careinfo_content-4 ul {
        padding-inline-start: 20px;
    }

    .careinfo_content-1 ul li,
    .careinfo_content-2 ul li,
    .careinfo_content-3 ul li,
    .careinfo_content-4 ul li {
        padding: 5px 0px;
    }

    .careinfo_content-1 button {
        background: rgb(37, 154, 122);
        background: linear-gradient(159deg, rgba(37, 154, 122, 1) 0%, rgba(124, 205, 157, 1) 80%);
        border-radius: 6px;
        padding: 0.5rem;
        height: auto;
        font-size: 16px;
        border: none;
        margin-left: 10px;
        font-weight: 200;
        padding-right: 1rem;
    }

    .careinfo_content-1 .content-1-left {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
    }

    .careinfo_content-2 .content-1-left,
    .careinfo_content-3 .content-1-left,
    .careinfo_content-4 .content-1-left {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .careinfo_content-1 .content-1-left img {
        width: 50%;
        height: 40%;
    }

    .careinfo_content-2 .content-1-left img {
        width: 40%;
    }

    .careinfo_content-3 .content-1-left img,
    .careinfo_content-4 .content-1-left img {
        width: 60%;
    }

    .careinfo_content-5 .content-5_imgfirst img {
        width: 40%;
    }

    .careinfo_content-5 .arrow-right1 {
        position: absolute;
        top: 40%;
        right: 0;
    }

    .careinfo_content-5 .arrow-right1 img,
    .careinfo_content-5 .arrow-right2 img {
        height: 50%;
        width: 50%;
    }

    .careinfo_content-5 .arrow-right2 {
        position: absolute;
        top: 30%;
        right: -10%;
    }

    .careinfo_content-5 .img1 {
        width: 40%;
    }

    .careinfo_content-5 .img2 {
        width: 32%;
    }

    .careinfo_content-5 .img3 {
        width: 34%;
    }

    @media only screen and (max-width: 1484px) {
        .careinfo_content-5 .arrow-right2 {
            top: 25%;
        }
    }

    @media only screen and (max-width: 1102px) {
        .careinfo_content-5 .arrow-right2 {
            top: 22%;
        }
    }

    @media only screen and (max-width: 1283px) {

        .careinfo_content-3 .content-1-left img,
        .careinfo_content-4 .content-1-left img {
            width: 75%;
        }

        .careinfo_content-2 .content-1-left img {
            width: 55%;
        }

        .careinfo_content-5 .arrow-right1 {
            right: -10%;
        }
    }

    @media only screen and (max-width: 1140px) {
        .careinfo_content-1 .content-1-left img {
            width: 80%;
        }

        .careinfo_content-3 .content-1-left img,
        .careinfo_content-4 .content-1-left img {
            width: 100%;
        }
    }

    @media only screen and (max-width: 1006px) {
        .careinfo_content-2 .content-1-left img {
            width: 55%;
        }

        .careinfo_content-2 .content-1-left img {
            width: 65%;
        }

        .careinfo_content-5 .arrow-right1 img,
        .careinfo_content-5 .arrow-right2 img {
            height: 40%;
            width: 40%;
        }
    }

    @media only screen and (max-width: 901px) {
        .careinfo_content-5 .arrow-right2 {
            top: 18%;
        }

        .careinfo_content-2 .content-1-left img {
            width: 80%;
        }

        .careinfo_content-5 .arrow-right1 img,
        .careinfo_content-5 .arrow-right2 img {
            height: 25%;
            width: 25%;
        }

        .careinfo_content-5 .arrow-right1 {
            right: -15%;
        }
    }

    @media only screen and (max-width: 781px) {
        .careinfo_content-2 .content-1-left img {
            width: 70%;
        }
    }

    @media only screen and (max-width: 767px) {
        .careinfo_content-1 .content-1-left img {
            width: 40%;
            height: auto;
        }

        .careinfo_content-1 .content-1-left {
            height: 30vh;
        }

        .careinfo_content-2 .content-1-left img {
            width: 30%;
        }

        .careinfo_content-3 .content-1-left img,
        .careinfo_content-4 .content-1-left img {
            width: 50%;
        }

        .careinfo_content-3 .content-1-left {
            height: 30vh !important;
        }

        .careinfo_content-2 .content-1 {
            padding: 3rem;
        }

        .careinfo_content-5 .arrow-right1,
        .careinfo_content-5 .arrow-right2 {
            display: none;
        }

        .careinfo_content-5 .img1 {
            width: 35%;
        }

        .careinfo_content-5 .img2,
        .careinfo_content-5 .img3 {
            margin-top: 2rem;
            width: 30%;
        }
    }

    @media only screen and (max-width: 584px) {

        .careinfo_content-3 .content-1-left img,
        .careinfo_content-4 .content-1-left img {
            width: 70%;
        }
    }

    @media only screen and (max-width: 530px) {
        .careinfo_content-1 .content-1-left {
            height: 35vh;
        }

        .careinfo_content-1 .content-1-left img {
            width: 50%;
        }

        .careinfo_content-3 .content-1-left img {
            width: 70%;
        }
    }

    @media only screen and (max-width: 458px) {
        .careinfo_content-1 button {
            padding: 0.3rem;
        }
    }

    .swal2-styled {
        padding: 0.3em 1.1em;
        font-family: 'Kanit', sans-serif;
    }

    /* .swal2-popup {
        width: 33em;
    } */

    body,
    .swal2-popup {
        font-family: 'Sarabun', sans-serif !important;
        background-color: #f3f4f6;
        /* สีพื้นหลังหน้าเว็บ */
    }

    /* --- CSS ที่จำเป็นสำหรับ Layout นี้ --- */

    /* 1. จัด Layout ใน Popup (Flexbox) */
    .my-custom-layout {
        display: flex;
        align-items: start;
        /* จัดให้อยู่กึ่งกลางแนวตั้งเพื่อให้ตรงกับไอคอน Swal */
        text-align: center;
        /* บังคับตัวหนังสือชิดซ้าย */
        gap: 15px;
        /* ระยะห่างระหว่างไอคอนกับข้อความ */
        margin-top: 5px;
    }

    /* ไม่ต้องใช้ .my-custom-icon แล้ว เพราะเราจะใช้ Class ของ Swal โดยตรง 
           แต่เราอาจต้องปรับขนาด Swal Icon นิดหน่อยเพื่อให้พอดี
        */

    /* 3. ปรับแต่งปุ่มตกลง */
    div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
        background-color: #5b21b6 !important;
        /* สีม่วง */
        font-size: 16px !important;
        padding: 0.3em 40px !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 6px -1px rgba(91, 33, 182, 0.2) !important;
        margin-top: 10px !important;
    }

    div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm:hover {
        background-color: #4c1d95 !important;
        /* สีม่วงเข้มเมื่อเอาเมาส์ชี้ */
    }

    /* 4. ปรับแต่งตัวหนังสือ */
    .my-text-content {
        font-size: 1.1rem;
        color: #374151;
        line-height: 1.6;
    }

    .vpn-highlight {
        font-weight: bold;
        color: #1e1b4b;
        /* สีน้ำเงินเข้ม */
    }

    .swal2-icon {
        border: 0.50em solid rgba(0, 0, 0, 0);
        font-weight: 700;
    }

    /* สีน้ำเงินเข้ม */
    .swal2-html-container {
        padding: 0 !important;
    }
</style>

<section class="new_careinfo">
    <div class="careinfo-header">
        <span class="text-style-1">
            <?php echo $txt_01 ?><span class="text-style-2"><?php echo $txt_02 ?></span>
        </span>
        <br>
        <span class="text_style-3">
            <?php echo $txt_03 ?>
        </span>
    </div>
    <div class="careinfo_content-1">
        <div class="content-1">
            <span class="text-style-1">
                <u><?php echo $txt_04 ?></u><?php echo $txt_05 ?>
            </span>
            <div class="row" style="margin-top: 2rem;">
                <div class="content-1-left col-sm-3">
                    <img src="./img/group-4.png">
                </div>
                <div class="content-1-right col-sm-9">
                    <span style="font-weight: 500;">
                        <?php echo $txt_06 ?>
                    </span>
                    <ul class="fa-ul" style="margin-top: 1.5rem;">
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_07 ?></span> <?php echo $txt_08 ?></li>
                        <ul class="fa-ul" style="margin-left:1em;">
                            <li><span class="fa-li"><i class="bi bi-caret-right"></i></span><?php echo $txt_09 ?></li>
                            <li><span class="fa-li"><i class="bi bi-caret-right"></i></span><?php echo $txt_10 ?></li>
                        </ul>
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_11 ?></span></li>
                        <ul style="list-style: none; margin-left:1em;">
                            <li>
                                <?php echo $txt_12 ?>
                                <button onclick="scamadviserLink()">
                                    <i class="bi bi-search" style="padding: 7px;"></i><?php echo $txt_13 ?>
                                </button>
                            </li>
                        </ul>
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_14 ?></span></li>
                        <ul class="fa-ul" style="font-weight: 300; margin-left:1em;">
                            <li><span class="fa-li"><i class="bi bi-caret-right"></i></span><?php echo $txt_15 ?></li>
                            <li>
                                <?php echo $txt_12 ?>
                                <button onclick="checkcorporation()">
                                    <i class="bi bi-search" style="padding: 7px;"></i><?php echo $txt_16 ?>
                                </button>
                            </li>
                            <li><span class="fa-li"><i class="bi bi-caret-right"></i></span><?php echo $txt_17 ?></li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="careinfo_content-2">
        <div class="content-1">
            <div class="row" style="margin-top: 10px;">
                <div class="content-1-left col-sm-3">
                    <img src="./img/group-10.png">
                </div>
                <div class="content-1-right col-sm-9">
                    <ul class="fa-ul" style="margin-top: 1rem;">
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_18 ?><u><?php echo $txt_19 ?></u></span></li>
                        <ul class="fa-ul" style="font-weight: 300;">
                            <li><span class="fa-li"><i class="bi bi-caret-right"></i></span><?php echo $txt_20 ?></li>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="careinfo_content-3">
        <div class="content-1">
            <span class="text-style-1">
                <u><?php echo $txt_21 ?></u><?php echo $txt_22 ?>
            </span>
            <div class="row" style="margin-top: 10px;">
                <div class="content-1-left col-sm-3" style="height: 20vh">
                    <img src="./img/group-9.png">
                </div>
                <div class="content-1-right col-sm-9">
                    <span style="font-weight: 500;">
                        <?php echo $txt_23 ?>
                    </span>
                    <ul class="fa-ul" style="margin-top: 2rem; font-weight: 500;">
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_24 ?></span></li>
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_25 ?></span></li>
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_37 ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="careinfo_content-4">
        <div class="content-1">
            <div class="row" style="margin-top: 10px;">
                <div class="content-1-left col-sm-3">
                    <img src="./img/group-7.png">
                </div>
                <div class="content-1-right col-sm-9">
                    <ul class="fa-ul" style="margin-top: 1rem; font-weight: 500;">
                        <li><span class="fa-li"><i class="bi bi-caret-right-fill"></i></span><span style="font-weight: 500;"><?php echo $txt_26 ?></span></li>
                        <li style="font-weight: 300;"><span class="fa-li"></span><?php echo $txt_27 ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="careinfo_content-5">
        <div class="content-1">
            <span class="text-style-1">
                <u><?php echo $txt_28 ?></u><?php echo $txt_29 ?>
            </span>
            <div class="row" style="margin-top: 1rem;">
                <div class="content-1-left col-sm-3"></div>
                <div class="content-1-right col-sm-9">
                    <span style="font-weight: 500;">
                        <?php echo $txt_30 ?>
                    </span>
                    <br>
                    <span>
                        <?php echo $txt_31 ?>
                    </span>
                </div>
            </div>
            <div class="row" style="margin-top: 2rem; text-align: center;">
                <div class="col-sm-4" style="position: relative;">
                    <img class="img1" src="./img/group-137.png">
                    <br>
                    <span style="font-weight: 500;"><?php echo $txt_32 ?></span>
                    <div class="arrow-right1">
                        <img src="./img/path.png">
                    </div>
                </div>
                <div class="col-sm-4">
                    <img class="img2" src="./img/final-character-ditp-08.png">
                    <br>
                    <span style="font-weight: 500;"><?php echo $txt_33 ?></span>
                    <br>
                    <span style="font-weight: 300;"><?php echo $txt_34 ?></span>
                    <div class="arrow-right2">
                        <img src="./img/path.png">
                    </div>
                </div>
                <div class="col-sm-4">
                    <img class="img3" src="./img/group-309.png">
                    <br>
                    <span style="font-weight: 500;"><?php echo $txt_35 ?></span>
                    <br>
                    <span style="font-weight: 300;"><?php echo $txt_36 ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function scamadviserLink() {
        window.open('https://www.scamadviser.com/');
    }

    function checkcorporation1() {
        var link = document.createElement('a');
        // link.href = "./fileExcel/รวมเว็บไซต์สำหรับขึ้นระบบ care_080365.pdf";
        /*  link.href = "./fileExcel/ditp_link_new.pdf"; */
        link.href = "./fileExcel/ตรวจสอบนิติบุคคลในต่างประเทศ.pdf";
        link.download = "เว็บไซต์สำหรับการตรวจสอบการจดทะเบียนนิติบุคคลในต่างประเทศ.pdf";
        link.click();
        link.remove();

        count_checkcorporation_clicked()
    }

    function performDownloadSimulation() {
        var link = document.createElement('a');
        link.href = "./fileExcel/ตรวจสอบนิติบุคคลในต่างประเทศ.pdf";
        link.download = "เว็บไซต์สำหรับการตรวจสอบการจดทะเบียนนิติบุคคลในต่างประเทศ.pdf";
        link.click();
        link.remove();

        count_checkcorporation_clicked()
    }

    // ==========================================
    // วิธีที่ 1: SweetAlert2 Logic
    // ==========================================
    /*   function checkcorporation() {
          Swal.fire({
              //title: 'ยืนยันการดาวน์โหลด',
              //text: "กรณีเว็บไซต์ต่างประเทศจำกัดการเข้าถึง <br>ขอให้เชื่อมต่อผ่าน VPN ",
              html: 'กรณีเว็บไซต์ต่างประเทศจำกัดการเข้าถึง ขอให้เชื่อมต่อผ่าน VPN',
              icon: 'warning', // เปลี่ยนไอคอนได้: success, error, warning, info, question
              //showCancelButton: true,
              confirmButtonColor: '#4f46e5', // สี Indigo ตาม Theme
              cancelButtonColor: '#d33',
              confirmButtonText: 'ตกลง',
              cancelButtonText: 'ยกเลิก',
              customClass: {
                  // ปรับระยะห่างของข้อความถ้าต้องการ (Optional)
                  htmlContainer: 'swal-text-custom' 
              }
          }).then((result) => {
              if (result.isConfirmed) {
                  // ทำงานเมื่อกดตกลง
                  performDownloadSimulation();

                  // แจ้งเตือนซ้ำว่าสำเร็จ (Optional)
                  Swal.fire(
                      'กำลังดาวน์โหลด!',
                      'ไฟล์ของคุณกำลังถูกดาวน์โหลด',
                      'success'
                  )
              }
          })
      } */
    function checkcorporation() {
        Swal.fire({
            // --- ใช้ HTML โครงสร้างไอคอนของ SweetAlert2 แทน Font Awesome ---
            html: `
                    <div class="my-custom-layout >
                        <!-- ส่วนข้อความด้านขวา -->
                        <div class="my-text-content d-flex">
                            <div class="swal2-icon swal2-warning" style="display: flex;margin: 0;font-size: 5px;border-color: #f8bb86;color: #f8bb86;align-content: flex-start;">
                                <div class="swal2-icon-content">!</div>
                            </div>
                            <div style="font-size: 20px;font-family: 'Kanit', sans-serif;">
                                กรณีเว็บไซต์ต่างประเทศจำกัดการเข้าถึง<br>
                                ขอให้เชื่อมต่อผ่าน VPN
                            </div>
                           
                        </div>
                    </div>
                `,

            // --- การตั้งค่าปุ่ม ---
            confirmButtonText: 'ตกลง',
            showCancelButton: false, // ปิดปุ่มยกเลิก
            focusConfirm: false,

            // --- การตั้งค่า Popup ---
            width: '480px', // ความกว้าง
            padding: '2em',
            background: '#fff',

            // ลบ padding มาตรฐานของ html container เพื่อให้เราจัดเองได้เต็มที่
            customClass: {
                htmlContainer: 'm-0 p-0'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // --- ส่วนทำงานเมื่อกดตกลง ---
                console.log("User confirmed download");

                var link = document.createElement('a');
                link.href = "./fileExcel/ตรวจสอบนิติบุคคลในต่างประเทศ(5).pdf";
                link.download = "เว็บไซต์สำหรับการตรวจสอบการจดทะเบียนนิติบุคคลในต่างประเทศ.pdf";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                if (typeof count_checkcorporation_clicked === 'function') {
                    count_checkcorporation_clicked();
                }
            }
        })
    }
</script>