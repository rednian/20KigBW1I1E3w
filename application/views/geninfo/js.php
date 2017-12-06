<script type="text/javascript">
  $(document).ready(function () {
    $("li.page_menu").removeClass("active");
    $("#menu_gen_info").addClass("active");

    $('input#shsCheckbox').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    }).on('ifChanged', function (e) {
      // Get the field name
      var isChecked = e.currentTarget.checked;
      if (isChecked == true) {
        $("#btnSetRate").removeClass('hide');
      }
      else {
        $("#btnSetRate").addClass('hide');
      }
    });

    $('input#abbvCheckbox').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    }).on('ifChanged', function (e) {
      // Get the field name
      var isChecked = e.currentTarget.checked;
      if (isChecked == true) {
        $("#abbvTextbox").attr("readonly", false);
      }
      else {
        $("#abbvTextbox").attr("readonly", true);
      }
    });

    $('input#progcodeCheckbox').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    }).on('ifChanged', function (e) {
      // Get the field name
      var isChecked = e.currentTarget.checked;
      if (isChecked == true) {
        $("#progcodeTextbox").attr("readonly", false);
      }
      else {
        $("#progcodeTextbox").attr("readonly", true);
      }
    });
  });

  // TAB CUSTOM JS
  var tabInstructorShown = false;
  $(document).ready(function () {

    $('div[data-toggle="tab"]').on('shown.bs.tab', function (e) {

      // CONTENT
      $('div[data-toggle="tab"]').removeClass("active");
      var x = $(this).attr("href");

      location.href = x;
      var element = "div[data-toggle=tab][href=" + x + "]";
      $(element).addClass("active");

      // INPUTS
      $(".tab-inputs").addClass("hide");
      $(".tab-inputs[tab-toggle=" + x + "]").removeClass("hide");

      if (x == "#tab-instructor" && tabInstructorShown == false) {
        tabInstructorShown = true;
        var date = new Date();
        var d = date.getDate(),
          m = date.getMonth(),
          y = date.getFullYear();
        var $calendar = $("#calendar");
        $calendar.fullCalendar({
          // defaultDate: moment(),
          defaultView: 'agendaWeek',
          header: {
            left: '',
            right: ''
          },
          minTime: "07:00:00",
          maxTime: "21:30:00",
          columnFormat: {
            week: 'ddd'
          },
          events: "<?php echo base_url('gen_info/get_instuctor_sched') ?>",
          slotMinutes: 30,
          allDaySlot: false,
          editable: false,
          droppable: false,
          firstDay: 1,
          height: 600,
          eventMouseover: function (data, event, view) {
            tooltip = '<div class="tooltiptopicevent" style="color:#0085B2;border-radius: 5px;width:auto;height:auto;background:#CCC;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'Subject: ' + ': ' + data.subject + '</br>' + 'Start: ' + ': ' + data.time_start + '</br>End: ' + data.time_end + '</br>Day: ' + data.composition + '</br>Room: ' + data.room + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function (e) {
              $(this).css('z-index', 10000);
              $('.tooltiptopicevent').fadeIn('500');
              $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
              $('.tooltiptopicevent').css('top', e.pageY + 10);
              $('.tooltiptopicevent').css('left', e.pageX + 20);
            });
          },
          eventMouseout: function (data, event, view) {
            $(this).css('z-index', 8);

            $('.tooltiptopicevent').remove();

          }
        });
      }
    });
  });

  var tblRoom;
  var tblDay;
  var tblCourse;
  var tblOthers;
  var tblTime;
  var tblInstructor;
  var tblServiceList;
  var tblProgram;

  $(document).ready(function () {
    tblRoom = $("#tblRoom").dataTable({
      "bSort": false,
      "bLength": false,
      "bInfo": false,
      pageLength: 25
    });
    tblDay = $("#tblDay").dataTable({
      "bSort": false,
      "bLength": false,
      "bInfo": false
    });
    tblCourse = $("#tblCourse").dataTable({
      "bSort": false,
      "bLength": false,
      "bInfo": false,
      pageLength: 25,
      order:[[2,'ASC']]
    });
    tblOthers = $("#tblOthers").dataTable({
      "bSort": false,
      "bLength": false,
      "bInfo": false
    });
    tblTime = $("#tblTime").dataTable({
      "bSort": false,
      "bLength": false,
      "bInfo": false,
      pageLength: 50
    });


    tblInstructor = $("#tblInstructorList").dataTable({
      "bSort": false,
      "bLengthChange": false,
      // "bInfo"   : false,
      "bFilter": true,
      pagingType: 'simple',
      destroy: true,
      processing: true,
      pageLength: 20,
      "oLanguage": {
        "sSearch": "<i class='fa fa-search'></i> ",
        "oPaginate": {
          "sNext": '<i class="fa fa-chevron-right"></i>',
          "sPrevious": '<i class="fa fa-chevron-left"></i>',
          "sFirst": '<i class="fa fa-angle-double-left"></i>',
          "sLast": '<i class="fa fa-angle-double-right"></i>'
        }
      }
    });


    tblServiceList = $("#tblServiceList").dataTable({
      "bSort": false,
      "bLengthChange": false,
      // "bInfo"   : false,
      "bFilter": false,
      pageLength: 25,
      pagingType: 'simple',
      "oLanguage": {
        "sSearch": "<i class='fa fa-search'></i> ",
        "oPaginate": {
          "sNext": '<i class="fa fa-chevron-right"></i>',
          "sPrevious": '<i class="fa fa-chevron-left"></i>',
          "sFirst": '<i class="fa fa-angle-double-left"></i>',
          "sLast": '<i class="fa fa-angle-double-right"></i>'
        }
      },
    });
    tblProgram = $("#tblProgram").dataTable({
      "bSort": false,
      "bLengthChange": false,
      "bInfo": true,
      "oLanguage": {
        "sSearch": "<i class='fa fa-search'></i> ",
        "oPaginate": {
          "sNext": '<i class="fa fa-chevron-right"></i>',
          "sPrevious": '<i class="fa fa-chevron-left"></i>',
          "sFirst": '<i class="fa fa-angle-double-left"></i>',
          "sLast": '<i class="fa fa-angle-double-right"></i>'
        }
      },
      "columnDefs": [
        {className: "text-right", "targets": [1]}
      ]
    });
  });

  $(function () {
    loadRoomList();
    loadDayList();
    loadSubjectList();
    loadInstructorList();
    loadOtherList();
  });

  // ---------------------------------------------- ROOM JS -----------------------------------------------------------
  $(document).ready(function () {
    // $("form#formAddRoom").on("submit", function (e) {
    //   e.preventDefault();
    //   $.ajax({
    //     url: "<?php echo base_url('gen_info/roomSave') ?>",
    //     data: $(this).serialize(),
    //     type: "post",
    //     dataType: "json",
    //     success: function (data) {
    //       if (data.result == true) {
    //         loadRoomList();
    //         $("form#formAddRoom button[type=reset]").trigger('click');

    //         if (data.type == 'new') {
    //           showMessage('Success', 'Room has been saved successfully.', 'success');
    //         }
    //         else if (data.type == 'update') {
    //           showMessage('Success', 'Room has been updated successfully.', 'success');
    //         }
    //       }
    //       else if (data.result == "validateError") {
    //         $(".error_message_room").html(data.errors);
    //       }
    //       else {
    //         showMessage('Error', 'Transaction error.', 'error');
    //       }
    //     },
    //     error: function () {
    //       showMessage('Error', 'Function error.', 'error');
    //     }
    //   });
    // });
  });

  function loadRoomList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/roomList') ?>",
      dataType: "json",
      success: function (data) {
        tblRoom.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblRoom.fnAddData([
            value['room_code'],
            value['room_name'],
            value['capacity'],
            value['type'],
            value['desc'],
            "<span class='pull-right'><button onclick='editRoom(" + value['rl_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-pencil\"></i></button> <button onclick='confirmDeleteRoom(" + value['rl_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-trash\"></i></button></span>"
          ]);

          var oSettings = tblRoom.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['rl_id']);
        });
      },
      error: function () {

      }
    });
  }

  function confirmDeleteRoom(rl_id) {
    bootbox.confirm("Are you sure you want to delete room?", function (result) {
      if (result == true) {
        deleteRoom(rl_id);
      }
    });
  };

  function deleteRoom(rl_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/roomDelete'); ?>",
      data: {rl_id: rl_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        if (data['result'] == true) {
          $("#tblRoom tr#" + rl_id).fadeOut();
          showMessage('Success', 'Room has been deleted successfully.', 'success');
        }
        else if (data['result'] == false) {
          showMessage('Error', 'Unable to delete room. Please try again', 'error');
        }
      },
      error: function () {
        showMessage('Error', 'Function error.', 'error');
      }
    });
  }

  function editRoom(rl_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/roomEdit'); ?>",
      data: {rl_id: rl_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (key, value) {
          $.each(value, function (key1, value1) {
            $("form#formAddRoom input[name=" + key1 + "]").val(value1);
          });
          $("form#formAddRoom select[name=type]").val(value['type']);
          $("form#formAddRoom textarea[name=desc]").val(value['desc']);
        });

      },
      error: function () {

      }
    });

  }

  // ----------------------------------------------- DAY JS ------------------------------------------------------
  $(document).ready(function () {
    $("form#formAddDay").on("submit", function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url('gen_info/daySave') ?>",
        data: $(this).serialize(),
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.result == true) {
            loadDayList();
            $("form#formAddDay button[type=reset]").trigger('click');
            if (data.type == 'new') {
              showMessage('Success', 'Day has been saved successfully.', 'success');
            }
            else if (data.type == 'update') {
              showMessage('Success', 'Day has been updated successfully.', 'success');
            }
          }
          else if (data.result == "validateError") {
            $(".error_message_day").html(data.errors);
          }
          else {
            showMessage('Error', 'Transaction error.', 'error');
          }
        },
        error: function () {
          showMessage('Error', 'Function error.', 'error');
        }
      });
    });
  });

  function loadDayList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/dayList') ?>",
      dataType: "json",
      success: function (data) {
        tblDay.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblDay.fnAddData([
            value['abbreviation'],
            value['composition'],
            '',
            '',
            '',
            "<span class='pull-right'><button onclick='editDay(" + value['sd_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-pencil\"></i></button> <button onclick='confirmDeleteDay(" + value['sd_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-trash\"></i></button></span>"
          ]);

          var oSettings = tblDay.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['sd_id']);
        });
      },
      error: function () {

      }
    });
  }

  function confirmDeleteDay(sd_id) {
    bootbox.confirm("Are you sure you want to delete day?", function (result) {
      if (result == true) {
        deleteDay(sd_id);
      }
    });
  };

  function deleteDay(sd_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/dayDelete'); ?>",
      data: {sd_id: sd_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        if (data['result'] == true) {
          $("#tblDay tr#" + sd_id).fadeOut();
          showMessage('Success', 'Day has been deleted successfully.', 'success');
        }
        else if (data['result'] == false) {
          showMessage('Error', 'Unable to delete day. Please try again', 'error');
        }
      },
      error: function () {
        showMessage('Error', 'Function error.', 'error');
      }
    });
  }

  function editDay(sd_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/dayEdit'); ?>",
      data: {sd_id: sd_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (key, value) {
          $.each(value, function (key1, value1) {
            $("form#formAddDay input[name=" + key1 + "]").val(value1);
          });
        });
      },
      error: function () {

      }
    });
  }

  // ------------------------------------------------ time js --------------------------------------------------------
  function showPreviewTimeSplit() {

    var start = $('input[name=time_start]').val();
    var end = $('input[name=time_end]').val();
    var interval = $('input[name=interval]').val();
    var unit = $('select[name=unit]').val();

    // var data1 = [start, end, interval, unit];
    // console.log(data1);
    $.ajax({
      url: "<?php echo base_url('gen_info/previewInterval'); ?>",
      data: {start: start, end: end, interval: interval, unit: unit},
      type: "GET",
      dataType: "json",
      success: function (data) {
        tblTime.fnClearTable();
        $.each(data, function (key, value) {
          tblTime.fnAddData([
            value,
            '',
            '',
            '',
            '',
            ''
          ]);
        })
      },
      error: function () {

      }
    });
  }

  $(document).ready(function () {
    $("form#formAddTime").on("submit", function (e) {
      e.preventDefault();

      $.ajax({
        url: "<?php echo base_url('gen_info/timeSave') ?>",
        data: $(this).serialize(),
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.result == true) {
            $("form#formAddTime button[type=reset]").trigger('click');
            tblTime.fnClearTable();

            if (data.type == 'new') {
              showMessage('Success', 'Time has been saved successfully.', 'success');
            }
            else if (data.type == 'update') {
              showMessage('Success', 'Time has been updated successfully.', 'success');
            }
          }
          else {
            showMessage('Error', 'Transaction error.', 'error');
          }
        },
        error: function () {
          showMessage('Error', 'Function error.', 'error');
        }
      });


    });
  });

  // ---------------------------------------  COURSE JS ------------------------------------------------------ //

  $(document).ready(function () {
    $("form#formAddSubject").on("submit", function (e) {
      e.preventDefault();

      if ($("input#shsCheckbox[type=checkbox]").is(':checked')) {
        if (Object.keys(addedRate).length == 0) {
          showMessage('Error', 'Please add set subject rate basis.', 'error');
        }
        else {
          var subjtype = "Senior High";
          $.ajax({
            url: "<?php echo base_url('gen_info/subjectSave') ?>",
            data: $(this).serialize() + "&" + $.param({'rate': addedRate, 'subj_type': subjtype}),
            type: "post",
            dataType: "json",
            success: function (data) {
              if (data.result == true) {
                loadSubjectList();
                $("form#formAddSubject button[type=reset]").trigger('click');

                if (data.type == 'new') {
                  showMessage('Success', 'Subject has been saved successfully.', 'success');
                  console.log(data['rate']);
                  resetRate();
                }
                else if (data.type == 'update') {
                  showMessage('Success', 'Subject has been updated successfully.', 'success');
                  console.log(data['rate']);
                  resetRate();
                }
              }
              else if (data.result == false) {
                showMessage('Error', 'Transaction error.', 'error');
              }
              else if (data.result == "validateError") {
                $(".error_message").html(data.errors);
              }
            },
            error: function () {
              showMessage('Error', 'Function error.', 'error');
            }
          });
        }
      }
      else {
        var subjtype = "College";
        $.ajax({
          url: "<?php echo base_url('gen_info/subjectSave') ?>",
          data: $(this).serialize() + "&" + $.param({'rate': addedRate, 'subj_type': subjtype}),
          type: "post",
          dataType: "json",
          success: function (data) {
            if (data.result == true) {
              loadSubjectList();
              $("form#formAddSubject button[type=reset]").trigger('click');

              if (data.type == 'new') {
                showMessage('Success', 'Subject has been saved successfully.', 'success');
                console.log(data['rate']);
                resetRate();
              }
              else if (data.type == 'update') {
                showMessage('Success', 'Subject has been updated successfully.', 'success');
                console.log(data['rate']);
                resetRate();
              }
            }
            else if (data.result == false) {
              showMessage('Error', 'Transaction error.', 'error');
            }
            else if (data.result == "validateError") {
              $(".error_message").html(data.errors);
            }
          },
          error: function () {
            showMessage('Error', 'Function error.', 'error');
          }
        });
      }

    });
  });

  function loadSubjectList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/subjectList') ?>",
      dataType: "json",
      success: function (data) {
        tblCourse.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblCourse.fnAddData([
            value['subj_code'],
            value['subj_name'],
            value['lab_unit'],
            value['lec_unit'],
            value['split'],
            "<span class='pull-right'><button onclick='editSubject(" + value['subj_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-pencil\"></i></button> <button onclick='confirmDeleteSubject(" + value['subj_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-trash\"></i></button></span>"
          ]);

          var oSettings = tblCourse.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['subj_id']);
        });
      },
      error: function () {

      }
    });
  }

  function editSubject(subj_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/subjectEdit'); ?>",
      data: {subj_id: subj_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data['subjData'], function (key, value) {
          $.each(value, function (key1, value1) {
            $("form#formAddSubject input[name=" + key1 + "]").val(value1);
          });
          $("form#formAddSubject textarea[name=subj_desc]").val(value['subj_desc']);

          // $("#shsCheckbox").iCheck('uncheck');

          if (value['subj_type'] == "Senior High") {
            $("#shsCheckbox").iCheck('check');
          }
          else {
            $("#shsCheckbox").iCheck('uncheck');
          }
        });

        $.each(data['rate'], function (key, value) {

          var display = "<div class=\"panel m-b-0\" id='rate" + countRate + "'>\
						        	<div class=\"panel-body p-t-0 p-b-5\">\
						        		<div class=\"row\">\
								        	<div class=\"col-md-8\">\
								        		Rate Name\
								        		<select class=\"form-control input-sm\">";
          display += "<option class='hide' selected ratename='" + rateObj[value.rn_id]['name'] + "' value='" + value.rn_id + "'>" + rateObj[value.rn_id]['name'] + "</option>";
          $.each(rateObj, function (key, value) {
            display += "<option ratename='" + value.name + "' value='" + value.id + "'>" + value.name + "</option>";
          });
          display += "</select>\
								        	</div>\
								        	<div class=\"col-md-4\">\
								        		Percentage\
								        		<div class=\"input-group input-group-sm\">\
								        			<input value='" + value.rate_num + "' data-parsley-type=\"number\" min=1 max=" + percent + " data-parsley-required=\"true\" type=\"text\" class=\"form-control input-sm txtpercent\">\
								        			<span class=\"input-group-addon\">%</span>\
								        		</div>\
								        	</div>\
								        </div>\
						        	</div>\
						        </div>";

          $("#modalRate .modal-body").append(display);
          // console.log(countRate);
          percent -= parseInt(value.rate_num);

          countRate++;
          delete rateObj[value.rn_id];
        });

      },
      error: function () {

      }
    });
  }

  function confirmDeleteSubject(sd_id) {

    bootbox.confirm("Are you sure you want to delete course?", function (result) {
      if (result == true) {
        deleteSubject(sd_id);
      }
    });
  };

  function deleteSubject(sd_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/subjectDelete'); ?>",
      data: {subj_id: sd_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        if (data['result'] == true) {
          $("#tblCourse tr#" + sd_id).fadeOut();
          showMessage('Success', 'Course has been deleted successfully.', 'success');
        }
        else if (data['result'] == false) {
          showMessage('Error', 'Unable to delete course. Please try again', 'error');
        }
      },
      error: function () {
        showMessage('Error', 'Function error.', 'error');
      }
    });
  }

  // ----------------------------------- INSTRUCTOR JS --------------------------------------------- //

  function loadInstructorList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/get_instructor_list') ?>",
      dataType: "json",
      success: function (data) {
        tblInstructor.fnClearTable();
        $.each(data, function (key, value) {

          var ext = value['employee_ext'] != null ? value['employee_ext'] :'';

          var newRow = tblInstructor.fnAddData([
            value['employee_fname'] + " " + value['employee_mname'][0] + " " + value['employee_lname'] + " " + ext,
            value['department_name']
          ]);

          var oSettings = tblInstructor.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['employment_id']);
        });
      },
      error: function () {

      }
    });
  }

  var selectedInstructor;
  var semister;
  var sy;

  $(document).ready(function () {
    $('#tblInstructorList tbody').on('click', 'tr', function () {
      var tr = $(this).closest('tr').attr("id");
      selectedInstructor = tr;

      $("table#tblInstructorList tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblInstructorList tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblInstructorList tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      if (semister != "" && sy != "") {
        showInstructorSched();
      }

    });

    $('#tblServiceList tbody').on('click', 'tr', function () {

      semister = $(this).closest('tr').attr("sem");
      sy = $(this).closest('tr').attr("sy");

      $("table#tblServiceList tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblServiceList tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblServiceList tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      if (selectedInstructor != "") {
        showInstructorSched();
      }

    });
  });

  function showInstructorSched() {
    var str = "gen_info/get_instuctor_sched?sem=" + semister + "&sy=" + sy + "&ins_id=" + selectedInstructor;
    var url = "<?php echo base_url('"+str+"') ?>";
    $("#calendar").fullCalendar('removeEvents');
    $("#calendar").fullCalendar('addEventSource', url);
  }

  // ---------------------------------------- OTHER SCHED JS --------------------------------------------------//
  $(document).ready(function () {
    $("form#formAddOtherSched").on("submit", function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url('gen_info/otherSave') ?>",
        data: $(this).serialize(),
        type: "post",
        dataType: "json",
        success: function (data) {
          if (data.result == true) {
            loadOtherList();
            $("form#formAddOtherSched button[type=reset]").trigger('click');

            if (data.type == 'new') {
              showMessage('Success', 'Schedule has been saved successfully.', 'success');
            }
            else if (data.type == 'update') {
              showMessage('Success', 'Schedule has been updated successfully.', 'success');
            }
          }
          else {
            showMessage('Error', 'Transaction error.', 'error');
          }
        },
        error: function () {
          showMessage('Error', 'Function error.', 'error');
        }
      });
    });
  });

  function loadOtherList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/otherList') ?>",
      dataType: "json",
      success: function (data) {
        tblOthers.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblOthers.fnAddData([
            value['work_name'],
            value['time_span'] + " " + value['time_unit'],
            value['description'],
            "<span class='pull-right'><button onclick=\"editOthers(" + value['os_id'] + ")\" class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-pencil\"></i></button> <button onclick='confirmDeleteOthers(" + value['os_id'] + ")' class=\"btn btn-xs btn-info no-radius\"><i class=\"fa fa-trash\"></i></button></span>"
          ]);

          var oSettings = tblOthers.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['os_id']);
        });
      },
      error: function () {

      }
    });
  }

  function confirmDeleteOthers(rl_id) {

    bootbox.confirm("Are you sure you want to delete schedule?", function (result) {
      if (result == true) {
        deleteOthers(rl_id);
      }
    });
  };

  function deleteOthers(rl_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/otherDelete'); ?>",
      data: {os_id: rl_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        if (data['result'] == true) {
          $("#tblOthers tr#" + rl_id).fadeOut();
          showMessage('Success', 'Schedule has been deleted successfully.', 'success');
        }
        else if (data['result'] == false) {
          showMessage('Error', 'Unable to delete schedule. Please try again', 'error');
        }
      },
      error: function () {
        showMessage('Error', 'Function error.', 'error');
      }
    });
  }

  function editOthers(rl_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/otherEdit'); ?>",
      data: {os_id: rl_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        $.each(data, function (key, value) {
          $.each(value, function (key1, value1) {
            $("form#formAddOtherSched input[name=" + key1 + "]").val(value1);
          });
          $("form#formAddOtherSched select[name=time_unit]").val(value['time_unit']);
          $("form#formAddOtherSched textarea[name=description]").val(value['description']);
        });
      },
      error: function () {

      }
    });
  }


  // RATING
  var countRate = 1;
  var rateObj = {};
  var countObj;
  var previous;
  var percent = 100;
  var addedRate = {};

  getRate();

  console.log(countRate);
  function getRate() {

    $.ajax({
      url: "<?php echo base_url('gen_info/rate') ?>",
      dataType: "json",
      success: function (data) {
        $.each(data, function (key, value) {
          rateObj[value.rn_id] = {id: value.rn_id, name: value.rate_name};
        });

        // countObj = rateObj.length;
        countObj = (Object.keys(rateObj).length);
      },
      error: function () {

      }
    });
  }


  $(document).ready(function () {
    $("#formAddRate").on("submit", function (e) {
      e.preventDefault();

      console.log(getRemainingPercent());

      if (getRemainingPercent() > 0) {
        if (countRate <= countObj) {
          console.log(countRate);
          var con = $('#rate' + (countRate - 1) + ' select').val();
          delete rateObj[con];

          if (countRate == 1) {
            percent -= 0;
          }
          else if (countRate > 1) {
            percent -= $('#rate' + (countRate - 1) + ' input.txtpercent').val();
          }

          $('#rate' + (countRate - 1) + ' select').attr("disabled", true);
          $('#rate' + (countRate - 1) + ' input.txtpercent').attr("disabled", true);

          var display = "<div class=\"panel m-b-0\" id='rate" + countRate + "'>\
						        	<div class=\"panel-body p-t-0 p-b-5\">\
						        		<div class=\"row\">\
								        	<div class=\"col-md-8\">\
								        		Rate Name\
								        		<select class=\"form-control input-sm\">";

          $.each(rateObj, function (key, value) {
            display += "<option ratename='" + value.name + "' value='" + value.id + "'>" + value.name + "</option>";
          });

          display += "</select>\
								        	</div>\
								        	<div class=\"col-md-4\">\
								        		Percentage\
								        		<div class=\"input-group input-group-sm\">\
								        			<input data-parsley-type=\"number\" min=1 max=" + percent + " data-parsley-required=\"true\" type=\"text\" class=\"form-control input-sm txtpercent\">\
								        			<span class=\"input-group-addon\">%</span>\
								        		</div>\
								        	</div>\
								        </div>\
						        	</div>\
						        </div>";

          $("#modalRate .modal-body").append(display);
          countRate++;

          console.log(rateObj);
          console.log(percent);
        }
      }
    });
  });

  function deleteRate() {

    if (countRate > 2) {
      var id = $('#rate' + (countRate - 2) + " select").val();
      var name = $('#rate' + (countRate - 2) + " select option:selected").attr('ratename');

      rateObj[id] = {id: id, name: name};

      $('#rate' + (countRate - 1)).remove();
      countRate--;

      $('#rate' + (countRate - 1) + ' select').attr("disabled", false);
      $('#rate' + (countRate - 1) + ' input.txtpercent').attr("disabled", false);

      percent = parseInt(percent) + parseInt($('#rate' + (countRate - 1) + ' input.txtpercent').val());

      console.log(rateObj);
      console.log(countRate);
      console.log(percent);
    }
  }

  function getRemainingPercent() {
    var totalPercent = 0;
    for (var x = 1; x < countRate; x++) {
      var percent = $('#rate' + (x) + " input.txtpercent").val();
      if ($('#rate' + (x) + " input.txtpercent").val() == "") {
        percent = 0;
      }
      totalPercent += parseInt(percent);
    }

    var remain = 100 - parseInt(totalPercent);
    return remain;
  }

  function setRate() {
    addedRate = {};
    var totalPercent = 0;
    for (var x = 1; x < countRate; x++) {

      var rate = $('#rate' + (x) + " select").val();
      var percent = $('#rate' + (x) + " input.txtpercent").val();

      var p = parseInt($('#rate' + (x) + " input.txtpercent").val());

      if ($('#rate' + (x) + " input.txtpercent").val() == "") {
        p = 0;
      }
      totalPercent += p;
      addedRate[x] = {rn_id: rate, rate_num: percent};
    }

    if (totalPercent < 100) {
      var remain = 100 - parseInt(totalPercent);
      showMessage('Information', 'The total rating percentage must be 100%. There is still have ' + remain + '% remaining.', 'error');
    }
    else if (totalPercent > 100) {
      showMessage('Information', 'The total rating percentage must be 100%.', 'error');
    }
    else {
      console.log(addedRate);
      $("#modalRate").modal("hide");
    }
  }

  function cancelAddRate() {
    bootbox.confirm("Are you sure you want to cancel?", function (result) {
      if (result == true) {
        countRate = 1;
        rateObj = {};
        countObj;
        percent = 100;
        addedRate = {};
        $("#modalRate .modal-body").html("");
        $("#modalRate").modal("hide");
        getRate();
      }
    });
  }

  function resetRate() {
    countRate = 1;
    rateObj = {};
    countObj;
    percent = 100;
    addedRate = {};
    $("#modalRate .modal-body").html("");
    getRate();
  }

  // ------------------------------ PROGRAM -----------------------------------------//

  getProgramList();

  function getProgramList() {
    $.ajax({
      url: "<?php echo base_url('gen_info/programList') ?>",
      dataType: "JSON",
      success: function (data) {
        tblProgram.fnClearTable();
        $.each(data, function (key, value) {
          var btnStatus = "";
          if (value.status == "active") {
            btnStatus = "<button onclick=\"changeStatusProgram('inactive'," + value.pl_id + ")\" class=\"btn btn-danger btn-xs\">Deactivate</button>";
          }
          else {
            btnStatus = "<button onclick=\"changeStatusProgram('active'," + value.pl_id + ")\" class=\"btn btn-info btn-xs\">Activate</button>";
          } 

          tblProgram.fnAddData([
            "<h5 class=\"m-b-0 m-t-0\" style=\"font-weight:bold\">" + value.prog_name + "</h5 class=\"text-bold\">\
            				<div>\
            					<small>Major: </small><small class=\"text-primary\">" + value.major + "</small>&nbsp;&nbsp;\
            					<small>Type: </small><small class=\"text-primary\">" + value.prog_type + "</small>&nbsp;&nbsp;\
            					<small>Level: </small><small class=\"text-primary\">" + value.level + "</small>\
            				</div>\
            				<div class=\"bg-primary p-2 m-t-2\">" + value.dep_name + "</div>",
            "<a href='javascript:;' onclick=\"location.href='#tab-program?edit=" + value.pl_id + "';editProgram()\" class=\"btn btn-warning btn-xs\">Modify</a> " + btnStatus
          ]);
        });
      },
      error: function () {

      }
    });
  }

  var pl_id = 0;
  function editProgram() {
    pl_id = 0;
    var hash = $(location).attr("hash");
    var tab = hash.split("?");
    var arr = hash.split("=");

    $("div[data-toggle=tab][href=" + tab[0] + "]").tab("show");

    if (arr.length > 1) {
      pl_id = arr[1];

      location.href = tab[0] + "?edit=" + pl_id;

      $.ajax({
        url: "<?php echo base_url('gen_info/modifyProgram') ?>",
        data: {pl_id: pl_id},
        type: "GET",
        dataType: "JSON",
        success: function (data) {

          $.each(data, function (key, value) {
            $.each(value, function (key1, value1) {
              $("[name=" + key1 + "]").val(value1);
            });
          });
        },
        error: function () {

        }
      });
    }
  }

  $(document).ready(function () {
    editProgram();
  });

  $(document).ready(function () {
    $("#frmAddProgram").on("submit", function (e) {
      e.preventDefault();
      if (pl_id == 0) {
        $.ajax({
          url: "<?php echo base_url('gen_info/addProgram') ?>",
          data: $(this).serialize(),
          type: "POST",
          dataType: "JSON",
          success: function (data) {
            if (data.result == true) {
              pl_id = 0;
             
              location.href = '#tab-program';

              $("form#frmAddProgram button[type=reset]").trigger('click');
             
              getProgramList();
             
              showMessage('Success', 'Program has been saved.', 'success');
            }
            else if (data.result == false) {
              showMessage('Error', 'Unable to save program. Please try again.', 'error');
            }
            else {
              showMessage('Validation Error', data.result, 'error');
            }
          },
          error: function () {
            showMessage('Error', 'Function error.', 'error');
          }
        });
      }
      else {
        // UPDATE
        $.ajax({
          url: "<?php echo base_url('gen_info/updateProgram') ?>",
          data: $(this).serialize() + "&pl_id=" + pl_id,
          type: "POST",
          dataType: "JSON",
          success: function (data) {
            
            if (data.result == true) {
              pl_id = 0;
              location.href = '#tab-program';

              $("form#frmAddProgram button[type=reset]").trigger('click');
              getProgramList();
              showMessage('Success', 'Program has been updated.', 'success');
            }
            else if (data.result == false) {
              showMessage('Error', 'Unable to update program. Please try again.', 'error');
            }
            else {
              showMessage('Validation Error', data.result, 'error');
            }
          },
          error: function () {
            showMessage('Error', 'Function error.', 'error');
          }
        });

      }
    });

    $("form#formAddDepartment").on("submit", function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo base_url('gen_info/addDepartment') ?>",
        data: $(this).serialize(),
        type: "POST",
        dataType: "JSON",
        success: function (data) {
          if (data.result == true) {
            $("form#formAddDepartment button[type=reset]").trigger('click');
            $("select#selectDepartment").append("<option value='" + data['last'][0] + "'>" + data['last'][1] + "</option>");
            showMessage('Success', 'Department has been saved.', 'success');
          }
          else if (data.result == false) {
            showMessage('Error', 'Unable to save department. Please try again.', 'error');
          }
          else {
            showMessage('Validation Error', data.result, 'error');
            ''
          }
        },
        error: function () {
          showMessage('Error', 'Function error.', 'error');
        }
      });
    });

    $("#frmAddProgram input[name=prog_name]").on("change", function () {
      $.ajax({
        url: "<?php echo base_url('gen_info/programAcronym') ?>",
        data: {prog_name: $(this).val()},
        type: "POST",
        dataType: "HTML",
        success: function (data) {
          $('input#abbvTextbox').val(data);
          $('input#progcodeTextbox').val(data);
        },
        error: function () {

        }
      });
    });
  });

  function resetFormProgram() {
    pl_id = 0;
    location.href = '#tab-program';
  }

  function changeStatusProgram(stat, pl_id) {
    $.ajax({
      url: "<?php echo base_url('gen_info/changeProgStatus') ?>",
      data: {status: stat, pl_id: pl_id},
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        if (data.result == true) {
          getProgramList();

          showMessage('Success', 'Program status has been updated.', 'success');

        }
        else {
          showMessage('Error', 'Unable to update program status.', 'error');
        }
      },
      error: function () {

      }
    });
  }

</script>