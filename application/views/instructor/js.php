<script type="text/javascript">

  // ------------------------------- CONTEXTMENU -----------------------------------------------//

  var contextMenuEventSelected;

  function ShowMenu(control, e) {
    var posx = e.clientX + window.pageXOffset + 'px'; //Left Position of Mouse Pointer
    var posy = e.clientY + window.pageYOffset + 'px'; //Top Position of Mouse Pointer
    document.getElementById(control).style.position = 'absolute';
    document.getElementById(control).style.display = 'inline';
    document.getElementById(control).style.left = posx;
    document.getElementById(control).style.top = posy;
    // content_menu_selected_id = id;
    // alert(posx+" - "+posy);
  }

  function HideMenu(control) {
    document.getElementById(control).style.display = 'none';
  }

  function clickOnBody(event) {
    HideMenu('contextMenu');
  }

  document.body.addEventListener('mousedown', clickOnBody, false);
  document.body.addEventListener('touchstart', clickOnBody, false);

  function clickOnMenu(event) {
    event.stopPropagation();
  }

  var menu = document.getElementById('contextMenu');
  menu.addEventListener('mousedown', clickOnMenu, false);
  menu.addEventListener('mouseup', clickOnMenu, false);
  menu.addEventListener('touchstart', clickOnMenu, false);

  // ------------------------------- END CONTEXT MENU -----------------------------------------------//

  $(document).ready(function () {
    $("li.page_menu").removeClass("active");
    $("#menu_course_load").addClass("active");
  });

  var tblServiceList;
  var tblCurriculum;
  var tblCourse;
  var tblBlockSection;
  var tblAllCourse;

  $(document).ready(function () {
    tblInstructor = $("#tblInstructorList").dataTable({
      "pageLength": 20,
      "pagingType": "simple",
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": true,
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

    
    tblCurriculum = $("#tblCurriculum").dataTable({
      "pageLength": 3,
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": false,
      "pagingType": "simple",
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

    tblBlockSection = $("#tblSectionList").dataTable({
      "pageLength": 3,
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": false,
      "pagingType": "simple",
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

    tblOffSectionList = $("#tblOffSectionList").dataTable({
      "pageLength": 3,
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": false,
      "pagingType": "simple",
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

    tblCourse = $("#tblCourse").dataTable({
      "pageLength": 5,
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": false,
      "pagingType": "simple",
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

    tblAllCourse = $("#tblAllCourse").dataTable({
      "pageLength": 5,
      "bSort": false,
      "bLengthChange": false,
      "bInfo": false,
      "bFilter": false,
      "pagingType": "simple",
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
  });

  $(document).ready(function () {
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
      maxTime: "22:00:00",
      columnFormat: {
        week: 'ddd'
      },
      slotMinutes: 15,
      allDaySlot: false,
      editable: false,
      droppable: false,
      firstDay: 1,
      eventRightclick: function (event, jsEvent, view) {
        ShowMenu('contextMenu', jsEvent);
        contextMenuEventSelected = event;
        return true;
      }
    });
  });

  $(function () {
    loadInstructorList();
    loadActiveCurriculum();
    loadOffSection();
  });

  function loadInstructorList() {
    $.ajax({
      url: "<?php echo base_url('instructor/listInstructor') ?>",
      dataType: "json",
      success: function (data) {
        tblInstructor.fnClearTable();
        $.each(data, function (key, value) {
            var ext = value['employee_ext'] != null ? value['employee_ext'] : '';

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

  function searchInstructor(val) {
    tblInstructor.fnFilter(val);
  }

  var pubSem = $("#selectSem").val();
  var pubSY = $("#selectSY").val();
  var pubInsID = 0;
  var pubBsID = 0;
  var pubSubjID = 0;
  var pubSubStat;

  $(document).ready(function () {

    $('#tblInstructorList tbody').on('click', 'tr', function () {

      var employee_id = $(this).closest('tr').attr("id");
      pubInsID = employee_id;

      $("table#tblInstructorList tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblInstructorList tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblInstructorList tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      showInstructorSched(employee_id);
    });

    $("#selectSY").on("change", function () {
      pubSY = $(this).val();
    });

    $("#selectSem").on("change", function () {
      pubSem = $(this).val();
    });
  });

  function showInstructorSched(insID) {

    var str = "instructor/get_instuctor_sched?sem=" + pubSem + "&sy=" + pubSY + "&ins_id=" + insID;
    var url = "<?php echo base_url('"+str+"') ?>";
    $("#calendar").fullCalendar('removeEvents');
    $("#calendar").fullCalendar('addEventSource', url);
  }

  function loadActiveCurriculum() {
    $.ajax({
      url: "<?php echo base_url('instructor/activeCurriculum') ?>",
      dataType: "JSON",
      success: function (data) {
        tblCurriculum.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblCurriculum.fnAddData([
            value[1]
          ]);

          var oSettings = tblCurriculum.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value[0]);
          $(nTr).attr("pl_id", value[2]);
          $(nTr).attr("sem", value[3]);
          $(nTr).attr("sy", value[4]);
        });
      },
      error: function () {

      }
    });
  }

  $(document).ready(function () {

    $('#tblCurriculum tbody').on('click', 'tr', function () {

      var tr = $(this).closest('tr').attr("id");
      var sy = $(this).closest('tr').attr("sy");
      var sem = $(this).closest('tr').attr("sem");
      var pl_id = $(this).closest('tr').attr("pl_id");

      $("table#tblCurriculum tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblCurriculum tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblCurriculum tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      // if(semister != "" && sy != ""){
      // 	showInstructorSched();
      // }
      loadBlockSection(sem, pl_id, sy, tr);
    });
  });

  function loadBlockSection(sem, pl_id, sy, tr) {
    $.ajax({
      url: "<?php echo base_url('instructor/loadBlockSection') ?>",
      data: {pl_id: pl_id, sem: sem, sy: sy, cur_id: tr},
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        tblBlockSection.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblBlockSection.fnAddData([
            "Section: " + value['sec_code'],
            value['year_lvl'],
            value['activation']
          ]);

          var oSettings = tblBlockSection.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['bs_id']);
        });
      },
      error: function () {

      }
    });
  }

  $(document).ready(function () {

    $('#tblSectionList tbody').on('click', 'tr', function () {

      var bs_id = $(this).closest('tr').attr("id");
      pubBsID = bs_id;

      $("table#tblSectionList tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblSectionList tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");

      $("#tblSectionList tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      loadSubject(bs_id);

    });
  });

  function loadOffSection() {
    $.ajax({
      url: "<?php echo base_url('instructor/loadOffSection') ?>",
      dataType: "JSON",
      success: function (data) {
        tblOffSectionList.fnClearTable();
        $.each(data, function (key, value) {
          var newRow = tblOffSectionList.fnAddData([
            "Section: " + value['sec_code'],
            value['year_lvl'],
            value['activation']
          ]);

          var oSettings = tblOffSectionList.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['bs_id']);
        });
      },
      error: function () {

      }
    });
  }

  $(document).ready(function () {

    $('#tblOffSectionList tbody').on('click', 'tr', function () {

      var bs_id = $(this).closest('tr').attr("id");
      pubBsID = bs_id;

      $("table#tblOffSectionList tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblOffSectionList tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblOffSectionList tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      loadSubject(bs_id);
    });
  });

  function loadSubject(bs_id) {
    $.ajax({
      url: "<?php echo base_url('instructor/loadSubject') ?>",
      data: {bs_id: bs_id},
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        tblCourse.fnClearTable();
        $.each(data, function (key, value) {
          var status = "";
          if (value.status == "taken") {
            status = "<i class='fa fa-check-square fa-2x pull-right'></i>";
          }
          else if (value.status == "vacant") {
            status = "<i class='fa fa-square-o fa-2x pull-right'></i>";
          }
          var newRow = tblCourse.fnAddData([
            value.subj_code,
            value.subj_name,
            value.lec_unit,
            value.lab_unit,
            status
          ]);
          var oSettings = tblCourse.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['subj_id']);
          $(nTr).attr("status", value['status']);
        });
      },
      error: function () {

      }
    });
  }

  function loadAllSubject() {
    $.ajax({
      url: "<?php echo base_url('instructor/loadAllSubject') ?>",
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        tblAllCourse.fnClearTable();
        $.each(data, function (key, value) {
          var status = "";
          if (value.status == "taken") {
            status = "<i class='fa fa-check-square fa-2x pull-right'></i>";
          }
          else if (value.status == "vacant") {
            status = "<i class='fa fa-square-o fa-2x pull-right'></i>";
          }
          var newRow = tblAllCourse.fnAddData([
            value.sec_code,
            value.subj_code,
            value.subj_name,
            value.lec_unit,
            value.lab_unit,
            status
          ]);
          var oSettings = tblAllCourse.fnSettings();
          var nTr = oSettings.aoData[newRow[0]].nTr;
          $(nTr).attr("id", value['subj_id']);
          $(nTr).attr("bs_id", value['bs_id']);
          $(nTr).attr("status", value['status']);
        });
      },
      error: function () {

      }
    });
  }

  $(document).ready(function () {

    $('#tblCourse tbody').on('click', 'tr', function () {

      var subj_id = $(this).closest('tr').attr("id");
      pubSubjID = subj_id;
      pubSubStat = $(this).closest('tr').attr("status");

      $("table#tblCourse tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblCourse tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblCourse tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      getCourseSchedules(subj_id, pubBsID, pubSubStat);
    });

    $('#tblAllCourse tbody').on('click', 'tr', function () {

      var subj_id = $(this).closest('tr').attr("id");
      var bs_id = $(this).closest('tr').attr("bs_id");
      pubSubjID = subj_id;
      pubSubStat = $(this).closest('tr').attr("status");

      $("table#tblAllCourse tbody tr td").css({"background": "none", "color": "#777"});
      $("table#tblAllCourse tbody tr").removeClass("activeRow");

      $(this).closest('tr').addClass("activeRow");
      $("#tblAllCourse tbody tr.activeRow td").css({"background": "rgb(179, 213, 224)", "color": "#FFF"});

      getCourseSchedules(subj_id, bs_id, pubSubStat);
    });
  });

  var schedToUpdate = {};

  function getCourseSchedules(subj_id, bs_id, stat) {
    var shedSTR = "";

    $.ajax({
      url: "<?php echo base_url('instructor/getSubjectSchedule') ?>",
      data: {subj_id: subj_id, bs_id: bs_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        schedToUpdate = {};

        if (!jQuery.isEmptyObject(data['Lecture'])) {
          shedSTR += "<h5 class=\"m-b-0\">Lecture</h5><ul class=\"schedule-list\">";
          $.each(data['Lecture'], function (key, value) {
            shedSTR += "<li>Room: " + value['room'] + " Schedule: " + value['sched'] + ", " + value['time_start'] + " - " + value['time_end'] + "</li>";

            schedToUpdate[value['ss_id']] = {ss_id: value['ss_id'], rl_id: value['rl_id'], sd_id: value['sd_id'], time_start: value['start'], time_end: value['end']};
          });
          shedSTR += "</ul>";
        }
        if (!jQuery.isEmptyObject(data['Laboratory'])) {
          shedSTR += "<h5 class=\"m-b-0\">Laboratory</h5><ul class=\"schedule-list\">";
          $.each(data['Laboratory'], function (key, value) {
            shedSTR += "<li>Room: " + value['room'] + " Schedule: " + value['sched'] + ", " + value['time_start'] + " - " + value['time_end'] + "</li>";

            schedToUpdate[value['ss_id']] = {ss_id: value['ss_id'], rl_id: value['rl_id'], sd_id: value['sd_id'], time_start: value['start'], time_end: value['end']};
          });
          shedSTR += "</ul>";
        }

        var status = {taken: "disabled", vacant: false};

        $("#btnGiveIn").attr("disabled", status[stat]);
        $("#panelSubSched #shedContainer").html(shedSTR);
        console.log(schedToUpdate);
      },
      error: function () {

      }
    });
  }

  function giveScheduleInstructorSched() {
    if (pubInsID == 0) {
      showMessage("Error", "Please select instructor first before saving schedule.", "error");
    }
    else if (pubSubjID == 0) {
      showMessage("Error", "Please select subject first before saving schedule.", "error");
    }
    else if (pubSubStat == "taken") {
      showMessage("Error", "The selected schedule is already taken.", "error");
    }
    else {
      bootbox.confirm("Are you sure you want to set schedule?", function (result) {
        if (result == true) {
          $.ajax({
            url: "<?php echo base_url('instructor/giveInSchedule') ?>",
            data: {employee_id: pubInsID, data: schedToUpdate},
            type: "GET",
            dataType: "json",
            success: function (data) {
              if (data.result == "updated") {
                loadSubject(pubBsID);
                showInstructorSched(pubInsID);
                showMessage("Success", "The schedule has given successfully.", "success");
              }
              else if (data.result == "hasConflict") {
                showMessage("Warning", "The schedule has conflict with other schedule.", "error");
              }
            },
            error: function () {
              console.log("ERROR");
            }
          });
        }
      });

    }
  }

  function removeSubjectFromInstructor() {

    HideMenu('contextMenu');

    var subj_id = contextMenuEventSelected.subj_id;
    var bs_id = contextMenuEventSelected.bs_id;

    bootbox.confirm("Are you sure you want to remove subject?", function (result) {
      if (result == true) {
        $.ajax({
          url: "<?php echo base_url('instructor/removeSubjectFromInstructor') ?>",
          data: {subj_id: subj_id, bs_id: bs_id},
          type: "GET",
          dataType: "JSON",
          success: function (data) {
            if (data.result == true) {
              loadSubject(pubBsID);
              showInstructorSched(pubInsID);
              showMessage("Success", "The subject has been removed successfully.", "success");
            }
            else if (data.result == false) {
              showMessage("Error", "Cannot remove subject. Please try again.", "error");
            }
          },
          error: function () {

          }
        });
      }

    });
  }

</script>