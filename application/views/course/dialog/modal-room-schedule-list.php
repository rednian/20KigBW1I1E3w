<div class="modal fade" id="modalSubjectScheduling" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <div class="row">

                    <div class="col-md-2">
                        <small>div:</small>
                        <div style="font-size:15px;color:#337ab7" id="section-detail"></div>
                    </div>
                    <div class="col-md-1">
                        <small>Year:</small>
                        <div style="font-size:15px;color:#337ab7" id="year-detail"></div>
                    </div>
                    <div class="col-md-4">
                        <small>Curriculum:</small>
                        <div style="font-size:15px;color:#337ab7" id="program-detail"></div>
                        <div>
                            <small id="major-detail"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small>Semester / School Year</small>
                        <div style="font-size:15px;color:#337ab7"><span id="semester-detail"></span> - <span
                                    id="sy-detail"></span></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">

                <div class="row">
                    <!-- <div class="col-md-3">
                      <label><b>Set Schedule</b></label>
                      <div class="form-group">
                        Time Start
                        <input type="text" class="form-control input-sm">
                      </div>
                      <div class="form-group">
                        Time End
                        <input type="text" class="form-control input-sm">
                      </div>
                      <div class="form-group">
                        Room Suggestions
                        <select class="form-control input-sm"></select>
                      </div>
                      <div class="form-group">
                        <button style="width:100px" class="btn btn-success pull-right">Save</button>
                      </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-7">
                                <!-- <h4>Subject List</h4> -->
                                <!-- <label><b>Subject List</b></label><br> -->

                                <div>
                                    <ul class="nav nav nav-pills" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                                                                  role="tab"
                                                                                  data-toggle="tab">Lecture</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                                                   data-toggle="tab">Laboratory</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <table class="table tbl_subject table-striped table-hover" id="table-subject-lecture">
                                                <thead class="hide">
                                                <tr>
                                                    <th>#</th>
                                                    <th class="hidden"></th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="profile">
                                            <table class="table table-hover table-striped tbl_subject" id="table-subject-lab">
                                                <thead class="hide">
                                                <tr>
                                                    <th>#</th>
                                                    <th class="hidden"></th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-5">
                                <section class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Schedule</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            Room Suggestions
                                            <select class="form-control input-sm" id="select-room" name="room"></select>
                                        </div>
                                        <div class="form-group">
                                            Day
                                            <select id="selected-days" class="form-control select2 input-sm"
                                                    multiple="multiple" data-placeholder="Select Day Schedule">
                                                <?php if (!empty($sched_day)): ?>
                                                    <?php foreach ($sched_day as $day): ?>
                                                        <option data-composition="<?php echo $day->composition; ?>" value="<?php echo $day->sd_id; ?>"><?php echo ucwords(strtolower($day->composition)) ?>
                                                            - <?php echo strtoupper($day->abbreviation); ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            Time Start
                                            <select id="select-time-start" class="form-control input-sm"></select>
                                        </div>
                                        <!--                                <div class="form-group">-->
                                        <!--                                    Time End-->
                                        <!--                                    <select class="form-control input-sm" id="select-time-end"></select>-->
                                        <!--                                </div>-->
                                        <div class="form-group">
                                            <button style="width:100px" class="btn btn-success pull-right"
                                                    id="btn-save">Add
                                            </button>
                                        </div>

                                    </div>
                                </section>

                            </div>
                            <div class="col-md-12">
                                <section class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Div Schedules</h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table m-t-10 table-striped">
                                            <thead style="background:#f3f3f3">
                                            <tr>
                                                <th>Code</th>
                                                <th>Subject</th>
                                                <th>Day</th>
                                                <th>Time</th>
                                                <th>Room</th>
                                                <th>Type</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center">No schedule available</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-heading clearfix">
                                <label class="text-white"><strong id="room-display-name">No Room
                                        Selected</strong></label>
                            </div>
                            <div class="panel-body p-t-0 p-l-10 p-r-10 p-b-10" style="border:1px solid #CCC">
                                <div class="m-t-0" id="subject-schedule-calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="confirm()" >Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var room_code = subj_id = sub_name = bs_id = type = lab_count = lec_count = '';
    var schedule_data = [];
    var room_type_value = '';

    $(document).ready(function () {

        reload();

        $('#modalSubjectScheduling').on('shown.bs.modal', function () {
            $('#select-room').html('<option disabled selected>Select Room</option>');
            load_start_time();
            lecture_room();     
            laboratory_room();
            initialize_calendar();
            load_room();
            set_room();
        });

    });

    function set_room() {
        $('#btn-save').click(function () {

            var selected_days = $('#selected-days').val();
            var start = $('#select-time-start').val();
            var room = $('#select-room').val();

            var event = {'type':type,'bs_id':bs_id,'sub_id': subj_id, 'start': start, 'room':room, 'selected_days':selected_days};

            $.ajax({
                url:'<?php echo base_url('course/save_schedule'); ?>',
                data:{event:event},
                success:function (data) {

                    if(data == 1){
                        
                         room_calendar(room_code);

                        new PNotify({
                            type:'success',
                            text:'Subject added to '+ schedObj.section_code +' section.'
                        });
                    }

                    if (data == 0) {
                        new PNotify({
                            type:'error',
                            text:'Schedule already taken. Please another Roon or Time'
                        });
                    }
                    
                  
                },
                error:function (first, second) {
                    console.log('error : '+ second);
                }
            });




        });
    }

    function reload() {
         $('#modalSubjectScheduling').on('hidden.bs.modal', function () {
           $.ajax({
              url: '<?php echo base_url('course/undo_schedule') ?>',
              success: function (data) {
                location.reload();
              }
            });
        });
    }

    function confirm() {
       
            $.ajax({
              url: '<?php echo base_url('course/check_plotted') ?>',
              data: {bs_id: bs_id},
              async:false,
              success: function (data) {
               
                if(data == 0){

                    (new PNotify({
                        title: 'Confirmation Needed',
                        text: 'Transaction undone. Are you sure you want to continue ?',
                        icon: 'glyphicon glyphicon-question-sign',
                        hide: false,
                        confirm: {
                            confirm: true
                        },
                        buttons: {
                            closer: false,
                            sticker: false
                        },
                        history: {
                            history: false
                        }
                    })).get().on('pnotify.confirm', function() {

                        $('.modal').modal('hide');

                    }).on('pnotify.cancel', function() {

                    });
                    
                }
                else{
                      $('.modal').modal('hide');
                }       
              }
    
            });
    }

     function initialize_calendar() {
        $('#subject-schedule-calendar').fullCalendar({
            cache: false,
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
            editable: false,
            droppable: false,
            firstDay: 1
        });
    }

    function load_room() {

        $(document).on('change', '#select-room', function () {

             room_code = $(this).val();
            var room_name = $(this).attr('data-name');

            //todo - room name does not display
            $('#room-display-name').html(room_name + ' (' + room_code + ')');


            room_calendar(room_code);


        });
    }

    function room_calendar(room_code) {

        $.ajax({
            url: '<?php echo base_url('course/get_plotted_room')?>',
            data: {room_code: room_code, sy: sy, semseter :semseter},
            dataType: 'json',
            success: function (data) {
            
                $("#subject-schedule-calendar").fullCalendar('removeEvents');
                
                $("#subject-schedule-calendar").fullCalendar('addEventSource', data);

                $("#subject-schedule-calendar").fullCalendar('refetchEvents');
            }
        });
    }

    function laboratory_room() {

        var lab_table = $('#table-subject-lab').DataTable({
            ajax: {
                url: '<?php echo base_url('course/get_block_subject'); ?>',
                data: {type: 'lab'}
            },
            filter: false,
            processing: true,
            deferRender: true,
            paginate: false,
            destroy: true,
            sort: false,
            length: false,
            info: false,
            pagingType: 'simple',
            language: {
                'loadingRecords': 'retrieving subjects...'
            },
            columns: [
                {
                    'visible': false,
                    'data': 'subj_id'
                },
                 {
                    'visible': false,
                    'data': 'bs_id'
                },
                {'data': 'code'},
                {'data': 'name'}
            ]
        });

        $('#table-subject-lab tbody').on('click', 'tr', function () {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
            }
            else {
                lab_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
            }

            subj_id = lab_table.row(this).data()['subj_id'];
               
            bs_id = lab_table.row(this).data()['bs_id'];

            sub_name = lab_table.row(this).data()['name'];

            type = 'lab';

            load_rooms('laboratory');


        });
    }

    function lecture_room() {
        var subject_table = $('#table-subject-lecture').DataTable({
            ajax: {
                url: '<?php echo base_url('course/get_block_subject'); ?>',
                data: {type: 'lec'}
            },
            filter: false,
            processing: true,
            deferRender: true,
            paginate: false,
            destroy: true,
            sort: false,
            length: false,
            info: false,
            pagingType: 'simple',
            language: {
                'loadingRecords': 'retrieving subjects...'
            },
            columns: [
                {
                    'visible': false,
                    'data': 'subj_id'
                },
                 {
                    'visible': false,
                    'data': 'bs_id'
                },
                {'data': 'code'},
                {'data': 'name'}
            ],
            initComplete: function(settings, json) {
               bs_id = json.data[0].bs_id;
             }
        });

        /*retrieve room from lecture table*/
        $('#table-subject-lecture tbody').on('click', 'tr', function () {
            if ($(this).hasClass('success')) {
                $(this).removeClass('success');
            }
            else {
                subject_table.$('tr.success').removeClass('success');
                $(this).addClass('success');
            }

            subj_id = subject_table.row(this).data()['subj_id'];

            bs_id = subject_table.row(this).data()['bs_id'];

            sub_name = subject_table.row(this).data()['name'];

            type = 'lec';


            load_rooms('lecture');

        });
    }

    function load_start_time() {
        $('#select-time-start').html('<option selected disabled> Select Time </option>');
        $.ajax({
            url: '<?php echo base_url('course/get_schedule_time'); ?>',
            dataType: 'JSON',
            success: function (data) {
                $.each(data, function (index, data) {
                    $('#select-time-start').append('<option value="' + data.time + '">' + data.time + '</option>');
                });
            }
        });
    }

    function load_rooms(type) {

        $.ajax({
            url: '<?php echo site_url('course/get_room'); ?>',
            data: {type: type},
            dataType: 'JSON',
            success: function (data) {
                $('#select-room').html('');
                $('#select-room').append('<option disabled selected>Select Room</option>');
                $.each(data, function (index, data) {
                    $('#select-room').append('<option data-name="' + data.room + '" value="' + data.room_code + '">' + data.room + '</option>');
                });

            }
        });
    }

    function select_day(day) {
        var num = '';
        switch (day) {
            case 'Sunday':
                num = 0;
                break;
            case 'Monday':
                num = 1;
                break;
            case 'Tuesday':
                num = 2;
                break;
            case 'Wednesday':
                num = 3;
                break;
            case 'Thursday':
                num = 4;
                break;
            case 'Friday':
                num = 5;
                break;
            case 'Saturday':
                num = 6;
                break;
        }
        return num;
    }

 
</script>
<style type="text/css">

    select#selected-days {
        width: 100% !important;
    }

    div#table-subject > label {
        display: none;
    }
</style>