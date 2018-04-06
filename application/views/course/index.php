
<?php $this->load->view('course/dialog/modal-schedule-list'); ?>
<?php $this->load->view('course/dialog/modal-add-schedule'); ?>
<?php $this->load->view('course/dialog/modal-room-schedule-list'); ?>
<?php $this->load->view('course/dialog/modal-move-to-room'); ?>

<div id="content" class="content">

    <section class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-inline" id="frm-schedule" method="get" action="#">
                        <div class="form-group">
                            <label for="school_year">School Year</label>
                            <select name="school_year" id="sy" class="form-control input-sm">
                                <option disabled>Choose School Year</option>
                                <?php if (!empty($section_school_year)): ?>
                                    <?php foreach ($section_school_year as $section): ?>
                                        <option value="<?php echo $section->sy; ?>"><?php echo $section->sy; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <label class="radio-inline"><input id="first-semester" type="radio" name="semester" <?php echo   $active = semester('first') ? 'checked':''; ?> value="first semester"> First Semester</label>
                        <label class="radio-inline"><input id="second-semester" type="radio" name="semester" <?php echo   $active = semester('second') ? 'checked':''; ?> value="second semester"> Second Semester</label>
                        <button type="submit" class="btn btn-success btn-sm" >display schedule</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button onclick="loadScheduleList();$('#modalScheduleList').modal('show')" class="btn btn-info btn-sm pull-right">
                        Schedule List
                    </button>
                    <button onclick="$('#setSchedModal').modal('show');" class="btn btn-sm btn-success pull-right">Set Schedule</button>
                </div>
            </div>

        </div>
    </section>

    <div class="row">
        <!-- LEFT -->
        <div class="col-lg-6">
            <div class="row p-t-5 p-b-5">
                <div class="col-md-12 clearfix">Lecture Room
                    <small class="pull-right">Total
                        Rooms: <span class="badge badge-danger">  <?php echo $retVal = (!empty($lectureRooms)) ? count($lectureRooms) : 0; ?></span></small>
                </div>
            </div>
            <div class="row m-t-5">
                <div class="col-md-12 p-l-0 p-r-5" id="lec-room-container">
<!--                    --><?php //$this->load->view('course/include/lecture_room'); ?>
                </div>
            </div>
        </div>
        <!-- RIGHT -->
        <div class="col-lg-6">
            <div class="row p-t-5 p-b-5">
                <div class="col-md-12 clearfix">Laboratory Room
                    <small class="pull-right">Total

                        Rooms : <span class="badge badge-danger"> <?php echo $retVal = (!empty($labRooms)) ? count($labRooms) : 0; ?></span></small>
                </div>
            </div>
            <div class="row m-t-5">
                <div class="col-md-12 p-l-5 p-r-0" id="lab-room-container">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="list-group" id="contextMenu">
    <!-- <a href="#" onclick="duplicateEvent()" class="list-group-item"><i class="fa fa-copy"></i> Duplicate</a> -->
    <a href="#" onclick="moveEvent()" class="list-group-item"><i class="fa fa-mail-forward"></i> Move</a>
    <!-- <a href="#" onclick="" class="list-group-item"><i class="fa fa-times"></i> Remove</a> -->
</div>

<script>

    // add schedule modal
    var _current_year_level = $('#yearlvl').val();
    var _current_semester = $('#semister').val();
    var _current_sy = $('#schoolyear').val();
    var _program_id = $('#program').val();

    var _curriculum_year_level = $('#curryearlvl').val();
    var _curriculum_year_semester = $('#currsemister').val();
    var _curriculum_revision = $('#currsy').val();
    var _section_code = $('#sectioncode').val();
    var lecture_room_id = {};
    var lab_room_id = {};

    var sy = $('#sy').val();
    var semester = $('#first-semester').is(':checked') ? 'first semester' : 'second semester';

    $(document).ready(function () {

        console.log(semester);
        displaySchedule();
        loadRooms();

        //after closing the room modal, table should be cleared.
        $('#modalSubjectScheduling').on('hidden.bs.modal', function (e) {
            room_laboratory = room_lecture = [];
        });

    });

    function displaySchedule() {
        $('form#frm-schedule').submit(function (e) {
            e.preventDefault();


           if ($('#first-semester').is(':checked')) {
            semester = $('#first-semester').val();
           }

           if ($('#second-semester').is(':checked')) {
            semester = $('#second-semester').val();
           }


            $.ajax({
                url:'<?php echo base_url('course/get_plotted_room'); ?>',
                data: {room_code: room_code, sy: sy, semester: semester},
                success:function (data) {
                    loadRooms();
                }
            });

        });
    }
    
    function loadRooms() {
        roomSchedule('div#lec-room-container', 'lecture');
        roomSchedule('div#lab-room-container', 'laboratory');
        laboratoryRoom();
        lectureRoom();
    }

    function lectureRoom() {
        roomByType('lecture');

        $.each(lecture_room_id, function (index, room) {

           var room_code = room.room_code;

            $.ajax({
                url: '<?php echo base_url('course/get_plotted_room')?>',
                data: {room_code: room_code, sy: sy, semester: semester},
                dataType:'json',
                success:function (data) {
                    $('#'+room_code).fullCalendar('removeEvents');
                    $('#'+room_code).fullCalendar('addEventSource', data);
                    $('#'+room_code).fullCalendar('refetchEvents');
                }
            });

          $('#'+room_code).fullCalendar({
              defaultView: 'agendaWeek',
              header: {left: '', right: ''},
              minTime: "<?php echo date('H:i', strtotime($time->time_start)); ?>",
              maxTime: "<?php echo date('H:i', strtotime($time->time_end)); ?>",
              columnFormat: {week: 'ddd'},
              slotDuration: "0:<?php echo $time->interval; ?>",
              snapDuration: "0:<?php echo $time->interval; ?>",
              allDaySlot: false,
              editable: true,
              droppable: true,
              firstDay: 1,
              eventOverlap: function (stillEvent, movingEvent) {
                  return stillEvent.allDay && movingEvent.allDay;
              },
              eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {


                  // eventsToSave[event.key].composition = event.start.format("dddd");
                  // eventsToSave[event.key].time_start = event.start.format("HH:mm:ss");
                  // eventsToSave[event.key].time_end = event.end.format("HH:mm:ss");

                  // sched = {
                  //     key: event.key,
                  //     time_start: event.start.format("HH:mm"),
                  //     time_end: event.end.format("HH:mm"),
                  //     composition: event.start.format("dddd"),
                  //     rl_id: event.rl_id
                  // };

                  // updatePlottedSched(sched);

                  // console.log(eventsToSave);
              },
              eventRightclick: function (event, jsEvent, view) {
                  ShowMenu('contextMenu', jsEvent);
                  contextMenuEventSelected = event;

                  return false;
              }
          });

        });
    }

    function laboratoryRoom() {

        roomByType('laboratory');

        $.each(lab_room_id, function (index, room) {

            var room_code = room.room_code;

            $.ajax({
                url: '<?php echo base_url('course/get_plotted_room')?>',
                data: {room_code: room_code, sy: sy, semester: semester},
                dataType:'json',
                success:function (data) {
                    $('#'+room_code).fullCalendar('removeEvents');
                    $('#'+room_code).fullCalendar('addEventSource', data);
                    $('#'+room_code).fullCalendar('refetchEvents');
                }
            });


            $('#'+room_code).fullCalendar({
                defaultView: 'agendaWeek',
                header: {left: '', right: ''},
                minTime: "<?php echo date('H:i', strtotime($time->time_start)); ?>",
                maxTime: "<?php echo date('H:i', strtotime($time->time_end)); ?>",
                columnFormat: {week: 'ddd'},
                slotDuration: "0:<?php echo $time->interval; ?>",
                snapDuration: "0:<?php echo $time->interval; ?>",
                allDaySlot: false,
                editable: true,
                droppable: true,
                firstDay: 1,
                eventOverlap: function (stillEvent, movingEvent) {
                    return stillEvent.allDay && movingEvent.allDay;
                },
                eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {


                    // eventsToSave[event.key].composition = event.start.format("dddd");
                    // eventsToSave[event.key].time_start = event.start.format("HH:mm:ss");
                    // eventsToSave[event.key].time_end = event.end.format("HH:mm:ss");

                    // sched = {
                    //     key: event.key,
                    //     time_start: event.start.format("HH:mm"),
                    //     time_end: event.end.format("HH:mm"),
                    //     composition: event.start.format("dddd"),
                    //     rl_id: event.rl_id
                    // };

                    // updatePlottedSched(sched);

                    // console.log(eventsToSave);
                },
                eventRightclick: function (event, jsEvent, view) {
                    ShowMenu('contextMenu', jsEvent);
                    contextMenuEventSelected = event;

                    return false;
                }
            });

        });
    }

    function roomSchedule(selector, type) {
        $(selector).html('');
        $.ajax({
            url:'<?php echo base_url('course/getRoom'); ?>',
            data: {type: type},
            dataType:'json',
            success:function (data) {

                $.each(data, function (index, room) {
                    $(selector).append(room.code);
                });
            }
        });
    }

    function roomByType(type) {
            $.ajax({
                url:'<?php echo base_url('course/get_room'); ?>',
                data: {type: type},
                dataType: 'json',
                async:false,
                success:function (data) {
                    (type == 'lecture' ? lecture_room_id = data : lab_room_id = data);
                }
            });
    }

</script>

<style type="text/css">

    div.content {
        padding-top: 0;
    }

    div.p-t-5.p-b-5 {
        background: #154360;
        color: #FFF;
        border-radius: 5px;
    }

    div#setScheduleContent {
        /*background: #154360;*/
        border-radius: 5px;
        color: #FFF !important;
    }

    button#btnAddMoreSubject {
        width: 60px;
        height: 60px;
        border-radius: 60px;
        position: fixed;
        z-index: 1000;
        right: 0;
        bottom: 0;
        margin-bottom: 100px;
        margin-right: 50px;
    }

    #modalSubjectScheduling .modal-dialog.modal-lg {
        width: 1300px !important;
    }

    .fc-toolbar {
        margin-bottom: 0px !important;
    }

    .select2-container.select2-container-multi.form-control {

        width: 100% !important;
    }

    .tbl_subject td {
        border-top: none !important;
    }

    .tbl_subject tr {
        cursor: pointer
    }

    .list-group-item {
        background-color: #333;
        color: #fff !important;
        font-size: 12px;
        border: none !important;
        padding-top: 7px !important;
        padding-bottom: 7px !important;
    }

    .list-group-item:hover {
        background-color: #00698C !important;
        color: #FFF !important;
    }

    .list-group-item:hover {
        background-color: #00698C !important;
        color: #FFF !important;
    }

    div.list-group#contextMenu {
        display: none;
        z-index: 1000;
        width: 150px;
    }

    .btn {
        margin-left: .3%;
    }
</style>
