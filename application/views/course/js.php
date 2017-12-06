<script type="text/javascript">

    var tblSubjectList;
    var room_laboratory = room_lecture = [];
    var eventsToSave = {};
    var schedObj;
    var sec;
    var subject = {};
    var dupCount = 1;
    var moveCount = 1;
    var secToEdit;
    var contextMenuEventSelected;
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();

    // loadRenderedEvents();
    // loadPlottedEvents();
    // resetPlottedSchedule();

    $(document).ready(function(){

        $("li.page_menu").removeClass("active");

        $("#menu_course_sched").addClass("active");

        $("#select2Program").select2();

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });



        //initialize subject datatable
        tblSubjectList = $("#example").DataTable({
            paging: false,
            "bInfo": false
        });


        // setInterval(loadPlottedEvents, 1000);
//        window.addEventListener("beforeunload", function (e) {
//            var confirmationMessage = 'It looks like you have been editing something. '
//                + 'If you leave before saving, your changes will be lost.';
//
//            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
//            return confirmationMessage; //Gecko + Webkit, Safari, Chrome eventtc.
//        }); 



    });


  function searchSubject(key) {
    tblSubjectList.fnFilter(key);
  }


  function setCurriculumSched() {
    if ($("#setSchedModal input#ownsectioncode").val() == "") {
      sec = $("#setSchedModal span#sectioncode").html();
    }
    else {
      sec = $("#setSchedModal input#ownsectioncode").val();
    }

    if (activeTab == 'subject') {

      $.each($("input[type='checkbox'][name='subj_id']:checked"), function () {

        subject[$(this).val()] = {
          subj_id: $(this).val(),
          subj_code: $(this).attr('subjcode'),
          subj_name: $(this).attr('subjname'),
          lec_unit: $(this).attr('lecunit'),
          lab_unit: $(this).attr('labunit'),
          split: $(this).attr('split'),
          lab_hour: $(this).attr('labhour'),
          lec_hour: $(this).attr('lechour')
        };

      });
    }
    else {

    }

    schedObj = {
      program: $("#setSchedModal select#program").val(),
      prog_name: $("#setSchedModal select#program option:selected").attr("progname"),
      major: $("#setSchedModal input#major").val(),
      year: $("#setSchedModal select#yearlvl").val(),
      semister: $("#setSchedModal select#semister").val(),
      sy: $("#setSchedModal select#schoolyear").val(),
      section: sec,
      curryearlvl: $("#setSchedModal select#curryearlvl").val(),
      currsemister: $("#setSchedModal select#currsemister").val(),
      currsy: $("#setSchedModal select#currsy").val(),
      schedule: $("#setSchedModal input[type=radio][name=schedule]:checked").val(),
      subjects: subject,
    };

    console.log(schedObj);

    setDetails(schedObj);

    $.ajax({
      url: "<?php echo base_url('course/setSchedule') ?>",
      data: {sched: schedObj, type: activeTab},
      type: "GET",
      dataType: "json",
      success: function (data) {

        $(".roomCalendar").fullCalendar('removeEvents');
        // loadRenderedEvents();
        // loadPlottedEvents();

        for (var i = 0; i < data.length; i++) {


          $("#" + data[i]['room']).fullCalendar('addEventSource', [data[i]]);

          var dataToSave = {
            year_lvl: data[i].year_lvl,
            sy: data[i].sy,
            sem: data[i].sem,
            subj_id: data[i].subj_id,
            composition: data[i].composition,
            rl_id: data[i].rl_id,
            time_start: data[i].time_start,
            time_end: data[i].time_end,
            ss_id: data[i].ss_id
          };

          var key = data[i]['key'];
          eventsToSave[key] = dataToSave;
        }
      },
      error: function () {

      }
    });
    var html = '<button onclick="cancelEdit()" class="btn btn-success pull-right m-l-5"> Cancel</button>';
    html += '<button onclick="saveSubjectSched()" class="btn btn-success pull-right m-l-5"> Save</button>';
//    $("#buttonContainer").html("<button onclick=\"cancelEdit()\" class=\"btn btn-sm btn-success pull-right m-l-5\">Cancel</button> <button onclick=\"saveSubjectSched()\" class=\"btn btn-sm btn-info pull-right m-l-5\">Save</button>");
    $("#buttonContainer").html(html);
    console.log(eventsToSave);
  } 

  function saveSubjectSched() {
    if (!jQuery.isEmptyObject(eventsToSave)) {
      bootbox.confirm("Are you sure you want to save schedule?", function (result) {
        if (result == true) {
          $.ajax({
            url: "<?php echo base_url('course/saveSubjectSched') ?>",
            data: {input: eventsToSave, section: sec, sectionData: schedObj},
            type: "POST",
            dataType: "HTML",
            success: function (data) {
              // showMessage('Success', 'Schedule Saved', 'success');
              // resetPlottedSchedule();
              alert(data);
            },
            error: function () {

            }
          });
        }
      });
    }
    else {
      showMessage('Error', 'No schedule is set.', 'error');
    }
  }
      
  function loadRenderedEvents() {

    $.ajax({
      url: "<?php echo base_url('course/loadRenderingEvents') ?>",
      dataType: "json",
      success: function (data) {
        $(".roomCalendar").fullCalendar('removeEvents');
        for (var i = 0; i < data.length; i++) {
          $("#" + data[i]['room']).fullCalendar('addEventSource', [data[i]]);
        }
      },
      error: function () {

      }
    });
  }

  function loadPlottedEvents() {l
    $.ajax({
      url: "<?php echo base_url('course/loadPlottedEvents') ?>",
      dataType: "json",
      success: function (data) {
        $(".roomCalendar").fullCalendar('rerenderEvents');
        for (var i = 0; i < data.length; i++) {
          $("#" + data[i]['room']).fullCalendar('addEventSource', [data[i]]);
        }
      },
      error: function () {

      }
    });
  }

  function moveEvent() {

    $("#moveEventModal").modal('show');

    loadMoveRooms();

    HideMenu('contextMenu');
  }

  function moveConfirm() {
    var e = contextMenuEventSelected;
    var selectRoom = $("#moveEventModal select[name=rooms]").val();
    var rl_id = $('#moveEventModal select[name=rooms] option:selected').attr('rl_id');

    bootbox.confirm("Are you sure you want to move subject?", function (result) {
      if (result == true) {

        // delete eventsToSave[e.ss_id];
        $("#" + e.room).fullCalendar('removeEvents', e.id);

        var eventData = {
          composition: e.start.format("dddd"),
          key: e.key,
          id: e.id,
          year_lvl: e.year_lvl,
          sy: e.sy,
          sem: e.sem,
          subj_id: e.subj_id,
          sd_id: e.sd_id,
          rl_id: rl_id,
          time_start: e.start.format("HH:mm:ss"),
          time_end: e.end.format("HH:mm:ss"),
          room: selectRoom,
          title: e.title,
          start: e.start.format("YYYY-MM-DD HH:mm:ss"),
          end: e.end.format("YYYY-MM-DD HH:mm:ss"),
          allDay: e.allDay,
          color: e.color,
          textColor: e.textColor,
          type: e.type,
          ss_id: e.ss_id,
          bs_id: e.bs_id
        };

        var dataToSave = {
          year_lvl: eventData.year_lvl,
          sy: eventData.sy,
          sem: eventData.sem,
          subj_id: eventData.subj_id,
          composition: eventData.composition,
          rl_id: eventData.rl_id,
          time_start: eventData.time_start,
          time_end: eventData.time_end,
          ss_id: eventData.ss_id,
          bs_id: eventData.bs_id
        };

        eventsToSave[eventData.key] = dataToSave;

        $("#" + selectRoom).fullCalendar('addEventSource', [eventData]);
        // console.log(eventsToSave);
        $("#moveEventModal").modal('hide');
      }
    });
  }

  function loadMoveRooms() {

    var e = contextMenuEventSelected;

    console.log(e);

    $("#moveEventModal select[name=rooms]").html("");

    $.ajax({
      url: "<?php echo base_url('course/getMoveRooms') ?>",
      data: {type: e.type, except: e.rl_id},
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        $.each(data, function (key, value) {
          $("#moveEventModal select[name=rooms]").append('<option rl_id="'+value.rl_id+'" value="'+value.room_code+'">'+value.room_name + " ("+ value.room_code+")"+'</option>');
        });
      },
      error: function () {

      }

    });
  }

  function viewScheduleSection(bs_id) {
    secToEdit = bs_id;
    $.ajax({
      url: "<?php echo base_url('course/viewSectionSchedule') ?>",
      data: {bs_id: bs_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        $(".roomCalendar").fullCalendar('removeEvents');
        loadEditRenderedEvents(bs_id);
        for (var i = 0; i < data[0].length; i++) {
          $("#" + data[0][i]['room']).fullCalendar('addEventSource', [data[0][i]]);

          var dataToSave = {
            year_lvl: data[0][i].year_lvl,
            sy: data[0][i].sy,
            sem: data[0][i].sem,
            subj_id: data[0][i].subj_id,
            composition: data[0][i].composition,
            rl_id: data[0][i].rl_id,
            time_start: data[0][i].time_start,
            time_end: data[0][i].time_end,
            ss_id: data[0][i].ss_id,
            bs_id: data[0][i].bs_id
          };

          var key = data[0][i].key;
          eventsToSave[key] = dataToSave;
        }
        setDetails(data[1]);
        $("#buttonContainer").html("<button onclick=\"cancelEdit()\" class=\"btn btn-sm btn-success pull-right m-l-5\">Cancel</button> <button onclick=\"updateSchedule()\" class=\"btn btn-sm btn-info pull-right m-l-5\">Update</button>");
      },
      error: function () {

      }
    });
  }

  function loadEditRenderedEvents(bs_id) {
    $.ajax({
      url: "<?php echo base_url('course/loadEditRenderingEvents') ?>",
      data: {bs_id: bs_id},
      type: "GET",
      dataType: "json",
      success: function (data) {
        // $(".roomCalendar").fullCalendar('removeEvents');
        for (var i = 0; i < data.length; i++) {
          $("#" + data[i]['room']).fullCalendar('addEventSource', [data[i]]);
        }
      },
      error: function () {

      }
    });
  }

  function updateSchedule() {
    if (!jQuery.isEmptyObject(eventsToSave)) {
      bootbox.confirm("Are you sure you want to update schedule?", function (result) {
        if (result == true) {
          $.ajax({
            url: "<?php echo base_url('course/updateSchedule') ?>",
            data: {input: eventsToSave},
            type: "POST",
            dataType: "html",
            success: function (data) {
              showMessage("Success", "Schedule has been updated successfully.", "success");
              alert(data);
            },
            error: function () {

            }
          });
        }
      });
    }
    else {
      showMessage('Error', 'No schedule is set.', 'error');
    }
  }

  function cancelEdit() {
    eventsToSave = {};
    schedObj = {};
    sec = "";
    dupCount = 1;
    moveCount = 1;
    $(".roomCalendar").fullCalendar('removeEvents');
    loadRenderedEvents();
    loadPlottedEvents();
    $("#setScheduleContent span").html("...");
    $("#buttonContainer").html("<button onclick=\"$('#setSchedModal').modal('show')\" class=\"btn btn-sm btn-success pull-right m-l-5\">Set sched</button> <button onclick=\"saveSubjectSched()\" class=\"btn btn-sm btn-info pull-right m-l-5\">Save</button>");
  }

  function setDetails(data) {

    $("#setScheduleContent span.schedDetailsProgram").html(data.prog_name);
    $("#setScheduleContent span.schedDetailsMajor").html(data.major);
    $("#setScheduleContent span.schedDetailsYear").html(data.year);
    $("#setScheduleContent span.schedDetailsSemister").html(data.semister);
    $("#setScheduleContent span.schedDetailsSY").html(data.sy);
    $("#setScheduleContent span.schedDetailsSection").html(data.section);
  }

  function updatePlottedSched(sched) {

    $.ajax({
      url: "<?php echo base_url('course/updatePlottedSched') ?>",
      data: {s: sched},
      type: "GET",
      dataType: "json",
      success: function (data) {
        console.log(data);
      },
      error: function () {

      }
    });
  }

  function resetPlottedSchedule() {

    $.ajax({
      url: "<?php echo base_url('course/resetPlottedSchedule') ?>",
      dataType: "json",
      success: function (data) {
        console.log(data);
      },
      error: function () {

      }
    });
  }

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

  function clickOnMenu(event) {
    
    event.stopPropagation();
  }


  document.body.addEventListener('mousedown', clickOnBody, false);
  document.body.addEventListener('touchstart', clickOnBody, false);


  var menu = document.getElementById('contextMenu');
  menu.addEventListener('mousedown', clickOnMenu, false);
  menu.addEventListener('mouseup', clickOnMenu, false);
  menu.addEventListener('touchstart', clickOnMenu, false);

</script>