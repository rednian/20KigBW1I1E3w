<div id="setSchedModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" style="padding-bottom:0px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <br>

                <form class="form-horizontal">
                    <fieldset>
                        <legend class="pull-left width-full">Set Section</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Year lvl.</label>
                                    <div class="col-md-7">
                                        <select id="yearlvl" required class="form-control input-sm" name="year_lvl">
                                            <option value='' selected="selected" class="hide">Select year level</option>
                                            <option value="First Year">1st</option>
                                            <option value="Second Year">2nd</option>
                                            <option value="Third Year">3rd</option>
                                            <option value="Forth Year">4th</option>
                                            <option value="Fifth Year">5th</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sem</label>
                                    <div class="col-md-9">
                                        <select id="semister" required class="form-control input-sm" name="sem">
                                            <option value='' selected="selected" class="hide">Select Semester</option>
                                            <option value="First Semester">1st Semester</option>
                                            <option value="Second Semester">2nd Semester</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">S.Y.</label>
                                    <div class="col-md-9">
                                        <select id="schoolyear" required class="form-control input-sm" name="sy">
                                            <option value='' selected="selected" class="hide">Select school year
                                            </option>
                    
                                           <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                                                 <option value="<?php echo $i.'-'.($i+1)?>"><?php echo $i.'-'.($i+1)?></option>
                                           <?php endfor; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="pull-left width-full">Set Course</legend>
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#nav-pills-tab-1" tosave="subject" data-toggle="tab">Subject
                                    List</a></li>
                            <li><a href="#nav-pills-tab-2" tosave="curriculum" data-toggle="tab">Curriculum</a></li>
                        </ul>
                        <div class="tab-content" style="margin-bottom:0px;padding:0px">

                            <!-- SUBJECT LIST -->
                            <div class="tab-pane fade active in" id="nav-pills-tab-1">
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-8">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                      <i class="fa fa-search"></i>
                                                    </span>
                                                    <input onkeyup="searchSubject($(this).val())" type="text" placeholder="Search subject" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="overflow:auto;overflow-x:hidden;min-height:200px;max-height:300px;">
                                    <table id="example" class="table table-striped table-hover">
                                        <thead class="hide">
                                        <tr>
                                            <th></th>
                                            <th>Subject</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($subjectList)): ?>
                                            <?php foreach ($subjectList as $subject): ?>
                                                <tr>
                                                    <td class="col-md-2"><input type="checkbox" name="subj_id"
                                                                                subjname="<?php echo $subject->subj_name; ?>"
                                                                                labunit="<?php echo $subject->lab_unit; ?>"
                                                                                split="<?php echo $subject->split; ?>"
                                                                                lecunit="<?php echo $subject->lec_unit; ?>"
                                                                                lechour="<?php echo $subject->lec_hour; ?>"
                                                                                labhour="<?php echo $subject->lab_hour; ?>"
                                                                                subjcode="<?php echo $subject->subj_code; ?>"
                                                                                value="<?php echo $subject->subj_id; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subject->subj_code; ?>
                                                    </td>
                                                    <td><?php echo $subject->subj_name; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-pills-tab-2">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Program</label>
                                    <div class="col-md-9">
                                        <select id="program" required class="form-control input-sm">
                                            <option class="hide" selected value=''>Select program</option>
                                            <?php if (!empty($programList)): ?>
                                                <?php foreach ($programList as $key => $value): ?>
                                                    <option progname="<?php echo $value->prog_name ?>"
                                                            value="<?php echo $value->pl_id ?>"><?php echo $value->prog_name ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Major</label>
                                    <div class="col-md-9">
                                        <input value="Web Programming" required id="major"
                                               class="form-control input-sm text-primary" readonly
                                               type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Year lvl.</label>
                                            <div class="col-md-7">
                                                <select id="curryearlvl" required class="form-control input-sm"
                                                        name="year_lvl">
                                                    <option value='' selected="selected" class="hide">Select year level
                                                    </option>
                                                    <option value="1st">1st</option>
                                                    <option value="2nd">2nd</option>
                                                    <option value="3rd">3rd</option>
                                                    <option value="4th">4th</option>
                                                    <option value="5th">5th</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Sem</label>
                                            <div class="col-md-9">
                                                <select id="currsemister" required class="form-control input-sm"
                                                        name="sem">
                                                    <option value='' selected="selected" class="hide">Select Semester
                                                    </option>
                                                    <option value="1st Semester">1st Semester</option>
                                                    <option value="2nd Semester">2nd Semester</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Revision</label>
                                            <div class="col-md-9">
                                                <select id="currsy" class="form-control input-sm"
                                                        name="sy"></select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- MODAL CONTENT -->

                                <!-- MODAL CONTENT -->

                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="pull-left width-full">Section Code</legend>
                        <div class="row">
                            <div class="col-md-3" style="border-right:1px solid #348fe2">
                                <span id="sectioncode" class="text-primary text-bold"
                                      style="font-size:24px">CS001</span>
                                <button onclick="generate_section_code()" type="button"
                                        class="btn btn-xs btn-default pull-right">generate
                                </button>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input id="ownsectioncode" type="text"
                                               class="form-control input-sm text-primary"
                                               placeholder="Set your own code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Scheduled for:</label>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="radio" checked value="morning" name="schedule"> Morning |
                                        <input value="afternoon" type="radio" name="schedule"> Afternoon |
                                        <input value="evening" type="radio" name="schedule"> Evening
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-set-sched" type="button" onclick="set_curriculum()" class="btn btn-primary">Set</button>
            </div>
        </div>
    </div>
</div>
<?php


?>
<script type="text/javascript">


    var activeTab;

    $(document).ready(function () {
        FormWizardValidation.init();

        $('#setSchedModal').on('shown.bs.modal', function () {




            $('#currsy').html('<option selected disabled >Select school year</option>');

            generate_section_code();

            load_revision();

            activeTab = $("li.active a[data-toggle=tab]").attr("tosave");

            $("li a[data-toggle=tab]").on("shown.bs.tab", function (e) {
                activeTab = $(this).attr("tosave");
            });




        });

        //reset all fields after the modal will close
        $('#modalSubjectScheduling').on('hidden.bs.modal', function () {
//            $(this).find('form')[0].reset();
        });

    });
    //this function is omitted
    function setCurriculumSched(){
        if($("#setSchedModal input#ownsectioncode").val() == ""){
            sec = $("#setSchedModal span#sectioncode").html();
        }
        else{
            sec = $("#setSchedModal input#ownsectioncode").val();
        }

        if(activeTab == 'subject'){
            $.each($("input[type='checkbox'][name='subj_id']:checked"), function(){         
                subject[$(this).val()] = {subj_id : $(this).val(), subj_code : $(this).attr('subjcode'), subj_name : $(this).attr('subjname'), lec_unit : $(this).attr('lecunit'), lab_unit : $(this).attr('labunit'), split : $(this).attr('split'), lab_hour : $(this).attr('labhour'), lec_hour : $(this).attr('lechour') };
            });
        }

        schedObj  = {
                        program : $("#setSchedModal select#program").val(),
                        prog_name : $("#setSchedModal select#program option:selected").attr("progname"),
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

        setDetails(schedObj);

        $.ajax({
            url: "<?php echo base_url('course/setSchedule') ?>",
            data: {sched : schedObj, type : activeTab},
            type: "GET",
            dataType: "json",
            success: function(data){
                
                $(".roomCalendar").fullCalendar('removeEvents');
                loadRenderedEvents();
                loadPlottedEvents();

                for(var i = 0; i < data.length; i++){
                    
                    
                    $("#"+data[i]['room']).fullCalendar('addEventSource', [data[i]]);
                    
                    var dataToSave = {year_lvl : data[i].year_lvl,
                                      sy : data[i].sy,
                                      sem : data[i].sem,
                                      subj_id : data[i].subj_id,
                                      composition : data[i].composition,
                                      rl_id : data[i].rl_id,
                                      time_start : data[i].time_start,
                                      time_end : data[i].time_end,
                                      ss_id : data[i].ss_id };

                    var key = data[i]['key'];
                    eventsToSave[key] = dataToSave;
                }
            },
            error: function(){

            }
        });

        $("#buttonContainer").html("<button onclick=\"cancelEdit()\" class=\"btn btn-sm btn-success pull-right m-l-5\">Cancel</button> <button onclick=\"saveSubjectSched()\" class=\"btn btn-sm btn-info pull-right m-l-5\">Save</button>");
        console.log(eventsToSave);
    }

    function set_curriculum() {

        var section_code_val = $('#setSchedModal input#ownsectioncode').val();

        var sec = section_code_val == '' ? $("#setSchedModal span#sectioncode").html() : $('#setSchedModal input#ownsectioncode').val();

        var program = $("#setSchedModal select#program").val();
        var prog_name = $("#setSchedModal select#program option:selected").attr("progname");
        var major = $("#setSchedModal input#major").val();
        var year = $("#setSchedModal select#yearlvl").val();
        var semester = $("#setSchedModal select#semister").val();
        var school_year = $("#setSchedModal select#schoolyear").val();
        var curriculum_year_level = $("#setSchedModal select#curryearlvl").val();
        var curriculum_semester = $("#setSchedModal select#currsemister").val();
        var curriculum_school_year = $("#setSchedModal select#currsy").val();
        var schedule = $("#setSchedModal input[type=radio][name=schedule]:checked").val();


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


        schedObj = {
            program: program,
            prog_name: prog_name,
            major: major,
            year: year,
            semister: semester,
            sy: school_year,
            section_code: sec,
            curryearlvl: curriculum_year_level,
            currsemister: curriculum_semester,
            currsy: curriculum_school_year,
            schedule: schedule,
            subjects: subject
        };

        setDetails(schedObj);

        $.ajax({
            url: "<?php echo base_url('course/create_schedule') ?>",
            data: {sched: schedObj, type: activeTab},
            dataType: "json",
            success: function (response) {
                if (response == 1){
                    $('#setSchedModal').modal('hide');
                    $('#modalSubjectScheduling').modal('show');

                    $('#section-detail').html(schedObj.section_code.toUpperCase());
                    $('#year-detail').html(schedObj.year.toUpperCase());
                    $('#program-detail').html(schedObj.prog_name.toUpperCase());
                    $('#major-detail').html(schedObj.major.toUpperCase());
                    $('#semester-detail').html(schedObj.semister.toUpperCase());
                    $('#sy-detail').html(schedObj.sy.toUpperCase());
                }
                else{
                    new PNotify({
                        type:'error',
                        text:'Setting Curriculum/Subject detected error. Press F5 to Refresh and  Try again.'
                    });
                }

            },
            error: function () {

            }
        });
    }

    function generate_section_code() {
        $.ajax({
            url: "<?php echo base_url('course/generateSectionCode'); ?>",
            success: function (data) {
                if (typeof data != 'undefined') {
                    $("#setSchedModal span#sectioncode").html(data);
                }
                else {
                    $("#setSchedModal span#sectioncode").html('cannot generate code');
                }

            }
        });
    }

    function load_revision() {

        $('#program').change(function () {
            $('#currsy').html('');
            $.ajax({
                url: '<?php echo base_url('course/get_revision') ?>',
                data: {pl_id: $(this).val()},
                dataType: 'json',
                success: function (data) {

                    $.each(data, function (index, data) {
                        $('#currsy').append('<option value="' + data.sy + '">' + data.sy + '</option>');
                    });
                }

            });
        });
    }

    var handleBootstrapWizardsValidation = function () {

        "use strict";

        $("#wizard").bwizard({
            validating: function (e, t) {
                if (t.index == 0) {
                    if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-1")) {
                        return false
                    }
                } else if (t.index == 1) {
                    if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-2")) {
                        return false
                    }
                } else if (t.index == 2) {
                    if (false === $('form[name="form-wizard"]').parsley().validate("wizard-step-3")) {
                        return false
                    }
                }
            }
        })
    };

    var FormWizardValidation = function () {
        "use strict";
        return {
            init: function () {
                handleBootstrapWizardsValidation()
                  }
        }
    }();


</script>
<style type="text/css">
    #example_filter {
        display: none;
    }
</style>


         
