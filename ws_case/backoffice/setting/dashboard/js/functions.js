function data_category() {
  var display_cat = $('input[name=display_cat]:checked').val();
	var year_type_cat = $('input[name=year_type_cat]:checked').val();
	if(display_cat==1){
		var	issue_year  = $('#issue_year_cat1').val();
		var month  = $('#month_issue_cat1').val();
	}else{
			issue_year  = $('#issue_year_cat2').val();
			var month  = $('#month_issue_cat2').val();
	}
	var data = {
		display_cat : display_cat ,
		year_type_cat : year_type_cat,
		issue_year : issue_year,
		select_quarter_chk_cat :  $('#select_quarter_chk_cat').val(),
		month : month,
		startDate_cat : $('#startDate_cat').val(),
		stopDate_cat : $('#stopDate_cat').val(),
		search_cat : $('#search_cat').val()
	};
	$.ajax({
		url: "dashboard/category.php",
		type: "post",
		data: data ,
		success: function (data) {
			$(".data_category").html(data);
		}
	})


}

function data_case_filter(id) {
  $('#son_active').val(id);
	var year_type_case = $('input[name=year_type_case]:checked').val();    // ประเภทปี
	var month_case = $('#month_case').val();
	var year_case = $('#year_case').val();
	var issue_year1 = $('#issue_year1').val();
	var issue_year2 = $('#issue_year2').val();
	if(issue_year1!=''){
	var	chechk_type_year = 1;
		var issue_year =   $('#issue_year1').val();
	}else if(issue_year2!=''){
		issue_year =   $('#issue_year2').val();
	}
	var select_quarter_chk =   $('#select_quarter_chk').val();

	var month_issue_1 = $('#month_issue_1').val();
	var month_issue_2 = $('#month_issue_2').val();
	if(month_issue_1 !='' ){
		var month_issue =   $('#month_issue_1').val();
	}else if(month_issue_2 !='' ){
		month_issue =   $('#month_issue_2').val();
	}

	$('#input_case').val(id);
	var data = {
		            id_case : $('#input_case').val(),
								month_case : month_case,
								year_case: year_case,
								issue_year:issue_year,
								select_quarter_chk : select_quarter_chk,
								month_issue : month_issue,
								secrch_case : $('#secrch_case').val(),
								startDate : $('#startDate').val(),
								stopDate : $('#stopDate').val(),
								chechk_type_year : chechk_type_year,
								year_type_case : year_type_case
							};
	$.ajax({
		url: "dashboard/case.php",
		type: "post",
		data: data ,
		success: function (data) {
        $(".data_case_filter").html(data);

        var   secrch_case = $('#secrch_case').val();
        if(secrch_case==1){
          $('#month_case').val('default');
          $('#year_case').val('default');
          $('.selectpicker').selectpicker('refresh');

        }
		}
	})
	 $('.table-caseCh-list_case').bootstrapTable('refresh');
}
//
function ch_val() {
	$('#secrch_case').val(0);
	data_case_filter();
}
function click_add() {
	$('#secrch_case').val(1);
	$("#issue_year1 option:selected").val('');
	$("#year_case option:selected").val('');
}
function ch_activity() {

}
function search_cat() {

		var year_type_cat = $('input[name=year_type_cat]:checked').val();
		var issue_year_cat1 =   $('#issue_year_cat1').val();
		var issue_year_cat2 =   $('#issue_year_cat2').val();
		var startDate_cat =   $('#startDate_cat').val();
		var stopDate_cat =   $('#stopDate_cat').val();
		if(year_type_cat==2){
			if(issue_year_cat1=='' && issue_year_cat2 ==''){
				alert('กรุณาเลือกปีงบประมาณ');
				exit();
			}
		}else{
			if(issue_year_cat1=='' && issue_year_cat2 ==''){
				if(issue_year_cat1 == '' ||  issue_year_cat2 ==''){
					if(startDate_cat =='' && stopDate_cat ==''){
						alert('กรุณาเลือกช่วงเวลา หรือ Start Date');
						   exit();
					}else if(startDate_cat!=''){
						if(stopDate_cat==''){
							alert('กรุณาเลือกวัน Stop Date');
							exit();
						}
					}
				}
			}
		}


    var display_cat = $('input[name=display_cat]:checked').val();
    var select_quarter_chk_cat = $('#select_quarter_chk_cat').val();


    if(display_cat==1){
      var year =  $('#issue_year_cat1').val();
      var month_txt = $('#month_issue_cat1').val();
    }else{
      var year = $('#issue_year_cat2').val();
      var month_txt = $('#month_issue_cat2').val();
    }

    if(startDate_cat!='' &&  stopDate_cat !=''){
      // $(".by_year").html('');
      $(".by_year").html("<span>วันที่ "+startDate_cat+" - "+stopDate_cat+"</span>");
    }else if(year_type_cat==1){
      if(display_cat==1){
        var  thmonth = new Array (  "มกราคม","กุมภาพันธ์","มีนาคม", "เมษายน", "พฤษภาคม","มิถุนายน",
                                    "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        year = parseInt(year) + 543;
        if(month_txt!=''){
          $(".by_year").html("<span>"+thmonth[month_txt-1]+" ปี "+year+" (ปีปฏิทิน)</span>");
        }else if(select_quarter_chk_cat!=''){
          $(".by_year").html("<span>ไตรมาสที่ "+select_quarter_chk_cat+" ปี "+year+" (ปีปฏิทิน)</span>");
        }else{
          $(".by_year").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
        }
      }else{
        if(month_txt!=''){
          var  thmonth = new Array (  "January","February","February", "April", "May","June",
                                      "July","August","September","October","October","October");
          year = parseInt(year);
          $(".by_year").html("<span>"+thmonth[month_txt-1]+" year "+year+" (ปีปฏิทิน)</span>");
        }else if(select_quarter_chk_cat!=''){

          $(".by_year").html("<span>ไตรมาสที "+select_quarter_chk_cat+" ปี "+year+" (ปีปฏิทิน)</span>");
        }else{
          $(".by_year").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
        }
      }
    }else{
      if(display_cat==1){
        year = parseInt(year) + 543;
      }
      $(".by_year").html("<span>ปี "+year+" (ปีงบประมาณ)</span>");
    }

  $('#search_cat').val(1);
	data_category();
  $('#show_search_cat').hide();
}


function search_kpi() {
	$('#search_cat').val(1);
		var year_type_kpi = $('input[name=year_type_kpi]:checked').val();
		var issue_year_kpi1 =   $('#issue_year_kpi1').val();
		var issue_year_kpi2 =   $('#issue_year_kpi2').val();
		var startDate_kpi =   $('#startDate_kpi').val();
		var stopDate_kpi =   $('#stopDate_kpi').val();
		if(year_type_kpi==2){
			if(issue_year_kpi1=='' && issue_year_kpi2 ==''){
				alert('กรุณาเลือกปีงบประมาณ');
				exit();
			}
		}else{
			if(issue_year_kpi1=='' && issue_year_kpi2 ==''){
					if(startDate_kpi =='' && stopDate_kpi ==''){
						alert('กรุณาเลือกช่วงเวลา หรือ Start Date');
						   exit();
					}else if(startDate_kpi!=''){
						if(stopDate_kpi==''){
							alert('กรุณาเลือกวัน Stop Date');
							exit();
						}
  				}
  			}
  		}



      var select_quarter_chk_kpi = $('#select_quarter_chk_kpi').val();
      var display_kpi =  $('input[name=display_kpi]:checked').val();
      if(display_kpi==1){
        var year =  $('#issue_year_kpi1').val();
        var month_txt = $('#month_issue_kpi1').val();
      }else{
        var year = $('#issue_year_kpi2').val();
        var month_txt = $('#month_issue_kpi2').val();
      }

      if(startDate_kpi!='' &&  stopDate_kpi !=''){
        // $(".by_year").html('');
        $(".by_kpi").html("<span>วันที่ "+startDate_kpi+" - "+stopDate_kpi+"</span>");
      }else if(year_type_kpi==1){
        if(display_kpi==1){
          var  thmonth = new Array (  "มกราคม","กุมภาพันธ์","มีนาคม", "เมษายน", "พฤษภาคม","มิถุนายน",
                                      "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          year = parseInt(year) + 543;
          if(month_txt!=''){
            $(".by_kpi").html("<span>"+thmonth[month_txt-1]+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else if(select_quarter_chk_kpi!=''){
            $(".by_kpi").html("<span>ไตรมาสที่ "+select_quarter_chk_kpi+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else{
            $(".by_kpi").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
          }
        }else{
          if(month_txt!=''){
            var  thmonth = new Array (  "January","February","February", "April", "May","June",
                                        "July","August","September","October","October","October");
            year = parseInt(year);
            $(".by_kpi").html("<span>"+thmonth[month_txt-1]+" year "+year+" (ปีปฏิทิน)</span>");
          }else if(select_quarter_chk_kpi!=''){

            $(".by_kpi").html("<span>ไตรมาสที "+select_quarter_chk_kpi+" ปี "+year+" (ปีปฏิทิน)</span>");
          }else{
            $(".by_kpi").html("<span>ปี "+year+" (ปีปฏิทิน)</span>");
          }
        }
      }else{
        if(display_kpi==1){
          year = parseInt(year) + 543;
        }
        $(".by_kpi").html("<span>ปี "+year+" (ปีงบประมาณ)</span>");
      }












  $('#search_kpi').val(1);
  $('#month_kpi').val('default');
  $('#year_kpi').val('default');
  $('.selectpicker').selectpicker('refresh');

	data_kpi();
  $('#show_search_kpi').hide();
}

function ch_kpi() {
  var month_kpi =   $('#month_kpi').val();
  var year_kpi =   $('#year_kpi').val();
    if(month_kpi !='' ||  year_kpi !=''){
      $('#search_kpi').val(0);
      data_kpi();
    }
}


function data_kpi() {

  var display_kpi = $('input[name=display_kpi]:checked').val();
	var year_type_kpi = $('input[name=year_type_kpi]:checked').val();
	if(display_kpi==1){
		var	issue_year  = $('#issue_year_kpi1').val();
		var month  = $('#month_issue_kpi1').val();
	}else{
			issue_year  = $('#issue_year_kpi2').val();
			var month  = $('#month_issue_kpi2').val();
	}
	var data = {
    year_kpi : $('#year_kpi').val() ,
    month_kpi : $('#month_kpi').val() ,
		display_kpi : display_kpi ,
		year_type_kpi : year_type_kpi,
    issue_year : issue_year,
		select_quarter_chk_kpi :  $('#select_quarter_chk_kpi').val(),
		month : month,
		startDate_kpi : $('#startDate_kpi').val(),
		stopDate_kpi : $('#stopDate_kpi').val(),
		search_kpi : $('#search_kpi').val()
	};
  // console.log(data);
	$.ajax({
		url: "dashboard/kpi.php",
		type: "post",
		data: data ,
		success: function (data) {
			$(".data_kpi").html(data);
		}
	})
}
