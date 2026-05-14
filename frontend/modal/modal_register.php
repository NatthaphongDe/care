<form method="post" action="#" id="modal_register" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_register" tabindex="-1" role="dialog" aria-labelledby="modal_chk_register" style="padding:0px;">
			<div class="modal-dialog modal_chk_register" role="document" style="width:800px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">
						<input type="hidden" class="status_login">
						<input type="hidden" class="facebook_id">
						<input type="hidden" class="facebook_name">
						<div class="row" style="margin-bottom:30px;">
							<div class="box-add-modal-group">
                <div class="hr_modal"><?=$txt_identify?></div>
						</div>
					</div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
							<?php if($lang == "1"){?>
              <div class="modal_icon_person" style="text-align:right;"><a onclick="register_member_chk(1);"><img src="images/all_icon_DITP/icon-31.png" style="width:160px;margin-right:10px;cursor: pointer;"></a></div>
							<?php }elseif ($lang == "2") { ?>
								<div class="modal_icon_person" style="text-align:right;"><a onclick="register_member_chk(1);"><img src="images/logo_eng/icon-35.png" style="width:160px;margin-right:10px;cursor: pointer;"></a></div>
							<?php }else { ?>
								<div class="modal_icon_person" style="text-align:right;"><a onclick="register_member_chk(1);"><img src="images/all_icon_DITP/icon-31.png" style="width:160px;margin-right:10px;cursor: pointer;"></a></div>
							<?php } ?>
						</div>
            <div class="col-md-6 col-sm-6 col-xs-6">
							<?php if($lang == "1"){?>
              <div class="modal_icon_agent"><a onclick="register_member_chk(2);"><img src="images/all_icon_DITP/icon-32.png" style="width:160px;margin-left:10px;cursor: pointer;"></a></div>
							<?php }elseif ($lang == "2") { ?>
							<div class="modal_icon_agent"><a onclick="register_member_chk(2);"><img src="images/logo_eng/icon-36.png" style="width:160px;margin-left:10px;cursor: pointer;"></a></div>
							<?php }else { ?>
							<div class="modal_icon_agent"><a onclick="register_member_chk(2);"><img src="images/all_icon_DITP/icon-32.png" style="width:160px;margin-left:10px;cursor: pointer;"></a></div>
							<?php } ?>
						</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="modal_cartoon_login_g" style="text-align:center;"><img src="images/cartoon_login_g.png"></div>
          </div>
      </div>
				</div>
        <div class="modal-footer modal-footer-invite"></div>
			</div>
		</div>
	</div>
</form>
<script>
	function register_member_chk(id){
		$('#wait_process').css('display','block');
		var status = $('.status_login').val();
		var facebook_id = $('.facebook_id').val();
		var facebook_name = $('.facebook_name').val();
		var lang = $('.language_hidden').val();
		if(id == 1){
			if(status == "0"){
				window.location.href = '/frontend/agent.php?page=person&status='+status+'&lang='+lang+'';
			}else {
				window.location.href = '/frontend/agent.php?page=person&status='+status+'&fb_id='+facebook_id+'&fb_name='+facebook_name+'&lang='+lang+'';
			}
		}else {
			if(status == "0"){
				window.location.href = '/frontend/agent.php?page=office&status='+status+'&lang='+lang+'';
			}else {
				window.location.href = '/frontend/agent.php?page=office&status='+status+'&fb_id='+facebook_id+'&fb_name='+facebook_name+'&lang='+lang+'';
			}
		}
	}
</script>
