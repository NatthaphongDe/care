<?php
$sql = "SELECT * FROM Member WHERE member_id = '".$_SESSION['member_id']."'";
$query = $conn->query($sql);
$rs = $query->fetch_assoc();
?>
<input type="hidden" class="language_status" value="<?php echo $rs['member_lang']?>">
<input type="hidden" class="chk_lang_status" value="<?php echo $_SESSION["chk_lang"]?>">
<form method="post" action="#" id="modal_lang" enctype="multipart/form-data">
		<div class="modal fade" id="modal_chk_lang" tabindex="-1" role="dialog" aria-labelledby="modal_chk_lang" style="padding:0px;">
			<div class="modal-dialog modal_chk_lang" role="document" style="width:800px;">
				<div class="modal-content" style="border-radius: 11px 11px 11px 11px;">
          <div class="modal-header" style="padding-bottom:0px;">
            <div class="modal-title add-group-modal-title">
              <div class="close_modal"> <a href="javascript:void(0);" data-dismiss="modal" aria-hidden="true"><img src="images/btn-exit.png"></a></div>
            </div>
          </div>
					<div class="modal-body">
						<div class="row" style="margin-bottom:30px;">
							<div class="box-add-modal-group">
                <div class="hr_modal">Please select your prefered language</div>
						</div>
					</div>
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="modal_icon_person" style="text-align:right;"><a class="alert" href="function_php/function_index.php?method=lang&lang=1"><img src="images/all_icon_DITP/icon-33.png" style="width:160px;margin-right:10px;cursor: pointer;"></a></div>
							<div class="txt_lang_th" style="text-align:right; margin-right:70px;"><span>Thai</span></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="modal_icon_agent"><a class="alert" href="function_php/function_index.php?method=lang&lang=2"><img src="images/all_icon_DITP/icon-34.png" style="width:160px;margin-left:10px;cursor: pointer;"></a></div>
							<div class="txt_lang_en" style="margin-left:70px;"><span>English</span></div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="modal_cartoon_login_g" style="text-align:center;"><img src="images/cartoon_login_m.png"></div>
          </div>
      </div>
				</div>
        <div class="modal-footer modal-footer-invite"></div>
			</div>
		</div>
	</div>
</form>
<script>
			 $(document).on("click", ".alert", function(e) {
					 var link = $(this).attr("href");
					 e.preventDefault();
					 bootbox.confirm("ท่านต้องการเปลี่ยนภาษาหรือไม่ ?", function(result) {
							 if (result) {
									 document.location.href = link;
							 }
					 });
			 });
	 </script>
