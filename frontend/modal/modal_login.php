<form method="post" action="#" id="modal_login" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_login" tabindex="-1" role="dialog" aria-labelledby="modal_chk_login" style="padding:0px;">
			<div class="modal-dialog modal_chk_login" role="document" style="width:450px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">
						<div class="row" style="margin-bottom:30px;">
							<div class="box-add-modal-group">
                <div class="hr_modal_login"><i class="fa fa-lock" aria-hidden="true" style="margin-right:5px;"></i><?php if($lang == "1"){ echo "เข้าสู่ระบบ";}elseif($lang == "2"){ echo "Log in";}else{ echo "เข้าสู่ระบบ";}?></div>
						</div>
					</div>
        <div class="row">
          <div class="col-md-1 col-sm-1 col-xs-1" style="padding-right:0px;"></div>
          <div class="col-md-10 col-sm-10 col-xs-10 no-padding">
            <input type="text" class="form-control box_user" name="box_user" placeholder="E-mail" onkeypress="login_enter(event);">
            <input type="password" class="form-control box_pass" name="box_pass" placeholder="Password" onkeypress="login_enter(event);">
            <button type="button" class="btn btn-warning btn-login" style="width:100%;">Login</button>
            <div class="txt_login">
							<?=$txt_Existing_users?>
            </div>
            <div class="forgot_password"><a onclick="modal_forgot_password();">Forgot your password ?</a></div>
            <div class="icon_or"><img src="images/icon_or.png"></div>
						<input type="hidden" class="id_fb">
						<fb:login-button scope="public_profile,email" data-width="100%" data-max-rows="1" data-size="large" data-button-type="login_with" onlogin="checkLoginState();">Login with Facebook</fb:login-button>
            <div class="txt_singup"><span class="txt-sign-up">Don't have an account?</span><span class="txt-sign-up-2" style="margin-left:15px;"><a href="javascript:open_modal_register(0);">Sign up.</a></span></div>
          </div>
          <div class="col-md-1 col-sm-1 col-xs-1"></div>
      </div>
				</div>
        <div class="modal-footer modal-footer-invite"></div>
			</div>
		</div>
	</div>
</form>

<form method="post" action="#" id="forgot_password" enctype="multipart/form-data">
		<div class="modal fade" id="modal_forgot_password" tabindex="-1" role="dialog" aria-labelledby="modal_forgot_password" style="padding:0px;">
			<div class="modal-dialog modal_forgot_password" role="document" style="width:380px; top:170px;margin-left: 20px;margin: 30px auto;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">

        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">
						<div style="margin-bottom: 10px;"><?=$txt_forgot?></div>
						<input type="email" class="form-control forgot_email" name="forgot_email" placeholder="E-mail">
          </div>
          <div class="col-md-1"></div>
      </div>
				</div>
        <div class="modal-footer">
        	<button type="button" class="btn btn-warning btn_forgot_password"><?=$txt_ok?></button>
        </div>
			</div>
		</div>
	</div>
</form>
<?php if($_SESSION['member_id'] == ""){ ?>

<script>
// var respon = "";
// function statusChangeCallback2(re) {
// 	respon = re;
// }
// function onclick_login() {
// 	statusChangeCallback(respon);
// }
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    if (response.status === 'connected') {
      testAPI();
    } else {
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '785370434958924',//DITP_Production:785370434958924
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.9' // use graph api version 2.8
  });

  FB.getLoginStatus(function(response) {
    // statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
			$('.id_fb').val(response.id);
			if(response.id != "" && response.name != ""){
				chk_login_facebook(response.id,response.name);
			}
      console.log('Successful login for: ' + response.name + response.id);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }



	function chk_login_facebook(facebook_id,facebook_name){
		$.ajax({
				url: 'function_php/function_member.php',
				type: 'POST',
				async: false,
				responseType: "json",
				data: {
					'facebook_id':facebook_id,
					'facebook_name':facebook_name,
					"method":"facebook_login"
				},
			success: function(res) {
				if(res.fb_chk == "00"){
					login_facebook(facebook_id,facebook_name);
				}else {
					$('#modal_chk_login').modal('hide');
					$('#modal_chk_register').modal('show');
					$('.status_login').val('');
					$('.facebook_id').val(facebook_id);
					$('.facebook_name').val(facebook_name);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR, textStatus, errorThrown);

			}
		});
	}

	function login_facebook(facebook_id,facebook_name){
		$.ajax({
				url: 'function_php/function_member.php',
				type: 'POST',
				async: false,
				responseType: "json",
				data: {
					'facebook_id':facebook_id,
					'facebook_name':facebook_name,
					"method":"facebook_login_chk"
				},
			success: function(res) {
				if(res.fb_chk == "00"){
					window.location.href = '/frontend/index.php<?php if($_REQUEST["page"]!=""){ echo "?page=".$_REQUEST["page"]; } ?>';
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR, textStatus, errorThrown);

			}
		});
	}
</script>
<?php } ?>
<script>
function modal_forgot_password(){
	$('#modal_forgot_password').modal('show');
}

function login_enter(e) {
	if(e.keyCode == 13){
		$('.btn-login').click();
	}
}
$(function(){
	$(document).delegate(".btn-login","click",function(){
	  var box_user = $('.box_user').val();
	  var box_pass = $('.box_pass').val();
	  var lang = $('.language_hidden').val();
	  if(lang == "2"){
	    var ArlogIn = "Your E-mail has not yet been confirmed. Please confirm your subscription via your E-mail.";
	    var ArlogIn_x = "Password error please check.";
	    var ArlogIn_z = "E-mail is not available.";
	  }else {
	    var ArlogIn = "E-mail ของท่านยังไม่ได้ยืนยันการสมัครสมาชิก กรุณายืนยันการสมัครสมาชิก ผ่านทาง E-mail ของท่าน";
	    var ArlogIn_x = "Password ผิดพลาดกรุณาตรวจสอบ";
	    var ArlogIn_z = "E-mail ไม่มีอยู่ในระบบกรุณาตรวจสอบให้ถูกต้อง";
	  }
	  $('#wait_process').css('display','block');
	  $.ajax({
	      url: 'function_php/function_member.php',
	      type: 'POST',
	      async: false,
	      responseType: "json",
	      data: {
	        'box_user':box_user,
	        'box_pass':box_pass,
	        "method":"chk_login"

	      },
	    success: function(res) {
	      if(res.fb_chk == "00"){
	        window.location.href = '/frontend/index.php<?php if($_REQUEST["page"]!=""){ echo "?page=".$_REQUEST["page"]; } ?>';
	      }else if (res.fb_chk == "01") {
	        bootbox.alert(ArlogIn,function(){
	          $('#wait_process').css('display','none');
	        });
	      }else if (res.fb_chk == "02") {
	        bootbox.alert(ArlogIn_x,function(){
	          $('#wait_process').css('display','none');
	        });
	      }else {
	        bootbox.alert(ArlogIn_z,function(){
	          $('#wait_process').css('display','none');
	        });
	      }
	    },
	    error: function(jqXHR, textStatus, errorThrown) {
	      console.log(jqXHR, textStatus, errorThrown);

	    }
	  });
	});
});
</script>
