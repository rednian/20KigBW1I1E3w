<?php $this->load->view('course/dialog/modal-schedule-list'); ?>
<?php $this->load->view('course/dialog/modal-add-schedule'); ?>
<?php $this->load->view('course/dialog/modal-room-schedule-list'); ?>
<?php $this->load->view('course/dialog/modal-move-to-room'); ?>

<div id="content" class="content">

    <!-- <button id="btnAddMoreSubject" class="btn btn-success"><i class="fa fa-plus fa-2x"></i><br>Add subject</button> -->
    <!-- <div class="form-group m-l-0">
      <button onclick="loadScheduleList();$('#modalScheduleList').modal('show')" class="btn btn-info ">Schedule List</button>
    </div> -->
    <div id="setScheduleContent" class="row p-t-10 p-b-10 m-b-10">
        <!--        <div class="col-md-3 border-r">-->
        <!--            <small>Schedule is set for:</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsProgram">...</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-2 border-r">-->
        <!--            <small>Major</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsMajor">...</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-1 border-r">-->
        <!--            <small>Year Level</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsYear">...</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-1 border-r">-->
        <!--            <small>Semester</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsSemister">...</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-1 border-r">-->
        <!--            <small>School year</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsSY">...</span>-->
        <!--        </div>-->
        <!--        <div class="col-md-1 border-r">-->
        <!--            <small>div Code</small>-->
        <!--            <br>-->
        <!--            <span class="schedDetailsdiv">...</span>-->
        <!--        </div>-->

        <div class="col-md-2 col-md-offset-10" id="buttonContainer">
            <button onclick="loadScheduleList();$('#modalScheduleList').modal('show')" class="btn btn-info btn-sm">
                Schedule List
            </button>
            <button onclick="$('#setSchedModal').modal('show');" class="btn btn-sm btn-success">Set Schedule</button>
            <!--            <button onclick="saveSubjectSched()" class="btn btn-sm btn-info pull-right m-l-5">Save</button>-->
        </div>
    </div>

    
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
                <div class="col-md-12 p-l-0 p-r-5">
                    <?php $this->load->view('course/include/lecture_room'); ?>
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
                <div class="col-md-12 p-l-5 p-r-0">

                    <?php $this->load->view('course/include/lab-room'); ?>

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

    $(document).ready(function () {
 
        load_lecture_room();
        load_lab_room();

        //after closing the room modal, table should be cleared.
        $('#modalSubjectScheduling').on('hidden.bs.modal', function (e) {
            room_laboratory = room_lecture = [];
        });

    });

    function load_lab_room() {
        <?php
        $room = '';
        $start = '';
        $end = '';
        if (!empty($labRooms)){

        foreach ($labRooms as $key => $value) {
        $room = $value->room_code;
        $start = date('H:i', strtotime($time->time_start));
        $end = date('H:i', strtotime($time->time_end));
        ?>

        $("#<?php echo $value->room_code ?>").fullCalendar({
            eventSources: [{
                url: '<?php echo base_url('course/get_plotted_room')?>',
                data: {room_code: '<?php echo $value->room_code ?>'}
            }],
            defaultView: 'agendaWeek',
            header: {
                left: '',
                right: ''
            },
            minTime: "<?php echo date('H:i', strtotime($time->time_start)); ?>",
            maxTime: "<?php echo date('H:i', strtotime($time->time_end)); ?>",
            columnFormat: {
                week: 'ddd'
            },
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

                // console.log(event);

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
                updatePlottedSched(sched);

                // console.log('update schedule '+shed);
            },
            eventRightclick: function (event, jsEvent, view) {
                ShowMenu('contextMenu', jsEvent);
                contextMenuEventSelected = event;
                console.log(event);
                return false;
            }
        });
        <?php
        }
        } ?>
    }

    function load_lecture_room() {
        <?php
        if (!empty($lectureRooms)){
        foreach ($lectureRooms as $key => $value) { ?>
        $("#<?php echo $value->room_code ?>").fullCalendar({
            eventSources: [
                {
                    url: '<?php echo base_url('course/get_plotted_room')?>',
                    data: {room_code: '<?php echo $value->room_code ?>'}
                }
            ],
            defaultView: 'agendaWeek',
            header: {
                left: '',
                right: ''
            },
            minTime: "<?php echo date('H:i', strtotime($time->time_start)); ?>",
            maxTime: "<?php echo date('H:i', strtotime($time->time_end)); ?>",
            columnFormat: {
                week: 'ddd'
            },
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
        <?php }
        } ?>
    }
</script>

<style type="text/css">

    div.p-t-5.p-b-5 {
        background: #154360;
        color: #FFF;
        border-radius: 5px;
    }

    div#setScheduleContent {
        background: #154360;
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
</style>
